<?php
require_once 'db_connection.php'; // This file now directly establishes $conn and handles errors

header('Content-Type: application/json');

// $conn should be available after db_connection.php is included
if (!isset($conn) || $conn->connect_error) {
    // If db_connection.php died, this code won't be reached.
    // This handles cases where $conn might not be set or has a connection error
    // without dying (e.g., if customErrorHandler doesn't exit).
    echo json_encode(['error' => 'Database connection failed.']);
    exit();
}

$classFilter = isset($_GET['class']) ? $_GET['class'] : 'all';
$armFilter = isset($_GET['arm']) ? $_GET['arm'] : 'all';
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'get_filters') {
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

    echo json_encode(['classes' => $classes, 'arms' => $arms]);
    // CloseCon($conn); // Removed as CloseCon is no longer defined in db_connection.php
    exit();
}

// --- Data for Dashboard ---
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
    JOIN
        bursary b ON s.id = b.id
    " . $where_clause . "
    AND b.outstanding > 0
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
    JOIN
        bursary b ON s.id = b.id
    " . $where_clause . "
    AND b.outstanding <= 0
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

echo json_encode($response);

// No need to call CloseCon($conn) explicitly here as it's no longer defined in db_connection.php.
// The connection will be implicitly closed when the script finishes.
?>
