<?php
session_start();

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== 'LoggedIn') {
    http_response_code(403);
    echo 'Not logged in';
    exit;
}

if (!isset($_GET['file'])) {
    http_response_code(400);
    echo 'No file specified';
    exit;
}

$safeFile = basename($_GET['file']);
$fullPath = __DIR__ . '/uploads/' . $safeFile;

exec("mpg123 " . escapeshellarg($fullPath) . " > /dev/null 2>&1 &");
?>
