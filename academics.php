<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="academics-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Academics</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Academics</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Academics Section -->
    <section id="academics" class="academics section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="intro-wrapper">
          <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
              <div class="intro-image">
                <img src="assets/img/education/education-1.webp" alt="Academic Programs" class="img-fluid rounded-lg shadow">
                <div class="accent-shape"></div>
              </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
              <div class="intro-content">
                <span class="subtitle">Quality Learning for Every Child</span>
                <h2>Our Curriculum Approach</h2>
                <p class="intro-text">
                  We provide a rich and engaging academic experience designed to nurture creativity, critical thinking, and strong moral values. From foundational learning in primary school to advanced preparation in secondary school, our curriculum supports each learner’s unique strengths.
                </p>
                <div class="key-highlights">
                  <div class="highlight-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Child-centered learning experiences</span>
                  </div>
                  <div class="highlight-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Experienced and passionate educators</span>
                  </div>
                  <div class="highlight-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Modern classrooms & digital learning tools</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="programs-navigation" data-aos="fade-up" data-aos-delay="100">
          <ul class="nav nav-tabs justify-content-center" role="tablist">
            <li class="nav-item">
              <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#primary">
                <i class="bi bi-pencil"></i> Primary School
              </button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#secondary">
                <i class="bi bi-book-half"></i> Secondary School
              </button>
            </li>
          </ul>
        </div>

        <div class="tab-content programs-content" data-aos="fade-up" data-aos-delay="200">

          <!-- Primary School Tab -->
          <div class="tab-pane fade show active" id="primary">
            <div class="row g-4">
              <!-- Program Item -->
              <div class="col-lg-4 col-md-6">
                <div class="program-item">
                  <div class="program-header">
                    <i class="bi bi-pencil-square"></i>
                    <span>Core Subject</span>
                  </div>
                  <div class="program-body">
                    <h3>English Language</h3>
                    <p>Developing reading, writing, phonics, grammar, and communication skills for lifelong literacy.</p>
                  </div>
                </div>
              </div>

              <!-- Program Item -->
              <div class="col-lg-4 col-md-6">
                <div class="program-item">
                  <div class="program-header">
                    <i class="bi bi-calculator"></i>
                    <span>Core Subject</span>
                  </div>
                  <div class="program-body">
                    <h3>Mathematics</h3>
                    <p>Building strong numerical reasoning and problem-solving foundations through fun activities.</p>
                  </div>
                </div>
              </div>

              <!-- Program Item -->
              <div class="col-lg-4 col-md-6">
                <div class="program-item">
                  <div class="program-header">
                    <i class="bi bi-globe-africa"></i>
                    <span>Core Subject</span>
                  </div>
                  <div class="program-body">
                    <h3>Basic Science & Technology</h3>
                    <p>Hands-on exposure to scientific discovery, digital literacy, and environmental awareness.</p>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Primary -->

          <!-- Secondary School Tab -->
          <div class="tab-pane fade" id="secondary">
            <div class="row g-4">

              <!-- Program Item -->
              <div class="col-lg-4 col-md-6">
                <div class="program-item">
                  <div class="program-header">
                    <i class="bi bi-journal-bookmark"></i>
                    <span>Secondary Subject</span>
                  </div>
                  <div class="program-body">
                    <h3>Mathematics & Further Maths</h3>
                    <p>Preparing students for advanced analytical thinking and future STEM-related careers.</p>
                  </div>
                </div>
              </div>

              <!-- Program Item -->
              <div class="col-lg-4 col-md-6">
                <div class="program-item">
                  <div class="program-header">
                    <i class="bi bi-layers"></i>
                    <span>Secondary Subject</span>
                  </div>
                  <div class="program-body">
                    <h3>Sciences (Physics, Chemistry & Biology)</h3>
                    <p>Exploring the natural world through experiments, research and laboratory sessions.</p>
                  </div>
                </div>
              </div>

              <!-- Program Item -->
              <div class="col-lg-4 col-md-6">
                <div class="program-item">
                  <div class="program-header">
                    <i class="bi bi-palette"></i>
                    <span>Secondary Subject</span>
                  </div>
                  <div class="program-body">
                    <h3>Arts & Humanities</h3>
                    <p>Literature, History, Government, and Fine Arts to broaden creativity and critical thinking.</p>
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Secondary -->

        </div>

        <!-- Featured Program Section -->
        <div class="featured-program-wrapper" data-aos="fade-up">
          <div class="section-heading text-center mb-4">
            <h2>Featured Program</h2>
            <p>Innovative learning for future-ready students</p>
          </div>

          <div class="row">
            <div class="col-lg-10 mx-auto">
              <div class="featured-program-card row align-items-center">
                <div class="col-lg-5">
                  <img src="assets/img/education/education-5.webp" class="img-fluid rounded" alt="STEM Innovation">
                </div>
                <div class="col-lg-7">
                  <h3>STEM Innovation Program</h3>
                  <p>Students engage in robotics, coding, engineering challenges, and practical science projects that build creativity and teamwork skills.</p>

                  <div class="program-highlights">
                    <p><strong>Available To:</strong> Primary 4 – SS3</p>
                    <p><strong>Focus Areas:</strong> Coding · Robotics · Renewable Energy · Engineering Design</p>
                    <p><strong>Benefits:</strong> Modern skill development for global opportunities</p>
                  </div>

                  <a href="#" class="btn-apply">Enroll Today</a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section>

  </main>

  <?php include 'components/footer.php'; ?>
</body>
</html>
