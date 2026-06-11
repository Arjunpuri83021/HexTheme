<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

$message = '';

// Add category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $name = sanitize_text_field($_POST['name']);
    $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $name));
    
    $result = wp_insert_term($name, 'video_category', array('slug' => $slug));
    
    if ($result && !is_wp_error($result)) {
        $message = '<div class="alert alert-success">Category added successfully!</div>';
    } else {
        $error_msg = is_wp_error($result) ? $result->get_error_message() : 'Unknown error';
        $message = '<div class="alert alert-danger">Error adding category: ' . htmlspecialchars($error_msg) . '</div>';
    }
}

// Delete category
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    wp_delete_term($id, 'video_category');
    header('Location: categories.php');
    exit();
}

// Get all categories from WordPress taxonomy 'video_category'
$categories = get_terms(array(
    'taxonomy' => 'video_category',
    'hide_empty' => false,
    'orderby' => 'id',
    'order' => 'DESC'
));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hexmy Admin - Categories</title>
    <link rel="stylesheet" href="css/admin-style.css">
    <script src="js/admin.js" defer></script>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">HEXMY</div>
        <a href="dashboard.php" class="nav-item">Dashboard</a>
        <a href="videos.php" class="nav-item">Videos</a>
        <a href="add-video.php" class="nav-item">Add Video</a>
        <a href="categories.php" class="nav-item active">Categories</a>
        <a href="tags.php" class="nav-item">Tags</a>
        <a href="pornstars.php" class="nav-item">Pornstars</a>
        <a href="scraper.php" class="nav-item">Scraper</a>
    </div>
    
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
                <h1>Categories</h1>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <?php echo $message; ?>
        
        <div class="form-container" style="margin-bottom: 40px; max-width: 500px;">
            <form method="POST">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="name">Category Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <button type="submit" name="add_category" class="btn">Add Category</button>
            </form>
        </div>
        
        <div class="table-container">
            <div style="overflow-x: auto; width: 100%;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories) && !is_wp_error($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><?php echo $cat->term_id; ?></td>
                                <td style="font-weight: 500;"><?php echo htmlspecialchars($cat->name); ?></td>
                                <td><?php echo htmlspecialchars($cat->slug); ?></td>
                                <td style="color: var(--text-muted);">-</td>
                                <td>
                                    <a href="categories.php?delete=<?php echo $cat->term_id; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted);">No categories found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
