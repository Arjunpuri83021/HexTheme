<?php
/**
 * XVideos2 Scraper - Scrapes videos from xvideos2.com/tags/cute
 * and inserts them into WordPress database as 'video' custom post type
 * 
 * Usage: php scrape_xvideos.php
 */

// WordPress DB config
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'vip4kporn');
define('WP_TABLE_PREFIX', 'wp_');

// Scraping config
define('TARGET_URL', 'https://www.xvideos2.com/tags/cute');
define('DELAY_BETWEEN_REQUESTS', 2); // seconds between requests to be polite
define('WP_AUTHOR_ID', 1); // WordPress user ID for post author

// Connect to WordPress DB
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error . "\n");
}
$conn->set_charset("utf8mb4");
echo "✅ Connected to WordPress database\n\n";

/**
 * Fetch URL content with cURL
 */
function fetchUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Accept-Language: en-US,en;q=0.5',
    ]);
    
    $html = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        echo "⚠️ HTTP $httpCode for $url\n";
        return false;
    }
    
    return $html;
}

/**
 * Parse videos from listing page HTML
 */
function parseListingPage($html) {
    $videos = [];
    
    // Match each thumb-block div
    preg_match_all('/<div\s+id="video_([^"]+)"[^>]*data-id="(\d+)"[^>]*data-eid="([^"]+)"[^>]*>.*?<\/script>\s*<\/div>/s', $html, $blocks, PREG_SET_ORDER);
    
    foreach ($blocks as $block) {
        $video = [];
        $video['eid'] = $block[3];
        $video['data_id'] = $block[2];
        $blockHtml = $block[0];
        
        // Get video page URL
        if (preg_match('/<a\s+href="(\/video\.[^"]+)"/', $blockHtml, $m)) {
            $video['page_url'] = 'https://www.xvideos2.com' . $m[1];
        }
        
        // Get thumbnail
        if (preg_match('/data-src="([^"]+)"/', $blockHtml, $m)) {
            $video['thumbnail'] = $m[1];
        }
        
        // Get preview video
        if (preg_match('/data-pvv="([^"]+)"/', $blockHtml, $m)) {
            $video['preview_video'] = trim($m[1]);
        }
        
        // Get title from the <a> title attribute
        if (preg_match('/title="([^"]+)"/', $blockHtml, $m)) {
            $video['title'] = html_entity_decode($m[1], ENT_QUOTES, 'UTF-8');
        }
        
        // Get duration
        if (preg_match('/<span\s+class="duration">([^<]+)<\/span>/', $blockHtml, $m)) {
            $video['duration'] = trim($m[1]);
        }
        
        // Get views from metadata
        if (preg_match('/<span class="sprfluous">[\s]*-[\s]*<\/span>\s*([\d.]+[MKk]?)\s*<span class="sprfluous">\s*Views/s', $blockHtml, $m)) {
            $video['views_text'] = trim($m[1]);
            $video['views'] = parseViews($m[1]);
        }
        
        // Get channel/star name
        if (preg_match('/<span\s+class="name">([^<]+)<\/span>/', $blockHtml, $m)) {
            $video['star_name'] = trim($m[1]);
        }
        
        // Iframe URL
        $video['iframe_url'] = 'https://www.xvideos2.com/embedframe/' . $video['eid'];
        
        if (!empty($video['title']) && !empty($video['page_url'])) {
            $videos[] = $video;
        }
    }
    
    return $videos;
}

/**
 * Parse views string like "38.5M" or "1.2K" to integer
 */
function parseViews($viewsStr) {
    $viewsStr = trim($viewsStr);
    $multiplier = 1;
    
    if (stripos($viewsStr, 'M') !== false) {
        $multiplier = 1000000;
        $viewsStr = str_ireplace('M', '', $viewsStr);
    } elseif (stripos($viewsStr, 'K') !== false || stripos($viewsStr, 'k') !== false) {
        $multiplier = 1000;
        $viewsStr = str_ireplace(['K', 'k'], '', $viewsStr);
    }
    
    return intval(floatval($viewsStr) * $multiplier);
}

/**
 * Fetch individual video page for tags and additional info
 */
function fetchVideoDetails($url) {
    $html = fetchUrl($url);
    if (!$html) return [];
    
    $details = [];
    
    // Get tags
    if (preg_match('/video-tags-list.*?<\/ul>/s', $html, $tagsBlock)) {
        preg_match_all('/<a[^>]*>([^<]+)<\/a>/', $tagsBlock[0], $tagMatches);
        $tags = array_filter($tagMatches[1], function($tag) {
            return $tag !== '+' && $tag !== '-' && trim($tag) !== '';
        });
        $details['tags'] = implode(', ', $tags);
    }
    
    // Get likes
    if (preg_match('/"nb-video-vote-value-up"[^>]*>(\d+)/', $html, $likes)) {
        $details['likes'] = intval($likes[1]);
    } elseif (preg_match('/vote-action-good[^>]*>.*?<span[^>]*>(\d+)/s', $html, $likes)) {
        $details['likes'] = intval($likes[1]);
    }
    
    // Get ALL model/pornstar names from <li class="model"> blocks
    $models = [];
    preg_match_all('/<li\s+class="model"[^>]*>.*?<span\s+class="name">([^<]+)<\/span>.*?<\/li>/s', $html, $modelMatches);
    if (!empty($modelMatches[1])) {
        foreach ($modelMatches[1] as $name) {
            $name = trim($name);
            if (!empty($name)) {
                $models[] = $name;
            }
        }
    }
    if (!empty($models)) {
        $details['pornstar'] = implode(', ', array_unique($models));
    }
    
    return $details;
}

/**
 * Create WordPress-friendly slug from title
 */
function createSlug($title) {
    $slug = strtolower($title);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/[\s-]+/', '-', $slug);
    $slug = trim($slug, '-');
    return substr($slug, 0, 200); // WordPress slug limit
}

/**
 * Check if video already exists in WP database (by title)
 */
function videoExists($conn, $title) {
    $stmt = $conn->prepare("SELECT ID FROM " . WP_TABLE_PREFIX . "posts WHERE post_title = ? AND post_type = 'video' LIMIT 1");
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    return $exists;
}

/**
 * Insert video as WordPress custom post
 */
function insertVideoToWP($conn, $video) {
    $now = date('Y-m-d H:i:s');
    $nowGmt = gmdate('Y-m-d H:i:s');
    $slug = createSlug($video['title']);
    $description = isset($video['tags']) ? $video['tags'] : '';
    
    // Insert into wp_posts
    $sql = "INSERT INTO " . WP_TABLE_PREFIX . "posts 
            (post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, 
             post_status, comment_status, ping_status, post_name, post_type, 
             post_modified, post_modified_gmt, to_ping, pinged, post_content_filtered) 
            VALUES (?, ?, ?, ?, ?, '', 'publish', 'open', 'closed', ?, 'video', ?, ?, '', '', '')";
    
    $stmt = $conn->prepare($sql);
    $authorId = WP_AUTHOR_ID;
    $stmt->bind_param("isssssss", $authorId, $now, $nowGmt, $description, $video['title'], $slug, $now, $nowGmt);
    
    if (!$stmt->execute()) {
        echo "   ❌ Failed to insert post: " . $conn->error . "\n";
        $stmt->close();
        return false;
    }
    
    $postId = $conn->insert_id;
    $stmt->close();
    
    // Update GUID
    $guid = "http://localhost/vip4kPorn/?post_type=video&#038;p=$postId";
    $conn->query("UPDATE " . WP_TABLE_PREFIX . "posts SET guid = '$guid' WHERE ID = $postId");
    
    // Insert meta fields
    $metaFields = [
        '_video_image_url' => $video['thumbnail'] ?? '',
        '_video_preview_video' => $video['preview_video'] ?? '',
        '_video_url' => $video['page_url'] ?? '',
        '_video_iframe_url' => $video['iframe_url'] ?? '',
        '_video_minutes' => $video['duration'] ?? '',
        '_video_views' => $video['views'] ?? 0,
        '_video_likes' => $video['likes'] ?? 0,
        '_video_alt_keywords' => $video['tags'] ?? '',
        '_video_star_name' => $video['star_name'] ?? '',
        '_terms_synced' => 'no', // Will be synced by WordPress theme on page load
    ];
    
    $metaStmt = $conn->prepare("INSERT INTO " . WP_TABLE_PREFIX . "postmeta (post_id, meta_key, meta_value) VALUES (?, ?, ?)");
    
    foreach ($metaFields as $key => $value) {
        $metaStmt->bind_param("iss", $postId, $key, $value);
        $metaStmt->execute();
    }
    $metaStmt->close();
    
    // Now sync taxonomy terms (tags, pornstars)
    syncTaxonomyTerms($conn, $postId, $video);
    
    return $postId;
}

/**
 * Get or create taxonomy term, returns term_taxonomy_id
 */
function getOrCreateTerm($conn, $name, $taxonomy) {
    $slug = createSlug($name);
    $prefix = WP_TABLE_PREFIX;
    
    // Check if term exists
    $stmt = $conn->prepare("SELECT t.term_id, tt.term_taxonomy_id FROM {$prefix}terms t 
                            JOIN {$prefix}term_taxonomy tt ON t.term_id = tt.term_id 
                            WHERE t.slug = ? AND tt.taxonomy = ? LIMIT 1");
    $stmt->bind_param("ss", $slug, $taxonomy);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stmt->close();
        
        // Increment count
        $ttId = $row['term_taxonomy_id'];
        $conn->query("UPDATE {$prefix}term_taxonomy SET count = count + 1 WHERE term_taxonomy_id = $ttId");
        
        return $ttId;
    }
    $stmt->close();
    
    // Create new term
    $stmt = $conn->prepare("INSERT INTO {$prefix}terms (name, slug, term_group) VALUES (?, ?, 0)");
    $stmt->bind_param("ss", $name, $slug);
    $stmt->execute();
    $termId = $conn->insert_id;
    $stmt->close();
    
    // Create term_taxonomy entry
    $stmt = $conn->prepare("INSERT INTO {$prefix}term_taxonomy (term_id, taxonomy, description, parent, count) VALUES (?, ?, '', 0, 1)");
    $stmt->bind_param("is", $termId, $taxonomy);
    $stmt->execute();
    $ttId = $conn->insert_id;
    $stmt->close();
    
    return $ttId;
}

/**
 * Sync taxonomy terms (tags and pornstar) for a post
 */
function syncTaxonomyTerms($conn, $postId, $video) {
    $prefix = WP_TABLE_PREFIX;
    $order = 0;
    
    // Sync tags from alt_keywords
    if (!empty($video['tags'])) {
        $tags = array_map('trim', explode(',', $video['tags']));
        $tags = array_filter($tags);
        
        foreach ($tags as $tag) {
            $ttId = getOrCreateTerm($conn, $tag, 'video_tag');
            
            // Check if relationship already exists
            $check = $conn->query("SELECT * FROM {$prefix}term_relationships WHERE object_id = $postId AND term_taxonomy_id = $ttId");
            if ($check->num_rows === 0) {
                $conn->query("INSERT INTO {$prefix}term_relationships (object_id, term_taxonomy_id, term_order) VALUES ($postId, $ttId, $order)");
                $order++;
            }
        }
    }
    
    // Sync pornstar
    if (!empty($video['star_name'])) {
        $stars = array_map('trim', explode(',', $video['star_name']));
        $stars = array_filter($stars);
        
        foreach ($stars as $star) {
            $ttId = getOrCreateTerm($conn, $star, 'pornstar');
            
            $check = $conn->query("SELECT * FROM {$prefix}term_relationships WHERE object_id = $postId AND term_taxonomy_id = $ttId");
            if ($check->num_rows === 0) {
                $conn->query("INSERT INTO {$prefix}term_relationships (object_id, term_taxonomy_id, term_order) VALUES ($postId, $ttId, $order)");
                $order++;
            }
        }
    }
    
    // Add "cute" as a category tag since we're scraping from /tags/cute
    $cuteTagId = getOrCreateTerm($conn, 'cute', 'video_tag');
    $check = $conn->query("SELECT * FROM {$prefix}term_relationships WHERE object_id = $postId AND term_taxonomy_id = $cuteTagId");
    if ($check->num_rows === 0) {
        $conn->query("INSERT INTO {$prefix}term_relationships (object_id, term_taxonomy_id, term_order) VALUES ($postId, $cuteTagId, $order)");
    }
}

// ========== MAIN EXECUTION ==========

echo "🔍 Fetching listing page: " . TARGET_URL . "\n";
$html = fetchUrl(TARGET_URL);

if (!$html) {
    die("❌ Failed to fetch listing page\n");
}

echo "✅ Page fetched (" . strlen($html) . " bytes)\n\n";

// Parse videos from listing
$videos = parseListingPage($html);
echo "📊 Found " . count($videos) . " videos on listing page\n\n";

if (empty($videos)) {
    die("❌ No videos found. The page structure may have changed.\n");
}

$inserted = 0;
$skipped = 0;
$errors = 0;

foreach ($videos as $i => $video) {
    $num = $i + 1;
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "📹 [$num/" . count($videos) . "] " . $video['title'] . "\n";
    
    // Check if already exists
    if (videoExists($conn, $video['title'])) {
        echo "   ⏭️ Already exists, skipping\n";
        $skipped++;
        continue;
    }
    
    // Fetch individual video page for tags and extra info
    echo "   🔍 Fetching video details...\n";
    sleep(DELAY_BETWEEN_REQUESTS);
    
    $details = fetchVideoDetails($video['page_url']);
    
    // Merge details
    if (!empty($details['tags'])) {
        $video['tags'] = $details['tags'];
    }
    if (!empty($details['likes'])) {
        $video['likes'] = $details['likes'];
    }
    if (!empty($details['pornstar'])) {
        $video['star_name'] = $details['pornstar'];
    }
    
    // Insert into WordPress
    $postId = insertVideoToWP($conn, $video);
    
    if ($postId) {
        echo "   ✅ Inserted as post ID: $postId\n";
        echo "   📌 Duration: " . ($video['duration'] ?? 'N/A') . " | Views: " . ($video['views'] ?? 0) . " | Tags: " . substr($video['tags'] ?? '', 0, 80) . "...\n";
        $inserted++;
    } else {
        echo "   ❌ Failed to insert\n";
        $errors++;
    }
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📊 SCRAPING COMPLETE!\n";
echo "   ✅ Inserted: $inserted\n";
echo "   ⏭️ Skipped (duplicates): $skipped\n";
echo "   ❌ Errors: $errors\n";
echo "   📹 Total processed: " . count($videos) . "\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

// Count total videos in WP now
$result = $conn->query("SELECT COUNT(*) as cnt FROM " . WP_TABLE_PREFIX . "posts WHERE post_type = 'video' AND post_status = 'publish'");
$row = $result->fetch_assoc();
echo "\n📊 Total videos in WordPress: " . $row['cnt'] . "\n";

$conn->close();
echo "\n✅ Done!\n";
?>
