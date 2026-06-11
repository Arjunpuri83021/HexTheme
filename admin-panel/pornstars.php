<?php
require_once 'config.php';

// Check authentication
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit();
}

$message = '';

// Add pornstar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_pornstar'])) {
    $name = sanitize_text_field($_POST['name']);
    $slug = strtolower(preg_replace('/[^a-z0-9]+/', '-', $name));
    $image_url = esc_url_raw($_POST['image_url']);
    $bio = sanitize_textarea_field($_POST['bio']);
    
    $result = wp_insert_term($name, 'pornstar', array(
        'slug' => $slug,
        'description' => $bio
    ));
    
    if ($result && !is_wp_error($result)) {
        $term_id = intval($result['term_id']);
        if (!empty($image_url)) {
            update_term_meta($term_id, '_pornstar_image_url', $image_url);
        }
        $message = '<div class="alert alert-success">Pornstar added successfully!</div>';
    } else {
        $error_msg = is_wp_error($result) ? $result->get_error_message() : 'Unknown error';
        $message = '<div class="alert alert-danger">Error adding pornstar: ' . htmlspecialchars($error_msg) . '</div>';
    }
}

// Delete pornstar
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    wp_delete_term($id, 'pornstar');
    header('Location: pornstars.php');
    exit();
}

// Get all pornstars from WordPress taxonomy 'pornstar'
$pornstars = get_terms(array(
    'taxonomy' => 'pornstar',
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
    <title>Hexmy Admin - Pornstars</title>
    <link rel="stylesheet" href="css/admin-style.css">
    <script src="js/admin.js" defer></script>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-logo">HEXMY</div>
        <a href="dashboard.php" class="nav-item">Dashboard</a>
        <a href="videos.php" class="nav-item">Videos</a>
        <a href="add-video.php" class="nav-item">Add Video</a>
        <a href="categories.php" class="nav-item">Categories</a>
        <a href="tags.php" class="nav-item">Tags</a>
        <a href="pornstars.php" class="nav-item active">Pornstars</a>
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
                <h1>Pornstars</h1>
            </div>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        
        <?php echo $message; ?>
        
        <div class="form-container" style="margin-bottom: 40px;">
            <form method="POST">
                <div class="form-group">
                    <label for="name">Performer Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="image_url">Image URL</label>
                    <input type="url" id="image_url" name="image_url">
                </div>
                <div class="form-group">
                    <label for="bio">Biography</label>
                    <textarea id="bio" name="bio"></textarea>
                </div>
                <button type="submit" name="add_pornstar" class="btn">Add Pornstar</button>
            </form>
        </div>
        
        <div class="table-container">
            <div style="overflow-x: auto; width: 100%;">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Bio</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pornstars) && !is_wp_error($pornstars)): ?>
                            <?php foreach ($pornstars as $star): 
                                $image_url = get_term_meta($star->term_id, '_pornstar_image_url', true);
                            ?>
                            <tr>
                                <td><?php echo $star->term_id; ?></td>
                                <td>
                                    <?php if ($image_url): ?>
                                        <img src="<?php echo htmlspecialchars($image_url); ?>" class="avatar" alt="Avatar">
                                    <?php else: ?>
                                        <div style="width: 48px; height: 48px; background: #1a1a1a; border-radius: 50%; border: 1px solid var(--border-glass);"></div>
                                    <?php endif; ?>
                                </td>
                                <td style="font-weight: 500;"><?php echo htmlspecialchars($star->name); ?></td>
                                <td style="color: var(--text-muted); line-height: 1.5;"><?php echo htmlspecialchars(substr($star->description, 0, 100)); ?><?php echo strlen($star->description) > 100 ? '...' : ''; ?></td>
                                <td style="color: var(--text-muted);">-</td>
                                <td>
                                    <a href="pornstars.php?delete=<?php echo $star->term_id; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted);">No performers found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
