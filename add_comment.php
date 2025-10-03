<?php
/**
 * add_comment.php
 *
 * This script handles the submission of new comments for blog posts.
 * It receives POST data containing the post ID, commenter's name, email, and the comment content.
 * The script then inserts this information into the 'comments' table in the database.
 * Upon successful insertion, it redirects the user back to the original blog post.
 */

// Start the session to manage user sessions.
session_start();

// Include the database connection file. This file is responsible for establishing a connection to the database.
include("backend/db_connection.php");

// Check if the current request method is POST. This ensures the script only processes form submissions.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the 'post_id' from the POST data. This identifies which blog post the comment belongs to.
    $post_id = $_POST["post_id"];
    // Retrieve the 'name' of the commenter from the POST data.
    $name = $_POST["name"];
    // Retrieve the 'email' of the commenter from the POST data.
    $email = $_POST["email"];
    // Retrieve the 'comment' content from the POST data.
    $comment = $_POST["comment"];

    // Construct the SQL query to insert the new comment into the 'comments' table.
    // Values are provided for 'post_id', 'name', 'email', and 'content'.
    // Note: Using direct variable insertion into SQL queries can be a security risk (SQL injection).
    // For production, prepared statements should be used.
    $sql = "INSERT INTO comments (post_id, name, email, content) VALUES ($post_id, '$name', '$email', '$comment')";

    // Execute the SQL query using the database connection.
    if ($conn->query($sql) === TRUE) {
        // If the query was successful, redirect the user back to the specific blog post page.
        // The 'post_id' is appended to the URL as a GET parameter.
        header("Location: post.php?id=$post_id");
        exit(); // Terminate script execution after redirection.
    } else {
        // If the query failed, display an error message including the SQL error.
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection to free up resources.
$conn->close();
?>
