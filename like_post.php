<?php
session_start();
include 'backend/db_connection.php';

// if (!isset($_SESSION['user_id'])) {
//     // Redirect to login page if user is not logged in
//     header("Location: login.php");
//     exit();
// }

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

            // Update the likes count in the blog_posts table
            $update_stmt = $conn->prepare("UPDATE blog_posts SET likes = likes + 1 WHERE id = ?");
            $update_stmt->bind_param("i", $post_id);
            $update_stmt->execute();
            $update_stmt->close();
        }

header("Location: post.php?id=" . $post_id);
exit();
?>
