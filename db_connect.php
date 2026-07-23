<?php

mysqli_report(MYSQLI_REPORT_OFF);

$host = "localhost";
$user = "root";
$password = "";
$database = "resumeiq";

$conn = @mysqli_connect($host, $user, $password);

if (!$conn) {
    die("Database Connection Failed. Please start MySQL from XAMPP Control Panel.");
}


mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $database");
mysqli_select_db($conn, $database);

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)");



$oldTableExists = mysqli_query($conn, "SHOW TABLES LIKE 'ai_history'");
if ($oldTableExists && mysqli_num_rows($oldTableExists) > 0) {
   


    $columnCheck = mysqli_query($conn, "SHOW COLUMNS FROM ai_history LIKE 'user_id'");
    if ($columnCheck && mysqli_num_rows($columnCheck) == 0) {
        mysqli_query($conn, "ALTER TABLE ai_history ADD user_id INT NULL AFTER id");
    }

$query = "INSERT IGNORE INTO ao_history (id, user_id, resume_text, ai_response, created_at)
        SELECT id, user_id, resume_text, ai_response, created_at
        FROM ai_history" ;

    mysqli_query($conn, $query);

   

    mysqli_query($conn, "DROP TABLE IF EXISTS ai_history");
}


mysqli_query($conn, "CREATE TABLE IF NOT EXISTS ao_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    resume_text LONGTEXT NOT NULL,
    ai_response LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

?>
