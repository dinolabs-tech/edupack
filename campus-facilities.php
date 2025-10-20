<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="campus-facilities-page">

<?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Campus &amp; Facilities</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Campus Facilities</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

  <section id="facilities" class="facilities section">
  <div class="container" data-aos="fade-up">
    <div class="section-header">
      <h2>Campus Facilities</h2>
      <p>Providing an environment that inspires learning, creativity, and growth.</p>
    </div>

    <div class="row gy-4">
      <div class="col-lg-4 col-md-6">
        <div class="facility-item" data-aos="fade-up" data-aos-delay="100">
          <img src="assets/img/facilities/library.jpg" class="img-fluid rounded-3" alt="School Library">
          <h4>Modern Library</h4>
          <p>
            Our library provides a serene and resource-rich environment where students can study, research, and explore knowledge beyond the classroom. It is stocked with academic textbooks, novels, and digital learning materials.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="facility-item" data-aos="fade-up" data-aos-delay="200">
          <img src="assets/img/facilities/ictlab.jpg" class="img-fluid rounded-3" alt="ICT Laboratory">
          <h4>ICT & Computer Laboratory</h4>
          <p>
            Equipped with modern computers and reliable internet access, our ICT lab helps students build essential digital skills in programming, research, and creative design — preparing them for a technology-driven world.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="facility-item" data-aos="fade-up" data-aos-delay="300">
          <img src="assets/img/facilities/sciencelab.jpg" class="img-fluid rounded-3" alt="Science Laboratory">
          <h4>Science Laboratories</h4>
          <p>
            We provide well-equipped Physics, Chemistry, and Biology laboratories that allow students to engage in hands-on experiments and develop a deep understanding of scientific principles through discovery-based learning.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="facility-item" data-aos="fade-up" data-aos-delay="400">
          <img src="assets/img/facilities/sports.jpg" class="img-fluid rounded-3" alt="Sports Facilities">
          <h4>Sports & Recreation</h4>
          <p>
            Physical fitness and teamwork are integral to our learning culture. Our campus boasts a football pitch, basketball court, and indoor sports facilities that encourage discipline, sportsmanship, and healthy competition.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="facility-item" data-aos="fade-up" data-aos-delay="500">
          <img src="assets/img/facilities/hostel.jpg" class="img-fluid rounded-3" alt="Boarding Hostel">
          <h4>Comfortable Boarding</h4>
          <p>
            Our boarding facilities provide a secure, comfortable, and well-supervised home for students who live on campus. Each hostel is designed to promote responsibility, friendship, and personal development in a family-like setting.
          </p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6">
        <div class="facility-item" data-aos="fade-up" data-aos-delay="600">
          <img src="assets/img/facilities/artroom.jpg" class="img-fluid rounded-3" alt="Art and Music Studio">
          <h4>Art, Music & Creativity Studios</h4>
          <p>
            Creativity is at the heart of our education. Our studios provide space for artistic expression, music training, and drama rehearsals — helping students discover and develop their creative potential.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>


  </main>

<?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>