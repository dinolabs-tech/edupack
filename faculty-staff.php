<!DOCTYPE html>
<html lang="en">

<?php include 'components/head.php'; ?>

<body class="faculty-staff-page">

  <?php include 'components/header.php'; ?>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" style="background-image: url(assets/img/education/showcase-1.webp);">
      <div class="container position-relative">
        <h1>Faculty Staff</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.php">Home</a></li>
            <li class="current">Faculty Staff</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Faculty & Staff Section -->
    <section id="faculty--staff" class="faculty--staff section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <!-- Search and Filter -->
        <div class="row mb-5">
          <div class="col-lg-8 mx-auto">
            <div class="search-container" data-aos="fade-up" data-aos-delay="200">
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Search teachers or staff by name, subject, or department...">
                <button class="btn search-btn" type="button"><i class="bi bi-search"></i></button>
              </div>
              <div class="filters mt-3">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="academicFilter" checked="">
                  <label class="form-check-label" for="academicFilter">Academic</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="adminFilter" checked="">
                  <label class="form-check-label" for="adminFilter">Administrative</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="supportFilter" checked="">
                  <label class="form-check-label" for="supportFilter">Support Staff</label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Faculty & Staff Tabs -->
        <div class="row">
          <div class="col-lg-3" data-aos="fade-up" data-aos-delay="300">
            <div class="departments-nav">
              <h4 class="departments-title">Departments</h4>
              <ul class="nav nav-tabs flex-column">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#faculty--staff-tab-1">Science</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#faculty--staff-tab-2">Arts & Humanities</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#faculty--staff-tab-3">Commercial</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#faculty--staff-tab-4">Administrative</button>
                </li>
              </ul>
            </div>
          </div>

          <div class="col-lg-9" data-aos="fade-up" data-aos-delay="400">
            <div class="tab-content">

              <!-- Science Department -->
              <div class="tab-pane fade show active" id="faculty--staff-tab-1">
                <div class="department-info mb-4">
                  <h3>Science Department</h3>
                  <p>The Science Department is committed to fostering critical thinking and practical inquiry among students. Our teachers engage learners through experiments, projects, and hands-on lessons that connect classroom knowledge with real-world applications.</p>
                </div>
                <div class="row g-4">

                  <div class="col-md-6 col-lg-4">
                    <div class="faculty-card">
                      <div class="faculty-image">
                        <img src="assets/img/person/person-m-3.webp" class="img-fluid" alt="Faculty Member">
                      </div>
                      <div class="faculty-info">
                        <h4>Mr. David Okoro</h4>
                        <p class="faculty-title">Head of Department, Physics Teacher</p>
                        <div class="faculty-specialties">
                          <span>Electricity & Magnetism</span>
                          <span>Practical Physics</span>
                        </div>
                        <div class="faculty-contact">
                          <a href="mailto:dokoro@school.edu"><i class="bi bi-envelope"></i> Email</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-lg-4">
                    <div class="faculty-card">
                      <div class="faculty-image">
                        <img src="assets/img/person/person-f-5.webp" class="img-fluid" alt="Faculty Member">
                      </div>
                      <div class="faculty-info">
                        <h4>Mrs. Angela Hassan</h4>
                        <p class="faculty-title">Biology Teacher</p>
                        <div class="faculty-specialties">
                          <span>Human Anatomy</span>
                          <span>Genetics</span>
                        </div>
                        <div class="faculty-contact">
                          <a href="mailto:ahassan@school.edu"><i class="bi bi-envelope"></i> Email</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-lg-4">
                    <div class="faculty-card">
                      <div class="faculty-image">
                        <img src="assets/img/person/person-m-7.webp" class="img-fluid" alt="Faculty Member">
                      </div>
                      <div class="faculty-info">
                        <h4>Mr. Samuel Eze</h4>
                        <p class="faculty-title">Chemistry Teacher</p>
                        <div class="faculty-specialties">
                          <span>Organic Chemistry</span>
                          <span>Laboratory Safety</span>
                        </div>
                        <div class="faculty-contact">
                          <a href="mailto:seze@school.edu"><i class="bi bi-envelope"></i> Email</a>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <!-- Arts & Humanities Department -->
              <div class="tab-pane fade" id="faculty--staff-tab-2">
                <div class="department-info mb-4">
                  <h3>Arts & Humanities Department</h3>
                  <p>The Arts & Humanities Department nurtures creativity, communication, and cultural awareness through subjects like Literature, Civic Education, and History. Students are guided to think critically and express themselves with confidence.</p>
                </div>
                <div class="row g-4">

                  <div class="col-md-6 col-lg-4">
                    <div class="faculty-card">
                      <div class="faculty-image">
                        <img src="assets/img/person/person-f-9.webp" class="img-fluid" alt="Faculty Member">
                      </div>
                      <div class="faculty-info">
                        <h4>Mrs. Grace Adewale</h4>
                        <p class="faculty-title">English Language Teacher</p>
                        <div class="faculty-specialties">
                          <span>Grammar & Composition</span>
                          <span>Public Speaking</span>
                        </div>
                        <div class="faculty-contact">
                          <a href="mailto:gadewale@school.edu"><i class="bi bi-envelope"></i> Email</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-lg-4">
                    <div class="faculty-card">
                      <div class="faculty-image">
                        <img src="assets/img/person/person-m-11.webp" class="img-fluid" alt="Faculty Member">
                      </div>
                      <div class="faculty-info">
                        <h4>Mr. Henry Uche</h4>
                        <p class="faculty-title">Literature-in-English Teacher</p>
                        <div class="faculty-specialties">
                          <span>Poetry</span>
                          <span>Drama Analysis</span>
                        </div>
                        <div class="faculty-contact">
                          <a href="mailto:h uche@school.edu"><i class="bi bi-envelope"></i> Email</a>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <!-- Commercial Department -->
              <div class="tab-pane fade" id="faculty--staff-tab-3">
                <div class="department-info mb-4">
                  <h3>Commercial Department</h3>
                  <p>The Commercial Department prepares students for future careers in business, finance, and entrepreneurship. Courses such as Accounting, Commerce, and Economics are taught with a balance of theory and practical examples.</p>
                </div>
                <div class="row g-4">

                  <div class="col-md-6 col-lg-4">
                    <div class="faculty-card">
                      <div class="faculty-image">
                        <img src="assets/img/person/person-m-2.webp" class="img-fluid" alt="Faculty Member">
                      </div>
                      <div class="faculty-info">
                        <h4>Mr. Daniel Musa</h4>
                        <p class="faculty-title">Economics Teacher</p>
                        <div class="faculty-specialties">
                          <span>Microeconomics</span>
                          <span>Market Dynamics</span>
                        </div>
                        <div class="faculty-contact">
                          <a href="mailto:dmusa@school.edu"><i class="bi bi-envelope"></i> Email</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6 col-lg-4">
                    <div class="faculty-card">
                      <div class="faculty-image">
                        <img src="assets/img/person/person-f-12.webp" class="img-fluid" alt="Faculty Member">
                      </div>
                      <div class="faculty-info">
                        <h4>Mrs. Chika Nnaji</h4>
                        <p class="faculty-title">Accounting Teacher</p>
                        <div class="faculty-specialties">
                          <span>Bookkeeping</span>
                          <span>Financial Reporting</span>
                        </div>
                        <div class="faculty-contact">
                          <a href="mailto:cnnaji@school.edu"><i class="bi bi-envelope"></i> Email</a>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <!-- Administrative Department -->
              <div class="tab-pane fade" id="faculty--staff-tab-4">
                <div class="department-info mb-4">
                  <h3>Administrative Staff</h3>
                  <p>Our administrative team ensures smooth daily operations, providing support for students, parents, and teachers alike. They are the backbone of our school’s efficiency and hospitality.</p>
                </div>
                <div class="row g-4">

                  <div class="col-md-6 col-lg-4">
                    <div class="faculty-card">
                      <div class="faculty-image">
                        <img src="assets/img/person/person-f-2.webp" class="img-fluid" alt="Faculty Member">
                      </div>
                      <div class="faculty-info">
                        <h4>Mrs. Ruth Bello</h4>
                        <p class="faculty-title">School Administrator</p>
                        <div class="faculty-specialties">
                          <span>Records Management</span>
                          <span>Student Affairs</span>
                        </div>
                        <div class="faculty-contact">
                          <a href="mailto:rbello@school.edu"><i class="bi bi-envelope"></i> Email</a>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>

      </div>

    </section>
    <!-- /Faculty & Staff Section -->


  </main>


  <?php include 'components/footer.php'; ?>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?php include 'components/scripts.php'; ?>

</body>

</html>