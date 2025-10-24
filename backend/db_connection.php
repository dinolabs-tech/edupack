<?php
// onlice connection
$servername = "localhost";
$username = "dinolabs_root";
$password = "foxtrot2november";
$dbname = "dinolabs_edupack";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// offline connection
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "edupack";
// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

?>
