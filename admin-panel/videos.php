<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

// Get all videos from WordPress CPT 'video'
$all_posts = get_posts(array(
    'post_type' => 'video',
    'posts_per_page' => -1,
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
    <title>Hexmy Admin - Videos</title>
    <link rel="stylesheet" href="css/admin-style.css?v=3">
    <script src="js/admin.js?v=3" defer></script>
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
                <h1>Videos</h1>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <a href="add-video.php" class="btn">Add New Video</a>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
        
        <div class="table-container">
            <div style="overflow-x: auto; width: 100%;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Thumbnail</th>
                            <th>Title</th>
                            <th>Star Name</th>
                            <th>Views</th>
                            <th>Likes</th>
                            <th>Duration</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_posts as $post): 
                            $image_url = get_post_meta($post->ID, '_video_image_url', true);
                            $star_name = get_post_meta($post->ID, '_video_star_name', true);
                            $views = intval(get_post_meta($post->ID, '_video_views', true));
                            $likes = intval(get_post_meta($post->ID, '_video_likes', true));
                            $minutes = get_post_meta($post->ID, '_video_minutes', true);
                        ?>
                        <tr>
                            <td><?php echo $post->ID; ?></td>
                            <td>
                                <?php if ($image_url): ?>
                                    <img src="<?php echo htmlspecialchars($image_url); ?>" class="thumbnail" alt="Thumbnail">
                                <?php else: ?>
                                    <div style="width: 80px; height: 48px; background: #1a1a1a; border-radius: 6px; border: 1px solid var(--border-glass);"></div>
                                <?php endif; ?>
                            </td>
                            <td style="font-weight: 500;"><?php echo htmlspecialchars($post->post_title); ?></td>
                            <td><?php echo htmlspecialchars($star_name); ?></td>
                            <td><?php echo number_format($views); ?></td>
                            <td><?php echo number_format($likes); ?></td>
                            <td><span style="background: rgba(255, 255, 255, 0.05); padding: 4px 8px; border-radius: 6px; font-size: 13px; font-weight: 500; border: 1px solid rgba(255, 255, 255, 0.05);"><?php echo htmlspecialchars($minutes); ?></span></td>
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


