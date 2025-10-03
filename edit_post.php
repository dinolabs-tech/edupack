<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: index.php");
  exit();
}

include("backend/db_connection.php");

$post_id = $_GET["id"];

$sql = "SELECT * FROM blog_posts WHERE id = $post_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
  echo "Post not found";
  exit();
}

$post = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
<script>
  // Initialize TinyMCE editor for the 'content' textarea.
  tinymce.init({
    selector: '#content', // Target the textarea with id 'content'.
    menubar: false, // Hide the menubar.
    toolbar: 'undo redo | formatselect | bold italic underline superscript subscript | alignleft aligncenter alignright | bullist numlist outdent indent | table', // Configure toolbar buttons.
    plugins: 'lists', // Enable the 'lists' plugin for list formatting.
    branding: false // Hide the TinyMCE branding.
  });
</script>

<body class="starter-page-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Edit Post</h1>
        <!-- <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p> -->
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Edit Post</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

    

      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-md-6 col-lg-12">
            <div class="card card-rounded p-3">
              <form action="update_post.php" method="POST" enctype="multipart/form-data" novalidate>
                <!-- Hidden input field to pass the post ID to the update script. -->
                <input type="hidden" name="id" value="<?php echo $post_id; ?>">
                <div class="mb-3">
                  <input class="single-input form-control rounded" type="text" name="title" placeholder="Post Title" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Post Title'" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                </div>
                <div class="mb-3">
                  <textarea class="single-textarea form-control rounded" id="content" name="content" placeholder="Content" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Content'" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                </div>
                <div class="input-group-icon mb-3">
                  <label for="image" class="form-label text-white">Upload Image</label>
                  <input type="file" class="form-control rounded" name="image" id="image" required>

                  <?php
                  // Display the current image if one exists.
                  if (!empty($post["image_path"])): ?>
                    <div class="mt-2">
                      <img src="img/blog/<?php echo htmlspecialchars($post["image_path"]); ?>"
                        alt="Blog Image" style="max-width: 100px;" class="rounded img-fluid">
                    </div>
                  <?php endif; ?>

                </div>
                <div class="input-group-icon mb-3">
                  <div class="icon"><i class="fa fa-tag" aria-hidden="true"></i></div>
                  
                    <select class="form-control form-select" name="category" required>
                      <option value="" selected disabled>Select Category</option>
                      <?php
                      // SQL query to fetch all available categories.
                      $sql_categories = "SELECT id, name FROM categories";
                      // Execute the query.
                      $result_categories = $conn->query($sql_categories);
                      // Check if categories are available.
                      if ($result_categories->num_rows > 0) {
                        // Loop through each category to populate the dropdown options.
                        while ($row_category = $result_categories->fetch_assoc()) {
                          // Mark the option as 'selected' if its ID matches the post's current category ID.
                          $selected = ($post["category_id"] == $row_category["id"]) ? "selected" : ""; ?>
                          <option value="<?php echo $row_category["id"]; ?>" <?php echo $selected; ?>><?php echo htmlspecialchars($row_category["name"]); ?></option>
                      <?php }
                      } else {
                        // Display a default option if no categories are available.
                        echo "<option value=''>No categories available</option>";
                      }
                      ?>
                    </select>
                </div>

                <div class="col-12 text-center">
                  <button class="btn btn-primary mt-3">Update Post</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Starter Section Section -->

  </main>

  <script>
    // Initialize TinyMCE editor for the 'content' textarea.
    tinymce.init({
      selector: '#content', // Target the textarea with id 'content'.
      menubar: false, // Hide the menubar.
      toolbar: 'undo redo | formatselect | bold italic underline superscript subscript | alignleft aligncenter alignright | bullist numlist outdent indent | table', // Configure toolbar buttons.
      plugins: 'lists', // Enable the 'lists' plugin for list formatting.
      branding: false // Hide the TinyMCE branding.
    });

    // Add an event listener to the form to perform custom validation before submission.
    document.querySelector('form').addEventListener('submit', function(e) {
      // Check if the content of the TinyMCE editor is empty after trimming whitespace.
      if (tinymce.get('content').getContent({
          format: 'text'
        }).trim() === '') {
        // If content is empty, display an alert to the user.
        alert('Please enter some content.');
        // Prevent the form from being submitted.
        e.preventDefault();
      }
    });
  </script>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>