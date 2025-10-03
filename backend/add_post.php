<?php
/**
 * add_post.php
 *
 * This file handles the creation of new posts within a forum thread.
 * It allows authenticated users to submit content to a specific thread.
 *
 * It includes:
 * - Session management to ensure the user is logged in.
 * - Role-based fetching of the author's name (student or staff).
 * - Processing of POST requests to insert new post data into the database.
 * - Redirection upon successful post creation or error handling.
 * - An HTML form for users to input their post content, utilizing TinyMCE for rich text editing.
 */

// Include the database connection file to establish a connection to the database.
include 'db_connection.php';
// Start or resume a session to manage user login state and roles.
session_start();

// Check if the user is logged in. If not, redirect them to the login page.
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

// Retrieve the user's role from the session, defaulting to an empty string if not set.
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$student_name = ''; // Initialize $student_name to avoid undefined variable warnings.

// Determine the author's name based on their role.
// This block fetches the appropriate name (student name or staff name) from the database
// depending on the user's assigned role.
if ($role === 'Student' || $role === 'Alumni') {
    // For students and alumni, fetch the name from the 'students' table.
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT name FROM students WHERE id=?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($student_name);
    $stmt->fetch();
    $stmt->close();
} elseif (in_array($role, ['Superuser', 'Administrator', 'Store', 'Library', 'Tuckshop', 'Teacher', 'Bursary', 'Admission'])) {
    // For staff roles, fetch the staff name from the 'login' table.
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT staffname FROM login WHERE id=?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($student_name);
    $stmt->fetch();
    $stmt->close();
}


// Check if the request method is POST, indicating a form submission.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the POST request.
    $thread_id = $_POST["thread_id"];
    $content = $_POST["content"];
    $author = $student_name; // The author's name determined above.

    try {
        // Sanitize input to prevent SQL injection.
        $thread_id = mysqli_real_escape_string($conn, $thread_id);
        $content = mysqli_real_escape_string($conn, $content);
        $author = mysqli_real_escape_string($conn, $author);

        // SQL query to insert the new post into the 'posts' table.
        $sql = "INSERT INTO posts (thread_id, content, author, created_at) VALUES ('$thread_id', '$content', '$author', NOW())";

        // Execute the query.
        if ($conn->query($sql) === TRUE) {
            // If the post is successfully added, redirect to the thread's view page.
            header("Location: view_thread.php?id=" . $thread_id);
            exit();
        } else {
            // If there's a database error, display it.
            echo "Error: " . $conn->error;
        }
    } catch (Exception $e) {
        // Catch any exceptions during the process and display the error message.
        echo "Error: " . $e->getMessage();
    }
} else {
    // If the request is not a POST request (e.g., direct access), redirect to the threads list.
    header("Location: threads.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Post</title>
    <!-- Link to the main stylesheet for styling. -->
    <link rel="stylesheet" href="style.css">
    <!-- Include TinyMCE library for rich text editing in the textarea. -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
    <script>
      // Initialize TinyMCE on the textarea with the ID 'content'.
      tinymce.init({
        selector: '#content'
      });
    </script>
</head>
<body>
    <?php
    // Include the navigation bar for consistent site navigation.
    include 'navbar.php';
    ?>
    <div class="container">
        <h2>Add New Post</h2>
        <!-- Form to submit a new post. The action points back to this file. -->
        <form action="add_post.php" method="post">
            <!-- Hidden input field to pass the thread ID to which the post belongs. -->
            <input type="hidden" name="thread_id" value="<?php echo htmlspecialchars($_GET['thread_id']); ?>">
            <div class="mb-3">
                <label for="content" class="form-label">Content:</label>
                <!-- Textarea for the post content. TinyMCE will be initialized on this. -->
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <!-- Submit button. The onclick event ensures TinyMCE content is saved to the textarea before submission. -->
            <button type="submit" class="btn btn-primary" onclick="tinyMCE.triggerSave();">Submit</button>
        </form>
    </div>
</body>
</html>
