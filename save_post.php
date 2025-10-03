<?php
/**
 * save_post.php
 *
 * This script handles the submission of new blog posts.
 * It requires the user to be logged in; otherwise, it redirects to the login page.
 * The script receives POST data containing the post title, content, category, and image.
 * It validates the image, uploads it to the server, and then inserts the post details
 * into the 'posts' table in the database.
 * Upon successful insertion, it redirects to the blog page.
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

// Check if the current request method is POST. This ensures the script only processes form submissions.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the post title from the POST data and escape special characters for security.
    $title = $conn->real_escape_string($_POST["title"]);
    // Retrieve the post content from the POST data and escape special characters for security.
    $content = $conn->real_escape_string($_POST["content"]);
    // Retrieve the category ID from the POST data and cast it to an integer.
    $category_id = (int) $_POST["category"];
    // Retrieve the user ID from the session, identifying the current logged-in user as the author.
    $author_id = $_SESSION["user_id"]; 

    // --- Image Upload Handling ---
    // Initialize a flag to track the success of the upload process.
    $uploadOk = 1;
    // Define the target directory where uploaded images will be stored.
    $target_dir = "img/blog/";
    // Extract the base filename from the uploaded image.
    $image_path = basename($_FILES["image"]["name"]);
    // Define the full path to the target file.
    $target_file = $target_dir . $image_path;
    // Extract the file extension from the uploaded image and convert it to lowercase.
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // --- Image Validation ---
    // Check if the uploaded file is a valid image.
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        // If not a valid image, display an error message and set the upload flag to 0.
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if the file already exists in the target directory.
    if (file_exists($target_file)) {
        // If the file already exists, display an error message and set the upload flag to 0.
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check the file size to prevent excessively large uploads.
    if ($_FILES["image"]["size"] > 500000) {
        // If the file size exceeds the limit (500KB), display an error message and set the upload flag to 0.
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats for image uploads.
    $allowedTypes = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowedTypes)) {
        // If the file type is not allowed, display an error message and set the upload flag to 0.
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // --- File Upload and Database Insertion ---
    // If all validation checks pass, proceed with uploading the file and inserting the post data.
    if ($uploadOk === 1) {
        // Attempt to move the uploaded file to the target directory.
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // If the file was successfully moved, construct the SQL query to insert the new post.
            $sql = "INSERT INTO blog_posts (title, content, author_id, category_id, image_path) 
                    VALUES ('$title', '$content', '$author_id', '$category_id', '$image_path')";

            // Execute the SQL query using the database connection.
            if ($conn->query($sql) === TRUE) {
                // If the query was successful, redirect the user to the blog page.
                header("Location: blog.php");
                exit(); // Terminate script execution after redirection.
            } else {
                // If the database query failed, display an error message.
                echo "Database Error: " . $conn->error;
            }
        } else {
            // If there was an error uploading the file, display an error message.
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        // If any validation check failed, display a generic file upload failure message.
        echo "File upload failed. Post not saved.";
    }
}

// Close the database connection to free up resources.
$conn->close();
?>
