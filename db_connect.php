<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Read database credentials from Render Environment Variables
$host = getenv("DB_HOST");
$port = getenv("DB_PORT");
$user = getenv("DB_USER");
$password = getenv("DB_PASS");
$database = getenv("DB_NAME");

// Initialize MySQL connection
$conn = mysqli_init();

// Enable SSL (required by Aiven)
mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

// Connect to MySQL
if (!mysqli_real_connect(
    $conn,
    $host,
    $user,
    $password,
    $database,
    (int)$port,
    NULL,
    MYSQLI_CLIENT_SSL
)) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

// Create user table
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)
");

// Create history table
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS ao_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    resume_text LONGTEXT NOT NULL,
    ai_response LONGTEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE SET NULL
)
");

?>