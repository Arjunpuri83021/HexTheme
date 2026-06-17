<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

$message = '';

// Add tag
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tag'])) {
    $name = sanitize_text_field($_POST['name']);
    $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $name));
    
    $result = wp_insert_term($name, 'video_tag', array('slug' => $slug));
    
    if ($result && !is_wp_error($result)) {
        $message = '<div class="alert alert-success">Tag added successfully!</div>';
    } else {
        $error_msg = is_wp_error($result) ? $result->get_error_message() : 'Unknown error';
        $message = '<div class="alert alert-danger">Error adding tag: ' . htmlspecialchars($error_msg) . '</div>';
    }
}

// Delete tag
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    wp_delete_term($id, 'video_tag');
    header('Location: tags.php');
    exit();
}

// Get all tags from WordPress taxonomy 'video_tag'
$tags = get_terms(array(
    'taxonomy' => 'video_tag',
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
    <title>Hexmy Admin - Tags</title>
    <link rel="stylesheet" href="css/admin-style.css?v=4">
    <script src="js/admin.js?v=4" defer></script>
</head>
<body>
    <?php $active_page = 'tags.php'; require_once 'sidebar.php'; ?>
    
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
                <h1>Tags</h1>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <?php echo $message; ?>
        
        <div class="form-container" style="margin-bottom: 40px; max-width: 500px;">
            <form method="POST">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="name">Tag Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <button type="submit" name="add_tag" class="btn">Add Tag</button>
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
                        <?php if (!empty($tags) && !is_wp_error($tags)): ?>
                            <?php foreach ($tags as $tag): ?>
                            <tr>
                                <td><?php echo $tag->term_id; ?></td>
                                <td style="font-weight: 500;"><?php echo htmlspecialchars($tag->name); ?></td>
                                <td><?php echo htmlspecialchars($tag->slug); ?></td>
                                <td style="color: var(--text-muted);">-</td>
                                <td>
                                    <a href="tags.php?delete=<?php echo $tag->term_id; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted);">No tags found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>


