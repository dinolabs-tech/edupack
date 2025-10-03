<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>
<style>
  .pagination {
    text-align: center;
    margin-top: 20px;
  }

  .pagination a {
    color: #007bff;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #ddd;
    margin: 0 4px;
  }

  .pagination a.active {
    background-color: #007bff;
    color: white;
    border: 1px solid #007bff;
  }

  .pagination a:hover:not(.active) {
    background-color: #ddd;
  }
</style>

<body class="starter-page-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Gallery</h1>
        <!-- <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam molestias.</p> -->
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Gallery</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Gallery Section</h2>
        <?php if (isset($_SESSION["staffname"])) { ?>
          <?php if ($_SESSION['role'] == 'Administrator' || $_SESSION['role'] == 'Superuser') { ?>
            <a href="upload_page.php" class="btn btn-primary">Upload Image</a>
          <?php } else { ?>

          <?php } ?>

        <?php } else { ?>

        <?php } ?>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up">
        <?php
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
          mkdir($uploadDir, 0777, true);
        } ?>
        <?php $images = glob($uploadDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        $imagesPerPage = 8;
        $totalImages = count($images);
        $totalPages = ceil($totalImages / $imagesPerPage);
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $currentPage = max(1, min($totalPages, $currentPage));
        $startIndex = ($currentPage - 1) * $imagesPerPage;
        $pagedImages = array_slice($images, $startIndex, $imagesPerPage); ?>
        <div class="row g-3">
          <?php foreach ($pagedImages as $image) { ?>
            <div class="col-lg-3">
              <a href="<?= $image ?>" class="img-gal">
                <div class="single-imgs relative">
                  <div class="relative">
                    <img src="<?= $image ?>" alt="Gallery Image" class="img-fluid rounded gallery-image" style="height:300px; width:100%; object-fit:cover;">
                  </div>
                </div>
              </a>
              <?php if (isset($_SESSION["staffname"]) && ($_SESSION['role'] == 'Administrator' || $_SESSION['role'] == 'Superuser')) { ?>
                <a href="delete.php?image=<?= urlencode(basename($image)) ?>" class="btn btn-danger m-3 text-center" style="width:90%;" onclick="return confirm('Are you sure you want to delete this image?')">Delete</a>
              <?php } ?>
            </div>
          <?php } ?>
        </div>

        <div class="pagination justify-content-center">
          <?php
          for ($i = 1; $i <= $totalPages; $i++) { ?>
            <a href="?page=<?= $i ?>" <?= ($i == $currentPage ? ' class="active"' : '') ?>><?= $i ?></a>
          <?php } ?>
        </div>

      </div>

    </section><!-- /Starter Section Section -->

  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>
	<script>
		const modal = document.getElementById("fullscreen-modal");
		const modalImg = document.getElementById("fullscreen-image");
		const galleryImages = document.querySelectorAll(".gallery-image");
		const closeBtn = document.querySelector(".close");

		galleryImages.forEach(img => {
			img.onclick = function() {
				modal.style.display = "block";
				modalImg.src = this.src;
			}
		});

		closeBtn.onclick = function() {
			modal.style.display = "none";
		}

		window.onclick = function(event) {
			if (event.target == modal) {
				modal.style.display = "none";
			}
		}
	</script>
</body>

</html>