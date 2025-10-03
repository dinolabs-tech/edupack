<?php
// Database connection
include 'db_connection.php';

// Create the database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
if (!$conn->query($sql)) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection again
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper function for executing SQL and showing errors
function executeSQL($conn, $sql, $tableName) {
    if ($conn->query($sql) !== TRUE) {
        echo "Error creating table $tableName: " . $conn->error . "\n";
    }
}

// Create tables
$tables = [
    "users" => "
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );",

    "students" => "
        CREATE TABLE IF NOT EXISTS students (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(255) NOT NULL,
            last_name VARCHAR(255) NOT NULL,
            class VARCHAR(255) NOT NULL,
            arm VARCHAR(255) NOT NULL,
            registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );",

    "classes" => "
        CREATE TABLE IF NOT EXISTS classes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        );",

    "arms" => "
        CREATE TABLE IF NOT EXISTS arms (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        );",

    "terms" => "
        CREATE TABLE IF NOT EXISTS terms (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        );",

    "sessions" => "
        CREATE TABLE IF NOT EXISTS sessions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL
        );",

        "attendance" => "
        CREATE TABLE IF NOT EXISTS attendance (
            id INT AUTO_INCREMENT PRIMARY KEY,
            student_id VARCHAR(255) NOT NULL,
            name VARCHAR(255) NOT NULL,
            class VARCHAR(255) NOT NULL,
            arm VARCHAR(255) NOT NULL,
            date DATE NOT NULL,
            term_id VARCHAR(255) NOT NULL,
            session_id VARCHAR(255) NOT NULL,
            status INT NOT NULL COMMENT '1=Present, 0=Absent',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY unique_attendance (student_id, name, class, arm, date, term_id, session_id)
        );",

    "settings" => "
        CREATE TABLE IF NOT EXISTS settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            current_term_id VARCHAR(255) DEFAULT NULL,
            current_session_id VARCHAR(255) DEFAULT NULL
        );"
];

// Execute all table creation queries
foreach ($tables as $name => $sql) {
    executeSQL($conn, $sql, $name);
}

// Optional: Insert default values (uncomment to use)
/*
$defaultInserts = [
    "classes" => "INSERT IGNORE INTO classes (name) VALUES 
        ('JSS 1'), ('JSS 2'), ('JSS 3'), 
        ('SSS 1'), ('SSS 2'), ('SSS 3');",

    "arms" => "INSERT IGNORE INTO arms (name) VALUES 
        ('A'), ('B'), ('C'), ('D'), ('E');",

    "terms" => "INSERT IGNORE INTO terms (name) VALUES 
        ('1st Term'), ('2nd Term'), ('3rd Term');",

    "sessions" => "INSERT IGNORE INTO sessions (name) VALUES 
        ('2024/2025');",

    "settings" => "INSERT IGNORE INTO settings (id) VALUES (1);"
];

foreach ($defaultInserts as $table => $sql) {
    if (!$conn->query($sql)) {
        echo "Error inserting defaults into $table: " . $conn->error . "\n";
    }
}
*/

$conn->close();
?>
