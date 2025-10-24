<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="index-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <div class="hero-container">
        <video autoplay muted loop playsinline class="video-background">
          <source src="assets/img/education/video-2.mp4" type="video/mp4">
        </video>
        <div class="overlay"></div>
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-7" data-aos="zoom-out" data-aos-delay="100">
              <div class="hero-content">
                <h1>Empowering Minds, Shaping the Future</h1>
                <p>At <strong>Dinolabs</strong>, we believe education goes beyond the classroom. Our mission is to inspire curiosity, nurture talent, and equip students with the skills and confidence to thrive in a fast-changing world. Join a community driven by innovation, creativity, and lifelong learning.</p>
                <div class="cta-buttons">
                  <a href="admissions.php#admission_form" class="btn-primary">Apply Now</a>
                  <a href="academics.php" class="btn-secondary">Explore Our Programs</a>
                </div>
              </div>
            </div>
            <div class="col-lg-5" data-aos="zoom-out" data-aos-delay="200">
              <div class="stats-card">
                <div class="stats-header">
                  <h3>Why Choose Dinolabs</h3>
                  <div class="decoration-line"></div>
                </div>
                <div class="stats-grid">
                  <div class="stat-item">
                    <div class="stat-icon">
                      <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div class="stat-content">
                      <h4>98%</h4>
                      <p>Graduate Employment Rate</p>
                    </div>
                  </div>
                  <div class="stat-item">
                    <div class="stat-icon">
                      <i class="bi bi-globe"></i>
                    </div>
                    <div class="stat-content">
                      <h4>45+</h4>
                      <p>Global Academic Partners</p>
                    </div>
                  </div>
                  <div class="stat-item">
                    <div class="stat-icon">
                      <i class="bi bi-mortarboard"></i>
                    </div>
                    <div class="stat-content">
                      <h4>15:1</h4>
                      <p>Student–Class Ratio</p>
                    </div>
                  </div>
                  <div class="stat-item">
                    <div class="stat-icon">
                      <i class="bi bi-building"></i>
                    </div>
                    <div class="stat-content">
                      <h4>120+</h4>
                      <p>Courses & Programs Offered</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="event-ticker">
        <div class="container">
          <div class="row gy-4">
            <div class="col-md-6 col-xl-4 col-12 ticker-item">
              <span class="date">Events</span>
              <span class="title">View our upcoming events</span>
              <a href="events.php" class="btn-register">View</a>
            </div>
            <div class="col-md-6 col-xl-4 col-12 ticker-item">
              <span class="date">Gallery</span>
              <span class="title">View our gallery</span>
              <a href="gallery.php" class="btn-register">View</a>
            </div>
            <div class="col-md-6 col-xl-4 col-12 ticker-item">
              <span class="date">Blog</span>
              <span class="title">International Student Orientation</span>
              <a href="blog.php" class="btn-register">View</a>
            </div>
          </div>
        </div>
      </div>

    </section>
    <!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row mb-5">
          <div class="col-lg-6 pe-lg-5" data-aos="fade-right" data-aos-delay="200">
            <h2 class="display-6 fw-bold mb-4">Empowering Minds, <span>Shaping Futures</span></h2>
            <p class="lead mb-4">For years, <strong>Dinolabs</strong> has been at the forefront of transformative education — guiding learners toward academic excellence, personal growth, and lifelong success. We combine technology, innovation, and mentorship to help every student reach their full potential.</p>
            <div class="d-flex flex-wrap gap-4 mb-4">
              <div class="stat-box">
                <span class="stat-number"><span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>+</span>
                <span class="stat-label">Years of Excellence</span>
              </div>
              <div class="stat-box">
                <span class="stat-number"><span data-purecounter-start="0" data-purecounter-end="250" data-purecounter-duration="1" class="purecounter"></span>+</span>
                <span class="stat-label">Active Students</span>
              </div>
              <div class="stat-box">
                <span class="stat-number"><span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>+</span>
                <span class="stat-label">Dedicated Facilities</span>
              </div>
            </div>
            <div class="d-flex align-items-center mt-4 signature-block">
              <!-- <img src="assets/img/misc/signature-1.webp" alt="Principal's Signature" width="120"> -->
              <div class="ms-3">
                <p class="mb-0 fw-bold">Dr. Elizabeth Morgan</p>
                <p class="mb-0 text-muted">Principal & Academic Director</p>
              </div>
            </div>
          </div>
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="image-stack">
              <div class="image-stack-item image-stack-item-top" data-aos="zoom-in" data-aos-delay="400">
                <img src="assets/img/education/campus-4.webp" alt="Campus Life" class="img-fluid rounded-4 shadow-lg">
              </div>
              <div class="image-stack-item image-stack-item-bottom" data-aos="zoom-in" data-aos-delay="500">
                <img src="assets/img/education/students-2.webp" alt="Students" class="img-fluid rounded-4 shadow-lg">
              </div>
            </div>
          </div>
        </div>

        <div class="row mission-vision-row g-4">
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="value-card h-100">
              <div class="card-icon">
                <i class="bi bi-rocket-takeoff"></i>
              </div>
              <h3>Our Mission</h3>
              <p>To deliver quality, inclusive, and technology-driven education that inspires creativity, nurtures character, and prepares students for leadership in a global society.</p>
            </div>
          </div>
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="value-card h-100">
              <div class="card-icon">
                <i class="bi bi-eye"></i>
              </div>
              <h3>Our Vision</h3>
              <p>To become a world-class educational hub recognized for innovation, excellence, and impact — where learning transforms lives and builds stronger communities.</p>
            </div>
          </div>
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="value-card h-100">
              <div class="card-icon">
                <i class="bi bi-star"></i>
              </div>
              <h3>Our Values</h3>
              <p>We uphold integrity, curiosity, collaboration, and excellence. At Dinolabs, we believe that knowledge should empower individuals to make meaningful contributions to the world.</p>
            </div>
          </div>
        </div>

      </div>

    </section>
    <!-- /About Section -->



    <!-- Featured Programs Section -->
    <section id="featured-programs" class="featured-programs section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Featured Academic Levels</h2>
        <p>From early childhood foundation to secondary school graduation, we provide a comprehensive learning journey that builds confidence, creativity, and character.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <ul class="program-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All Levels</li>
            <li data-filter=".filter-nursery">Nursery</li>
            <li data-filter=".filter-primary">Primary 1–6</li>
            <li data-filter=".filter-jss">JSS 1–3</li>
            <li data-filter=".filter-sss">SSS 1–3</li>
          </ul>

          <div class="row g-4 isotope-container">

            <!-- Nursery -->
            <div class="col-lg-6 isotope-item filter-nursery" data-aos="zoom-in" data-aos-delay="100">
              <div class="program-item">
                <div class="program-badge">Nursery School</div>
                <div class="row g-0">
                  <div class="col-md-4">
                    <div class="program-image-wrapper">
                      <img src="assets/img/education/education-1.webp" class="img-fluid" alt="Nursery Program">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="program-content">
                      <h3>Early Years Foundation</h3>
                      <div class="program-highlights">
                        <span><i class="bi bi-lightbulb"></i> Ages 2–5</span>
                        <span><i class="bi bi-people-fill"></i> Small Groups</span>
                        <span><i class="bi bi-calendar3"></i> Year-round</span>
                      </div>
                      <p>We nurture social skills, motor development, early numeracy and literacy through engaging, play-based learning.</p>
                      <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Primary -->
            <div class="col-lg-6 isotope-item filter-primary" data-aos="zoom-in" data-aos-delay="200">
              <div class="program-item">
                <div class="program-badge">Primary Education</div>
                <div class="row g-0">
                  <div class="col-md-4">
                    <div class="program-image-wrapper">
                      <img src="assets/img/education/education-2.webp" class="img-fluid" alt="Primary School Program">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="program-content">
                      <h3>Primary 1–6</h3>
                      <div class="program-highlights">
                        <span><i class="bi bi-clock"></i> 6 Years</span>
                        <span><i class="bi bi-book"></i> Core Subjects</span>
                        <span><i class="bi bi-award"></i> Basic Education</span>
                      </div>
                      <p>Building a strong foundation in literacy, numeracy, creativity, and moral values to prepare learners for JSS.</p>
                      <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- JSS -->
            <div class="col-lg-6 isotope-item filter-jss" data-aos="zoom-in" data-aos-delay="300">
              <div class="program-item">
                <div class="program-badge">Junior Secondary</div>
                <div class="row g-0">
                  <div class="col-md-4">
                    <div class="program-image-wrapper">
                      <img src="assets/img/education/education-3.webp" class="img-fluid" alt="Junior Secondary Program">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="program-content">
                      <h3>JSS 1–3</h3>
                      <div class="program-highlights">
                        <span><i class="bi bi-clock"></i> 3 Years</span>
                        <span><i class="bi bi-people-fill"></i> Skill-based</span>
                        <span><i class="bi bi-tools"></i> Practical Learning</span>
                      </div>
                      <p>Exploring core academic subjects while introducing technical, vocational, and creative pathways—preparing for BECE.</p>
                      <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- SSS -->
            <div class="col-lg-6 isotope-item filter-sss" data-aos="zoom-in" data-aos-delay="400">
              <div class="program-item">
                <div class="program-badge">Senior Secondary</div>
                <div class="row g-0">
                  <div class="col-md-4">
                    <div class="program-image-wrapper">
                      <img src="assets/img/education/education-5.webp" class="img-fluid" alt="Senior Secondary Program">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="program-content">
                      <h3>SSS 1–3</h3>
                      <div class="program-highlights">
                        <span><i class="bi bi-clock"></i> 3 Years</span>
                        <span><i class="bi bi-brain"></i> Science, Arts &amp; Commercial</span>
                        <span><i class="bi bi-award-fill"></i> WAEC / NECO</span>
                      </div>
                      <p>Advanced academic pathways that prepare students for university admission, career success, and global opportunities.</p>
                      <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div><!-- End Isotope Container -->
        </div>
      </div>
    </section>

    <!-- /Featured Programs Section -->


    <!-- ============================= -->
    <!-- 🎓 Students Life Section -->
    <!-- ============================= -->
    <section id="students-life" class="students-life section bg-light">

      <!-- Section Header -->
      <div class="container section-title text-center" data-aos="fade-up">
        <h2 class="fw-bold">Student Life</h2>
        <p class="text-muted">Experience the vibrant campus life and explore exciting opportunities beyond the classroom.</p>
      </div>
      <!-- End Section Header -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row align-items-center gy-5">

          <!-- Left: Image & Overlay -->
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="position-relative rounded-4 overflow-hidden shadow-sm">
              <img src="assets/img/education/education-square-11.webp" class="img-fluid rounded-4" alt="Students Life">
              <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center bg-dark bg-opacity-50 text-white text-center p-4">
                <h3 class="fw-semibold mb-3 text-white">Discover Campus Life</h3>
                <a href="students-life.html" class="btn btn-outline-light rounded-pill">
                  Explore More <i class="bi bi-arrow-right ms-2"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Right: Activities List -->
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="row g-4 mb-4">

              <!-- Student Clubs -->
              <div class="col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="card border-0 shadow-sm text-center p-4 h-100">
                  <div class="icon-box mb-3">
                    <i class="bi bi-people display-6 text-primary"></i>
                  </div>
                  <h5 class="fw-bold">Student Clubs</h5>
                  <p class="text-muted mb-0">Join clubs that match your interests and grow your leadership skills.</p>
                </div>
              </div>

              <!-- Sports Events -->
              <div class="col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="card border-0 shadow-sm text-center p-4 h-100">
                  <div class="icon-box mb-3">
                    <i class="bi bi-trophy display-6 text-warning"></i>
                  </div>
                  <h5 class="fw-bold">Sports Events</h5>
                  <p class="text-muted mb-0">Stay active and competitive with our exciting sports programs and tournaments.</p>
                </div>
              </div>

              <!-- Arts & Culture -->
              <div class="col-md-6" data-aos="zoom-in" data-aos-delay="400">
                <div class="card border-0 shadow-sm text-center p-4 h-100">
                  <div class="icon-box mb-3">
                    <i class="bi bi-music-note-beamed display-6 text-danger"></i>
                  </div>
                  <h5 class="fw-bold">Arts & Culture</h5>
                  <p class="text-muted mb-0">Celebrate creativity through music, drama, and cultural exhibitions.</p>
                </div>
              </div>

              <!-- Global Experiences -->
              <div class="col-md-6" data-aos="zoom-in" data-aos-delay="500">
                <div class="card border-0 shadow-sm text-center p-4 h-100">
                  <div class="icon-box mb-3">
                    <i class="bi bi-globe-americas display-6 text-success"></i>
                  </div>
                  <h5 class="fw-bold">Global Experiences</h5>
                  <p class="text-muted mb-0">Explore international exchange programs and cross-cultural learning.</p>
                </div>
              </div>

            </div>

            <!-- CTA Button -->
            <div class="text-center" data-aos="fade-up" data-aos-delay="600">
              <a href="students-life.html" class="btn btn-primary rounded-pill px-4 py-2">
                View All Student Activities
              </a>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- /🎓 Students Life Section -->


    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section bg-light py-5">

      <!-- Section Title -->
      <div class="container text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold display-6 mb-3">What Our Students Say</h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">
          Hear from our students and partners about how our programs have shaped their paths toward success.
        </p>
      </div>

      <!-- Testimonials Grid -->
      <div class="container">
        <div class="row g-4">

          <!-- Testimonial 1 -->
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="testimonial-card p-4 rounded-4 shadow-sm h-100 bg-white">
              <div class="quote mb-3">
                <i class="bi bi-quote fs-2 text-primary"></i>
              </div>
              <p class="text-muted mb-4">Implementing innovative strategies has revolutionized our approach to market challenges and competitive positioning.</p>
              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-7.webp" alt="Client" class="rounded-circle me-3" width="60" height="60">
                <div>
                  <h6 class="mb-0 fw-semibold">Rachel Bennett</h6>
                  <small class="text-muted">Strategy Director</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Testimonial 2 (Highlight) -->
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="testimonial-card highlight p-4 rounded-4 shadow-lg h-100 bg-primary text-white">
              <div class="quote mb-3">
                <i class="bi bi-quote fs-2 opacity-75"></i>
              </div>
              <p class="mb-4">Exceptional service delivery and innovative solutions have transformed our business operations, leading to remarkable growth and enhanced customer satisfaction.</p>
              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-m-7.webp" alt="Client" class="rounded-circle me-3 border border-light" width="60" height="60">
                <div>
                  <h6 class="mb-0 fw-semibold text-white">Daniel Morgan</h6>
                  <small class="text-light opacity-75">Chief Innovation Officer</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Testimonial 3 -->
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="testimonial-card p-4 rounded-4 shadow-sm h-100 bg-white">
              <div class="quote mb-3">
                <i class="bi bi-quote fs-2 text-primary"></i>
              </div>
              <p class="text-muted mb-4">Strategic partnership has enabled seamless digital transformation and operational excellence.</p>
              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-8.webp" alt="Client" class="rounded-circle me-3" width="60" height="60">
                <div>
                  <h6 class="mb-0 fw-semibold">Emma Thompson</h6>
                  <small class="text-muted">Digital Lead</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Testimonial 4 -->
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="400">
            <div class="testimonial-card p-4 rounded-4 shadow-sm h-100 bg-white">
              <div class="quote mb-3">
                <i class="bi bi-quote fs-2 text-primary"></i>
              </div>
              <p class="text-muted mb-4">Professional expertise and dedication have significantly improved our project delivery timelines and quality metrics.</p>
              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-m-8.webp" alt="Client" class="rounded-circle me-3" width="60" height="60">
                <div>
                  <h6 class="mb-0 fw-semibold">Christopher Lee</h6>
                  <small class="text-muted">Technical Director</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Testimonial 5 (Highlight) -->
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="500">
            <div class="testimonial-card highlight p-4 rounded-4 shadow-lg h-100 bg-primary text-white">
              <div class="quote mb-3">
                <i class="bi bi-quote fs-2 opacity-75"></i>
              </div>
              <p class="mb-4">Collaborative approach and industry expertise have revolutionized our product development cycle, resulting in faster time-to-market and higher customer engagement.</p>
              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-9.webp" alt="Client" class="rounded-circle me-3 border border-light" width="60" height="60">
                <div>
                  <h6 class="mb-0 fw-semibold text-white">Olivia Carter</h6>
                  <small class="text-light opacity-75">Product Manager</small>
                </div>
              </div>
            </div>
          </div>

          <!-- Testimonial 6 -->
          <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="600">
            <div class="testimonial-card p-4 rounded-4 shadow-sm h-100 bg-white">
              <div class="quote mb-3">
                <i class="bi bi-quote fs-2 text-primary"></i>
              </div>
              <p class="text-muted mb-4">Innovative approach to user experience design has significantly enhanced our platform's engagement metrics and customer retention rates.</p>
              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-m-13.webp" alt="Client" class="rounded-circle me-3" width="60" height="60">
                <div>
                  <h6 class="mb-0 fw-semibold">Nathan Brooks</h6>
                  <small class="text-muted">UX Director</small>
                </div>
              </div>
            </div>
          </div>

        </div><!-- /row -->
      </div><!-- /container -->

    </section><!-- /Testimonials Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section bg-light py-5">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center gy-5">

          <!-- Left Column: Overview -->
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="stats-overview pe-lg-4">
              <h2 class="fw-bold mb-3">Excellence in Education for Over 50 Years</h2>
              <p class="text-muted mb-4">
                For more than half a century, we’ve been shaping minds and building futures.
                Our programs, faculty, and facilities are designed to inspire curiosity, creativity, and leadership.
              </p>
              <div class="d-flex gap-3">
                <a href="#" class="btn btn-primary px-4 py-2">
                  <i class="bi bi-book me-2"></i> Learn More
                </a>
                <a href="#" class="btn btn-outline-primary px-4 py-2">
                  <i class="bi bi-camera-video me-2"></i> Virtual Tour
                </a>
              </div>
            </div>
          </div>

          <!-- Right Column: Stats Cards -->
          <div class="col-lg-6">
            <div class="row g-4">

              <div class="col-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="stats-card text-center p-4 rounded-4 shadow-sm bg-white">
                  <div class="stats-icon mb-3 text-primary fs-1">
                    <i class="bi bi-people-fill"></i>
                  </div>
                  <div class="stats-number fw-bold fs-3 text-dark">
                    <span data-purecounter-start="0" data-purecounter-end="94" data-purecounter-duration="1" class="purecounter"></span>%
                  </div>
                  <div class="stats-label text-secondary small mt-1">Graduation Rate</div>
                </div>
              </div>

              <div class="col-6" data-aos="zoom-in" data-aos-delay="400">
                <div class="stats-card text-center p-4 rounded-4 shadow-sm bg-white">
                  <div class="stats-icon mb-3 text-primary fs-1">
                    <i class="bi bi-person-workspace"></i>
                  </div>
                  <div class="stats-number fw-bold fs-3 text-dark">
                    <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>:1
                  </div>
                  <div class="stats-label text-secondary small mt-1">Student-Faculty Ratio</div>
                </div>
              </div>

              <div class="col-6" data-aos="zoom-in" data-aos-delay="500">
                <div class="stats-card text-center p-4 rounded-4 shadow-sm bg-white">
                  <div class="stats-icon mb-3 text-primary fs-1">
                    <i class="bi bi-award"></i>
                  </div>
                  <div class="stats-number fw-bold fs-3 text-dark">
                    <span data-purecounter-start="0" data-purecounter-end="125" data-purecounter-duration="1" class="purecounter"></span>+
                  </div>
                  <div class="stats-label text-secondary small mt-1">Academic Programs</div>
                </div>
              </div>

              <div class="col-6" data-aos="zoom-in" data-aos-delay="600">
                <div class="stats-card text-center p-4 rounded-4 shadow-sm bg-white">
                  <div class="stats-icon mb-3 text-primary fs-1">
                    <i class="bi bi-cash-stack"></i>
                  </div>
                  <div class="stats-number fw-bold fs-3 text-dark">
                    $<span data-purecounter-start="0" data-purecounter-end="42" data-purecounter-duration="1" class="purecounter"></span>M
                  </div>
                  <div class="stats-label text-secondary small mt-1">Research Funding</div>
                </div>
              </div>

            </div>
          </div>

        </div>

        <!-- Achievements Gallery -->
        <div class="mt-5" data-aos="fade-up" data-aos-delay="700">
          <div class="row g-4">

            <div class="col-md-4">
              <div class="achievement-item position-relative overflow-hidden rounded-4 shadow-sm">
                <img src="assets/img/education/education-1.webp" alt="Achievement" class="img-fluid rounded-4">
                <div class="achievement-content position-absolute bottom-0 start-0 end-0 p-3 text-white"
                  style="background: rgba(0,0,0,0.6);">
                  <h5 class="fw-semibold mb-1 text-white">Top-Ranked Programs</h5>
                  <p class="small mb-0">Recognized globally for academic excellence and innovation.</p>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="achievement-item position-relative overflow-hidden rounded-4 shadow-sm">
                <img src="assets/img/education/education-2.webp" alt="Achievement" class="img-fluid rounded-4">
                <div class="achievement-content position-absolute bottom-0 start-0 end-0 p-3 text-white"
                  style="background: rgba(0,0,0,0.6);">
                  <h5 class="fw-semibold mb-1 text-white">State-of-the-Art Facilities</h5>
                  <p class="small mb-0">Modern classrooms and libraries that empower learning.</p>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="achievement-item position-relative overflow-hidden rounded-4 shadow-sm">
                <img src="assets/img/education/education-3.webp" alt="Achievement" class="img-fluid rounded-4">
                <div class="achievement-content position-absolute bottom-0 start-0 end-0 p-3 text-white"
                  style="background: rgba(0,0,0,0.6);">
                  <h5 class="fw-semibold mb-1 text-white">Global Alumni Network</h5>
                  <p class="small mb-0">Connecting graduates making an impact worldwide.</p>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>

    </section>
    <!-- /Stats Section -->


    <!-- Recent News Section -->
    <section id="recent-news" class="recent-news section bg-light py-5">

      <!-- Section Title -->
      <div class="container section-title text-center mb-5" data-aos="fade-up">
        <h2 class="fw-bold">Latest Updates</h2>
        <p class="text-muted">Stay informed on school highlights, student achievements, and upcoming events.</p>
      </div>

      <div class="container">
        <div class="row gy-5">

          <!-- News Item 1 -->
          <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <article class="news-card rounded-4 overflow-hidden bg-white h-100 d-flex flex-column shadow-lg hover-shadow transition-all">

              <div class="position-relative">
                <img src="assets/img/blog/blog-post-1.webp"
                  alt="Inter-house Sports Competition"
                  class="img-fluid w-100 rounded-3">
                <span class="badge bg-primary position-absolute top-0 start-0 m-3 px-3 py-2 text-uppercase small">
                  School Events
                </span>
              </div>

              <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                <div>
                  <h5 class="fw-semibold mb-2">
                    <a href="news-details.html"
                      class="stretched-link text-dark text-decoration-none hover-text-primary">
                      Successful Inter-House Sports Competition 2025
                    </a>
                  </h5>
                  <p class="text-muted small">Students displayed great talent and sportsmanship during this year’s competition.</p>
                </div>

                <div class="d-flex align-items-center mt-4 pt-2 border-top">
                  <img src="assets/img/person/person-m-3.webp" alt="Sports Coordinator"
                    class="rounded-circle me-3" width="45" height="45">
                  <div>
                    <p class="mb-0 fw-medium">Coach Ibrahim</p>
                    <small class="text-muted">Oct 12, 2025</small>
                  </div>
                </div>
              </div>

            </article>
          </div>

          <!-- News Item 2 -->
          <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <article class="news-card rounded-4 overflow-hidden bg-white h-100 d-flex flex-column shadow-lg hover-shadow transition-all">

              <div class="position-relative">
                <img src="assets/img/blog/blog-post-3.webp"
                  alt="Science Fair Project Showcase"
                  class="img-fluid w-100 rounded-3">
                <span class="badge bg-success position-absolute top-0 start-0 m-3 px-3 py-2 text-uppercase small">
                  Academics
                </span>
              </div>

              <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                <div>
                  <h5 class="fw-semibold mb-2">
                    <a href="news-details.html"
                      class="stretched-link text-dark text-decoration-none hover-text-primary">
                      Primary Students Shine at Science Fair
                    </a>
                  </h5>
                  <p class="text-muted small">Innovative projects on renewable energy and technology captured attention.</p>
                </div>

                <div class="d-flex align-items-center mt-4 pt-2 border-top">
                  <img src="assets/img/person/person-f-2.webp" alt="Science Teacher"
                    class="rounded-circle me-3" width="45" height="45">
                  <div>
                    <p class="mb-0 fw-medium">Mrs. Okeke</p>
                    <small class="text-muted">Oct 08, 2025</small>
                  </div>
                </div>
              </div>

            </article>
          </div>

          <!-- News Item 3 -->
          <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <article class="news-card rounded-4 overflow-hidden bg-white h-100 d-flex flex-column shadow-lg hover-shadow transition-all">

              <div class="position-relative">
                <img src="assets/img/blog/blog-post-4.webp"
                  alt="Cultural Day Celebration"
                  class="img-fluid w-100 rounded-3">
                <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 px-3 py-2 text-uppercase small">
                  Culture & Tradition
                </span>
              </div>

              <div class="p-4 flex-grow-1 d-flex flex-column justify-content-between">
                <div>
                  <h5 class="fw-semibold mb-2">
                    <a href="news-details.html"
                      class="stretched-link text-dark text-decoration-none hover-text-primary">
                      Colourful Cultural Day Celebration Across All Levels
                    </a>
                  </h5>
                  <p class="text-muted small">Students proudly showcased Nigeria’s rich cultural heritage in style.</p>
                </div>

                <div class="d-flex align-items-center mt-4 pt-2 border-top">
                  <img src="assets/img/person/person-m-2.webp" alt="Cultural Coordinator"
                    class="rounded-circle me-3" width="45" height="45">
                  <div>
                    <p class="mb-0 fw-medium">Mr. Daniels</p>
                    <small class="text-muted">Oct 02, 2025</small>
                  </div>
                </div>
              </div>

            </article>
          </div>

        </div><!-- End row -->
      </div>

    </section>

    <!-- /Recent News Section -->



  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <?php include 'components/scripts.php'; ?>

</body>

</html>