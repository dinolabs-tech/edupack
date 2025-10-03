<?php
// $servername = "localhost";
// $username = "dinolabs_root";
// $password = "foxtrot2november";
// $dbname = "dinolabs_portal";
// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }



$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portalv2";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
