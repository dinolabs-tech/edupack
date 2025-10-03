<?php
/**
 * bpayment.php
 *
 * This file provides an interface for students or parents to make a payment deposit.
 * It allows users to enter student details, depositor information, amount, narration,
 * and upload a payment receipt. The submitted data is stored in a 'prebursary' table
 * for administrative approval.
 *
 * Key functionalities include:
 * - Session management and role-based navigation inclusion.
 * - Database connection.
 * - Handling POST requests for submitting payment details and file uploads.
 * - Dynamic fetching of student details based on student ID (via AJAX).
 * - Displaying success or error messages for deposit submissions.
 * - Includes various UI components like head, logo header, navbar, footer, and scripts.
 */

// Include the student-specific logic file, which likely handles session checks and other student-related functions.
include('components/students_logic.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Deposit</title> <!-- Changed title to reflect page purpose -->
    <meta
      content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
      name="viewport"
    />
    <link
      rel="icon"
      href="assets/img/kaiadmin/favicon.ico"
      type="image/x-icon"
    />

    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
    <link rel="stylesheet" href="components/students_style.css" />

  </head>
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
      <?php
      // Determine which navigation sidebar to include based on the user's role.
      $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
      if ($role === 'Student') {
        include('studentnav.php');
      } elseif ($role === 'Administrator') {
        include('adminnav.php');
      } elseif ($role === 'Alumni') {
        include('alumninav.php');
      }
      ?>
      <!-- End Sidebar -->

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <?php include('logo_header.php');?> <!-- Includes the logo and header content -->
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
         <?php include('navbar.php');?> <!-- Includes the main navigation bar -->
          <!-- End Navbar -->
        </div>

        <div class="container">
          <div class="page-inner">
            <div
              class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4"
            >
              <div>
                <h3 class="fw-bold mb-3">Deposit</h3>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="students.php">Home</a></li>
                  <li class="breadcrumb-item active">Bursary</li>
                  <li class="breadcrumb-item active">Deposit</li>
              </ol>
              </div>

            </div>

            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                  <h4 class="card-title">Deposit |
                    <?php
                    // Display student's class and arm, if available from students_logic.php.
                    echo htmlspecialchars($student_class); ?> <?php echo htmlspecialchars($student_arm);
                    ?>
                    </h4>
                  </div>
                  <div class="card-body">

                                      <p>
                            <?php
                            // Display any registration or bulk upload messages.
                            if (!empty($register_message)): ?>
                        <div class="message"><?php echo htmlspecialchars($register_message); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($bulk_message)): ?>
                        <div class="message"><?php echo htmlspecialchars($bulk_message); ?></div>
                    <?php endif; ?>

                    <!-- Registration Form for Payment Deposit -->
                    <form method="post" class="row g-3" enctype="multipart/form-data">

                    <div class="col-md-2">
                    <input type="text" id="id" class="form-control form-control" name="id" required onkeyup="fetchStudentDetails(this.value)" placeholder="Student ID">
                    </div>

                    <div class="col-md-6">
                    <input type="text" id="name" name="name" class="form-control form-control" readonly placeholder="Students Name">
                    </div>

                    <div class="col-md-2">
                    <input type="text" id="class" class="form-control form-control" name="class" readonly placeholder="Students Class">
                    </div>

                    <div class="col-md-2">
                    <input type="text" id="arm" class="form-control form-control" name="arm" readonly placeholder="Students Arm">
                    </div>

                    <div class="col-md-2">
                    <input type="text" id="term" class="form-control form-control" name="term" readonly placeholder="Current Term">
                    </div>

                    <div class="col-md-2">
                    <input type="text" id="gender" class="form-control form-control" name="gender" readonly placeholder="Gender">
                    </div>

                    <div class="col-md-2">
                    <input type="text" id="session"  class="form-control form-control" name="session" readonly placeholder="Academic Session">
                    </div>

                    <div class="col-md-6">
                    <input type="text" id="depositor_name" name="depositor_name"  class="form-control form-control" required placeholder="Depositor's Name">
                    </div>

                    <div class="col-md-2">
                    <input type="text" id="depositor_mobile" name="depositor_mobile" class="form-control form-control" required placeholder="Mobile">
                    </div>

                    <div class="col-md-2">
                    <input type="text" id="amount_deposited" name="amount_deposited" class="form-control form-control" required placeholder="Amount">
                    </div>

                    <div class="col-md-2">
                    <input type="text" id="narration" name="narration" class="form-control form-control" required placeholder="Narration">
                    </div>

                    <div class="col-md-6">
                    <input type="file" id="file_upload" name="file_upload" accept=".jpg,.jpeg" class="form-control form-control" required placeholder="Payment Receipt">
                    </div>

                        <button type="submit" class="btn btn-primary"> Submit Deposit</button>

                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </form>


                                </p>
                  </div>

              </div>

          </div>
        </div>

        <?php include('footer.php');?> <!-- Includes the footer section of the page -->
      </div>

      <!-- Custom template | don't include it in your project! -->
      <?php include('cust-color.php');?> <!-- Includes custom color settings or scripts -->
      <!-- End Custom template -->
    </div>
   <?php include('scripts.php');?> <!-- Includes general JavaScript scripts for the page -->
  </body>
</html>
