<?php
require_once 'config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

$progressFile = __DIR__ . '/scraper_progress.json';

if (!file_exists($progressFile)) {
    echo json_encode(['status' => 'idle']);
    exit();
}

$data = file_get_contents($progressFile);
echo $data ?: json_encode(['status' => 'idle']);
