<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="students-life-page">

<?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background position-relative" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Student Life</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Students Life</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

<!-- Students Life Section -->
<section id="students-life" class="students-life section">
  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <!-- Hero Banner -->
    <div class="students-life-banner" data-aos="zoom-in" data-aos-delay="200">
      <div class="banner-content" data-aos="fade-right" data-aos-delay="300">
        <h2>Experience Life Beyond the Classroom</h2>
        <p>
          At our school, we believe education extends far beyond textbooks. Students enjoy a vibrant campus life filled with clubs, sports, creative arts, and leadership opportunities — all designed to build confidence, teamwork, and lifelong friendships.
        </p>
      </div>
      <img src="assets/img/education/showcase-2.webp" alt="Campus Life" class="img-fluid">
    </div>

    <!-- Life Categories -->
    <div class="life-categories mt-5" data-aos="fade-up" data-aos-delay="200">
      <div class="row g-4">
        <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="100">
          <div class="category-card">
            <div class="icon-container">
              <i class="bi bi-people-fill"></i>
            </div>
            <h4>Clubs</h4>
            <p>50+ Active Student Groups</p>
          </div>
        </div>

        <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="200">
          <div class="category-card">
            <div class="icon-container">
              <i class="bi bi-trophy-fill"></i>
            </div>
            <h4>Athletics</h4>
            <p>15+ Sporting Disciplines</p>
          </div>
        </div>

        <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="300">
          <div class="category-card">
            <div class="icon-container">
              <i class="bi bi-calendar-event"></i>
            </div>
            <h4>Events</h4>
            <p>Annual Cultural & Academic Shows</p>
          </div>
        </div>

        <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="400">
          <div class="category-card">
            <div class="icon-container">
              <i class="bi bi-house-door-fill"></i>
            </div>
            <h4>Boarding</h4>
            <p>Safe & Comfortable Hostels</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Tabs Section -->
    <div class="students-life-tabs mt-5" data-aos="fade-up" data-aos-delay="200">
      <ul class="nav nav-pills mb-4 justify-content-center" id="studentLifeTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="clubs-tab" data-bs-toggle="pill" data-bs-target="#students-life-clubs" type="button" role="tab" aria-controls="clubs" aria-selected="true">
            <i class="bi bi-people"></i> Clubs &amp; Societies
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="athletics-tab" data-bs-toggle="pill" data-bs-target="#students-life-athletics" type="button" role="tab" aria-controls="athletics" aria-selected="false">
            <i class="bi bi-trophy"></i> Sports & Games
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="facilities-tab" data-bs-toggle="pill" data-bs-target="#students-life-facilities" type="button" role="tab" aria-controls="facilities" aria-selected="false">
            <i class="bi bi-building"></i> Campus Spaces
          </button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="support-tab" data-bs-toggle="pill" data-bs-target="#students-life-support" type="button" role="tab" aria-controls="support" aria-selected="false">
            <i class="bi bi-shield-check"></i> Student Support
          </button>
        </li>
      </ul>

      <div class="tab-content" id="studentLifeTabsContent">

        <!-- Clubs Tab -->
        <div class="tab-pane fade show active" id="students-life-clubs" role="tabpanel" aria-labelledby="clubs-tab">
          <div class="row g-4">
            <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
              <div class="tab-content-image">
                <img src="assets/img/education/students-2.webp" alt="Student Clubs" class="img-fluid rounded">
                <div class="stat-badge">
                  <span class="number">50+</span>
                  <span class="text">Active Clubs</span>
                </div>
              </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="300">
              <div class="tab-content-text">
                <h3>Join a Club, Discover Your Passion</h3>
                <p>
                  From debate and press clubs to coding, arts, and drama societies — every student finds a platform to express creativity and leadership. Clubs are student-led and guided by staff advisors, promoting teamwork and responsibility.
                </p>

                <div class="row g-3 mt-4">
                  <div class="col-md-6">
                    <div class="club-category">
                      <div class="icon-box">
                        <i class="bi bi-palette"></i>
                      </div>
                      <div class="content">
                        <h5>Arts &amp; Culture</h5>
                        <p>Includes Drama, Dance, and Fine Arts Clubs</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="club-category">
                      <div class="icon-box">
                        <i class="bi bi-globe"></i>
                      </div>
                      <div class="content">
                        <h5>Leadership &amp; Community</h5>
                        <p>Includes Prefects Council and Charity Club</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="club-category">
                      <div class="icon-box">
                        <i class="bi bi-lightbulb"></i>
                      </div>
                      <div class="content">
                        <h5>STEM &amp; Innovation</h5>
                        <p>Science, Coding, and Robotics Clubs</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="club-category">
                      <div class="icon-box">
                        <i class="bi bi-music-note-beamed"></i>
                      </div>
                      <div class="content">
                        <h5>Music &amp; Performance</h5>
                        <p>School Choir and Instrumental Band</p>
                      </div>
                    </div>
                  </div>
                </div>

                <a href="#" class="btn btn-explore mt-4">Explore All Clubs <i class="bi bi-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Athletics Tab -->
        <div class="tab-pane fade" id="students-life-athletics" role="tabpanel" aria-labelledby="athletics-tab">
          <div class="row g-4 mb-4 align-items-center">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
              <h3>Sports &amp; Physical Development</h3>
              <p>
                We nurture not just academic excellence but also physical fitness and teamwork. Students participate in football, basketball, track events, and more through house competitions and inter-school tournaments.
              </p>
              <a href="#" class="btn btn-explore">View Sports Schedule <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
              <div class="stats-container">
                <div class="stat-item">
                  <span class="number">15+</span>
                  <span class="label">Sports Teams</span>
                </div>
                <div class="stat-item">
                  <span class="number">20+</span>
                  <span class="label">Inter-School Awards</span>
                </div>
                <div class="stat-item">
                  <span class="number">300+</span>
                  <span class="label">Active Athletes</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Facilities Tab -->
        <div class="tab-pane fade" id="students-life-facilities" role="tabpanel" aria-labelledby="facilities-tab">
          <div class="row g-4">
            <div class="col-lg-8" data-aos="fade-right" data-aos-delay="200">
              <div class="facilities-gallery">
                <div class="row g-3">
                  <div class="col-md-8">
                    <img src="assets/img/education/campus-4.webp" alt="Hostels" class="img-fluid rounded">
                  </div>
                  <div class="col-md-4">
                    <img src="assets/img/education/campus-5.webp" alt="Dining" class="img-fluid rounded">
                  </div>
                  <div class="col-md-4">
                    <img src="assets/img/education/campus-6.webp" alt="Library" class="img-fluid rounded">
                  </div>
                  <div class="col-md-8">
                    <img src="assets/img/education/campus-7.webp" alt="Recreation" class="img-fluid rounded">
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-4" data-aos="fade-left" data-aos-delay="300">
              <div class="facilities-info">
                <h3>Modern Learning Spaces</h3>
                <p>
                  Our campus is built to support balanced learning — from well-equipped science and ICT labs to serene hostels and creative art studios. Every corner inspires students to learn, live, and lead confidently.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Support Services Tab -->
        <div class="tab-pane fade" id="students-life-support" role="tabpanel" aria-labelledby="support-tab">
          <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
              <div class="support-card">
                <div class="icon">
                  <i class="bi bi-heart-pulse"></i>
                </div>
                <h5>Health & Wellness</h5>
                <p>Our school clinic provides basic medical care and ensures students’ physical and emotional well-being throughout the term.</p>
              </div>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
              <div class="support-card">
                <div class="icon">
                  <i class="bi bi-chat-square-heart"></i>
                </div>
                <h5>Counselling Services</h5>
                <p>Professional guidance counselors are available to help students navigate academics, peer relationships, and personal growth.</p>
              </div>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
              <div class="support-card">
                <div class="icon">
                  <i class="bi bi-person-badge"></i>
                </div>
                <h5>Student Mentorship</h5>
                <p>Each student is assigned a staff mentor who provides academic guidance and ensures individual talents are nurtured.</p>
              </div>
            </div>

            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
              <div class="support-card">
                <div class="icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
                <h5>Safety & Security</h5>
                <p>Our school maintains 24-hour security and ensures a safe, well-supervised environment for all students, both day and boarding.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA -->
    <div class="cta-wrapper mt-5" data-aos="fade-up" data-aos-delay="200">
      <div class="cta-content">
        <div class="row align-items-center">
          <div class="col-lg-8" data-aos="fade-right" data-aos-delay="300">
            <h3>Ready to Be Part of Our Vibrant Community?</h3>
            <p>Join a school that celebrates knowledge, creativity, and character. Experience learning that transforms minds and builds leaders for tomorrow.</p>
          </div>
          <div class="col-lg-4" data-aos="fade-left" data-aos-delay="400">
            <div class="cta-buttons">
              <a href="#" class="btn btn-primary">Schedule a Visit</a>
              <a href="#" class="btn btn-outline">Apply Now</a>
            </div>
          </div>
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