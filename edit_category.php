<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}

include("backend/db_connection.php");

$category_id = $_GET["id"];

$sql = "SELECT * FROM categories WHERE id = $category_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
  echo "Category not found";
  exit();
}

$category = $result->fetch_assoc();
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
              <form action="update_category.php?id=<?php echo $category['id']; ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $category_id; ?>">
                <div class="mb-3">
                  <input class="form-control rounded" type="text" name="name" value="<?php echo $category['name']; ?>" placeholder="Category Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Category Name'" required>
                </div>
                <div class="mb-3">
                  <textarea class="form-control rounded" id="description" name="description" placeholder="Description" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Description'" required><?php echo $category['description']; ?></textarea>
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