<?php
// Database credentials
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'sylo_database');

// Silence warnings and notices in production
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

// Attempt to connect to MySQL database
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    // Log the error
    error_log("Database connection failed: " . $conn->connect_error);
    // Throw an exception to be caught by the parent script
    throw new Exception('Database connection failed');
}

// Set charset to prevent encoding issues
$conn->set_charset("utf8");
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

?>
