<?php
/**
 * checkcbt.php
 *
 * This file provides an administrative interface to check and download CBT (Computer Based Test) results.
 * It allows administrators to view a specific student's result by entering their ID or download the entire
 * CBT result data.
 *
 * Key functionalities include:
 * - User authentication and session management (via admin_logic.php).
 * - Database connection.
 * - Providing a form to input a student ID for checking individual results.
 * - Providing a button to download the entire CBT result data.
 * - Includes various UI components like head, navigation, header, footer, and scripts.
 */

// Include the administrative logic file, which likely handles session checks and other admin-specific functions.
include('components/admin_logic.php');

?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php');?> <!-- Includes the head section of the HTML document (meta tags, title, CSS links) -->
  <body>
    <div class="wrapper">
      <!-- Sidebar -->
     <?php include('adminnav.php');?> <!-- Includes the admin specific navigation sidebar -->
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
                <h3 class="fw-bold mb-3">Check Result</h3>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">CBT</li>
                  <li class="breadcrumb-item active">Check Result</li>
              </ol>
              </div>

            </div>

            <!-- Check Result Section -->
            <div class="row">

             <div class="col-md-12">
               <div class="card card-round">
                 <div class="card-header">
                   <div class="card-head-row">
                     <div class="card-title">Check Result</div>
                   </div>
                 </div>
                 <div class="card-body pb-0">
                   <div class="mb-4 mt-2">

                   <!-- Form to input student ID for checking individual CBT result -->
                   <form method="post" action="checker.php">
                      <div class="mb-3">
                        <input type="text" class="form-control" id="check" name="check" placeholder="Enter Student ID" required>
                      </div>
                      <button type="submit" name="checksubmit" class="btn btn-success"><span class="btn-label">
                      <i class="fa fa-eye"></i>View Result</button>
                    </form>

                   </div>
                 </div>
               </div>
             </div>

             <!-- Download Entire Result Section -->
             <div class="col-md-12">
               <div class="card card-round">
                 <div class="card-header">
                   <div class="card-head-row">
                     <div class="card-title">Check Result | Full Download</div>
                   </div>
                 </div>
                 <div class="card-body pb-0">
                   <div class="mb-4 mt-2">

                     <!-- Form to download the entire CBT result data -->
                     <form method="post" action="downloadcbt.php">
                      <button type="submit" name="checksubmit" class="btn btn-secondary"><span class="btn-label">
                      <i class="fa fa-cloud-download-alt"></i>Download Entire Result</button>
                    </form>

                   </div>
                 </div>
               </div>
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
