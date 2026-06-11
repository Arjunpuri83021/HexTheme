<?php
require_once 'config.php';

// Must be logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit();
}

set_time_limit(0);
ignore_user_abort(true);

$progressFile = __DIR__ . '/scraper_progress.json';

// ─────────────────────────────────────────────────────────────
// Helper: write progress to JSON file
// ─────────────────────────────────────────────────────────────
function writeProgress($data) {
    global $progressFile;
    file_put_contents($progressFile, json_encode($data, JSON_UNESCAPED_UNICODE));
}

function addLog($msg) {
    global $progressFile;
    $data = json_decode(file_get_contents($progressFile), true) ?? [];
    $data['log'][] = '[' . date('H:i:s') . '] ' . $msg;
    // Keep only last 200 lines
    if (count($data['log']) > 200) {
        $data['log'] = array_slice($data['log'], -200);
    }
    file_put_contents($progressFile, json_encode($data, JSON_UNESCAPED_UNICODE));
}

// ─────────────────────────────────────────────────────────────
// Helper functions (same scraping logic)
// ─────────────────────────────────────────────────────────────
function parseViewsNumeric($viewsStr) {
    $viewsStr = trim($viewsStr);
    $multiplier = 1;
    if (stripos($viewsStr, 'M') !== false) {
        $multiplier = 1000000;
        $viewsStr = str_ireplace('M', '', $viewsStr);
    } elseif (stripos($viewsStr, 'K') !== false) {
        $multiplier = 1000;
        $viewsStr = str_ireplace(['K', 'k'], '', $viewsStr);
    }
    return intval(floatval($viewsStr) * $multiplier);
}

function fetchUrlHtml($url) {
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
    return ($httpCode === 200) ? $html : false;
}

function parseVideoListings($html) {
    $videos = [];
    preg_match_all('/<div\s+id="video_([^"]+)"[^>]*data-id="(\d+)"[^>]*data-eid="([^"]+)"[^>]*>.*?<\/script>\s*<\/div>/s', $html, $blocks, PREG_SET_ORDER);
    foreach ($blocks as $block) {
        $video = [];
        $video['eid'] = $block[3];
        $video['data_id'] = $block[2];
        $blockHtml = $block[0];
        if (preg_match('/<a\s+href="(\/video\.[^"]+)"/', $blockHtml, $m)) {
            $video['page_url'] = 'https://www.xvideos2.com' . $m[1];
        }
        if (preg_match('/data-src="([^"]+)"/', $blockHtml, $m)) {
            $video['thumbnail'] = $m[1];
        }
        if (preg_match('/data-pvv="([^"]+)"/', $blockHtml, $m)) {
            $video['preview_video'] = trim($m[1]);
        }
        if (preg_match('/title="([^"]+)"/', $blockHtml, $m)) {
            $video['title'] = html_entity_decode($m[1], ENT_QUOTES, 'UTF-8');
        }
        if (preg_match('/<span\s+class="duration">([^<]+)<\/span>/', $blockHtml, $m)) {
            $video['duration'] = trim($m[1]);
        }
        if (preg_match('/<span class="sprfluous">[\s]*-[\s]*<\/span>\s*([\d.]+[MKk]?)\s*<span class="sprfluous">\s*Views/s', $blockHtml, $m)) {
            $video['views'] = parseViewsNumeric($m[1]);
        }
        if (preg_match('/<span\s+class="name">([^<]+)<\/span>/', $blockHtml, $m)) {
            $video['star_name'] = trim($m[1]);
        }
        $video['iframe_url'] = 'https://www.xvideos2.com/embedframe/' . $video['eid'];
        if (!empty($video['title']) && !empty($video['page_url'])) {
            $videos[] = $video;
        }
    }
    return $videos;
}

function fetchVideoDetailsPage($url) {
    $html = fetchUrlHtml($url);
    if (!$html) return [];
    $details = [];
    if (preg_match('/video-tags-list.*?<\/ul>/s', $html, $tagsBlock)) {
        preg_match_all('/<a[^>]*>([^<]+)<\/a>/', $tagsBlock[0], $tagMatches);
        $tags = array_filter($tagMatches[1], function($tag) {
            return $tag !== '+' && $tag !== '-' && trim($tag) !== '';
        });
        $details['tags'] = implode(', ', $tags);
    }
    if (preg_match('/"nb-video-vote-value-up"[^>]*>(\d+)/', $html, $likes)) {
        $details['likes'] = intval($likes[1]);
    } elseif (preg_match('/vote-action-good[^>]*>.*?<span[^>]*>(\d+)/s', $html, $likes)) {
        $details['likes'] = intval($likes[1]);
    }
    $models = [];
    preg_match_all('/<li\s+class="model"[^>]*>.*?<span\s+class="name">([^<]+)<\/span>.*?<\/li>/s', $html, $modelMatches);
    if (!empty($modelMatches[1])) {
        foreach ($modelMatches[1] as $name) {
            $name = trim($name);
            if (!empty($name)) $models[] = $name;
        }
    }
    if (!empty($models)) $details['pornstar'] = implode(', ', array_unique($models));
    return $details;
}

function parseFullhdListings($html) {
    $parts = explode('<div class="item">', $html);
    array_shift($parts); // remove header
    $videos = [];
    foreach ($parts as $part) {
        if (strpos($part, 'class="thumb_img"') === false) {
            continue;
        }
        $video = [];
        // 1. Page URL & Title
        if (preg_match('/href="([^"]+)"[^>]*title="([^"]+)"/i', $part, $m)) {
            $video['page_url'] = trim($m[1]);
            $video['title'] = html_entity_decode($m[2], ENT_QUOTES, 'UTF-8');
        }
        // 2. Preview Video
        if (preg_match('/data-preview="([^"]+)"/i', $part, $m)) {
            $video['preview_video'] = trim($m[1]);
        }
        // 3. Thumbnail
        if (preg_match('/<img[^>]*src="([^"]+)"/i', $part, $m)) {
            $video['thumbnail'] = trim($m[1]);
        }
        // 4. Duration
        if (preg_match('/class="duration">([^<]+)/i', $part, $m)) {
            $duration = trim($m[1]);
            $duration = str_ireplace(['Full Video', 'Trailer'], '', $duration);
            $video['duration'] = trim($duration);
        }
        // 5. Star/Model Name
        preg_match_all('/class="models__item thumb_model"[^>]*>.*?<span>([^<]+)<\/span>/is', $part, $m_stars);
        if (!empty($m_stars[1])) {
            $video['star_name'] = implode(', ', array_map('trim', $m_stars[1]));
        }
        // Extract ID from URL for embed/eid
        if (isset($video['page_url']) && preg_match('#/videos/(\d+)/#', $video['page_url'], $m_id)) {
            $video['eid'] = $m_id[1];
            $video['data_id'] = $m_id[1];
            $video['iframe_url'] = 'https://www.fullhd.xxx/embed/' . $m_id[1] . '/';
        }
        
        $video['views'] = 0;

        if (!empty($video['title']) && !empty($video['page_url'])) {
            $videos[] = $video;
        }
    }
    return $videos;
}

function fetchFullhdVideoDetailsPage($url) {
    $html = fetchUrlHtml($url);
    if (!$html) return [];
    $details = [];
    
    // 1. Tags
    preg_match_all('/class="btn_tag"[^>]*>([^<]+)/i', $html, $tagMatches);
    if (!empty($tagMatches[1])) {
        $tags = array_filter(array_map('trim', $tagMatches[1]), function($tag) {
            return trim($tag) !== '';
        });
        $details['tags'] = implode(', ', array_unique($tags));
    }
    
    // 2. Pornstars/Models
    preg_match_all('/class="btn_model"[^>]*>([^<]+)/i', $html, $modelMatches);
    if (!empty($modelMatches[1])) {
        $models = array_filter(array_map('trim', $modelMatches[1]), function($name) {
            return trim($name) !== '';
        });
        $details['pornstar'] = implode(', ', array_unique($models));
    }
    
    // 3. Views
    if (preg_match('/class="views">([^<]+)/i', $html, $m)) {
        $details['views'] = parseViewsNumeric($m[1]);
    }
    
    // 4. Likes
    if (preg_match('/class="count">(\d+)/i', $html, $m)) {
        $details['likes'] = intval($m[1]);
    }
    
    return $details;
}

function parseBigasszListings($html) {
    $parts = preg_split('/<div[^>]*class="[^"]*card thumb_rel item[^"]*"[^>]*>/i', $html);
    array_shift($parts); // remove text before the first card
    $videos = [];
    
    // Attempt base URL extraction
    $baseUrl = 'https://bigassz.com';
    
    foreach ($parts as $part) {
        $video = [];
        // 1. Page URL & Title
        if (preg_match('/href="([^"]+)"\s+title="([^"]+)"/i', $part, $m)) {
            $video['page_url'] = trim($m[1]);
            $video['title'] = html_entity_decode($m[2], ENT_QUOTES, 'UTF-8');
        } elseif (preg_match('/class="title"[^>]*href="([^"]+)"[^>]*>([^<]+)/is', $part, $m)) {
            $video['page_url'] = trim($m[1]);
            $video['title'] = html_entity_decode(trim($m[2]), ENT_QUOTES, 'UTF-8');
        } elseif (preg_match('/href="([^"]+)"[^>]*class="title"[^>]*>([^<]+)/is', $part, $m)) {
            $video['page_url'] = trim($m[1]);
            $video['title'] = html_entity_decode(trim($m[2]), ENT_QUOTES, 'UTF-8');
        }
        
        if (empty($video['page_url'])) {
            continue;
        }
        
        if (strpos($video['page_url'], 'http') !== 0) {
            $video['page_url'] = $baseUrl . $video['page_url'];
        }
        
        // 2. Thumbnail
        if (preg_match('/data-original="([^"]+)"/i', $part, $m)) {
            $video['thumbnail'] = trim($m[1]);
        } elseif (preg_match('/data-webp="([^"]+)"/i', $part, $m)) {
            $video['thumbnail'] = trim($m[1]);
        } elseif (preg_match('/srcset="([^"\s]+)/i', $part, $m)) {
            $video['thumbnail'] = trim($m[1]);
        }
        
        // 3. Preview Video
        if (preg_match('/data-preview="([^"]+)"/i', $part, $m)) {
            $video['preview_video'] = trim($m[1]);
        }
        
        // 4. Duration
        if (preg_match('/class="badge"[^>]*>.*?\b(\d{1,3}:\d{2}(?::\d{2})?)\s*<\/div>/is', $part, $m)) {
            $video['duration'] = trim($m[1]);
        }
        
        // 5. Embed ID & iframeUrl
        if (preg_match('/\/video\/(\d+)\//', $video['page_url'], $m_id)) {
            $video['eid'] = $m_id[1];
            $video['data_id'] = $m_id[1];
            $video['iframe_url'] = 'https://bigassz.com/embed/' . $m_id[1] . '/';
        }
        
        $video['views'] = 0;
        
        if (!empty($video['title']) && !empty($video['page_url'])) {
            $videos[] = $video;
        }
    }
    return $videos;
}

function fetchBigasszVideoDetailsPage($url) {
    $html = fetchUrlHtml($url);
    if (!$html) return [];
    $details = [];
    
    // 1. Tags
    preg_match_all('/<meta[^>]*property="video:tag"[^>]*content="([^"]+)"/i', $html, $tagMatches);
    if (!empty($tagMatches[1])) {
        $tags = array_unique(array_filter(array_map('trim', $tagMatches[1])));
        $details['tags'] = implode(', ', $tags);
    } else {
        preg_match_all('/href="[^"]*\/tag\/([^"\/]+)\/?"[^>]*>([^<]+)/i', $html, $tagLinks);
        if (!empty($tagLinks[2])) {
            $tags = array_unique(array_filter(array_map('trim', $tagLinks[2])));
            $details['tags'] = implode(', ', $tags);
        }
    }
    
    // 2. Pornstars/Models
    if (preg_match('/"actor"\s*:\s*\[([^\]]+)\]/s', $html, $actorBlock)) {
        preg_match_all('/"name"\s*:\s*"([^"]+)"/i', $actorBlock[1], $actorMatches);
        if (!empty($actorMatches[1])) {
            $models = array_unique(array_filter(array_map('trim', $actorMatches[1])));
            $details['pornstar'] = implode(', ', $models);
        }
    } else {
        preg_match_all('/href="[^"]*\/model\/([^"\/]+)\/?"[^>]*>([^<]+)/i', $html, $modelLinks);
        if (!empty($modelLinks[2])) {
            $models = array_unique(array_filter(array_map('trim', $modelLinks[2])));
            $details['pornstar'] = implode(', ', $models);
        }
    }
    
    // 3. Views
    if (preg_match('/"userInteractionCount"\s*:\s*(\d+)/', $html, $viewsMatch)) {
        $details['views'] = intval($viewsMatch[1]);
    }
    
    // 4. Likes
    if (preg_match('/"interactionType"\s*:\s*\{\s*"@type"\s*:\s*"LikeAction"\s*\}\s*,\s*"userInteractionCount"\s*:\s*(\d+)/s', $html, $likeMatch)) {
        $details['likes'] = intval($likeMatch[1]);
    } elseif (preg_match('/LikeAction"[^}]+}[^}]+"userInteractionCount"\s*:\s*(\d+)/i', $html, $likeMatch)) {
        $details['likes'] = intval($likeMatch[1]);
    }
    
    return $details;
}

function parsePublicpornoListings($html) {
    $parts = preg_split('/<div[^>]*class="[^"]*card thumb_rel item[^"]*"[^>]*>/i', $html);
    array_shift($parts); // remove text before the first card
    $videos = [];
    
    // Attempt base URL extraction
    $baseUrl = 'https://public-porno.com';
    
    foreach ($parts as $part) {
        $video = [];
        // 1. Page URL & Title
        if (preg_match('/href="([^"]+)"\s+title="([^"]+)"/i', $part, $m)) {
            $video['page_url'] = trim($m[1]);
            $video['title'] = html_entity_decode($m[2], ENT_QUOTES, 'UTF-8');
        } elseif (preg_match('/class="title"[^>]*href="([^"]+)"[^>]*>([^<]+)/is', $part, $m)) {
            $video['page_url'] = trim($m[1]);
            $video['title'] = html_entity_decode(trim($m[2]), ENT_QUOTES, 'UTF-8');
        } elseif (preg_match('/href="([^"]+)"[^>]*class="title"[^>]*>([^<]+)/is', $part, $m)) {
            $video['page_url'] = trim($m[1]);
            $video['title'] = html_entity_decode(trim($m[2]), ENT_QUOTES, 'UTF-8');
        }
        
        if (empty($video['page_url'])) {
            continue;
        }
        
        if (strpos($video['page_url'], 'http') !== 0) {
            $video['page_url'] = $baseUrl . $video['page_url'];
        }
        
        // 2. Thumbnail
        if (preg_match('/data-original="([^"]+)"/i', $part, $m)) {
            $video['thumbnail'] = trim($m[1]);
        } elseif (preg_match('/data-webp="([^"]+)"/i', $part, $m)) {
            $video['thumbnail'] = trim($m[1]);
        } elseif (preg_match('/srcset="([^"\s]+)/i', $part, $m)) {
            $video['thumbnail'] = trim($m[1]);
        }
        
        // 3. Preview Video
        if (preg_match('/data-preview="([^"]+)"/i', $part, $m)) {
            $video['preview_video'] = trim($m[1]);
        }
        
        // 4. Duration
        if (preg_match('/class="badge"[^>]*>.*?\b(\d{1,3}:\d{2}(?::\d{2})?)\s*<\/div>/is', $part, $m)) {
            $video['duration'] = trim($m[1]);
        }
        
        // 5. Embed ID & iframeUrl
        if (preg_match('/\/video\/(\d+)\//', $video['page_url'], $m_id)) {
            $video['eid'] = $m_id[1];
            $video['data_id'] = $m_id[1];
            $video['iframe_url'] = 'https://public-porno.com/embed/' . $m_id[1];
        }
        
        $video['views'] = 0;
        
        if (!empty($video['title']) && !empty($video['page_url'])) {
            $videos[] = $video;
        }
    }
    return $videos;
}

function fetchPublicpornoVideoDetailsPage($url) {
    $html = fetchUrlHtml($url);
    if (!$html) return [];
    $details = [];
    
    // 1. Tags and Models from flex-block
    preg_match_all('/<div[^>]*class="[^"]*flex-block[^"]*"[^>]*>(.*?)<\/div>/is', $html, $fbMatches);
    $tags = [];
    $models = [];
    foreach ($fbMatches[1] as $fbContent) {
        // Models
        preg_match_all('/href="[^"]*\/models\/([^"\/]+)\/?"[^>]*>(.*?)<\/a>/is', $fbContent, $modelMatches, PREG_SET_ORDER);
        foreach ($modelMatches as $m) {
            $modelTextClean = preg_replace('/<span[^>]*>.*?<\/span>/i', '', $m[2]);
            $modelTextClean = trim(strip_tags($modelTextClean));
            if (!empty($modelTextClean)) {
                $models[] = $modelTextClean;
            }
        }
        
        // Tags
        preg_match_all('/href="[^"]*\/(?:categories|tags|tag)\/([^"\/]+)\/?"[^>]*>(.*?)<\/a>/is', $fbContent, $tagMatches, PREG_SET_ORDER);
        foreach ($tagMatches as $m) {
            $tagTextClean = trim(strip_tags($m[2]));
            if (!empty($tagTextClean)) {
                $tags[] = $tagTextClean;
            }
        }
    }
    
    if (!empty($tags)) {
        $details['tags'] = implode(', ', array_unique($tags));
    }
    if (!empty($models)) {
        $details['pornstar'] = implode(', ', array_unique($models));
    }
    
    // 2. Views
    if (preg_match('/"userInteractionCount"\s*:\s*(\d+)/', $html, $viewsMatch)) {
        $details['views'] = intval($viewsMatch[1]);
    }
    
    // 3. Likes
    if (preg_match('/rate-like[^"]*"[^>]*>.*?class="second"[^>]*>(\d+)<\/span>/is', $html, $likeHTML)) {
        $details['likes'] = intval($likeHTML[1]);
    }
    
    return $details;
}

function hexmy_check_video_exists($url, $title) {
    global $wpdb;
    $postId = $wpdb->get_var($wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_video_url' AND meta_value = %s LIMIT 1",
        $url
    ));
    if ($postId) return intval($postId);
    $variants = array_unique(array_filter([
        $title,
        html_entity_decode($title, ENT_QUOTES, 'UTF-8'),
        esc_html($title)
    ]));
    foreach ($variants as $variant) {
        $post = get_page_by_title($variant, OBJECT, 'video');
        if ($post) return $post->ID;
    }
    return false;
}

// ─────────────────────────────────────────────────────────────
// START SCRAPING
// ─────────────────────────────────────────────────────────────
$targetUrl = trim($_POST['scraper_url'] ?? '');
$limit     = max(1, intval($_POST['video_limit'] ?? 10));
$catId     = intval($_POST['video_category'] ?? 0);

if (empty($targetUrl)) {
    writeProgress(['status' => 'error', 'message' => 'No URL provided.', 'log' => []]);
    exit();
}

// Initialize progress file
writeProgress([
    'status'      => 'running',
    'message'     => 'Initializing crawler...',
    'total'       => 0,
    'done'        => 0,
    'skipped'     => 0,
    'errors'      => 0,
    'remaining'   => 0,
    'pct'         => 0,
    'current'     => '',
    'log'         => ['[' . date('H:i:s') . '] 🚀 Crawler initialized.'],
    'started_at'  => date('Y-m-d H:i:s'),
]);

$isFullhd = (strpos($targetUrl, 'fullhd.xxx') !== false);
$isBigassz = (strpos($targetUrl, 'bigassz.com') !== false);
$isPublicporno = (strpos($targetUrl, 'public-porno.com') !== false);

if ($isFullhd) {
    addLog("🔍 Target is FullHD.xxx listings page: $targetUrl");
} elseif ($isBigassz) {
    addLog("🔍 Target is Bigassz.com listings page: $targetUrl");
} elseif ($isPublicporno) {
    addLog("🔍 Target is Public-Porno.com listings page: $targetUrl");
} else {
    addLog("🔍 Fetching listings page: $targetUrl");
}

$html = fetchUrlHtml($targetUrl);
if (!$html) {
    $data = json_decode(file_get_contents($progressFile), true);
    $data['status']  = 'error';
    $data['message'] = '❌ Failed to fetch listings page. Check URL.';
    $data['log'][]   = '[' . date('H:i:s') . '] ❌ Failed to fetch: ' . $targetUrl;
    writeProgress($data);
    exit();
}

addLog("✅ Listings page fetched successfully.");

if ($isFullhd) {
    $videos = parseFullhdListings($html);
} elseif ($isBigassz) {
    $videos = parseBigasszListings($html);
} elseif ($isPublicporno) {
    $videos = parsePublicpornoListings($html);
} else {
    $videos = parseVideoListings($html);
}
$foundCount = count($videos);
addLog("📊 Found $foundCount video blocks on page.");

if (empty($videos)) {
    $data = json_decode(file_get_contents($progressFile), true);
    $data['status']  = 'error';
    $data['message'] = '⚠️ No video blocks found. Site structure may have changed.';
    writeProgress($data);
    exit();
}

if ($foundCount > $limit) {
    $videos = array_slice($videos, 0, $limit);
}
$processCount = count($videos);
addLog("📌 Will process $processCount videos (limit: $limit).");

// Update total in progress
$data = json_decode(file_get_contents($progressFile), true);
$data['total']     = $processCount;
$data['remaining'] = $processCount;
$data['message']   = "Found $processCount videos — starting scrape...";
writeProgress($data);

$inserted = 0;
$skipped  = 0;
$errors   = 0;

foreach ($videos as $index => $video) {
    $num = $index + 1;
    $title = $video['title'];

    // Update current video in progress
    $data = json_decode(file_get_contents($progressFile), true);
    $processed       = $inserted + $skipped + $errors;
    $data['current'] = $title;
    $data['remaining'] = $processCount - $processed;
    $data['pct']     = $processCount > 0 ? round(($processed / $processCount) * 100) : 0;
    $data['message'] = "Processing [$num/$processCount]...";
    $data['log'][]   = '[' . date('H:i:s') . '] ─────────────────────────';
    $data['log'][]   = '[' . date('H:i:s') . "] 📹 [$num/$processCount] $title";
    writeProgress($data);

    // Duplicate check
    $existingId = hexmy_check_video_exists($video['page_url'], $title);
    if ($existingId) {
        $skipped++;
        $data = json_decode(file_get_contents($progressFile), true);
        $data['skipped'] = $skipped;
        $processed = $inserted + $skipped + $errors;
        $data['remaining'] = max(0, $processCount - $processed);
        $data['pct']     = $processCount > 0 ? round(($processed / $processCount) * 100) : 0;
        $data['message'] = "Skipped duplicate [$num/$processCount]";
        $data['log'][]   = '[' . date('H:i:s') . "] ⏭️ Already exists (ID: $existingId). Skipping.";
        writeProgress($data);
        continue;
    }

    // Polite delay
    addLog("[" . date('H:i:s') . "] ⌛ Polite wait (2s)...");
    sleep(2);

    // Fetch detail page
    addLog("[" . date('H:i:s') . "] 🔍 Fetching detail page metadata...");
    if ($isFullhd) {
        $details = fetchFullhdVideoDetailsPage($video['page_url']);
    } elseif ($isBigassz) {
        $details = fetchBigasszVideoDetailsPage($video['page_url']);
    } elseif ($isPublicporno) {
        $details = fetchPublicpornoVideoDetailsPage($video['page_url']);
    } else {
        $details = fetchVideoDetailsPage($video['page_url']);
    }
    if (!empty($details['tags']))     $video['tags']      = $details['tags'];
    if (!empty($details['likes']))    $video['likes']     = $details['likes'];
    if (!empty($details['pornstar'])) $video['star_name'] = $details['pornstar'];
    if (($isFullhd || $isBigassz || $isPublicporno) && isset($details['views'])) {
        $video['views'] = $details['views'];
    }

    // Insert post
    addLog("[" . date('H:i:s') . "] 💾 Saving post to WordPress...");
    $postId = wp_insert_post([
        'post_title'   => sanitize_text_field($title),
        'post_content' => wp_kses_post($video['tags'] ?? ''),
        'post_status'  => 'publish',
        'post_type'    => 'video',
    ]);

    if ($postId && !is_wp_error($postId)) {
        update_post_meta($postId, '_video_image_url',    esc_url_raw($video['thumbnail'] ?? ''));
        update_post_meta($postId, '_video_preview_video',esc_url_raw($video['preview_video'] ?? ''));
        update_post_meta($postId, '_video_url',          esc_url_raw($video['page_url'] ?? ''));
        update_post_meta($postId, '_video_iframe_url',   esc_url_raw($video['iframe_url'] ?? ''));
        update_post_meta($postId, '_video_minutes',      sanitize_text_field($video['duration'] ?? ''));
        update_post_meta($postId, '_video_views',        intval($video['views'] ?? 0));
        update_post_meta($postId, '_video_likes',        intval($video['likes'] ?? 0));
        update_post_meta($postId, '_video_alt_keywords', sanitize_textarea_field($video['tags'] ?? ''));
        update_post_meta($postId, '_video_star_name',    sanitize_text_field($video['star_name'] ?? ''));

        if (function_exists('hexmy_sync_post_terms')) hexmy_sync_post_terms($postId);
        if ($catId > 0) wp_set_object_terms($postId, $catId, 'video_category', false);
        wp_set_object_terms($postId, 'cute', 'video_tag', true);

        $inserted++;
        $data = json_decode(file_get_contents($progressFile), true);
        $data['done']    = $inserted;
        $processed = $inserted + $skipped + $errors;
        $data['remaining'] = max(0, $processCount - $processed);
        $data['pct']     = $processCount > 0 ? round(($processed / $processCount) * 100) : 0;
        $data['message'] = "Scraped $inserted of $processCount videos";
        $data['log'][]   = '[' . date('H:i:s') . "] ✅ Saved! Post ID: $postId";
        writeProgress($data);
    } else {
        $err = is_wp_error($postId) ? $postId->get_error_message() : 'Unknown Error';
        $errors++;
        $data = json_decode(file_get_contents($progressFile), true);
        $data['errors']  = $errors;
        $processed = $inserted + $skipped + $errors;
        $data['remaining'] = max(0, $processCount - $processed);
        $data['pct']     = $processCount > 0 ? round(($processed / $processCount) * 100) : 0;
        $data['message'] = "Error on video $num";
        $data['log'][]   = '[' . date('H:i:s') . "] ❌ Failed: $err";
        writeProgress($data);
    }
}

// Final state
$data = json_decode(file_get_contents($progressFile), true);
$data['status']    = 'done';
$data['done']      = $inserted;
$data['skipped']   = $skipped;
$data['errors']    = $errors;
$data['remaining'] = 0;
$data['pct']       = 100;
$data['current']   = '';
$data['message']   = "✅ Complete! Inserted: $inserted | Skipped: $skipped | Errors: $errors";
$data['log'][]     = '[' . date('H:i:s') . '] ══════════════════════════════';
$data['log'][]     = '[' . date('H:i:s') . '] 📊 DONE — Inserted: ' . $inserted . ' | Skipped: ' . $skipped . ' | Errors: ' . $errors;
$data['log'][]     = '[' . date('H:i:s') . '] 🚀 Scraper completed successfully!';
$data['finished_at'] = date('Y-m-d H:i:s');
writeProgress($data);

echo json_encode(['ok' => true]);
