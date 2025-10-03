<?php
/**
 * checkresult.php
 *
 * This file generates a result slip for a student based on their CBT (Computer Based Test) scores.
 * It retrieves student details, their scores from the 'mst_result' table, and calculates
 * the overall percentage. The result slip includes student information, subject-wise scores,
 * attendance information, class teacher and principal comments, a grading table, and a skills assessment.
 * The report is generated in PDF format using the FPDF library.
 *
 * Key functionalities include:
 * - Session management for user authentication.
 * - Database connection.
 * - Retrieval of student details, CBT scores, attendance, and comments.
 * - Dynamic generation of a PDF result slip with student information, subject scores,
 *   overall average, attendance details, and comments.
 * - Custom PDF class for consistent header, footer, and text rotation.
 */

// Start or resume a session. This is crucial for checking user login status.
session_start();
// Start output buffering to prevent headers already sent errors.
ob_start();

// Check if the user is logged in. If not, redirect them to the login page
// to ensure only authenticated users can access this result generation.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if session and term are set in the GET request.
if (isset($_GET['session'], $_GET['term'])) {
    $csession = $_GET['session']; // Academic session (e.g., 2024/2025).
    $term     = $_GET['term'];   // Academic term (e.g., 1st Term).
} else {
    // If session or term are not set, redirect to the login page.
    header('Location: login.php');
    exit();
}

// Includes the FPDF library for PDF generation and the database connection file.
require('includes/fpdf.php');
include 'db_connection.php';

/**
 * Converts an integer into its ordinal representation (e.g., 1st, 2nd, 3rd, 4th).
 *
 * @param int $n The integer to convert.
 * @return string The ordinal string.
 */
function ordinal(int $n): string
{
    $suffixes = ['th','st','nd','rd','th','th','th','th','th','th'];
    $v = $n % 100;
    if ($v >= 11 && $v <= 13) {
        return "{$n}th";
    }
    return $n . $suffixes[$n % 10];
}

// Get the user ID from the session to identify the student.
$user_id = $_SESSION['user_id'];

/**
 * Custom PDF class extending FPDF to include custom header, footer, and text rotation.
 */
class PDF extends FPDF {
    public $studentImage; // Public property to hold the path to the student's image.
    protected $angle = 0; // Initialize the angle property for text rotation.

    /**
     * Overrides the default FPDF Header method to create a custom header for the report.
     * Includes school logo, student image, school name, address, and contact information.
     */
    function Header() {
        // Set font for the header.
        $this->SetFont('Arial','B',10);
        $this->Image('assets/img/logo.png',10,8,20); // School logo
        // Student photo in the top-right corner
        if (!empty($this->studentImage) && file_exists($this->studentImage)) {
            $x = $this->GetPageWidth() - 30;
            $this->Image($this->studentImage, $x, 8, 20);
        }
        $this->Ln(5); // Line break
        // School Name and Address
        $this->SetFont('Arial','B',18);
        $this->Cell(0,5,'DINOLABS ACADEMY',0,1,'C');
        $this->SetFont('Arial','B',11);
        $this->Cell(0,5,'5th floor, Wing-B TISCO Building, Alagbaka,',0,1,'C');
        $this->Cell(0,5,'Akure, Ondo State, Nigeria.',0,1,'C');
        $this->Cell(0,5,'enquiries@dinolabstech.com',0,1,'C');
        $this->Cell(0,5,'+234-813-772-6887, +234-704-324-7461',0,1,'C');
        $this->Ln(5); // Line break
        // Draw a horizontal line across the page
        $this->Line(10, $this->GetY(), $this->GetPageWidth() - 10, $this->GetY());
        $this->Ln(5);
    }

    /**
     * Overrides the default FPDF Footer method to create a custom footer for the report.
     * Displays the current date and time at the bottom of each page.
     */
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(100,10,date('d/m/Y'),0,0,'L');
        $this->Cell(0,10,date('H:i:s'),0,0,'R');
    }

 function Rotate($angle, $x = -1, $y = -1) {
    if ($x == -1) $x = $this->x;
    if ($y == -1) $y = $this->y;
    if ($this->angle != 0) $this->_out('Q');
    $this->angle = $angle;
    if ($angle != 0) {
        $angle *= M_PI / 180;
        $c = cos($angle);
        $s = sin($angle);
        $cx = $x * $this->k;
        $cy = ($this->h - $y) * $this->k;
        $this->_out(sprintf('q %.5f %.5f %.5f %.5f %.2f %.2f cm 1 0 0 1 %.2f %.2f cm',
            $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
    }
}

    function RotatedText($x, $y, $txt, $angle) {
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }
}

// Create PDF and add header
$pdf = new PDF();

// Correct student image path
$photo_fn = str_replace('/', '_', $student['id']) . '.jpg';
$photo_path = 'studentimg/' . $photo_fn;
$pdf->studentImage = file_exists($photo_path) ? $photo_path : 'studentimg/default.jpg';

$pdf->AddPage();

// Fetch student and term/session context
$student = $conn->query("SELECT * FROM students WHERE id='$user_id'")->fetch_assoc();
$class_comments = $conn->query(
    "SELECT comment, attentiveness, neatness, politeness, selfcontrol, punctuality, relationship, handwriting, music, club, sport
     FROM classcomments
     WHERE id='$user_id' AND term='$term' AND csession='$csession'"
)->fetch_assoc() ?: [];
$principal_comment = $conn->query(
    "SELECT comment FROM principalcomments WHERE id='$user_id' AND term='$term' AND csession='$csession'"
)->fetch_assoc()['comment'] ?? 'No comment available';
$next_term = $conn->query("SELECT Next FROM nextterm WHERE id=1")->fetch_assoc()['Next'];
// $promotec = $conn->query("SELECT comment FROM promote WHERE id='$user_id' AND term='$term' AND csession='$csession'")->fetch_assoc()['comment'] ?? 'N/A';

// Attendance stats
$days_opened = (int)$conn->query(
    "SELECT COUNT(DISTINCT date) AS days_opened
     FROM attendance
     WHERE class='{$student['class']}' AND arm='{$student['arm']}'
       AND term_id='$term' AND session_id='$csession'"
)->fetch_assoc()['days_opened'];
$att = $conn->query(
    "SELECT SUM(status) AS days_present, COUNT(DISTINCT date) - SUM(status) AS days_absent
     FROM attendance
     WHERE student_id='$user_id' AND term_id='$term' AND session_id='$csession'"
)->fetch_assoc();
$days_present = (int)($att['days_present'] ?? 0);
$days_absent  = (int)($att['days_absent'] ?? 0);

// Student info
$pdf->SetFont('Arial','',10);
$pdf->Cell(95,7,"Name: {$student['name']}", 'B',0);
$pdf->Cell(95,7,"SchlOpen: $days_opened", 'B',1);
$pdf->Cell(95,7,"Class: {$student['class']} {$student['arm']}", 'B',0);
$pdf->Cell(95,7,"Days Absent: $days_absent", 'B',1);
$pdf->Cell(95,7,"Term: $term", 'B',0);
$pdf->Cell(95,7,"Days Present: $days_present", 'B',1);
$pdf->Cell(95,7,"Session: $csession", 'B',0);
$pdf->Cell(95,7,"Next Term: $next_term", 'B',1);
$pdf->Ln(5);

// Results table header
$pdf->SetFillColor(90, 174, 255);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetTextColor(0, 0, 0); // Ensure text is black
$pdf->Cell(80, 25, 'SUBJECT', 1, 0, 'C', true);
$x0 = $pdf->GetX();
$y0 = $pdf->GetY();
$rot_headers = ['CA1', 'CA2', 'EXAM', 'LAST CUM', 'TOTAL', 'AVERAGE', 'GRADE', 'CLASS AVG.', 'POSITION'];
foreach ($rot_headers as $i => $h) {
    $pdf->Cell(8, 25, '', 1, 0, 'C', true);
    $pdf->RotatedText($x0 + $i * 8 + 4, $y0 + 22, $h, 90); // Centered position
}
$pdf->Cell(40, 25, 'REMARK', 1, 1, 'C', true);

// Fetch & print results
$pdf->SetFont('Arial','',8);
$results = $conn->query(
    "SELECT * FROM mastersheet
     WHERE id='$user_id' AND term='$term' AND csession='$csession'"
);
$avg_query = $conn->query(
    "SELECT subject, AVG(total) AS avg_score FROM mastersheet
     WHERE class='{$student['class']}' AND term='$term' AND csession='$csession'
     GROUP BY subject"
);
$avg_map = [];
while ($r = $avg_query->fetch_assoc()) {
    $avg_map[$r['subject']] = ceil($r['avg_score']);
}
$total_score = 0; $num_sub = 0;
while ($row = $results->fetch_assoc()) {
    $pdf->Cell(80,5,htmlspecialchars($row['subject']),1,0);
    foreach (['ca1','ca2','exam','lastcum','total','average','grade'] as $col) {
        $pdf->Cell(8,5,htmlspecialchars($row[$col]),1,0,'C');
    }
    $class_avg = $avg_map[$row['subject']] ?? '-';
    $pdf->Cell(8,5,htmlspecialchars($class_avg),1,0,'C');
    $pdf->Cell(8,5,ordinal((int)$row['position']),1,0,'C');
    $pdf->Cell(40,5,htmlspecialchars($row['remark']),1,1,'C');
    $total_score += $row['average'];
    $num_sub++;
}

// Overall average
$overall = $num_sub > 0 ? number_format($total_score / $num_sub, 2) : '0.00';
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,7,"Overall Average: ".htmlspecialchars($overall),1,1,'C');

// Comments
$pdf->Ln(2);
$pdf->SetFont('Arial','I',10);
$pdf->Cell(0,5,htmlspecialchars($class_comments['comment'] ?? 'No comment available'),'B',1,'C');
$pdf->Cell(0,5,"Class Teacher's Comment",0,1,'C');
$pdf->Ln(2);
$pdf->Cell(0,5,htmlspecialchars($principal_comment),'B',1,'C');
$pdf->Cell(0,5,"Principal's Comment",0,1,'C');

// Signature
$pdf->Ln(3);
$pdf->SetX(-40);
$pdf->Image('assets/img/signature.jpg',$pdf->GetX(),$pdf->GetY(),30);
$pdf->Ln(1);
$pdf->SetX(-30);
$pdf->Cell(10,-5,"Principal's Signature",0,1,'C');

// Side-by-side tables
$pdf->Ln(7);
$pdf->SetFont('Arial','B',10);
$startX = $pdf->GetX();
$startY = $pdf->GetY();
$pdf->SetXY($startX,$startY);
$pdf->Cell(60,7,'Grading Table',1,0,'C',true);
$secondX = $startX + 65;
$pdf->SetXY($secondX,$startY);
$pdf->Cell(90,7,'Skills Assessment',1,1,'C',true);

$pdf->SetFont('Arial','',10);
$currentY = $startY + 7;
$grading = [
    ['A','75 - 100','Excellent'],
    ['B','65 - 74','Very Good'],
    ['C','50 - 64','Good'],
    ['D','45 - 49','Fair'],
    ['E','40 - 44','Poor'],
    ['F','0 - 39','Very Poor']
];
$skills = [
    ['Attentiveness',htmlspecialchars($class_comments['attentiveness'] ?? 'N/A'),'Relationship',htmlspecialchars($class_comments['relationship'] ?? 'N/A')],
    ['Neatness',htmlspecialchars($class_comments['neatness'] ?? 'N/A'),'Handwriting',htmlspecialchars($class_comments['handwriting'] ?? 'N/A')],
    ['Politeness',htmlspecialchars($class_comments['politeness'] ?? 'N/A'),'Music',htmlspecialchars($class_comments['music'] ?? 'N/A')],
    ['Self-Control',htmlspecialchars($class_comments['selfcontrol'] ?? 'N/A'),'Club/Society',htmlspecialchars($class_comments['club'] ?? 'N/A')],
    ['Punctuality',htmlspecialchars($class_comments['punctuality'] ?? 'N/A'),'Sport',htmlspecialchars($class_comments['sport'] ?? 'N/A')]
];
$rows = max(count($grading), count($skills));
for ($i = 0; $i < $rows; $i++) {
    $pdf->SetXY($startX, $currentY);
    if (isset($grading[$i])) {
        $pdf->Cell(10,6,htmlspecialchars($grading[$i][0]),1,0,'C');
        $pdf->Cell(20,6,htmlspecialchars($grading[$i][1]),1,0,'C');
        $pdf->Cell(30,6,htmlspecialchars($grading[$i][2]),1,0,'C');
    } else {
        $pdf->Cell(10,6,'',1,0);
        $pdf->Cell(20,6,'',1,0);
        $pdf->Cell(30,6,'',1,0);
    }
    if (isset($skills[$i])) {
        $pdf->SetXY($secondX, $currentY);
        $pdf->Cell(30,6,htmlspecialchars($skills[$i][0]),1,0,'C');
        $pdf->Cell(15,6,htmlspecialchars($skills[$i][1]),1,0,'C');
        $pdf->Cell(30,6,htmlspecialchars($skills[$i][2]),1,0,'C');
        $pdf->Cell(15,6,htmlspecialchars($skills[$i][3]),1,1,'C');
    }
    $currentY += 6;
}

// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(95,7,"Promotional Status: {$promotec}", 'B',0, 'C');

$pdf->Output();
ob_end_flush();
?>
