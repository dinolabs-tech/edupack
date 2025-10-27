<?php
include('db_connection.php');

// Function to add a new fee definition
function addFeeDefinition($conn, $class, $arm, $term, $service, $price, $hostel, $session)
{
    $id = strtoupper(str_replace(' ', '-', $service)) . '-' . strtoupper(str_replace(' ', '-', $class)) . '-' . strtoupper(str_replace(' ', '-', $term)) . '-' . strtoupper(str_replace(' ', '-', $session));
    $stmt = $conn->prepare("INSERT INTO fee (id, class, arm, term, service, price, hostel, session) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssdss", $id, $class, $arm, $term, $service, $price, $hostel, $session);
    return $stmt->execute();
}

// Function to get all fee definitions
function getFeeDefinitions($conn)
{
    $result = $conn->query("SELECT * FROM fee ORDER BY session DESC, class ASC, term ASC, arm ASC, service ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get a specific fee definition by ID
function getFeeDefinitionById($conn, $fee_id)
{
    $stmt = $conn->prepare("SELECT * FROM fee WHERE id = ?");
    $stmt->bind_param("s", $fee_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Function to update a fee definition
function updateFeeDefinition($conn, $id, $class, $arm, $term, $service, $price, $hostel, $session)
{
    $stmt = $conn->prepare("UPDATE fee SET class = ?, arm = ?, term = ?, service = ?, price = ?, hostel = ?, session = ? WHERE id = ?");
    $stmt->bind_param("ssssdsss", $class, $arm, $term, $service, $price, $hostel, $session, $id);
    return $stmt->execute();
}

// Function to delete a fee definition
function deleteFeeDefinition($conn, $fee_id)
{
    $stmt = $conn->prepare("DELETE FROM fee WHERE id = ?");
    $stmt->bind_param("s", $fee_id);
    return $stmt->execute();
}

// Function to record a student payment
function recordStudentPayment($conn, $student_id, $fee_definition_id, $amount_paid, $payment_method, $transaction_ref, $recorded_by, $session, $term)
{
    $stmt = $conn->prepare("INSERT INTO fee_transactions (student_id, fee_definition_id, amount_paid, payment_method, transaction_ref, recorded_by, session, term) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsssss", $student_id, $fee_definition_id, $amount_paid, $payment_method, $transaction_ref, $recorded_by, $session, $term);
    $success = $stmt->execute();

    if ($success) {
        // Update bursary table
        updateBursaryBalance($conn, $student_id, $session, $term, $amount_paid);
    }
    return $success;
}

// Function to get student payment history
function getStudentPaymentHistory($conn, $student_id)
{
    $stmt = $conn->prepare("SELECT ft.*, f.service, f.class, f.arm FROM fee_transactions ft JOIN fee f ON ft.fee_definition_id = f.id WHERE ft.student_id = ? ORDER BY ft.payment_date DESC");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Function to get a single transaction by ID
function getSingleTransaction($conn, $transaction_id)
{
    $stmt = $conn->prepare("SELECT ft.*, f.service, f.class, f.arm, s.name as student_name, s.id as student_reg_id FROM fee_transactions ft JOIN fee f ON ft.fee_definition_id = f.id JOIN students s ON ft.student_id = s.id WHERE ft.transaction_id = ?");
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Function to get student payment history by date range
function getStudentPaymentHistoryByDateRange($conn, $student_id, $start_date, $end_date)
{
    $sql = "SELECT ft.*, f.service, f.class, f.arm, s.name as student_name
            FROM fee_transactions ft
            JOIN fee f ON ft.fee_definition_id = f.id
            JOIN students s ON ft.student_id = s.id
            WHERE ft.student_id = ? AND DATE(ft.payment_date) BETWEEN ? AND ?
            ORDER BY ft.payment_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $student_id, $start_date, $end_date);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Function to get student's current fee status from bursary table
function getStudentFeeStatus($conn, $student_id, $session, $term)
{
    $stmt = $conn->prepare("SELECT * FROM bursary WHERE id = ? AND session = ? AND term = ?");
    $stmt->bind_param("sss", $student_id, $session, $term);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Function to get all outstanding balances for a student, excluding the current term/session
function getPreviousOutstandingBalances($conn, $student_id, $current_session, $current_term)
{
    $sql = "SELECT session, term, outstanding
            FROM bursary
            WHERE id = ? AND outstanding > 0
            AND NOT (session = ? AND term = ?)
            ORDER BY session ASC, term ASC"; // Order by session and term to show chronologically
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $student_id, $current_session, $current_term);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Function to initialize or update a student's bursary record
function updateBursaryBalance($conn, $student_id, $session, $term, $amount_paid = 0)
{
    // Get student details
    $student_stmt = $conn->prepare("SELECT name, gender, class, arm, hostel FROM students WHERE id = ?");
    $student_stmt->bind_param("s", $student_id);
    $student_stmt->execute();
    $student_result = $student_stmt->get_result();
    $student_data = $student_result->fetch_assoc();

    if (!$student_data) {
        error_log("Student with ID $student_id not found.");
        return false;
    }

    $name = $student_data['name'];
    $gender = $student_data['gender'];
    $class = $student_data['class'];
    $arm = $student_data['arm'];
    $hostel = $student_data['hostel'];

    // Calculate total fee for the student for the given session and term
    $total_fee_stmt = $conn->prepare("SELECT SUM(price) as total_fee FROM fee WHERE class = ? AND arm = ? AND term = ? AND session = ? AND (hostel = ? OR hostel = 'N/A')");
    $total_fee_stmt->bind_param("sssss", $class, $arm, $term, $session, $hostel);
    $total_fee_stmt->execute();
    $total_fee_result = $total_fee_stmt->get_result();
    $total_fee_data = $total_fee_result->fetch_assoc();
    $total_fee_current_period = $total_fee_data['total_fee'] ? $total_fee_data['total_fee'] : 0;

    // Get current paid amount from fee_transactions for the current period
    $current_paid_stmt = $conn->prepare("SELECT SUM(amount_paid) as current_paid FROM fee_transactions WHERE student_id = ? AND session = ? AND term = ?");
    $current_paid_stmt->bind_param("sss", $student_id, $session, $term);
    $current_paid_stmt->execute();
    $current_paid_result = $current_paid_stmt->get_result();
    $current_paid_data = $current_paid_result->fetch_assoc();
    $current_paid_current_period = $current_paid_data['current_paid'] ? $current_paid_data['current_paid'] : 0;

    $outstanding_current_period = $total_fee_current_period - $current_paid_current_period;

    // Sum up outstanding balances from previous periods
    $previous_outstanding_sum = 0;
    $previous_outstanding_records = getPreviousOutstandingBalances($conn, $student_id, $session, $term);
    foreach ($previous_outstanding_records as $record) {
        $previous_outstanding_sum += $record['outstanding'];
    }

    // Total outstanding is current period's outstanding plus previous periods' outstanding
    $total_outstanding = $outstanding_current_period + $previous_outstanding_sum;

    // Check if a record exists for the student, session, and term
    $existing_bursary = getStudentFeeStatus($conn, $student_id, $session, $term);

    if ($existing_bursary) {
        // Update existing record
        $stmt = $conn->prepare("UPDATE bursary SET name = ?, gender = ?, class = ?, arm = ?, hostel = ?, fee = ?, paid = ?, outstanding = ? WHERE id = ? AND session = ? AND term = ?");
        $stmt->bind_param("sssssddssss", $name, $gender, $class, $arm, $hostel, $total_fee_current_period, $current_paid_current_period, $total_outstanding, $student_id, $session, $term);
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO bursary (id, name, gender, class, arm, session, term, hostel, fee, paid, outstanding) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssddds", $student_id, $name, $gender, $class, $arm, $session, $term, $hostel, $total_fee_current_period, $current_paid_current_period, $total_outstanding);
    }
    return $stmt->execute();
}

// Function to get all students with their current fee status
function getAllStudentsFeeStatus($conn, $session, $term)
{
    $sql = "SELECT s.id, s.name, s.class, s.arm, s.hostel,
                   COALESCE(b.fee, 0) as total_fee,
                   COALESCE(b.paid, 0) as total_paid,
                   COALESCE(b.outstanding, 0) as outstanding_balance
            FROM students s
            LEFT JOIN bursary b ON s.id = b.id AND b.session = ? AND b.term = ?
            ORDER BY s.class, s.arm, s.name";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $session, $term);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Function to get all classes
function getClasses($conn)
{
    $result = $conn->query("SELECT class FROM class ORDER BY class ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get all arms
function getArms($conn)
{
    $result = $conn->query("SELECT arm FROM arm ORDER BY arm ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get all terms
function getTerms($conn)
{
    $result = $conn->query("SELECT cterm FROM currentterm ORDER BY cterm ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get all sessions
function getSessions($conn)
{
    $result = $conn->query("SELECT csession FROM currentsession ORDER BY csession DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get all hostels
function getHostels($conn)
{
    // Assuming 'hostel' values are stored in the 'students' table or a dedicated 'hostel' table
    // For now, we'll get distinct values from 'students'
    $result = $conn->query("SELECT DISTINCT hostel FROM students WHERE hostel IS NOT NULL AND hostel != '' ORDER BY hostel ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Function to get all students
function getStudents($conn)
{
    $result = $conn->query("SELECT id, name, class, arm FROM students ORDER BY class, arm, name");
    return $result->fetch_all(MYSQLI_ASSOC);
}
