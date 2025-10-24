<?php
// Include database connection
include_once 'db_connection.php'; // Assuming db_connection.php is in the same directory or accessible

// Initialize Flutterwave keys with default empty values
$flutterwave_public_key = '';
$flutterwave_secret_key = '';

// Fetch Flutterwave API Keys from the database
if (isset($conn) && $conn instanceof mysqli) {
    $stmt = $conn->prepare("SELECT setting_name, setting_value FROM admission_settings WHERE setting_name IN (?, ?)");
    $public_key_name = 'flutterwave_public_key';
    $secret_key_name = 'flutterwave_secret_key';
    $stmt->bind_param("ss", $public_key_name, $secret_key_name);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if ($row['setting_name'] === 'flutterwave_public_key') {
            $flutterwave_public_key = $row['setting_value'];
        } elseif ($row['setting_name'] === 'flutterwave_secret_key') {
            $flutterwave_secret_key = $row['setting_value'];
        }
    }
    $stmt->close();
} else {
    // Log an error or handle the case where $conn is not available
    error_log("Database connection not available in config.php");
}

// Define Flutterwave API Keys constants
define('FLUTTERWAVE_PUBLIC_KEY', $flutterwave_public_key);
define('FLUTTERWAVE_SECRET_KEY', $flutterwave_secret_key);

// Other configurations can go here
?>
