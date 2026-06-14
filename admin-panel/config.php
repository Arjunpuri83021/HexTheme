<?php
// Disable WordPress theme for admin panel
define('WP_USE_THEMES', false);

// Load WordPress Core bootstrap file
$wp_load_paths = [
    'C:/xampp/htdocs/wordpress/wp-load.php',
    dirname(__DIR__) . '/wordpress/wp-load.php', // Local sibling folder
    dirname(__DIR__) . '/wp-load.php',          // Subdomain root (Hostinger nested folder)
    $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php', // Server document root
    $_SERVER['DOCUMENT_ROOT'] . '/wordpress/wp-load.php'
];

$loaded = false;
foreach ($wp_load_paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        $loaded = true;
        break;
    }
}

if (!$loaded) {
    die("WordPress load failed. Could not locate wp-load.php. Please configure the correct path in admin-panel/config.php");
}

// Create connection using WordPress database constants defined in wp-config.php
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Session start if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Intercept write actions in demo mode
if ((isset($_SESSION['is_demo']) && $_SESSION['is_demo'] === true) || (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'demo')) {
    $current_page = basename($_SERVER['PHP_SELF']);
    $is_post = ($_SERVER['REQUEST_METHOD'] === 'POST');
    $is_delete_page = ($current_page === 'delete-video.php');
    $has_delete_param = (isset($_GET['delete']) || isset($_GET['delete_tag']) || isset($_GET['delete_pornstar']));

    if ($is_post || $is_delete_page || $has_delete_param) {
        setcookie('demo_alert', '1', time() + 30, '/');
        if ($is_delete_page) {
            header('Location: videos.php');
        } else {
            header("Location: " . $_SERVER['PHP_SELF'] . ( !empty($_SERVER['QUERY_STRING']) && !isset($_GET['delete']) && !isset($_GET['delete_tag']) && !isset($_GET['delete_pornstar']) ? '?' . $_SERVER['QUERY_STRING'] : '' ));
        }
        exit();
    }
}

// Admin credentials
if (!defined('ADMIN_USERNAME')) {
    define('ADMIN_USERNAME', 'admin');
}
if (!defined('ADMIN_PASSWORD')) {
    define('ADMIN_PASSWORD', 'admin123');
}

// Base URL
if (!defined('BASE_URL')) {
    define('BASE_URL', '/admin-panel');
}
?>
