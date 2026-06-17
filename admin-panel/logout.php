<?php
require_once 'config.php';

session_destroy();
setcookie('is_demo', '', time() - 3600, '/');
setcookie('demo_alert', '', time() - 3600, '/');
header('Location: index.php');
exit();
?>
