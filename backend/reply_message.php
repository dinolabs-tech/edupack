<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'db_connection.php';

// Ensure that the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Use the logged in user's id as the sender, regardless of what is sent from the form
    $from_user = $_SESSION['user_id'];
    
    // Sanitize and retrieve POST data
    $to_user   = $conn->real_escape_string($_POST['to_user']);
    $subject   = $conn->real_escape_string($_POST['subject']);
    $message   = $conn->real_escape_string($_POST['message']);
    // Optional: reference to the original message (if needed for tracking)
    $reply_to  = isset($_POST['reply_to']) ? $conn->real_escape_string($_POST['reply_to']) : null;
    
    // Set default status (0 for unread)
    $status    = 0;
    
    // Insert the reply into the mail table
    $sql = "INSERT INTO mail (subject, message, from_user, to_user, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        customErrorHandler(E_ERROR, "Error preparing statement: " . $conn->error, __FILE__, __LINE__);
        exit();
    }
    $stmt->bind_param("ssiii", $subject, $message, $from_user, $to_user, $status);
    if ($stmt->execute()) {
        // Optionally, you can use the reply_to value here if you want to thread conversations.
        // Redirect back to the inbox or to the original message view
        header("Location: inbox.php");
        exit();
    } else {
        customErrorHandler(E_ERROR, "Error sending reply: " . $stmt->error, __FILE__, __LINE__);
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
