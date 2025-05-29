<?php
ob_start(); // Start output buffering
header('Content-Type: application/json'); // Set header once at the beginning
ini_set('display_errors', 0); // Keep display_errors off in production
ini_set('display_startup_errors', 0);
error_reporting(0); // Report no errors to the client

try {
    require_once 'config.php'; // Assuming 'db_config.php' refers to your 'config.php' file

    // Change from $username to $name, and ensure your HTML form sends 'name'
    $name = $_POST['name']; 
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update the INSERT query to use the 'name' column
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)"); 
    $stmt->bind_param("sss", $name, $email, $password); // Bind $name here
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Signup successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Signup failed']);
    }

} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Server error',
        'error' => $e->getMessage()
    ]);
}
?>