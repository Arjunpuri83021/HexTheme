<?php
require_once 'config.php';

// Check if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}

$error = '';

// Check if trying to log in using the demo auto-login button
if (isset($_GET['demo']) && $_GET['demo'] === '1') {
    $_SESSION['admin_logged_in'] = true;
    $_SESSION['admin_username'] = 'demo';
    $_SESSION['user_role'] = 'demo';
    $_SESSION['is_demo'] = true;
    setcookie('is_demo', '1', time() + 86400, '/');
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Support admin / admin1234 and fallback to whatever ADMIN_PASSWORD config is set
    if ($username === ADMIN_USERNAME && ($password === ADMIN_PASSWORD || $password === 'admin1234' || $password === 'admin123')) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        $_SESSION['user_role'] = 'admin';
        $_SESSION['is_demo'] = false;
        setcookie('is_demo', '0', time() - 3600, '/');
        header('Location: dashboard.php');
        exit();
    } elseif ($username === 'demo' && ($password === 'demo123' || $password === 'demo')) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = 'demo';
        $_SESSION['user_role'] = 'demo';
        $_SESSION['is_demo'] = true;
        setcookie('is_demo', '1', time() + 86400, '/');
        header('Location: dashboard.php');
        exit();
    } else {
        $error = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIP4K Admin — Login</title>
    <link rel="stylesheet" href="css/admin-style.css?v=4">
</head>
<body class="login-body">
    <div class="login-container">

        <!-- VIP4K Logo -->
        <div class="login-logo">
            <div class="login-logo-mark">
                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
            </div>
            <div class="login-logo-wordmark"><span class="vip">VIP</span><span class="fourk">4K</span></div>
            <div class="login-subtitle">Admin Panel</div>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
            </div>

            <button type="submit" class="btn" style="width: 100%; justify-content: center; margin-top: 8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/></svg>
                Sign In
            </button>
        </form>

        <div style="margin-top: 12px;">
            <a href="index.php?demo=1" class="btn btn-secondary" style="width: 100%; justify-content: center; text-decoration: none; display: flex; align-items: center;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                Try Demo
            </a>
        </div>
    </div>
</body>
</html>
