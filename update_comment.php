<?php
// Start a new session or resume the existing session.
session_start();

// Check if the user is logged in. If not, redirect to the login page.
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit(); // Stop script execution after redirection.
}

// Include the database connection file. This file is responsible for establishing a connection to the database.
include("db_connect.php");

// Check if the request method is POST. This script should only process form submissions.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the comment ID, post ID, and the updated comment content from the POST data.
    $comment_id = $_POST["id"];      // The ID of the comment to be updated.
    $post_id = $_POST["post_id"];    // The ID of the post to which the comment belongs.
    $comment = $_POST["comment"];    // The new content for the comment.

    // Construct the SQL UPDATE query.
    // It updates the 'content' field for the comment with the specified 'id'.
    $sql = "UPDATE comments SET content = '$comment' WHERE id = $comment_id";

    // Execute the SQL query.
    if ($conn->query($sql) === TRUE) {
        // If the query is successful, redirect the user back to the 'post.php' page,
        // passing the 'post_id' to display the updated comment in its context.
        header("Location: post.php?id=$post_id");
        exit(); // Stop script execution after redirection.
    } else {
        // If there's an error with the query, display an error message.
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection.
$conn->close();
?>
