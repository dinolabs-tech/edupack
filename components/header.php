  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo.ico" alt="">
        <!-- <i class="bi bi-buildings"></i> -->
        <h1 class="sitename">EduPack</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="students-life.php">Students Life</a></li>
          <li><a href="events.php">Events</a></li>
          <li><a href="gallery.php">Gallery</a></li>

          <li class="dropdown"><a href="#"><span>Our School</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="admissions.php">Admissions</a></li>
              <li><a href="academics.php">Academics</a></li>
              <li><a href="faculty-staff.php">Faculty &amp; Staff</a></li>
              <li><a href="campus-facilities.php">Campus &amp; Facilities</a></li>
              <li><a href="alumni.php">Alumni</a></li>
            </ul>
          </li>
          <!-- <li class="dropdown"><a href="#"><span>More Pages</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="event-details.php">Event Details</a></li>
              <li><a href="privacy.php">Privacy</a></li>
              <li><a href="terms-of-service.php">Terms of Service</a></li>
              <li><a href="404.php">Error 404</a></li>
              <li><a href="starter-page.php">Starter Page</a></li>
            </ul>
          </li> -->

          <?php if (isset($_SESSION["staffname"])) { ?>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'Superuser' || $_SESSION['role'] == 'Administrator' || $_SESSION['role'] == 'Teacher') { ?>
              <li class="dropdown"><a href="blog.php"><span>Blog</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="blog.php">Blog</a></li>
                  <li><a href="create_post.php">Create Post</a></li>
                  <li><a href="manage_categories.php">Manage Categories</a></li>
                  <li><a href="dashboard.php">Blog Dashboard</a></li>
                </ul>
              <? } else { ?>

              <?php } ?>

            <?php } else { ?>
              <a href="blog.php">Blog</a>
            <?php } ?>

              </li>

              <?php if (isset($_SESSION['role']) == 'Superuser') { ?>
                <li><a href="backend/superdashboard.php">Dashboard</a></li>
              <?php } elseif (isset($_SESSION['role']) == 'Administrator' || isset($_SESSION['role']) == 'Teacher' || isset($_SESSION['role']) == 'Admmission') { ?>
                <li><a href="backend/dashboard.php">Dashboard</a></li>
              <?php } elseif (isset($_SESSION['role']) == 'Tuckshop') { ?>
                <li><a href="backend/tuckdashboard.php">Dashboard</a></li>
              <?php } elseif (isset($_SESSION['role']) == 'Parent') { ?>
                <li><a href="backend/parent.php">Dashboard</a></li>
              <?php } elseif (isset($_SESSION['role']) == 'Bursary') { ?>
                li><a href="backend/account/index.php">Dashboard</a></li>
              <?php } else { ?>
                <li><a href="backend/login.php">Dashboard</a></li>
              <?php }
              ?>

              <li><a href="about.php">About</a></li>
              <li><a href="contact.php">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>