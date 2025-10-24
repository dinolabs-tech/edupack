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

    <!-- Campus Facilities Section -->
    <section id="campus-facilities" class="campus-facilities section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Introduction -->
        <div class="intro-row">
          <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
              <div class="intro-content">
                <h2 class="fw-bold">Experience Our Campus</h2>
                <p class="lead">Where learning thrives in a safe & inspiring environment</p>
                <p>Our school campus is designed to support academic excellence and holistic development. From modern classrooms to innovative learning resources, every space encourages creativity, collaboration, and growth. We provide a serene and secure environment where students can explore their full potential.</p>
                <div class="stats-container">
                  <div class="stat-item">
                    <span class="stat-number">120+</span>
                    <span class="stat-label">Acres</span>
                  </div>
                  <div class="stat-item">
                    <span class="stat-number">45</span>
                    <span class="stat-label">Buildings</span>
                  </div>
                  <div class="stat-item">
                    <span class="stat-number">15k+</span>
                    <span class="stat-label">Students</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
              <div class="intro-image-container">
                <div class="intro-image main-image">
                  <img src="assets/img/education/campus-1.webp" alt="Main Campus" class="img-fluid rounded">
                </div>
                <div class="intro-image accent-image">
                  <img src="assets/img/education/campus-2.webp" alt="Campus Feature" class="img-fluid rounded">
                </div>
                <div class="tour-button">
                  <a href="#" class="btn-tour"><i class="bi bi-play-circle-fill"></i> Virtual Tour</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Facilities Tabs -->
        <div class="facilities-tabs" data-aos="fade-up" data-aos-delay="200">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="academic-tab" data-bs-toggle="tab" data-bs-target="#campus-facilities-academic" type="button" role="tab">
                <i class="bi bi-book"></i> Academic
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="athletic-tab" data-bs-toggle="tab" data-bs-target="#campus-facilities-athletic" type="button" role="tab">
                <i class="bi bi-trophy"></i> Athletic
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="residential-tab" data-bs-toggle="tab" data-bs-target="#campus-facilities-residential" type="button" role="tab">
                <i class="bi bi-house-door"></i> Residential
              </button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="community-tab" data-bs-toggle="tab" data-bs-target="#campus-facilities-community" type="button" role="tab">
                <i class="bi bi-people"></i> Community
              </button>
            </li>
          </ul>

          <div class="tab-content">

            <!-- Academic Facilities Tab -->
            <div class="tab-pane fade show active" id="campus-facilities-academic" role="tabpanel">
              <div class="row gy-4">
                <div class="col-md-7" data-aos="fade-right" data-aos-delay="100">
                  <div class="facility-highlight">
                    <div class="facility-slider">
                      <div class="facility-slide">
                        <img src="assets/img/education/campus-3.webp" alt="Library" class="img-fluid rounded">
                        <div class="slide-caption">Central Library</div>
                      </div>
                    </div>
                    <div class="facility-description">
                      <h3>World-Class Learning Spaces</h3>
                      <p>Our school offers well-equipped science and computer laboratories, multimedia classrooms, and resource-rich libraries that support both curiosity and innovation. Teachers and learners work together in a technology-driven environment designed to improve academic performance.</p>
                      <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill"></i> Smart classrooms with digital displays</li>
                        <li><i class="bi bi-check-circle-fill"></i> Fully equipped science laboratories</li>
                        <li><i class="bi bi-check-circle-fill"></i> Computer and ICT centers</li>
                        <li><i class="bi bi-check-circle-fill"></i> Individual and group study facilities</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-5" data-aos="fade-left" data-aos-delay="200">
                  <div class="facility-cards">
                    <div class="facility-card">
                      <div class="icon-container">
                        <i class="bi bi-laptop"></i>
                      </div>
                      <h4>ICT Laboratories</h4>
                      <p>Students learn coding, research skills, and digital literacy with access to high-speed internet and modern computing equipment.</p>
                      <span class="info-badge"><i class="bi bi-info-circle"></i> 24 Labs</span>
                    </div>

                    <div class="facility-card">
                      <div class="icon-container">
                        <i class="bi bi-flask"></i>
                      </div>
                      <h4>Science Labs</h4>
                      <p>Hands-on experiments in Physics, Chemistry, and Biology help develop critical thinking and scientific reasoning.</p>
                      <span class="info-badge"><i class="bi bi-info-circle"></i> 42 Facilities</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Athletic Facilities Tab -->
            <div class="tab-pane fade" id="campus-facilities-athletic" role="tabpanel">
              <div class="row gy-4">
                <div class="col-md-7" data-aos="fade-right" data-aos-delay="100">
                  <div class="facility-highlight">
                    <div class="facility-slider">
                      <div class="facility-slide">
                        <img src="assets/img/education/campus-5.webp" alt="Athletic Center" class="img-fluid rounded">
                        <div class="slide-caption">Sports Complex</div>
                      </div>
                    </div>
                    <div class="facility-description">
                      <h3>Sports & Wellness for Every Student</h3>
                      <p>Sports are a vital part of life on campus. We provide professional-grade facilities that help students stay fit, learn teamwork, and compete confidently in local and national events.</p>
                      <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill"></i> Football and basketball courts</li>
                        <li><i class="bi bi-check-circle-fill"></i> Track and field grounds</li>
                        <li><i class="bi bi-check-circle-fill"></i> Gym and fitness centers</li>
                        <li><i class="bi bi-check-circle-fill"></i> Training support for school teams</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-5" data-aos="fade-left" data-aos-delay="200">
                  <div class="facility-cards">
                    <div class="facility-card">
                      <div class="icon-container">
                        <i class="bi bi-water"></i>
                      </div>
                      <h4>Swimming Pool</h4>
                      <p>A safe and supervised aquatic center where students learn water safety and develop swimming skills.</p>
                      <span class="info-badge"><i class="bi bi-info-circle"></i> Olympic Standard</span>
                    </div>

                    <div class="facility-card">
                      <div class="icon-container">
                        <i class="bi bi-stopwatch"></i>
                      </div>
                      <h4>Training Facilities</h4>
                      <p>Dedicated coaches and modern equipment help build discipline and athletic excellence.</p>
                      <span class="info-badge"><i class="bi bi-info-circle"></i> Pro Equipment</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Residential Facilities Tab -->
            <div class="tab-pane fade" id="campus-facilities-residential" role="tabpanel">
              <div class="row gy-4">
                <div class="col-md-7" data-aos="fade-right" data-aos-delay="100">
                  <div class="facility-highlight">
                    <div class="facility-slider">
                      <div class="facility-slide">
                        <img src="assets/img/education/campus-7.webp" alt="Residence Hall" class="img-fluid rounded">
                        <div class="slide-caption">Boarding Facilities</div>
                      </div>
                    </div>
                    <div class="facility-description">
                      <h3>A Home Away from Home</h3>
                      <p>Our boarding houses provide a comfortable and secure living environment, supervised by caring staff who ensure student well-being and academic focus throughout the term.</p>
                      <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill"></i> Male and female hostels</li>
                        <li><i class="bi bi-check-circle-fill"></i> Fully furnished living spaces</li>
                        <li><i class="bi bi-check-circle-fill"></i> Common rooms for recreation</li>
                        <li><i class="bi bi-check-circle-fill"></i> 24/7 security services</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-5" data-aos="fade-left" data-aos-delay="200">
                  <div class="facility-cards">
                    <div class="facility-card">
                      <div class="icon-container">
                        <i class="bi bi-cup-hot"></i>
                      </div>
                      <h4>Dining Facilities</h4>
                      <p>Nutritious meals are prepared by professional caterers, promoting healthy eating habits among students.</p>
                      <span class="info-badge"><i class="bi bi-info-circle"></i> 5 Locations</span>
                    </div>

                    <div class="facility-card">
                      <div class="icon-container">
                        <i class="bi bi-shield-check"></i>
                      </div>
                      <h4>Security Services</h4>
                      <p>Our campus is secured with trained personnel and surveillance systems to ensure student safety.</p>
                      <span class="info-badge"><i class="bi bi-info-circle"></i> 24/7 Support</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Community Facilities Tab -->
            <div class="tab-pane fade" id="campus-facilities-community" role="tabpanel">
              <div class="row gy-4">
                <div class="col-md-7" data-aos="fade-right" data-aos-delay="100">
                  <div class="facility-highlight">
                    <div class="facility-slider">
                      <div class="facility-slide">
                        <img src="assets/img/education/campus-4.webp" alt="Student Center" class="img-fluid rounded">
                        <div class="slide-caption">Student Center</div>
                      </div>
                    </div>
                    <div class="facility-description">
                      <h3>Building a Strong School Community</h3>
                      <p>We encourage students to express themselves, develop leadership skills, and participate in social, cultural, and creative activities that shape character and lifelong values.</p>
                      <ul class="feature-list">
                        <li><i class="bi bi-check-circle-fill"></i> Cultural and social spaces</li>
                        <li><i class="bi bi-check-circle-fill"></i> Music, arts, and drama studios</li>
                        <li><i class="bi bi-check-circle-fill"></i> Relaxation and counselling areas</li>
                        <li><i class="bi bi-check-circle-fill"></i> Event and meeting halls</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-md-5" data-aos="fade-left" data-aos-delay="200">
                  <div class="facility-cards">
                    <div class="facility-card">
                      <div class="icon-container">
                        <i class="bi bi-music-note-beamed"></i>
                      </div>
                      <h4>Creative Studios</h4>
                      <p>Music and arts laboratories help students discover and nurture their talents.</p>
                      <span class="info-badge"><i class="bi bi-info-circle"></i> 3 Venues</span>
                    </div>

                    <div class="facility-card">
                      <div class="icon-container">
                        <i class="bi bi-shop"></i>
                      </div>
                      <h4>School Stores</h4>
                      <p>Convenient access to books, stationery, and school essentials on campus.</p>
                      <span class="info-badge"><i class="bi bi-info-circle"></i> 8 Locations</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <!-- Campus Gallery -->
        <div class="campus-gallery-section" data-aos="fade-up" data-aos-delay="300">

          <div class="gallery-grid">
            <div class="gallery-item large" data-aos="zoom-in" data-aos-delay="100">
              <img src="assets/img/education/campus-3.webp" alt="Library" class="img-fluid" loading="lazy">
              <div class="gallery-overlay">
                <h4>Central Library</h4>
              </div>
            </div>
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="200">
              <img src="assets/img/education/campus-8.webp" alt="Student Center" class="img-fluid" loading="lazy">
              <div class="gallery-overlay">
                <h4>Student Center</h4>
              </div>
            </div>
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="300">
              <img src="assets/img/education/campus-9.webp" alt="Dormitory" class="img-fluid" loading="lazy">
              <div class="gallery-overlay">
                <h4>Boarding Dormitories</h4>
              </div>
            </div>
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="400">
              <img src="assets/img/education/campus-10.webp" alt="Study Areas" class="img-fluid" loading="lazy">
              <div class="gallery-overlay">
                <h4>Study Spaces</h4>
              </div>
            </div>
            <div class="gallery-item" data-aos="zoom-in" data-aos-delay="500">
              <img src="assets/img/education/campus-5.webp" alt="Sports Complex" class="img-fluid" loading="lazy">
              <div class="gallery-overlay">
                <h4>Sports Complex</h4>
              </div>
            </div>
          </div>
        </div>

        <!-- Campus Map -->
        <div class="campus-map-section" data-aos="fade-up" data-aos-delay="200">
          <div class="row align-items-center">
            <div class="col-lg-5" data-aos="fade-right" data-aos-delay="100">
              <div class="map-info">
                <h2>Campus Map</h2>
                <p>Explore the school easily using our map. Find classrooms, hostels, laboratories, and activity centers all across our secure campus.</p>
                <div class="map-legend">
                  <div class="legend-item">
                    <span class="marker academic"></span>
                    <span>Academic Buildings</span>
                  </div>
                  <div class="legend-item">
                    <span class="marker residential"></span>
                    <span>Residence Halls</span>
                  </div>
                  <div class="legend-item">
                    <span class="marker athletic"></span>
                    <span>Athletic Facilities</span>
                  </div>
                  <div class="legend-item">
                    <span class="marker dining"></span>
                    <span>Dining Facilities</span>
                  </div>
                  <div class="legend-item">
                    <span class="marker parking"></span>
                    <span>Parking Areas</span>
                  </div>
                </div>
                <a href="#" class="btn-map"><i class="bi bi-download"></i> Download PDF Map</a>
              </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
              <div class="map-container">
                <div class="ratio ratio-16x9">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d640.6690182300736!2d5.2145191194978935!3d7.252504593673251!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sng!4v1745751141530!5m2!1sen!2sng" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section><!-- /Campus Facilities Section -->

  </main>

<?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>
