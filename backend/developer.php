<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?> <!-- Includes the head section of the HTML document (meta tags, title, CSS links) -->

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include('adminnav.php'); ?> <!-- Includes the admin specific navigation sidebar -->
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <?php include('logo_header.php'); ?> <!-- Includes the logo and header content -->
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <?php include('navbar.php'); ?> <!-- Includes the main navigation bar -->
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div
                        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Check Result</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">CBT</li>
                                <li class="breadcrumb-item active">Check Result</li>
                            </ol>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h2>Developer Tools</h2>
                            <p>This page provides access to developer-specific tools and logs.</p>

                            <div class="card mt-4">
                                <div class="card-header">
                                    View Logs
                                </div>
                                <div class="card-body">
                                    <button class="btn btn-primary mb-2" id="viewErrorLog">View error_log.txt</button>
                                    <button class="btn btn-info mb-2" id="viewBackupLog">View backup.log</button>
                                    <a href="download_backup.php" class="btn btn-success mb-2" download>Download backup_dinolabs_edupack.sql</a>
                                    <div id="logContent" class="mt-3" style="white-space: pre-wrap; background-color: #f8f9fa; padding: 15px; border-radius: 5px; max-height: 500px; overflow-y: scroll;">
                                        <!-- Log content will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include('footer.php'); ?> <!-- Includes the footer section of the page -->
            </div>

            <!-- Custom template | don't include it in your project! -->
            <?php include('cust-color.php'); ?> <!-- Includes custom color settings or scripts -->
            <!-- End Custom template -->
        </div>
        <?php include('scripts.php'); ?> <!-- Includes general JavaScript scripts for the page -->

        <script>
            $(document).ready(function() {
                $('#viewErrorLog').click(function() {
                    $.ajax({
                        url: 'fetch_log.php', // A new PHP file to fetch log content
                        type: 'GET',
                        data: {
                            log_type: 'error_log'
                        },
                        success: function(response) {
                            $('#logContent').text(response);
                        },
                        error: function() {
                            $('#logContent').text('Error fetching error_log.txt');
                        }
                    });
                });

                $('#viewBackupLog').click(function() {
                    $.ajax({
                        url: 'fetch_log.php', // A new PHP file to fetch log content
                        type: 'GET',
                        data: {
                            log_type: 'backup_log'
                        },
                        success: function(response) {
                            $('#logContent').text(response);
                        },
                        error: function() {
                            $('#logContent').text('Error fetching backup.log');
                        }
                    });
                });
            });
        </script>
    </div>
</body>

</html>