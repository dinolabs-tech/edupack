<?php
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION["user_id"])) {
  // Redirect to the login page
  header("Location: index.php");
  exit();
}

// Include the database connection file
include("backend/db_connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="starter-page-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Blog Dashboard</h1>
        <!-- <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p> -->
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Blog</li>
            <li class="current">Blog Dashboard</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <div class="container" data-aos="fade-up">
        <div class="row">
          <?php
          // Fetch total number of posts
          $sql_posts = "SELECT COUNT(*) AS total_posts FROM blog_posts";
          $result_posts = $conn->query($sql_posts);
          $total_posts = $result_posts->fetch_assoc()["total_posts"];

          // Fetch total number of comments
          $sql_comments = "SELECT COUNT(*) AS total_comments FROM comments";
          $result_comments = $conn->query($sql_comments);
          $total_comments = $result_comments->fetch_assoc()["total_comments"];
          ?>

          <div class="col-md-6 col-lg-6 text-center">
            <div class="card card-rounded p-3">
              <div class="card-title">Total Posts</div>
              <div class="row">
                <div class="col-lg-12">
                  <blockquote class="generic-blockquote">
                    <h1><?= $total_posts; ?></h1>
                  </blockquote>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6 col-lg-6 text-center">
            <div class="card card-rounded p-3">
              <div class="card-title">Total Comments</div>
              <div class="row">
                <div class="col-lg-12">
                  <blockquote class="generic-blockquote">
                    <h1><?= $total_comments; ?></h1>
                  </blockquote>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <!-- carousel -->
      <!-- <div class="container" data-aos="fade-up">
        <div class="row">
          <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="..." class="d-block w-100" alt="Image 1">
              </div>
              <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="Image 2">
              </div>
              <div class="carousel-item">
                <img src="..." class="d-block w-100" alt="image 3">
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
        </div>
      </div> -->
      <!-- carousel end here -->

    </section><!-- /Starter Section Section -->

  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>