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
        <video autoplay="" muted="" loop="" playsinline="" class="video-background">
          <source src="assets/img/education/video-2.mp4" type="video/mp4">
        </video>
        <div class="overlay"></div>
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-7" data-aos="zoom-out" data-aos-delay="100">
              <div class="hero-content">
                <h1>Empowering Futures Through Education</h1>
                <p>Unlock your potential with our diverse academic programs, cutting-edge research opportunities, and a vibrant campus community dedicated to your success.</p>
                <div class="cta-buttons">
                  <a href="#" class="btn-primary">Start Your Journey</a>
                  <a href="#" class="btn-secondary">Discover Programs</a>
                </div>
              </div>
            </div>
            <div class="col-lg-5" data-aos="zoom-out" data-aos-delay="200">
              <div class="stats-card">
                <div class="stats-header">
                  <h3>Why Choose Us</h3>
                  <div class="decoration-line"></div>
                </div>
                <div class="stats-grid">
                  <div class="stat-item">
                    <div class="stat-icon">
                      <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div class="stat-content">
                      <h4>98%</h4>
                      <p>Graduate Employment</p>
                    </div>
                  </div>
                  <div class="stat-item">
                    <div class="stat-icon">
                      <i class="bi bi-globe"></i>
                    </div>
                    <div class="stat-content">
                      <h4>45+</h4>
                      <p>International Partners</p>
                    </div>
                  </div>
                  <div class="stat-item">
                    <div class="stat-icon">
                      <i class="bi bi-mortarboard"></i>
                    </div>
                    <div class="stat-content">
                      <h4>15:1</h4>
                      <p>Student-Faculty Ratio</p>
                    </div>
                  </div>
                  <div class="stat-item">
                    <div class="stat-icon">
                      <i class="bi bi-building"></i>
                    </div>
                    <div class="stat-content">
                      <h4>120+</h4>
                      <p>Degree Programs</p>
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
              <span class="date">NOV 15</span>
              <span class="title">Open House Day</span>
              <a href="#" class="btn-register">Register</a>
            </div>
            <div class="col-md-6 col-12 col-xl-4  ticker-item">
              <span class="date">DEC 5</span>
              <span class="title">Application Workshop</span>
              <a href="#" class="btn-register">Register</a>
            </div>
            <div class="col-md-6 col-12 col-xl-4 ticker-item">
              <span class="date">JAN 10</span>
              <span class="title">International Student Orientation</span>
              <a href="#" class="btn-register">Register</a>
            </div>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row mb-5">
          <div class="col-lg-6 pe-lg-5" data-aos="fade-right" data-aos-delay="200">
            <h2 class="display-6 fw-bold mb-4">Empowering Minds, <span>Shaping Futures</span></h2>
            <p class="lead mb-4">At EduPack, we believe in fostering a dynamic learning environment that inspires innovation, critical thinking, and global citizenship.</p>
            <div class="d-flex flex-wrap gap-4 mb-4">
              <div class="stat-box">
                <span class="stat-number"><span data-purecounter-start="0" data-purecounter-end="25" data-purecounter-duration="1" class="purecounter"></span>+</span>
                <span class="stat-label">Years</span>
              </div>
              <div class="stat-box">
                <span class="stat-number"><span data-purecounter-start="0" data-purecounter-end="2500" data-purecounter-duration="1" class="purecounter"></span>+</span>
                <span class="stat-label">Students</span>
              </div>
              <div class="stat-box">
                <span class="stat-number"><span data-purecounter-start="0" data-purecounter-end="125" data-purecounter-duration="1" class="purecounter"></span>+</span>
                <span class="stat-label">Faculty</span>
              </div>
            </div>
            <div class="d-flex align-items-center mt-4 signature-block">
              <img src="assets/img/misc/signature-1.webp" alt="Principal's Signature" width="120">
              <div class="ms-3">
                <p class="mb-0 fw-bold">Dr. Elizabeth Morgan</p>
                <p class="mb-0 text-muted">Principal</p>
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
              <p>To provide exceptional education that empowers students to achieve their full potential, contribute meaningfully to society, and thrive in a rapidly changing world.</p>
            </div>
          </div>
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="value-card h-100">
              <div class="card-icon">
                <i class="bi bi-eye"></i>
              </div>
              <h3>Our Vision</h3>
              <p>To be a leading institution recognized globally for academic excellence, innovative research, and a commitment to creating future leaders and problem-solvers.</p>
            </div>
          </div>
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
            <div class="value-card h-100">
              <div class="card-icon">
                <i class="bi bi-star"></i>
              </div>
              <h3>Our Values</h3>
              <p>Integrity, innovation, inclusivity, and excellence are the cornerstones of our educational philosophy, guiding every aspect of our community.</p>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Featured Programs Section -->
    <section id="featured-programs" class="featured-programs section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Featured Programs</h2>
        <p>Explore our diverse range of programs designed to equip you with the skills and knowledge for a successful future.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
          <ul class="program-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All Programs</li>
            <li data-filter=".filter-bachelor">Bachelor's</li>
            <li data-filter=".filter-master">Master's</li>
            <li data-filter=".filter-certificate">Certificates</li>
          </ul>

          <div class="row g-4 isotope-container">
            <div class="col-lg-6 isotope-item filter-bachelor" data-aos="zoom-in" data-aos-delay="100">
              <div class="program-item">
                <div class="program-badge">Bachelor's Degree</div>
                <div class="row g-0">
                  <div class="col-md-4">
                    <div class="program-image-wrapper">
                      <img src="assets/img/education/education-1.webp" class="img-fluid" alt="Program">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="program-content">
                      <h3>Computer Science</h3>
                      <div class="program-highlights">
                        <span><i class="bi bi-clock"></i> 4 Years</span>
                        <span><i class="bi bi-people-fill"></i> 120 Credits</span>
                        <span><i class="bi bi-calendar3"></i> Fall & Spring</span>
                      </div>
                      <p>Dive into the world of technology, programming, and innovation. Our Computer Science program prepares you for a dynamic career in software development, AI, and cybersecurity.</p>
                      <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Program Item -->

            <div class="col-lg-6 isotope-item filter-bachelor" data-aos="zoom-in" data-aos-delay="200">
              <div class="program-item">
                <div class="program-badge">Bachelor's Degree</div>
                <div class="row g-0">
                  <div class="col-md-4">
                    <div class="program-image-wrapper">
                      <img src="assets/img/education/education-3.webp" class="img-fluid" alt="Program">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="program-content">
                      <h3>Business Administration</h3>
                      <div class="program-highlights">
                        <span><i class="bi bi-clock"></i> 3 Years</span>
                        <span><i class="bi bi-people-fill"></i> 90 Credits</span>
                        <span><i class="bi bi-calendar3"></i> Fall Only</span>
                      </div>
                      <p>Develop essential leadership and management skills. Our Business Administration program offers a comprehensive curriculum for aspiring entrepreneurs and corporate leaders.</p>
                      <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Program Item -->

            <div class="col-lg-6 isotope-item filter-bachelor" data-aos="zoom-in" data-aos-delay="300">
              <div class="program-item">
                <div class="program-badge">Bachelor's Degree</div>
                <div class="row g-0">
                  <div class="col-md-4">
                    <div class="program-image-wrapper">
                      <img src="assets/img/education/education-5.webp" class="img-fluid" alt="Program">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="program-content">
                      <h3>Medical Sciences</h3>
                      <div class="program-highlights">
                        <span><i class="bi bi-clock"></i> 5 Years</span>
                        <span><i class="bi bi-people-fill"></i> 150 Credits</span>
                        <span><i class="bi bi-calendar3"></i> Fall Only</span>
                      </div>
                      <p>Embark on a rewarding journey in healthcare. Our Medical Sciences program provides rigorous training and hands-on experience for future medical professionals.</p>
                      <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Program Item -->

            <div class="col-lg-6 isotope-item filter-master" data-aos="zoom-in" data-aos-delay="100">
              <div class="program-item">
                <div class="program-badge">Master's Degree</div>
                <div class="row g-0">
                  <div class="col-md-4">
                    <div class="program-image-wrapper">
                      <img src="assets/img/education/education-7.webp" class="img-fluid" alt="Program">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="program-content">
                      <h3>Environmental Studies</h3>
                      <div class="program-highlights">
                        <span><i class="bi bi-clock"></i> 2 Years</span>
                        <span><i class="bi bi-people-fill"></i> 60 Credits</span>
                        <span><i class="bi bi-calendar3"></i> Spring Only</span>
                      </div>
                      <p>Address critical global challenges with our Environmental Studies program. Learn sustainable practices and policies to protect our planet.</p>
                      <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Program Item -->

            <div class="col-lg-6 isotope-item filter-master" data-aos="zoom-in" data-aos-delay="200">
              <div class="program-item">
                <div class="program-badge">Master's Degree</div>
                <div class="row g-0">
                  <div class="col-md-4">
                    <div class="program-image-wrapper">
                      <img src="assets/img/education/education-9.webp" class="img-fluid" alt="Program">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="program-content">
                      <h3>Mechanical Engineering</h3>
                      <div class="program-highlights">
                        <span><i class="bi bi-clock"></i> 2 Years</span>
                        <span><i class="bi bi-people-fill"></i> 64 Credits</span>
                        <span><i class="bi bi-calendar3"></i> Fall & Spring</span>
                      </div>
                      <p>Innovate and design the future with Mechanical Engineering. Focus on robotics, energy systems, and advanced manufacturing in a hands-on learning environment.</p>
                      <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Program Item -->

            <div class="col-lg-6 isotope-item filter-certificate" data-aos="zoom-in" data-aos-delay="100">
              <div class="program-item">
                <div class="program-badge">Certificate</div>
                <div class="row g-0">
                  <div class="col-md-4">
                    <div class="program-image-wrapper">
                      <img src="assets/img/education/education-2.webp" class="img-fluid" alt="Program">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="program-content">
                      <h3>Data Science</h3>
                      <div class="program-highlights">
                        <span><i class="bi bi-clock"></i> 6 Months</span>
                        <span><i class="bi bi-people-fill"></i> 24 Credits</span>
                        <span><i class="bi bi-calendar3"></i> Year-round</span>
                      </div>
                      <p>Master the art of data analysis and interpretation. Our Data Science certificate program equips you with the skills to transform raw data into actionable insights.</p>
                      <a href="#" class="program-btn"><span>Learn More</span> <i class="bi bi-arrow-right"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            </div><!-- End Program Item -->

          </div>
        </div>

      </div>

    </section><!-- /Featured Programs Section -->

    <!-- Students Life Block Section -->
    <section id="students-life-block" class="students-life-block section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Students Life</h2>
        <p>Discover a vibrant and engaging campus experience beyond academics, fostering personal growth and lifelong friendships.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center gy-4">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="students-life-img position-relative">
              <img src="assets/img/education/education-square-11.webp" class="img-fluid rounded-4 shadow-sm" alt="Students Life">
              <div class="img-overlay">
                <h3>Discover Campus Life</h3>
                <a href="students-life.html" class="explore-btn">Explore More <i class="bi bi-arrow-right"></i></a>
                    </div>
                    <h4>Student Clubs</h4>
                    <p>Join a diverse range of student organizations and clubs, from academic societies to cultural groups, to enrich your campus experience.</p>
                  </div>
                </div>

                <div class="col-md-6" data-aos="zoom-in" data-aos-delay="300">
                  <div class="student-activity-item">
                    <div class="icon-box">
                      <i class="bi bi-trophy"></i>
                    </div>
                    <h4>Sports Events</h4>
                    <p>Participate in or cheer for our athletic teams in various sports events, promoting teamwork, discipline, and healthy competition.</p>
                  </div>
                </div>

                <div class="col-md-6" data-aos="zoom-in" data-aos-delay="400">
                  <div class="student-activity-item">
                    <div class="icon-box">
                      <i class="bi bi-music-note-beamed"></i>
                    </div>
                    <h4>Arts & Culture</h4>
                    <p>Immerse yourself in a rich tapestry of artistic and cultural events, including theater productions, music concerts, and art exhibitions.</p>
                  </div>
                </div>

                <div class="col-md-6" data-aos="zoom-in" data-aos-delay="500">
                  <div class="student-activity-item">
                    <div class="icon-box">
                      <i class="bi bi-globe-americas"></i>
                    </div>
                    <h4>Global Experiences</h4>
                    <p>Expand your horizons with international exchange programs, study abroad opportunities, and diverse cultural events on campus.</p>
                  </div>
                </div>
              </div>
                </div>

                <div class="col-md-6" data-aos="zoom-in" data-aos-delay="500">
                  <div class="student-activity-item">
                    <div class="icon-box">
                      <i class="bi bi-globe-americas"></i>
                    </div>
                    <h4>Global Experiences</h4>
                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia.</p>
                  </div>
                </div>
              </div>

              <div class="students-life-cta" data-aos="fade-up" data-aos-delay="600">
                <a href="students-life.html" class="btn btn-primary">View All Student Activities</a>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Students Life Block Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>Hear directly from our students and alumni about their transformative experiences and how EduPack shaped their success.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="testimonial-masonry">

          <div class="testimonial-item" data-aos="fade-up">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Implementing innovative strategies has revolutionized our approach to market challenges and competitive positioning.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-f-7.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Rachel Bennett</h3>
                  <span class="position">Strategy Director</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item highlight" data-aos="fade-up" data-aos-delay="100">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Exceptional service delivery and innovative solutions have transformed our business operations, leading to remarkable growth and enhanced customer satisfaction across all touchpoints.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-m-7.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Daniel Morgan</h3>
                  <span class="position">Chief Innovation Officer</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item" data-aos="fade-up" data-aos-delay="200">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Strategic partnership has enabled seamless digital transformation and operational excellence.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-f-8.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Emma Thompson</h3>
                  <span class="position">Digital Lead</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item" data-aos="fade-up" data-aos-delay="300">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Professional expertise and dedication have significantly improved our project delivery timelines and quality metrics.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-m-8.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Christopher Lee</h3>
                  <span class="position">Technical Director</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item highlight" data-aos="fade-up" data-aos-delay="400">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Collaborative approach and industry expertise have revolutionized our product development cycle, resulting in faster time-to-market and increased customer engagement levels.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-f-9.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Olivia Carter</h3>
                  <span class="position">Product Manager</span>
                </div>
              </div>
            </div>
          </div>

          <div class="testimonial-item" data-aos="fade-up" data-aos-delay="500">
            <div class="testimonial-content">
              <div class="quote-pattern">
                <i class="bi bi-quote"></i>
              </div>
              <p>Innovative approach to user experience design has significantly enhanced our platform's engagement metrics and customer retention rates.</p>
              <div class="client-info">
                <div class="client-image">
                  <img src="assets/img/person/person-m-13.webp" alt="Client">
                </div>
                <div class="client-details">
                  <h3>Nathan Brooks</h3>
                  <span class="position">UX Director</span>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <!-- Stats Section -->
    <section id="stats" class="stats section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-6">
            <div class="stats-overview" data-aos="fade-right" data-aos-delay="200">
              <h2 class="stats-title">Excellence in Education for Over 50 Years</h2>
              <p class="stats-description">With over five decades of dedication to academic excellence, we have consistently nurtured bright minds and fostered a legacy of success and innovation.</p>
              <div class="stats-cta">
                <a href="#" class="btn btn-primary">Learn More</a>
                <a href="#" class="btn btn-outline">Virtual Tour</a>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="stats-card" data-aos="zoom-in" data-aos-delay="300">
                  <div class="stats-icon">
                    <i class="bi bi-people-fill"></i>
                  </div>
                  <div class="stats-number">
                    <span data-purecounter-start="0" data-purecounter-end="94" data-purecounter-duration="1" class="purecounter"></span>%
                  </div>
                  <div class="stats-label">Graduation Rate</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="stats-card" data-aos="zoom-in" data-aos-delay="400">
                  <div class="stats-icon">
                    <i class="bi bi-person-workspace"></i>
                  </div>
                  <div class="stats-number">
                    <span data-purecounter-start="0" data-purecounter-end="15" data-purecounter-duration="1" class="purecounter"></span>:1
                  </div>
                  <div class="stats-label">Student-Faculty Ratio</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="stats-card" data-aos="zoom-in" data-aos-delay="500">
                  <div class="stats-icon">
                    <i class="bi bi-award"></i>
                  </div>
                  <div class="stats-number">
                    <span data-purecounter-start="0" data-purecounter-end="125" data-purecounter-duration="1" class="purecounter"></span>+
                  </div>
                  <div class="stats-label">Academic Programs</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="stats-card" data-aos="zoom-in" data-aos-delay="600">
                  <div class="stats-icon">
                    <i class="bi bi-cash-stack"></i>
                  </div>
                  <div class="stats-number">$<span data-purecounter-start="0" data-purecounter-end="42" data-purecounter-duration="1" class="purecounter"></span>M
                  </div>
                  <div class="stats-label">Research Funding</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-5">
          <div class="col-lg-12">
            <div class="achievements-gallery" data-aos="fade-up" data-aos-delay="700">
              <div class="row g-4">
                <div class="col-md-4">
                  <div class="achievement-item">
                    <img src="assets/img/education/education-1.webp" alt="Achievement" class="img-fluid">
                  <div class="achievement-content">
                    <h4>Top-Ranked Programs</h4>
                    <p>Our programs consistently achieve high rankings, reflecting our commitment to academic rigor and student success.</p>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="achievement-item">
                    <img src="assets/img/education/education-2.webp" alt="Achievement" class="img-fluid">
                    <div class="achievement-content">
                      <h4>State-of-the-Art Facilities</h4>
                      <p>Experience learning in modern classrooms, advanced laboratories, and innovative research centers designed for the future.</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="achievement-item">
                    <img src="assets/img/education/education-3.webp" alt="Achievement" class="img-fluid">
                    <div class="achievement-content">
                      <h4>Global Alumni Network</h4>
                      <p>Connect with a powerful network of alumni making an impact worldwide, offering mentorship and career opportunities.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div>

      </div>

    </section><!-- /Stats Section -->

    <!-- Recent News Section -->
    <section id="recent-news" class="recent-news section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Recent News</h2>
        <p>Stay informed with the latest news, achievements, and events from our vibrant campus community.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-1.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Academics</p>

              <h2 class="title">
                <a href="blog-details.html">Groundbreaking Research in AI Ethics Published</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-12.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Maria Doe</p>
                  <p class="post-date">
                    <time datetime="2024-10-27">Oct 27, 2024</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-2.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Student Life</p>

              <h2 class="title">
                <a href="blog-details.html">Student Team Wins National Robotics Competition</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-f-13.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Allisa Mayer</p>
                  <p class="post-date">
                    <time datetime="2024-10-20">Oct 20, 2024</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

          <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
            <article>

              <div class="post-img">
                <img src="assets/img/blog/blog-post-3.webp" alt="" class="img-fluid">
              </div>

              <p class="post-category">Campus News</p>

              <h2 class="title">
                <a href="blog-details.html">New Scholarship Fund Launched for STEM Students</a>
              </h2>

              <div class="d-flex align-items-center">
                <img src="assets/img/person/person-m-10.webp" alt="" class="img-fluid post-author-img flex-shrink-0">
                <div class="post-meta">
                  <p class="post-author">Mark Dower</p>
                  <p class="post-date">
                    <time datetime="2024-10-15">Oct 15, 2024</time>
                  </p>
                </div>
              </div>

            </article>
          </div><!-- End post list item -->

        </div><!-- End recent posts list -->

      </div>

    </section><!-- /Recent News Section -->

    <!-- Events Section -->
    <section id="events" class="events section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Events</h2>
        <p>Join us for upcoming events, workshops, and celebrations that enrich our community and foster engagement.</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="event-filters mb-4">
          <div class="row justify-content-center g-3">
            <div class="col-md-4">
              <select class="form-select">
                <option selected="">All Months</option>
                <option>January</option>
                <option>February</option>
                <option>March</option>
                <option>April</option>
                <option>May</option>
                <option>June</option>
              </select>
            </div>
            <div class="col-md-4">
              <select class="form-select">
                <option selected="">All Categories</option>
                <option>Academic</option>
                <option>Arts</option>
                <option>Sports</option>
                <option>Community</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row g-4">

          <div class="col-lg-6">
            <div class="event-card">
              <div class="event-date">
                <span class="month">FEB</span>
                <span class="day">15</span>
                <span class="year">2025</span>
              </div>
              <div class="event-content">
              <div class="event-tag academic">Academic</div>
                <h3>Science Fair Exhibition</h3>
                <p>Showcasing innovative projects from our brightest young scientists, exploring breakthroughs in various fields.</p>
                <div class="event-meta">
                  <div class="meta-item">
                    <i class="bi bi-clock"></i>
                    <span>09:00 AM - 03:00 PM</span>
                  </div>
                  <div class="meta-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>Main Auditorium</span>
                  </div>
                </div>
                <div class="event-actions">
                  <a href="#" class="btn-learn-more">Learn More</a>
                  <a href="#" class="btn-calendar"><i class="bi bi-calendar-plus"></i> Add to Calendar</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="event-card">
              <div class="event-date">
                <span class="month">MAR</span>
                <span class="day">10</span>
                <span class="year">2025</span>
              </div>
              <div class="event-content">
                <div class="event-tag sports">Sports</div>
                <h3>Annual Sports Day</h3>
                <p>A day of spirited competition and camaraderie, featuring various athletic events and team challenges for all students.</p>
                <div class="event-meta">
                  <div class="meta-item">
                    <i class="bi bi-clock"></i>
                    <span>08:30 AM - 05:00 PM</span>
                  </div>
                  <div class="meta-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>School Playground</span>
                  </div>
                </div>
                <div class="event-actions">
                  <a href="#" class="btn-learn-more">Learn More</a>
                  <a href="#" class="btn-calendar"><i class="bi bi-calendar-plus"></i> Add to Calendar</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="event-card">
              <div class="event-date">
                <span class="month">APR</span>
                <span class="day">22</span>
                <span class="year">2025</span>
              </div>
              <div class="event-content">
                <div class="event-tag arts">Arts</div>
                <h3>Spring Music Concert</h3>
                <p>An evening of captivating performances by our talented student musicians and vocalists, celebrating the arts.</p>
                <div class="event-meta">
                  <div class="meta-item">
                    <i class="bi bi-clock"></i>
                    <span>06:30 PM - 08:30 PM</span>
                  </div>
                  <div class="meta-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>Performing Arts Center</span>
                  </div>
                </div>
                <div class="event-actions">
                  <a href="#" class="btn-learn-more">Learn More</a>
                  <a href="#" class="btn-calendar"><i class="bi bi-calendar-plus"></i> Add to Calendar</a>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="event-card">
              <div class="event-date">
                <span class="month">MAY</span>
                <span class="day">8</span>
                <span class="year">2025</span>
              </div>
              <div class="event-content">
                <div class="event-tag community">Community</div>
                <h3>Parent-Teacher Conference</h3>
                <p>An opportunity for parents to connect with teachers, discuss student progress, and collaborate on educational goals.</p>
                <div class="event-meta">
                  <div class="meta-item">
                    <i class="bi bi-clock"></i>
                    <span>01:00 PM - 07:00 PM</span>
                  </div>
                  <div class="meta-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>Various Classrooms</span>
                  </div>
                </div>
                <div class="event-actions">
                  <a href="#" class="btn-learn-more">Learn More</a>
                  <a href="#" class="btn-calendar"><i class="bi bi-calendar-plus"></i> Add to Calendar</a>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="text-center mt-5">
          <a href="#" class="btn-view-all">View All Events</a>
        </div>

      </div>

    </section><!-- /Events Section -->

  </main>

<?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


 <?php include 'components/scripts.php'; ?>

</body>

</html>
