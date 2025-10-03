<?php
// Start a new session or resume the existing session.
session_start();

// Check if the user is logged in. If not, redirect to the index page.
// This prevents unauthorized access to the post update functionality.
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php");
    exit(); // Stop script execution after redirection.
}

// Include the database connection file. This file is responsible for establishing a connection to the database.
include("backend/db_connection.php");

// Check if the request method is POST. This script should only process form submissions.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize post data from the POST request.
    // intval() is used for integer values to ensure they are numbers.
    // mysqli_real_escape_string() is used for string values to prevent SQL injection.
    $post_id = intval($_POST["id"]);                      // The ID of the post to be updated.
    $title = mysqli_real_escape_string($conn, $_POST["title"]);       // The new title of the post.
    $content = mysqli_real_escape_string($conn, $_POST["content"]);     // The new content of the post.
    $category_id = intval($_POST["category"]);            // The new category ID for the post.

    $image_path = ""; // Initialize image_path variable. It will store the new image filename if uploaded.

    // Handle image upload if a new image file is provided.
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "assets/images/"; // Directory where uploaded images will be stored.
        $image_path = basename($_FILES["image"]["name"]); // Get the base filename of the uploaded image.
        $target_file = $target_dir . $image_path; // Full path where the file will be saved.
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Get the file extension.

        // Validate the uploaded file.
        $uploadOk = 1; // Flag to indicate if upload is allowed (1 for OK, 0 for not OK).

        // Check if the file is an actual image or a fake image.
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            $uploadOk = 0;
        }
        // Check file size (e.g., limit to 500KB).
        if ($_FILES["image"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats.
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // If all validation checks pass, attempt to move the uploaded file.
        if ($uploadOk) {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "Sorry, there was an error uploading your file.";
                $image_path = ""; // Reset image_path if file move failed.
            }
        } else {
            $image_path = ""; // Reset image_path if validation failed.
        }
    }

    // Construct the SQL UPDATE query based on whether a new image was uploaded.
    if (!empty($image_path)) {
        // If a new image was uploaded, update the 'image_path' field as well.
        $sql = "UPDATE blog_posts 
                SET title = '$title', content = '$content', category_id = '$category_id', image_path = '$image_path' 
                WHERE id = $post_id";
    } else {
        // If no new image was uploaded, update only title, content, and category.
        $sql = "UPDATE blog_posts 
                SET title = '$title', content = '$content', category_id = '$category_id' 
                WHERE id = $post_id";
    }

    // Execute the SQL update query.
    if ($conn->query($sql) === TRUE) {
        // If the update is successful, redirect the user to the dashboard.
        header("Location: post.php?id=$post_id");
        exit(); // Stop script execution after redirection.
    } else {
        // If there's an error with the query, display an error message.
        echo "Error updating post: " . $conn->error;
    }
}

// Close the database connection.
$conn->close();
?>
