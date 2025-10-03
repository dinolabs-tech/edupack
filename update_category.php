<?php
// Start a new session or resume the existing session.
session_start();

// Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit(); // Stop script execution after redirection.
}

// Include the database connection file. This file is responsible for establishing a connection to the database.
include("backend/db_connection.php");

// Check if the request method is POST. This script should only process form submissions.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the category ID, name, and description from the POST data.
    $category_id = $_POST["id"];          // The ID of the category to be updated.
    $name = $_POST["name"];               // The new name for the category.
    $description = $_POST["description"]; // The new description for the category.

    // Construct the SQL UPDATE query.
    // It updates the 'name' and 'description' fields for the category with the specified 'id'.
    $sql = "UPDATE categories SET name = '$name', description = '$description' WHERE id = $category_id";

    // Execute the SQL query.
    if ($conn->query($sql) === TRUE) {
        // If the query is successful, redirect the user to the 'manage_categories.php' page.
        header("Location: manage_categories.php");
        exit(); // Stop script execution after redirection.
    } else {
        // If there's an error with the query, display an error message.
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection.
$conn->close();
?>
