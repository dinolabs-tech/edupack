<?php
session_start();
// if (!isset($_SESSION["username"])) {
//   header("Location: login.php");
//   exit();
// }

include("backend/db_connection.php");

$comment_id = $_GET["id"];

$sql = "SELECT * FROM comments WHERE id = $comment_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
  echo "Comment not found";
  exit();
}

$comment = $result->fetch_assoc();
$post_id = $comment["post_id"];
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
              <form action="update_comment.php" method="post">
                <input type="hidden" name="id" value="<?php echo $comment_id; ?>">
                <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

                <div class="row g-3">
                  <div class="col-12">

                    <textarea class="form-control bg-light border-0" id="content" name="content"
                      placeholder="content" style="height: 150px;"
                      required><?php echo htmlspecialchars($comment["content"]); ?></textarea>
                  </div>

                  <div class="col-12">
                    <button type="submit" class="btn btn-dark w-100 py-3">Update Comment</button>
                  </div>

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