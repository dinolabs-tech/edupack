<?php
/**
 * delete_comment.php
 *
 * This script handles the deletion of a specific comment from a blog post.
 * It requires the user to be logged in; otherwise, it redirects to the login page.
 * The comment to be deleted is identified by its ID, passed via a GET parameter.
 * Before deleting, it retrieves the associated post ID to redirect the user back
 * to the correct post page after deletion.
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

// Retrieve the 'id' of the comment to be deleted from the GET request parameters.
// Note: Direct use of GET parameters in SQL queries can be a security risk (SQL injection).
// For production, prepared statements should be used.
$comment_id = $_GET["id"];

// First, retrieve the comment to get its associated 'post_id'.
// This is necessary to redirect the user back to the correct post after deletion.
$sql = "SELECT * FROM comments WHERE id = $comment_id";
// Execute the query.
$result = $conn->query($sql);

// Check if no comment was found with the given ID.
if ($result->num_rows == 0) {
    // If the comment does not exist, display an error message and terminate.
    echo "Comment not found";
    exit();
}

// Fetch the comment details as an associative array.
$comment = $result->fetch_assoc();
// Extract the 'post_id' from the fetched comment.
$post_id = $comment["post_id"];

// Construct the SQL query to delete the comment from the 'comments' table
// where the 'id' matches the retrieved comment ID.
$sql = "DELETE FROM comments WHERE id = $comment_id";

// Execute the SQL query using the database connection.
if ($conn->query($sql) === TRUE) {
    // If the query was successful, redirect the user back to the original blog post page.
    // The 'post_id' is appended to the URL as a GET parameter.
    header("Location: post.php?id=$post_id");
    exit(); // Terminate script execution after redirection.
} else {
    // If the query failed, display an error message including the SQL error.
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection to free up resources.
$conn->close();
?>
