<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: index.php");
  exit();
}
include("backend/db_connection.php");

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

<body class="starter-page-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Manage Categories</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Blog</li>
            <li class="current">Manage Categories</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <a href="create_category.php" class="btn btn-primary circle mt-3">Create New Category</a>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up">
        <div class="row">
          <div class="col-md-6 col-lg-12">
            <div class="card card-rounded p-3">
              <!-- Table to display categories. DataTables is initialized on this table. -->
              <table id="categoryTable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Check if there are any categories returned from the database query.
                  if ($result->num_rows > 0) {
                    // Loop through each category and display its details in a table row.
                    while ($row = $result->fetch_assoc()) { ?>
                      <tr>
                        <td><?php echo htmlspecialchars($row["name"]); ?></td>
                        <td><?php echo htmlspecialchars($row["description"]); ?></td>
                        <td>
                          <!-- Link to edit the category, passing the category ID. -->
                          <a href='edit_category.php?id=<?php echo $row["id"]; ?>' class='btn btn-primary rounded-circle bi bi-pencil'></a>
                          <!-- Link to delete the category, with a JavaScript confirmation prompt. -->
                          <a href='delete_category.php?id=<?php echo $row["id"]; ?>' class='btn btn-danger rounded-circle bi bi-trash' onclick='return confirm("Are you sure you want to delete this category?")'></a>
                        </td>
                      </tr>
                    <?php  } ?>
                  <?php } else { ?>
                    <!-- Optionally, display a message if no categories are found. -->
                    <!-- This part is not explicitly in the original code but can be added for better UX. -->
                    <tr>
                      <td colspan='3'>No categories found.</td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>

    </section><!-- /Starter Section Section -->

  </main>

  <?php include 'components/footer.php'; ?>


  <!-- jQuery (needed for DataTables): Links to the jQuery library. -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JS: Links to the DataTables JavaScript library. -->
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

  <script>
    // Initialize DataTables on the '#categoryTable' once the document is ready.
    $(document).ready(function() {
      $('#categoryTable').DataTable({
        "pageLength": 10, // Set the default number of rows per page to 10.
        "lengthMenu": [5, 10, 25, 50], // Provide options for changing the number of rows per page.
        "language": {
          "search": "Search Categories:" // Customize the search input label.
        }
      });
    });
  </script>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>