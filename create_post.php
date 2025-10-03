<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["user_id"])) {
  // Redirect to the index page
  header("Location: index.php");
  exit();
}

// Include the database connection file
include("backend/db_connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>

<body class="starter-page-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Create Post</h1>
        <!-- <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p> -->
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">blog</li>
            <li class="current">Create Post</li>
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
              <form action="save_post.php" method="POST" enctype="multipart/form-data" novalidate>
                <div class="mb-3">
                  <input class="single-input form-control rounded" type="text" name="title" placeholder="Post Title" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Post Title'" required>
                </div>
                <div class="mb-3">
                  <textarea class="single-textarea form-control rounded" id="content" name="content" placeholder="Content" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Content'" required></textarea>
                </div>
                <div class="input-group-icon mb-3">
                  <label for="image" class="form-label text-white">Upload Image</label>
                  <input type="file" class="form-control rounded" name="image" id="image" required>
                </div>
                <div class="input-group-icon mb-3">
                  <div class="icon"><i class="fa fa-tag" aria-hidden="true"></i></div>
                  
                    <select class="form-control form-select" name="category" required>
                      <option value="" selected disabled>Select Category</option>
                      <?php
                      // SQL query to fetch all available categories from the 'categories' table.
                      $sql_categories = "SELECT id, name FROM categories";
                      // Execute the query.
                      $result_categories = $conn->query($sql_categories);
                      // Check if there are any categories returned from the database.
                      if ($result_categories->num_rows > 0) {
                        // Loop through each category and display it as an option in the dropdown.
                        while ($row_category = $result_categories->fetch_assoc()) { ?>
                          <option value="<?php echo $row_category["id"]; ?>"><?php echo htmlspecialchars($row_category["name"]); ?></option>
                        <?php } ?>
                      <?php } else { ?>
                        <!-- If no categories are available, display a default option. -->
                        <option value=''>No categories available</option>
                      <?php }
                      ?>
                    </select>
                  
                </div>

                <div class="col-12 text-center">
                  <button class="btn btn-primary rounded mt-3">Save Post</button>
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