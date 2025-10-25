<?php
session_start();


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
