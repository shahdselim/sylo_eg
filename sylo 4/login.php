<?php
ob_start(); // Start output buffering
header('Content-Type: application/json'); // Set header once at the beginning
ini_set('display_errors', 0); // Keep display_errors off in production
ini_set('display_startup_errors', 0);
error_reporting(0); // Report no errors to the client

try {
    // IMPORTANT: Move require_once INSIDE the try block
    // Ensure 'db_config.php' is correctly named 'config.php' if that's your actual file
    require_once 'config.php'; // Assuming 'db_config.php' refers to your 'config.php' file

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    }

} catch (Exception $e) {
    // This catch block will now handle exceptions from config.php as well
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false,
        'message' => 'Server error',
        'error' => $e->getMessage() // This will show "Database connection failed" if that's the issue
    ]);
}
?>