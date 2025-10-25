<?php
session_start();
// Check if the user is logged in and is a super user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'super_user') {
    echo "Access Denied";
    exit();
}

if (isset($_GET['log_type'])) {
    $log_type = $_GET['log_type'];
    $log_file = '';

    if ($log_type === 'error_log') {
        $log_file = '../error_log.txt'; // Assuming error_log.txt is in the parent directory
    } elseif ($log_type === 'backup_log') {
        $log_file = 'backup.log'; // Assuming backup.log is in the backend directory
    }

    if (!empty($log_file) && file_exists($log_file)) {
        echo file_get_contents($log_file);
    } else {
        echo "Log file not found or specified.";
    }
} else {
    echo "Invalid log type.";
}
?>
