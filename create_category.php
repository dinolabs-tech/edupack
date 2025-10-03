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

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the category name from the POST data
  $name = $_POST["name"];
  // Retrieve the category description from the POST data
  $description = $_POST["description"];

  // SQL query to insert a new category into the categories table
  $sql = "INSERT INTO categories (name, description) VALUES ('$name', '$description')";

  // Execute the SQL query
  if ($conn->query($sql) === TRUE) {
    // Redirect to the manage categories page if the query was successful
    header("Location: manage_categories.php");
    exit();
  } else {
    // Display an error message if the query failed
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Close the database connection
$conn->close();
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
        <h1>Create Category</h1>
        <!-- <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p> -->
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Blog</li>
            <li class="current">Create Category</li>
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
              <form action="create_category.php" method="POST">
                <div class="mb-3">
                  <input class="form-control rounded" type="text" name="name" placeholder="Category Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Category Name'" required>
                </div>
                <div class="mb-3">
                  <textarea class="form-control rounded" id="description" name="description" placeholder="Description" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Description'" required></textarea>
                </div>

                <div class="col-12 text-center">
                  <button class="btn btn-primary circle mt-3">Save Category</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>

    </section><!-- /Starter Section Section -->

  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>