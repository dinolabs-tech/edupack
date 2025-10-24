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
            <img src="assets/img/education/education-1.webp" alt="Academic Programs" class="img-fluid rounded-lg shadow">
          </div>
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <span class="subtitle">Excellence in Education</span>
            <h2>Discover Our Academic Programs</h2>
            <p class="intro-text">
              Our academic structure is carefully designed to nurture innovation, leadership,
              and critical thinking. Students learn through practical experiences, mentorship,
              and access to cutting-edge facilities that prepare them for the careers of tomorrow.
            </p>
            <div class="key-highlights">
              <div class="highlight-item"><i class="bi bi-check-circle-fill"></i><span>Hands-on industry exposure</span></div>
              <div class="highlight-item"><i class="bi bi-check-circle-fill"></i><span>Globally recognized qualifications</span></div>
              <div class="highlight-item"><i class="bi bi-check-circle-fill"></i><span>Personalized student development</span></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation Tabs -->
      <div class="programs-navigation mt-5">
        <ul class="nav nav-tabs justify-content-center" role="tablist">
          <li class="nav-item"><button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#academics-all" type="button">All Programs</button></li>
          <li class="nav-item"><button class="nav-link" id="undergraduate-tab" data-bs-toggle="tab" data-bs-target="#academics-undergraduate" type="button">Undergraduate</button></li>
          <li class="nav-item"><button class="nav-link" id="graduate-tab" data-bs-toggle="tab" data-bs-target="#academics-graduate" type="button">Graduate</button></li>
          <li class="nav-item"><button class="nav-link" id="doctoral-tab" data-bs-toggle="tab" data-bs-target="#academics-doctoral" type="button">Doctoral</button></li>
        </ul>
      </div>

      <!-- Tab Content -->
      <div class="tab-content programs-content mt-4">

        <!-- All Programs -->
        <div class="tab-pane fade show active" id="academics-all">
          <div class="row g-4">

            <!-- Computer Science -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in">
              <div class="program-item undergraduate">
                <div class="program-header"><i class="bi bi-cpu program-icon"></i><span>Undergraduate</span></div>
                <div class="program-body">
                  <h3>Computer Science</h3>
                  <p>Gain expertise in artificial intelligence, cybersecurity, software engineering, and digital innovation.</p>
                  <ul class="program-details">
                    <li><i class="bi bi-clock"></i> 4 Years</li>
                    <li><i class="bi bi-mortarboard-fill"></i> B.Sc. Degree</li>
                    <li><i class="bi bi-calendar-check"></i> September & January Intake</li>
                  </ul>
                </div>
                <div class="program-footer"><a href="#">View Program</a></div>
              </div>
            </div>

            <!-- Business Admin -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="150">
              <div class="program-item graduate">
                <div class="program-header"><i class="bi bi-briefcase program-icon"></i><span>Graduate</span></div>
                <div class="program-body">
                  <h3>Business Administration</h3>
                  <p>Develop advanced business strategy and leadership skills for global management roles.</p>
                  <ul class="program-details">
                    <li><i class="bi bi-clock"></i> 2 Years</li>
                    <li><i class="bi bi-mortarboard-fill"></i> MBA Degree</li>
                    <li><i class="bi bi-calendar-check"></i> Rolling Admissions</li>
                  </ul>
                </div>
                <div class="program-footer"><a href="#">View Program</a></div>
              </div>
            </div>

            <!-- Neuroscience -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
              <div class="program-item doctoral">
                <div class="program-header"><i class="bi bi-diagram-3 program-icon"></i><span>Doctoral</span></div>
                <div class="program-body">
                  <h3>Neuroscience</h3>
                  <p>Explore brain function, neurotechnology, and cognitive science through advanced research.</p>
                  <ul class="program-details">
                    <li><i class="bi bi-clock"></i> 5 Years</li>
                    <li><i class="bi bi-mortarboard-fill"></i> Ph.D. Degree</li>
                    <li><i class="bi bi-calendar-check"></i> Annual Intake</li>
                  </ul>
                </div>
                <div class="program-footer"><a href="#">View Program</a></div>
              </div>
            </div>

          </div>
        </div>

        <!-- Undergraduate Tab -->
        <div class="tab-pane fade" id="academics-undergraduate">
          <div class="row g-4">

            <div class="col-lg-4 col-md-6">
              <div class="program-item undergraduate">
                <h3>Computer Science</h3>
                <p>Hands-on training in programming, robotics, cloud and emerging technologies.</p>
                <a href="#" class="program-link">Learn More</a>
              </div>
            </div>

            <div class="col-lg-4 col-md-6">
              <div class="program-item undergraduate">
                <h3>Environmental Science</h3>
                <p>Study environmental conservation, sustainability, and natural resource management.</p>
                <a href="#" class="program-link">Learn More</a>
              </div>
            </div>

          </div>
        </div>

        <!-- Graduate -->
        <div class="tab-pane fade" id="academics-graduate">
          <div class="row g-4">
            <div class="col-lg-4 col-md-6">
              <div class="program-item graduate">
                <h3>Master in Business Administration</h3>
                <p>Transform your career with leadership and entrepreneurship training.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Doctoral -->
        <div class="tab-pane fade" id="academics-doctoral">
          <div class="row g-4">
            <div class="col-lg-4 col-md-6">
              <div class="program-item doctoral">
                <h3>PhD in Psychology</h3>
                <p>Advanced study of behavior, mental health, and human cognitive performance.</p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Featured Program Area -->
      <div class="featured-program-wrapper mt-5">
        <h2 class="text-center">Featured Program</h2>
        <p class="text-center mb-5">Our most in-demand and technology-driven postgraduate degree</p>

        <div class="featured-program-card row align-items-center">
          <div class="col-lg-5 mb-4 mb-lg-0">
            <img src="assets/img/education/education-5.webp" class="img-fluid">
          </div>
          <div class="col-lg-7">
            <h3>Master of Science in Artificial Intelligence</h3>
            <p>
              A future-focused degree designed to empower innovators in machine learning,
              automation, and intelligent systems — preparing graduates for competitive
              technology roles worldwide.
            </p>
            <ul class="program-details">
              <li><i class="bi bi-clock"></i> 24 Months Full-time</li>
              <li><i class="bi bi-cash-stack"></i> High Graduate Employment Rate</li>
              <li><i class="bi bi-graph-up-arrow"></i> Strong Industry Partnerships</li>
            </ul>
            <a href="#" class="btn-details">Program Details</a>
            <a href="#" class="btn-apply ms-2">Apply Now</a>
          </div>
        </div>
      </div>

    </div>

  </section>

</main>

<?php include 'components/footer.php'; ?>
</body>
</html>
