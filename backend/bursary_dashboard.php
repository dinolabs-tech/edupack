<?php
include('components/admin_logic.php');
include('components/fees_management.php');

// --- Fetch Filter Options ---
$classes = [];
$arms = [];

// Fetch unique classes
$sql_classes = "SELECT DISTINCT class FROM students ORDER BY class";
$result_classes = $conn->query($sql_classes);
if ($result_classes && $result_classes->num_rows > 0) {
    while ($row = $result_classes->fetch_assoc()) {
        $classes[] = $row['class'];
    }
}

// Fetch unique arms
$sql_arms = "SELECT DISTINCT arm FROM students ORDER BY arm";
$result_arms = $conn->query($sql_arms);
if ($result_arms && $result_arms->num_rows > 0) {
    while ($row = $result_arms->fetch_assoc()) {
        $arms[] = $row['arm'];
    }
}

// --- Data for Dashboard ---
$classFilter = isset($_GET['class']) ? $_GET['class'] : 'all';
$armFilter = isset($_GET['arm']) ? $_GET['arm'] : 'all';

$response = [
    'owing_count' => 0,
    'paid_count' => 0,
    'total_outstanding' => 0.00,
    'owing_students' => [],
    'paid_students' => []
];

// Build WHERE clause for filtering
$where_clause = "WHERE 1=1";
if ($classFilter !== 'all') {
    $where_clause .= " AND s.class = '" . $conn->real_escape_string($classFilter) . "'";
}
if ($armFilter !== 'all') {
    $where_clause .= " AND s.arm = '" . $conn->real_escape_string($armFilter) . "'";
}

// Query for Students Owing
$sql_owing = "
    SELECT
        s.id AS student_id,
        s.name AS student_name,
        s.class,
        s.arm,
        b.outstanding AS amount_owing
    FROM
        students s
    LEFT JOIN
        bursary b ON s.id = b.id
    " . $where_clause . "
    AND (b.outstanding > 0 OR b.id IS NULL)
    ORDER BY
        b.outstanding DESC;
";

$result_owing = $conn->query($sql_owing);
if ($result_owing) {
    $response['owing_count'] = $result_owing->num_rows;
    while ($row = $result_owing->fetch_assoc()) {
        $response['owing_students'][] = $row;
        $response['total_outstanding'] += $row['amount_owing'];
    }
} else {
    error_log("Error fetching owing students: " . $conn->error);
}

// Query for Students Paid in Full
$sql_paid = "
    SELECT
        s.id AS student_id,
        s.name AS student_name,
        s.class,
        s.arm,
        b.fee AS amount_paid
    FROM
        students s
    LEFT JOIN
        bursary b ON s.id = b.id
    " . $where_clause . "
    AND b.outstanding <= 0 AND b.id IS NOT NULL
    ORDER BY
        s.name ASC;
";

$result_paid = $conn->query($sql_paid);
if ($result_paid) {
    $response['paid_count'] = $result_paid->num_rows;
    while ($row = $result_paid->fetch_assoc()) {
        $response['paid_students'][] = $row;
    }
} else {
    error_log("Error fetching paid students: " . $conn->error);
}

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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Dashboard Filters</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form method="GET" action="">
                                        <div class="row mb-4">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="classFilter">Filter by Class:</label>
                                                    <select class="form-control form-select" id="classFilter" name="class">
                                                        <option value="all">All Classes</option>
                                                        <?php foreach ($classes as $class) : ?>
                                                            <option value="<?php echo htmlspecialchars($class); ?>" <?php echo ($classFilter === $class) ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($class); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="armFilter">Filter by Arm:</label>
                                                    <select class="form-control form-select" id="armFilter" name="arm">
                                                        <option value="all">All Arms</option>
                                                        <?php foreach ($arms as $arm) : ?>
                                                            <option value="<?php echo htmlspecialchars($arm); ?>" <?php echo ($armFilter === $arm) ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($arm); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="submit" class="btn btn-primary">Apply Filter</button>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card card-round bg-primary p-5 text-white text-center">
                                                <h4>Students Owing</h4>
                                                <div class="value">
                                                    <h1><?php echo $response['owing_count']; ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card card-round bg-success p-5 text-white text-center">
                                                <h4>Students Paid in Full</h4>
                                                <div class="value">
                                                    <h1><?php echo $response['paid_count']; ?></h1>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card card-round bg-danger p-5 text-white text-center">
                                                <h4>Total Outstanding Balance</h4>
                                                <div>
                                                    <h1>₦<?php echo number_format($response['total_outstanding'], 2); ?></h1>
                                                </div>
                                            </div>
                                        </div>
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
                                        <div class="card-title">Students Owing</div>
                                    </div>
                                    <button class="btn btn-secondary btn-sm" onclick="printTable('studentsOwingTable')">Print Owing List</button>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped basic-datatables" id="studentsOwingTable">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Class</th>
                                                    <th>Arm</th>
                                                    <th>Amount Owing</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($response['owing_students'])) : ?>
                                                    <?php foreach ($response['owing_students'] as $student) : ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                                                            <td><?php echo htmlspecialchars($student['class']); ?></td>
                                                            <td><?php echo htmlspecialchars($student['arm']); ?></td>
                                                            <td>₦<?php echo number_format((float)$student['amount_owing'], 2); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">No students owing found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-round">
                                <div class="card-header d-flex">
                                    <div class="card-head-row me-auto">
                                        <div class="card-title">Student Paid in Full</div>
                                    </div>
                                    <button class="btn btn-secondary btn-sm" onclick="printTable('studentsPaidTable')">Print Paid List</button>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped basic-datatables" id=" studentsPaidTable">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Class</th>
                                                    <th>Arm</th>
                                                    <th>Amount Paid</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($response['paid_students'])) : ?>
                                                    <?php foreach ($response['paid_students'] as $student) : ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($student['student_name']); ?></td>
                                                            <td><?php echo htmlspecialchars($student['class']); ?></td>
                                                            <td><?php echo htmlspecialchars($student['arm']); ?></td>
                                                            <td>₦<?php echo number_format((float)$student['amount_paid'], 2); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">No students paid in full found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
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
