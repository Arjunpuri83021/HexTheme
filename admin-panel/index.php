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
    <title>Hexmy Admin - Login</title>
    <link rel="stylesheet" href="css/admin-style.css">
</head>
<body class="login-body">
    <div class="login-container">
        <div class="sidebar-logo">HEXMY</div>
        <h2>Admin Login</h2>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn" style="width: 100%; justify-content: center;">Login</button>
        </form>

        <div style="margin-top: 15px;">
            <a href="index.php?demo=1" class="btn" style="width: 100%; justify-content: center; background: linear-gradient(135deg, #e7434a, #ec4899); border: none; text-decoration: none; display: flex; align-items: center;">Demo Account</a>
        </div>
    </div>
</body>
</html>
