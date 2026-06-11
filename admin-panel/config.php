<?php
// Disable WordPress theme for admin panel
define('WP_USE_THEMES', false);

// Load WordPress Core bootstrap file
if (file_exists('C:/xampp/htdocs/wordpress/wp-load.php')) {
    require_once 'C:/xampp/htdocs/wordpress/wp-load.php';
} else {
    die("WordPress load failed. File not found at C:/xampp/htdocs/wordpress/wp-load.php");
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
