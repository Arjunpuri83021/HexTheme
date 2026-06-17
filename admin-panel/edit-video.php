<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = '';

// Get video post from WordPress
$post = get_post($id);

if (!$post || $post->post_type !== 'video') {
    header('Location: videos.php');
    exit();
}

// Fetch all video categories
$categories = get_terms(array(
    'taxonomy' => 'video_category',
    'hide_empty' => false
));
$assigned_categories = wp_get_object_terms($id, 'video_category', array('fields' => 'ids'));
if (is_wp_error($assigned_categories)) $assigned_categories = array();

// Map values
$video = array(
    'title' => $post->post_title,
    'description' => $post->post_content,
    'image_url' => get_post_meta($post->ID, '_video_image_url', true),
    'preview_video' => get_post_meta($post->ID, '_video_preview_video', true),
    'alt_keywords' => get_post_meta($post->ID, '_video_alt_keywords', true),
    'star_name' => get_post_meta($post->ID, '_video_star_name', true),
    'views' => intval(get_post_meta($post->ID, '_video_views', true)),
    'iframe_url' => get_post_meta($post->ID, '_video_iframe_url', true),
    'video_url' => get_post_meta($post->ID, '_video_url', true),
    'minutes' => get_post_meta($post->ID, '_video_minutes', true),
    'likes' => intval(get_post_meta($post->ID, '_video_likes', true)),
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $image_url = $_POST['image_url'];
    $preview_video = $_POST['preview_video'];
    $alt_keywords = $_POST['alt_keywords'];
    $star_name = $_POST['star_name'];
    $views = $_POST['views'];
    $iframe_url = $_POST['iframe_url'];
    $video_url = $_POST['video_url'];
    $minutes = $_POST['minutes'];
    $description = $_POST['description'];
    $likes = $_POST['likes'];
    
    // Update video post in WordPress
    $updated_post = wp_update_post(array(
        'ID'           => $id,
        'post_title'   => sanitize_text_field($title),
        'post_content' => wp_kses_post($description),
    ), true);
    
    if ($updated_post && !is_wp_error($updated_post)) {
        // Save post metadata
        update_post_meta($id, '_video_image_url', esc_url_raw($image_url));
        update_post_meta($id, '_video_preview_video', esc_url_raw($preview_video));
        update_post_meta($id, '_video_alt_keywords', sanitize_textarea_field($alt_keywords));
        update_post_meta($id, '_video_star_name', sanitize_text_field($star_name));
        update_post_meta($id, '_video_views', intval($views));
        update_post_meta($id, '_video_iframe_url', esc_url_raw($iframe_url));
        update_post_meta($id, '_video_url', esc_url_raw($video_url));
        update_post_meta($id, '_video_minutes', sanitize_text_field($minutes));
        update_post_meta($id, '_video_likes', intval($likes));
        
        // Sync custom taxonomies (tags and performers)
        if (function_exists('hexmy_sync_post_terms')) {
            hexmy_sync_post_terms($id);
        }
        
        // Assign selected categories
        if (isset($_POST['categories']) && is_array($_POST['categories'])) {
            $cat_ids = array_map('intval', $_POST['categories']);
            wp_set_object_terms($id, $cat_ids, 'video_category', false);
        } else {
            wp_set_object_terms($id, array(), 'video_category', false);
        }
        
        $message = '<div class="alert alert-success">Video updated successfully!</div>';
        
        // Refresh local variables
        $post = get_post($id);
        $assigned_categories = wp_get_object_terms($id, 'video_category', array('fields' => 'ids'));
        if (is_wp_error($assigned_categories)) $assigned_categories = array();
        
        $video = array(
            'title' => $post->post_title,
            'description' => $post->post_content,
            'image_url' => get_post_meta($id, '_video_image_url', true),
            'preview_video' => get_post_meta($id, '_video_preview_video', true),
            'alt_keywords' => get_post_meta($id, '_video_alt_keywords', true),
            'star_name' => get_post_meta($id, '_video_star_name', true),
            'views' => intval(get_post_meta($id, '_video_views', true)),
            'iframe_url' => get_post_meta($id, '_video_iframe_url', true),
            'video_url' => get_post_meta($id, '_video_url', true),
            'minutes' => get_post_meta($id, '_video_minutes', true),
            'likes' => intval(get_post_meta($id, '_video_likes', true)),
        );
    } else {
        $error_msg = is_wp_error($updated_post) ? $updated_post->get_error_message() : 'Unknown error';
        $message = '<div class="alert alert-danger">Error updating video: ' . htmlspecialchars($error_msg) . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hexmy Admin - Edit Video</title>
    <link rel="stylesheet" href="css/admin-style.css?v=4">
    <script src="js/admin.js?v=4" defer></script>
</head>
<body>
    <?php $active_page = 'videos.php'; require_once 'sidebar.php'; ?>
    
    <div class="main-content">
        <div class="header">
            <div style="display: flex; align-items: center; gap: 15px;">
                <button id="menu-toggle" class="menu-toggle">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <h1>Edit Video</h1>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <?php echo $message; ?>
        
        <div class="form-container">
            <form method="POST">
                <div class="form-section">
                    <h3>Basic Information</h3>
                    <div class="form-group">
                        <label for="title">Title *</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($video['title']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="image_url">Image URL *</label>
                        <input type="url" id="image_url" name="image_url" value="<?php echo htmlspecialchars($video['image_url']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="preview_video">Preview Video URL</label>
                        <input type="url" id="preview_video" name="preview_video" value="<?php echo htmlspecialchars($video['preview_video']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="alt_keywords">Alt Keywords (comma separated) *</label>
                        <input type="text" id="alt_keywords" name="alt_keywords" value="<?php echo htmlspecialchars($video['alt_keywords']); ?>" placeholder="keyword1, keyword2, keyword3" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="star_name">Star Name *</label>
                        <input type="text" id="star_name" name="star_name" value="<?php echo htmlspecialchars($video['star_name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Categories</label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px; background: rgba(0, 0, 0, 0.2); padding: 20px; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 10px; max-height: 200px; overflow-y: auto;">
                            <?php if (!empty($categories) && !is_wp_error($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <label style="display: flex; align-items: center; gap: 8px; font-weight: 500; cursor: pointer; color: var(--text-main); margin-bottom: 0; font-size: 14px;">
                                        <input type="checkbox" name="categories[]" value="<?php echo $cat->term_id; ?>" style="width: auto; height: auto; margin-right: 5px;" <?php echo in_array($cat->term_id, $assigned_categories) ? 'checked' : ''; ?>>
                                        <?php echo htmlspecialchars($cat->name); ?>
                                    </label>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <span style="color: var(--text-muted); font-size: 14px;">No categories found. Add some categories first.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Video Information</h3>
                    <div class="form-group">
                        <label for="views">Views</label>
                        <input type="number" id="views" name="views" value="<?php echo $video['views']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="iframe_url">Iframe URL</label>
                        <input type="url" id="iframe_url" name="iframe_url" value="<?php echo htmlspecialchars($video['iframe_url']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="video_url">Video URL</label>
                        <input type="url" id="video_url" name="video_url" value="<?php echo htmlspecialchars($video['video_url']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="minutes">Duration (minutes)</label>
                        <input type="text" id="minutes" name="minutes" value="<?php echo htmlspecialchars($video['minutes']); ?>" placeholder="e.g., 10:30">
                    </div>
                    
                    <div class="form-group">
                        <label for="likes">Likes</label>
                        <input type="number" id="likes" name="likes" value="<?php echo $video['likes']; ?>">
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Description</h3>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description"><?php echo htmlspecialchars($video['description']); ?></textarea>
                    </div>
                </div>
                
                <div style="margin-top: 30px; display: flex; gap: 15px;">
                    <button type="submit" class="btn">Update Video</button>
                    <a href="videos.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>


