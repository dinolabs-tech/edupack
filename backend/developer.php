<?php
session_start();
// Check if the user is logged in and is a super user
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'super_user') {
    header("Location: login.php");
    exit();
}

include 'head.php';
include 'navbar.php';
?>

<div class="container-fluid">
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

<?php include 'scripts.php'; ?>

<script>
$(document).ready(function() {
    $('#viewErrorLog').click(function() {
        $.ajax({
            url: 'fetch_log.php', // A new PHP file to fetch log content
            type: 'GET',
            data: { log_type: 'error_log' },
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
            data: { log_type: 'backup_log' },
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

<?php include 'footer.php'; ?>
