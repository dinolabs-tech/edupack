<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="about-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>About</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">About</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- History Section -->
    <section id="history" class="history section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center g-5">
          <div class="col-lg-6">
            <div class="about-content" data-aos="fade-up" data-aos-delay="200">
              <h3>Our Story</h3>
              <h2>Educating Minds, Inspiring Hearts</h2>
              <p>
                Founded on a vision to transform education through innovation and character building,
                EduPack has grown from a small local initiative into a trusted name in school management
                and educational technology. Over the years, we’ve empowered schools with modern tools,
                digital solutions, and a learner-centered philosophy that continues to shape bright futures.
              </p>

              <div class="timeline">
                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content">
                    <h4>2013</h4>
                    <p>
                      What began as a community learning center with only a few dedicated educators
                      laid the foundation for a culture of excellence and integrity in education.
                    </p>
                  </div>
                </div>

                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content">
                    <h4>2017</h4>
                    <p>
                      With growing enrollment and recognition, the institution introduced
                      structured academic programs, focusing on discipline, innovation, and moral development.
                    </p>
                  </div>
                </div>

                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content">
                    <h4>2021</h4>
                    <p>
                      The school embraced digital transformation, implementing modern teaching aids and technology-driven learning systems that enhanced classroom experiences.
                    </p>
                  </div>
                </div>

                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content">
                    <h4>2025</h4>
                    <p>
                      EduPack was officially established as a digital education platform, offering
                      school management software designed to simplify administration and improve
                      collaboration between teachers, students, and parents.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="about-image" data-aos="zoom-in" data-aos-delay="300">
              <img src="assets/img/education/campus-5.webp" alt="Campus" class="img-fluid rounded">

              <div class="mission-vision" data-aos="fade-up" data-aos-delay="400">
                <div class="mission">
                  <h3>Our Mission</h3>
                  <p>
                    To nurture a generation of critical thinkers and responsible citizens by providing
                    innovative tools and holistic educational experiences that promote learning, leadership,
                    and lifelong growth.
                  </p>
                </div>

                <div class="vision">
                  <h3>Our Vision</h3>
                  <p>
                    To be a global leader in educational innovation — building smarter schools,
                    empowering educators, and shaping a future where quality education is accessible to all.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-lg-12">
            <div class="core-values" data-aos="fade-up" data-aos-delay="500">
              <h3 class="text-center mb-4">Core Values</h3>
              <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">

                <div class="col">
                  <div class="value-card">
                    <div class="value-icon">
                      <i class="bi bi-book"></i>
                    </div>
                    <h4>Academic Excellence</h4>
                    <p>
                      We believe in the pursuit of knowledge and achievement through dedication,
                      innovation, and continuous improvement in learning.
                    </p>
                  </div>
                </div>

                <div class="col">
                  <div class="value-card">
                    <div class="value-icon">
                      <i class="bi bi-people"></i>
                    </div>
                    <h4>Community Engagement</h4>
                    <p>
                      Education thrives in community. We foster partnerships that encourage teamwork,
                      service, and social responsibility among learners and educators.
                    </p>
                  </div>
                </div>

                <div class="col">
                  <div class="value-card">
                    <div class="value-icon">
                      <i class="bi bi-lightbulb"></i>
                    </div>
                    <h4>Innovation</h4>
                    <p>
                      We embrace creativity and technology to deliver forward-thinking solutions
                      that transform teaching, learning, and school management.
                    </p>
                  </div>
                </div>

                <div class="col">
                  <div class="value-card">
                    <div class="value-icon">
                      <i class="bi bi-globe"></i>
                    </div>
                    <h4>Global Perspective</h4>
                    <p>
                      We prepare learners to succeed in an interconnected world by cultivating
                      awareness, diversity, and respect for global cultures and ideas.
                    </p>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

      </div>

    </section>
    <!-- /History Section -->


  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>