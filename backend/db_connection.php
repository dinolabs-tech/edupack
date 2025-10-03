<?php
// Include the error handler
require_once 'error_handler.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portalv2";

// Attempt to connect to MySQL server without specifying a database
$conn = new mysqli($servername, $username, $password);

// Check connection to MySQL server
if ($conn->connect_error) {
    customErrorHandler(E_ERROR, "Connection to MySQL server failed: " . $conn->connect_error, __FILE__, __LINE__);
}

// Create database if it does not exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    // Database created successfully or already exists
    // Now close the initial connection and establish a new one to the specific database
    $conn->close();
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection to the specific database
    if ($conn->connect_error) {
        customErrorHandler(E_ERROR, "Connection to database '$dbname' failed: " . $conn->connect_error, __FILE__, __LINE__);
    }
} else {
    customErrorHandler(E_ERROR, "Error creating database: " . $conn->error, __FILE__, __LINE__);
}
?>
