<?php include('components/admin_logic.php');

include('components/fees_management.php');


// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include('adminnav.php'); ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <?php include('logo_header.php'); ?>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <?php include('navbar.php'); ?>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Bursary Dashboard</h3>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">Home</li>
                                <li class="breadcrumb-item active">Bursary</li>
                                <li class="breadcrumb-item active">Bursary Dashboard</li>
                            </ol>
                        </div>

                    </div>

                    <!-- BULK UPLOAD ============================ -->
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Add New Fee</div>
                                    </div>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <p>

                                        <div class="row mb-4">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="classFilter">Filter by Class:</label>
                                                    <select class="form-control form-select" id="classFilter">
                                                        <option value="all">All Classes</option>
                                                        <!-- Options will be loaded dynamically -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="armFilter">Filter by Arm:</label>
                                                    <select class="form-control form-select" id="armFilter">
                                                        <option value="all">All Arms</option>
                                                        <!-- Options will be loaded dynamically -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button class="btn btn-primary" id="applyFilter">Apply Filter</button>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="card card-round bg-primary p-5 text-white text-center">
                                                    <h4>Students Owing</h4>
                                                    <div class="value" id="studentsOwingCount">
                                                        <h1>0</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card card-round bg-success p-5 text-white text-center">
                                                    <h4>Students Paid in Full</h4>
                                                    <div class="value" id="studentsPaidCount">
                                                        <h1>0</h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card card-round bg-danger p-5 text-white text-center">
                                                    <h4>Total Outstanding Balance</h4>
                                                    <div id="totalOutstandingBalance">
                                                        <h1>₦0.00</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="card card-round">
                                <div class="card-header d-flex">
                                    <div class="card-head-row me-auto">
                                        <div class="card-title">Students Owing </div>
                                    </div>
                                    <button class="btn btn-secondary btn-sm" onclick="printTable('studentsOwingTable')">Print Owing List</button>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="studentsOwingTable">
                                                <thead>
                                                    <tr>
                                                        <th>Student Name</th>
                                                        <th>Class</th>
                                                        <th>Arm</th>
                                                        <th>Amount Owing</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="studentsOwingTableBody">
                                                    <!-- Data will be loaded dynamically -->
                                                </tbody>
                                            </table>
                                        </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-round">
                                <div class="card-header d-flex">
                                    <div class="card-head-row me-auto">
                                        <div class="card-title">Student Paid in Full </div>
                                    </div>
                                    <button class="btn btn-secondary btn-sm" onclick="printTable('studentsPaidTable')">Print Paid List</button>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="mb-4 mt-2">
                                        <p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped" id="studentsPaidTable">
                                                <thead>
                                                    <tr>
                                                        <th>Student Name</th>
                                                        <th>Class</th>
                                                        <th>Arm</th>
                                                        <th>Amount Paid</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="studentsPaidTableBody">
                                                    <!-- Data will be loaded dynamically -->
                                                </tbody>
                                            </table>
                                        </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            <?php include('footer.php'); ?>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <?php include('cust-color.php'); ?>
        <!-- End Custom template -->
    </div>
    <?php include('scripts.php'); ?>
    <script>
        $(document).ready(function() {
            function loadDashboardData(classFilter = 'all', armFilter = 'all') {
                $.ajax({
                    url: 'bursary_dashboard_ajax.php', // This file will handle data fetching
                    method: 'GET',
                    data: {
                        class: classFilter,
                        arm: armFilter
                    },
                    dataType: 'json',
                    success: function(data) {
                        $('#studentsOwingCount').text(data.owing_count);
                        $('#studentsPaidCount').text(data.paid_count);
                        $('#totalOutstandingBalance').text('₦' + parseFloat(data.total_outstanding).toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }));

                        // Populate Students Owing Table
                        let owingTableHtml = '';
                        if (data.owing_students.length > 0) {
                            data.owing_students.forEach(student => {
                                owingTableHtml += `
                                    <tr>
                                        <td>${student.student_name}</td>
                                        <td>${student.class}</td>
                                        <td>${student.arm}</td>
                                        <td>₦${parseFloat(student.amount_owing).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            owingTableHtml = `<tr><td colspan="4" class="text-center">No students owing found.</td></tr>`;
                        }
                        $('#studentsOwingTableBody').html(owingTableHtml);

                        // Populate Students Paid in Full Table
                        let paidTableHtml = '';
                        if (data.paid_students.length > 0) {
                            data.paid_students.forEach(student => {
                                paidTableHtml += `
                                    <tr>
                                        <td>${student.student_name}</td>
                                        <td>${student.class}</td>
                                        <td>${student.arm}</td>
                                        <td>₦${parseFloat(student.amount_paid).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            paidTableHtml = `<tr><td colspan="4" class="text-center">No students paid in full found.</td></tr>`;
                        }
                        $('#studentsPaidTableBody').html(paidTableHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading dashboard data:", status, error);
                        alert("Failed to load dashboard data. Please try again.");
                    }
                });
            }

            // Load initial data
            loadDashboardData();

            // Handle filter application
            $('#applyFilter').on('click', function() {
                const selectedClass = $('#classFilter').val();
                const selectedArm = $('#armFilter').val();
                loadDashboardData(selectedClass, selectedArm);
            });

            // Function to load class and arm options
            function loadFilterOptions() {
                $.ajax({
                    url: 'bursary_dashboard_ajax.php', // Use the same AJAX file for options
                    method: 'GET',
                    data: {
                        action: 'get_filters'
                    },
                    dataType: 'json',
                    success: function(data) {
                        let classOptions = '<option value="all">All Classes</option>';
                        data.classes.forEach(cls => {
                            classOptions += `<option value="${cls}">${cls}</option>`;
                        });
                        $('#classFilter').html(classOptions);

                        let armOptions = '<option value="all">All Arms</option>';
                        data.arms.forEach(arm => {
                            armOptions += `<option value="${arm}">${arm}</option>`;
                        });
                        $('#armFilter').html(armOptions);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading filter options:", status, error);
                    }
                });
            }

            loadFilterOptions();
        });

        function printTable(tableId) {
            const printContents = document.getElementById(tableId).outerHTML;
            const originalContents = document.body.innerHTML;

            document.body.innerHTML = `
                <html>
                <head>
                    <title>Print</title>
                    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
                    <style>
                        body { margin: 20px; }
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
                        h3 { margin-bottom: 20px; }
                    </style>
                </head>
                <body>
                    <h3>${tableId === 'studentsOwingTable' ? 'Students Owing List' : 'Students Paid in Full List'}</h3>
                    ${printContents}
                </body>
                </html>
            `;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload(); // Reload to restore full page functionality and data
        }
    </script>
</body>

</html>