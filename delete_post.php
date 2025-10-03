<?php
/**
 * delete_post.php
 *
 * This script handles the deletion of a blog post, including its associated image file.
 * It requires the user to be logged in as an administrator; otherwise, it redirects to the login page.
 * The post to be deleted is identified by its ID, passed via a GET parameter.
 * Before deleting the post record from the database, it fetches the image path to delete the physical file.
 * Upon successful deletion, the script redirects to the dashboard.
 */

// Start the session to manage user sessions.
session_start();

// Check if the user is not logged in, or if they are not an administrator.
// If any of these conditions are true, access is denied.
if (!isset($_SESSION["user_id"])) {
    // Redirect unauthenticated or non-admin users to the login page.
    header("Location: index.php");
    exit(); // Terminate script execution after redirection.
}

// Include the database connection file to establish a connection to the database.
include("backend/db_connection.php");

// Check if the request method is GET and if a 'id' parameter is set in the URL.
// This ensures the script only processes valid deletion requests.
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    // Retrieve the 'id' of the post to be deleted from the GET request parameters.
    // Note: Direct use of GET parameters in SQL queries can be a security risk (SQL injection).
    // For production, prepared statements should be used.
    $post_id = $_GET["id"];

     // Delete comments associated with the post
    $sql_comments = "DELETE FROM comments WHERE post_id = $post_id";
    $conn->query($sql_comments);

    // First, fetch the 'image_path' of the post from the 'posts' table.
    // This is necessary to delete the physical image file from the server.
    $sql = "SELECT image_path FROM blog_posts WHERE id = $post_id";
    // Execute the query.
    $result = $conn->query($sql);

    // Check if a post with the given ID was found.
    if ($result->num_rows > 0) {
        // Fetch the post details as an associative array.
        $row = $result->fetch_assoc();
        // Extract the image filename.
        $image_filename = $row["image_path"];

        // Construct the SQL query to delete the post from the 'posts' table
        // where the 'id' matches the retrieved post ID.
        $sql = "DELETE FROM blog_posts WHERE id = $post_id";

        // Execute the SQL query using the database connection.
        if ($conn->query($sql) === TRUE) {
            // If the database record was successfully deleted, proceed to delete the image file.
            // Check if an image filename exists and if the file actually exists on the server.
            if (!empty($image_filename) && file_exists("img/blog/" . $image_filename)) {
                // Delete the physical image file from the 'img/blog/' directory.
                unlink("img/blog/" . $image_filename);
            }

            // Redirect the user to the blog page after successful deletion.
            header("Location: blog.php");
            exit(); // Terminate script execution after redirection.
        } else {
            // If the database query failed, display an error message.
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        // If no post was found with the given ID, display an error message.
        echo "Post not found";
    }
}

// Close the database connection to free up resources.
$conn->close();
?>