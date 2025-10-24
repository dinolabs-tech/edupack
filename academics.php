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
                <span class="subtitle">Excellence in Learning</span>
                <h2>Discover Our Academic Programmes</h2>
                <p class="intro-text">
                  We follow the Nigerian National Curriculum to provide an engaging and supportive
                  learning experience from Nursery through Senior Secondary School. We are committed
                  to building confidence, strong academics, and moral values in every learner.
                </p>
                <div class="key-highlights">
                  <div class="highlight-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Technology-enhanced classrooms and learning</span>
                  </div>
                  <div class="highlight-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Qualified and dedicated teachers</span>
                  </div>
                  <div class="highlight-item">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Preparation for WAEC, NECO & other examinations</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="programs-navigation" data-aos="fade-up" data-aos-delay="100">
          <div class="row">
            <div class="col-12">
              <div class="program-tabs">
                <ul class="nav nav-tabs justify-content-center" role="tablist">

                  <!-- All Levels -->
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="all-tab" data-bs-toggle="tab"
                      data-bs-target="#academics-all" type="button" role="tab">
                      <span class="icon"><i class="bi bi-grid"></i></span>
                      <span class="text">All Levels</span>
                    </button>
                  </li>

                  <!-- Nursery -->
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="nursery-tab" data-bs-toggle="tab"
                      data-bs-target="#academics-nursery" type="button" role="tab">
                      <span class="icon"><i class="bi bi-brush"></i></span>
                      <span class="text">Nursery</span>
                    </button>
                  </li>

                  <!-- Primary 1–6 -->
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="primary-tab" data-bs-toggle="tab"
                      data-bs-target="#academics-primary" type="button" role="tab">
                      <span class="icon"><i class="bi bi-pencil"></i></span>
                      <span class="text">Primary 1–6</span>
                    </button>
                  </li>

                  <!-- JSS 1–3 -->
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="junior-tab" data-bs-toggle="tab"
                      data-bs-target="#academics-junior" type="button" role="tab">
                      <span class="icon"><i class="bi bi-book"></i></span>
                      <span class="text">JSS 1–3</span>
                    </button>
                  </li>

                  <!-- SS 1–3 -->
                  <li class="nav-item" role="presentation">
                    <button class="nav-link" id="senior-tab" data-bs-toggle="tab"
                      data-bs-target="#academics-senior" type="button" role="tab">
                      <span class="icon"><i class="bi bi-award-fill"></i></span>
                      <span class="text">SS 1–3</span>
                    </button>
                  </li>

                </ul>
              </div>
            </div>
          </div>
        </div>

        <div class="tab-content programs-content" data-aos="fade-up" data-aos-delay="200">

          <!-- All Levels Tab -->
          <div class="tab-pane fade show active" id="academics-all" role="tabpanel">
            <div class="row g-4">

              <!-- Nursery Item -->
              <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="program-item nursery">
                  <div class="program-header">
                    <div class="program-icon">
                      <i class="bi bi-brush"></i>
                    </div>
                    <span class="program-type text-success">Nursery</span>
                  </div>
                  <div class="program-body">
                    <h3>Early Years Learning</h3>
                    <p>Building foundational skills in literacy, numeracy, social interaction and creative development.</p>
                    <ul class="program-details">
                      <li><i class="bi bi-clock"></i> Ages 2–5</li>
                      <li><i class="bi bi-calendar-check"></i> Continuous Assessment</li>
                    </ul>
                  </div>
                  <!-- <div class="program-footer">
                    <a href="#" class="program-link">View Level <i class="bi bi-arrow-right"></i></a>
                  </div> -->
                </div>
              </div>

              <!-- Primary Item -->
              <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="program-item primary">
                  <div class="program-header">
                    <div class="program-icon">
                      <i class="bi bi-pencil"></i>
                    </div>
                    <span class="program-type text-success">Primary 1–6</span>
                  </div>
                  <div class="program-body">
                    <h3>Basic Education</h3>
                    <p>Classroom learning across key areas to build strong academic foundations and personal development.</p>
                    <ul class="program-details">
                      <li><i class="bi bi-book"></i> Core Subjects</li>
                      <li><i class="bi bi-people"></i> 21st-century learning</li>
                    </ul>
                  </div>
                  <!-- <div class="program-footer">
                    <a href="#" class="program-link">View Level <i class="bi bi-arrow-right"></i></a>
                  </div> -->
                </div>
              </div>

              <!-- JSS Item -->
              <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="program-item jss">
                  <div class="program-header">
                    <div class="program-icon">
                      <i class="bi bi-book-half"></i>
                    </div>
                    <span class="program-type text-success">JSS 1–3</span>
                  </div>
                  <div class="program-body">
                    <h3>Junior Secondary</h3>
                    <p>Introducing broad subject exposure including sciences, business, technology and arts.</p>
                    <ul class="program-details">
                      <li><i class="bi bi-award"></i> BECE Preparation</li>
                      <li><i class="bi bi-lightbulb"></i> Skill development</li>
                    </ul>
                  </div>
                  <!-- <div class="program-footer">
                    <a href="#" class="program-link">View Level <i class="bi bi-arrow-right"></i></a>
                  </div> -->
                </div>
              </div>

              <!-- SS Item -->
              <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="400">
                <div class="program-item sss">
                  <div class="program-header">
                    <div class="program-icon">
                      <i class="bi bi-award-fill"></i>
                    </div>
                    <span class="program-type text-success">SS 1–3</span>
                  </div>
                  <div class="program-body">
                    <h3>Senior Secondary</h3>
                    <p>Students choose subject pathways — Science, Commercial or Arts — in preparation for WAEC & NECO exams.</p>
                    <ul class="program-details">
                      <li><i class="bi bi-journal-check"></i> WAEC/NECO</li>
                      <li><i class="bi bi-briefcase"></i> Career readiness</li>
                    </ul>
                  </div>
                  <!-- <div class="program-footer">
                    <a href="#" class="program-link">View Level <i class="bi bi-arrow-right"></i></a>
                  </div> -->
                </div>
              </div>

            </div>
          </div>

          <!-- Nursery Tab -->
          <div class="tab-pane fade" id="academics-nursery" role="tabpanel">
            <div class="row g-4">
              <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                <div class="program-item nursery">
                  <div class="program-header">
                    <div class="program-icon">
                      <i class="bi bi-brush"></i>
                    </div>
                    <span class="program-type">Nursery</span>
                  </div>
                  <div class="program-body">
                    <h3>Early Years Learning</h3>
                    <p>Play-based and activity-based learning for cognitive and emotional growth.</p>
                  </div>
                  <!-- <div class="program-footer">
                    <a href="#" class="program-link">View Level <i class="bi bi-arrow-right"></i></a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>

          <!-- Primary Tab -->
          <div class="tab-pane fade" id="academics-primary" role="tabpanel">
            <div class="row g-4">
              <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                <div class="program-item primary">
                  <div class="program-header">
                    <div class="program-icon">
                      <i class="bi bi-pencil"></i>
                    </div>
                    <span class="program-type">Primary 1–6</span>
                  </div>
                  <div class="program-body">
                    <h3>Basic Education</h3>
                    <p>Math, English, Social Studies, Science, Verbal/Quantitative Reasoning, ICT and more.</p>
                  </div>
                  <!-- <div class="program-footer">
                    <a href="#" class="program-link">View Level <i class="bi bi-arrow-right"></i></a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>

          <!-- JSS Tab -->
          <div class="tab-pane fade" id="academics-junior" role="tabpanel">
            <div class="row g-4">
              <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                <div class="program-item jss">
                  <div class="program-header">
                    <div class="program-icon">
                      <i class="bi bi-book-half"></i>
                    </div>
                    <span class="program-type">JSS 1–3</span>
                  </div>
                  <div class="program-body">
                    <h3>Junior Secondary</h3>
                    <p>Core subjects including Basic Science, Business Studies, Computer Studies and Civic Education.</p>
                  </div>
                  <!-- <div class="program-footer">
                    <a href="#" class="program-link">View Level <i class="bi bi-arrow-right"></i></a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>

          <!-- SSS Tab -->
          <div class="tab-pane fade" id="academics-senior" role="tabpanel">
            <div class="row g-4">
              <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                <div class="program-item sss">
                  <div class="program-header">
                    <div class="program-icon">
                      <i class="bi bi-award-fill"></i>
                    </div>
                    <span class="program-type">SS 1–3</span>
                  </div>
                  <div class="program-body">
                    <h3>Senior Secondary</h3>
                    <p>Students follow subject pathways such as Sciences, Commercial or Arts with exam-focused learning.</p>
                  </div>
                  <!-- <div class="program-footer">
                    <a href="#" class="program-link">View Level <i class="bi bi-arrow-right"></i></a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>

        </div>


        <div class="featured-program-wrapper" data-aos="fade-up">
          <div class="row">
            <div class="col-12">
              <div class="section-heading text-center mb-4">
                <h2>Featured Program</h2>
                <p>A flagship curriculum shaping future innovators</p>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-10 mx-auto">
              <div class="featured-program-card">
                <div class="row align-items-center">
                  <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-right" data-aos-delay="100">
                    <div class="featured-program-image">
                      <img src="assets/img/education/students-1.webp" alt="Senior Secondary Science" class="img-fluid">
                      <div class="program-label">
                        <span>Featured</span>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                    <div class="featured-program-content">
                      <h3>Senior Secondary Science Program (SS1 – SS3)</h3>
                      <p>
                        Our SS Science curriculum prepares students for WAEC, NECO, and global academic
                        opportunities. Learners engage in hands-on laboratory work, STEM projects,
                        and guided preparation for life in medicine, engineering, and technology fields.
                      </p>

                      <div class="program-highlights">
                        <div class="highlight">
                          <div class="highlight-icon">
                            <i class="bi bi-clock"></i>
                          </div>
                          <div class="highlight-info">
                            <h4>Duration</h4>
                            <p>3 Academic Years</p>
                          </div>
                        </div>
                        <div class="highlight">
                          <div class="highlight-icon">
                            <i class="bi bi-book-half"></i>
                          </div>
                          <div class="highlight-info">
                            <h4>Examination Focus</h4>
                            <p>WAEC · NECO · UTME</p>
                          </div>
                        </div>
                        <div class="highlight">
                          <div class="highlight-icon">
                            <i class="bi bi-stars"></i>
                          </div>
                          <div class="highlight-info">
                            <h4>Core Subjects</h4>
                            <p>Mathematics, Physics, Chemistry, Biology</p>
                          </div>
                        </div>
                      </div>

                      <div class="featured-program-action">
                        <a href="admissions.php#admission_form" class="btn-apply">Enroll Now</a>
                        <!-- <a href="#" class="btn-details">Program Details</a> -->
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="stats-wrapper" data-aos="fade-up">
          <div class="row align-items-center">

            <div class="col-lg-5 mb-4 mb-lg-0" data-aos="fade-right" data-aos-delay="100">
              <div class="stats-content">
                <span class="subtitle">By The Numbers</span>
                <h2>Our Academic Impact</h2>
                <p>
                  We are committed to academic excellence, character development, and a safe learning
                  environment where every child can thrive from Nursery to Senior Secondary School.
                </p>
                <a href="about.php" class="btn-about">Learn More About Us</a>
              </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
              <div class="stats-grid">

                <div class="stat-card" data-aos="zoom-in" data-aos-delay="100">
                  <div class="stat-icon">
                    <i class="bi bi-emoji-smile-fill"></i>
                  </div>
                  <div class="stat-number">
                    <span data-purecounter-start="0" data-purecounter-end="98" data-purecounter-duration="1" class="purecounter"></span>%
                  </div>
                  <div class="stat-title">Parent Satisfaction</div>
                </div>

                <div class="stat-card" data-aos="zoom-in" data-aos-delay="200">
                  <div class="stat-icon">
                    <i class="bi bi-book-half"></i>
                  </div>
                  <div class="stat-number">
                    <span data-purecounter-start="0" data-purecounter-end="40" data-purecounter-duration="1" class="purecounter"></span>+
                  </div>
                  <div class="stat-title">Subjects Offered</div>
                </div>

                <div class="stat-card" data-aos="zoom-in" data-aos-delay="300">
                  <div class="stat-icon">
                    <i class="bi bi-award-fill"></i>
                  </div>
                  <div class="stat-number">
                    <span data-purecounter-start="0" data-purecounter-end="95" data-purecounter-duration="1" class="purecounter"></span>%
                  </div>
                  <div class="stat-title">WAEC/NECO Success Rate</div>
                </div>

                <div class="stat-card" data-aos="zoom-in" data-aos-delay="400">
                  <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                  </div>
                  <div class="stat-number">
                    <span data-purecounter-start="0" data-purecounter-end="500" data-purecounter-duration="1" class="purecounter"></span>+
                  </div>
                  <div class="stat-title">Students Enrolled</div>
                </div>

              </div>
            </div>

          </div>
        </div>


      </div>

    </section><!-- /Academics Section -->

  </main>

  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>