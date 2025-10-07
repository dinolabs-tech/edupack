<?php
session_start();

// Start output buffering to prevent headers already sent
ob_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if session and term are set
if (isset($_GET['session'], $_GET['term'])) {
    $csession = $_GET['session'];
    $term     = $_GET['term'];
} else {
    header('Location: login.php');
    exit();
}

// Include FPDF library and database connection
require('includes/fpdf.php');
include 'db_connection.php';

function ordinal(int $n): string
{
    $suffixes = ['th','st','nd','rd','th','th','th','th','th','th'];
    $v = $n % 100;
    if ($v >= 11 && $v <= 13) {
        return "{$n}th";
    }
    return $n . $suffixes[$n % 10];
}

$user_id = $_SESSION['user_id'];

class PDF extends FPDF {
    public $studentImage;
    protected $angle = 0;

    function Header() {
        $this->SetFont('Arial','B',10);
        $this->Image('assets/img/logo.png',10,8,20);
        if (!empty($this->studentImage) && file_exists($this->studentImage)) {
            $x = $this->GetPageWidth() - 30;
            $this->Image($this->studentImage, $x, 8, 20);
        }
        $this->Ln(5);
        $this->SetFont('Arial','B',18);
        $this->Cell(0,5,'DINOLABS ACADEMY',0,1,'C');
        $this->SetFont('Arial','B',11);
        $this->Cell(0,5,'5th floor, Wing-B TISCO Building, Alagbaka,',0,1,'C');
        $this->Cell(0,5,'Akure, Ondo State, Nigeria.',0,1,'C');
        $this->Cell(0,5,'enquiries@dinolabstech.com',0,1,'C');
        $this->Cell(0,5,'+234-813-772-6887, +234-704-324-7461',0,1,'C');
        $this->Ln(5);
        $this->Line(10, $this->GetY(), $this->GetPageWidth() - 10, $this->GetY());
        $this->Ln(5);
    }

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

// Create PDF and add header
$pdf = new PDF();

// Correct student image path
$photo_fn = str_replace('/', '_', $student['id']) . '.jpg';
$photo_path = 'studentimg/' . $photo_fn;
$pdf->studentImage = file_exists($photo_path) ? $photo_path : 'studentimg/default.jpg';

$pdf->AddPage();

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
    $pdf->Cell(80,5,$row['subject'],1,0);
    foreach (['ca1','ca2','exam','lastcum','total','average','grade'] as $col) {
        $pdf->Cell(8,5,$row[$col],1,0,'C');
    }
    $class_avg = $avg_map[$row['subject']] ?? '-';
    $pdf->Cell(8,5,$class_avg,1,0,'C');
    $pdf->Cell(8,5,ordinal((int)$row['position']),1,0,'C');
    $pdf->Cell(40,5,$row['remark'],1,1,'C');
    $total_score += $row['average'];
    $num_sub++;
}

// Overall average
$overall = $num_sub > 0 ? number_format($total_score / $num_sub, 2) : '0.00';
$pdf->Ln(5);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190,7,"Overall Average: $overall",1,1,'C');

// Comments
$pdf->Ln(2);
$pdf->SetFont('Arial','I',10);
$pdf->Cell(0,5,$class_comments['comment'] ?? 'No comment available','B',1,'C');
$pdf->Cell(0,5,"Class Teacher's Comment",0,1,'C');
$pdf->Ln(2);
$pdf->Cell(0,5,$principal_comment,'B',1,'C');
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
    ['Attentiveness',$class_comments['attentiveness'] ?? 'N/A','Relationship',$class_comments['relationship'] ?? 'N/A'],
    ['Neatness',$class_comments['neatness'] ?? 'N/A','Handwriting',$class_comments['handwriting'] ?? 'N/A'],
    ['Politeness',$class_comments['politeness'] ?? 'N/A','Music',$class_comments['music'] ?? 'N/A'],
    ['Self-Control',$class_comments['selfcontrol'] ?? 'N/A','Club/Society',$class_comments['club'] ?? 'N/A'],
    ['Punctuality',$class_comments['punctuality'] ?? 'N/A','Sport',$class_comments['sport'] ?? 'N/A']
];
$rows = max(count($grading), count($skills));
for ($i = 0; $i < $rows; $i++) {
    $pdf->SetXY($startX, $currentY);
    if (isset($grading[$i])) {
        $pdf->Cell(10,6,$grading[$i][0],1,0,'C');
        $pdf->Cell(20,6,$grading[$i][1],1,0,'C');
        $pdf->Cell(30,6,$grading[$i][2],1,0,'C');
    } else {
        $pdf->Cell(10,6,'',1,0);
        $pdf->Cell(20,6,'',1,0);
        $pdf->Cell(30,6,'',1,0);
    }
    if (isset($skills[$i])) {
        $pdf->SetXY($secondX, $currentY);
        $pdf->Cell(30,6,$skills[$i][0],1,0,'C');
        $pdf->Cell(15,6,$skills[$i][1],1,0,'C');
        $pdf->Cell(30,6,$skills[$i][2],1,0,'C');
        $pdf->Cell(15,6,$skills[$i][3],1,1,'C');
    }
    $currentY += 6;
}

// $pdf->SetFont('Arial','B',10);
// $pdf->Cell(95,7,"Promotional Status: {$promotec}", 'B',0, 'C');

$pdf->Output();
ob_end_flush();
?>