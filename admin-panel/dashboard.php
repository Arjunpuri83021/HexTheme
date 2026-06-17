<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Get statistics from WordPress
$video_counts = wp_count_posts('video');
$total_videos = ($video_counts->publish ?? 0) + ($video_counts->draft ?? 0) + ($video_counts->private ?? 0);

global $wpdb;
$total_views = $wpdb->get_var("SELECT SUM(CAST(meta_value AS UNSIGNED)) FROM {$wpdb->postmeta} WHERE meta_key = '_video_views'") ?? 0;
$total_likes = $wpdb->get_var("SELECT SUM(CAST(meta_value AS UNSIGNED)) FROM {$wpdb->postmeta} WHERE meta_key = '_video_likes'") ?? 0;

$total_categories = wp_count_terms(array('taxonomy' => 'video_category', 'hide_empty' => false));
if (is_wp_error($total_categories)) $total_categories = 0;

$total_tags = wp_count_terms(array('taxonomy' => 'video_tag', 'hide_empty' => false));
if (is_wp_error($total_tags)) $total_tags = 0;

$total_pornstars = wp_count_terms(array('taxonomy' => 'pornstar', 'hide_empty' => false));
if (is_wp_error($total_pornstars)) $total_pornstars = 0;

$recent_posts = get_posts(array(
    'post_type' => 'video',
    'posts_per_page' => 5,
    'post_status' => 'any',
    'orderby' => 'date',
    'order' => 'DESC'
));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>69Tube Admin — Dashboard</title>
    <link rel="stylesheet" href="css/admin-style.css?v=4">
    <script src="js/admin.js?v=4" defer></script>
</head>
<body>
    <?php $active_page = 'dashboard.php'; require_once 'sidebar.php'; ?>
    
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
                <h1>Dashboard</h1>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Videos</div>
                <div class="stat-value"><?php echo $total_videos; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Views</div>
                <div class="stat-value"><?php echo number_format($total_views); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Total Likes</div>
                <div class="stat-value"><?php echo number_format($total_likes); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Categories</div>
                <div class="stat-value"><?php echo $total_categories; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Tags</div>
                <div class="stat-value"><?php echo $total_tags; ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pornstars</div>
                <div class="stat-value"><?php echo $total_pornstars; ?></div>
            </div>
        </div>
        
        <div class="table-container">
            <div class="section-title">
                Recent Videos
                <a href="add-video.php" class="btn">Add New Video</a>
            </div>
            <div style="overflow-x: auto; width: 100%;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Star Name</th>
                            <th>Views</th>
                            <th>Likes</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_posts as $post): 
                            $star_name = get_post_meta($post->ID, '_video_star_name', true);
                            $views = intval(get_post_meta($post->ID, '_video_views', true));
                            $likes = intval(get_post_meta($post->ID, '_video_likes', true));
                        ?>
                        <tr>
                            <td><?php echo $post->ID; ?></td>
                            <td style="font-weight: 500;"><?php echo htmlspecialchars($post->post_title); ?></td>
                            <td><?php echo htmlspecialchars($star_name); ?></td>
                            <td><?php echo number_format($views); ?></td>
                            <td><?php echo number_format($likes); ?></td>
                            <td style="color: var(--text-muted);"><?php echo date('Y-m-d', strtotime($post->post_date)); ?></td>
                            <td>
                                <a href="edit-video.php?id=<?php echo $post->ID; ?>" class="action-btn edit-btn">Edit</a>
                                <a href="delete-video.php?id=<?php echo $post->ID; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>


