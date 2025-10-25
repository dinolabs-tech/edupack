<?php
session_start();
// Check if the user is logged in and is a super user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Superuser') {
    header("Location: login.php");
    exit();
}

$file = 'backup_dinolabs_edupack.sql'; // The name of the SQL backup file

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
} else {
    echo "Backup file not found.";
}
?>
