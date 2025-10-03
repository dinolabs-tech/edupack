<?php
/**
 * delete_category.php
 *
 * This script handles the deletion of a blog post category from the database.
 * It requires the user to be logged in; otherwise, it redirects to the login page.
 * The category to be deleted is identified by its ID, passed via a GET parameter.
 * Upon successful deletion, the script redirects to the category management page.
 */

// Start the session to manage user sessions.
session_start();

// Check if the 'username' session variable is not set, meaning the user is not logged in.
if (!isset($_SESSION["user_id"])) {
    // If not logged in, redirect the user to the login page.
    header("Location: index.php");
    exit(); // Terminate script execution after redirection.
}

// Include the database connection file to establish a connection to the database.
include("backend/db_connection.php");

// Retrieve the 'id' of the category to be deleted from the GET request parameters.
// Note: Direct use of GET parameters in SQL queries can be a security risk (SQL injection).
// For production, prepared statements should be used.
$category_id = $_GET["id"];

// Construct the SQL query to delete the category from the 'categories' table
// where the 'id' matches the retrieved category ID.
$sql = "DELETE FROM categories WHERE id = $category_id";

// Execute the SQL query using the database connection.
if ($conn->query($sql) === TRUE) {
    // If the query was successful, redirect the user to the 'manage_categories.php' page.
    header("Location: manage_categories.php");
    exit(); // Terminate script execution after redirection.
} else {
    // If the query failed, display an error message including the SQL error.
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection to free up resources.
$conn->close();
?>
