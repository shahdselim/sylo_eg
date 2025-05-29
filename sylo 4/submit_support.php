<?php
ob_start(); // Start output buffering (added for consistency, though not present in your original snippet)
ini_set('display_errors', 0); // Keep display_errors off in production
ini_set('display_startup_errors', 0);
error_reporting(0); // Report no errors to the client
header('Content-Type: application/json'); // Set header once at the beginning

try {
    // IMPORTANT: Move require_once INSIDE the try block
    // Ensure 'db_config.php' is correctly named 'config.php' if that's your actual file
    require_once 'config.php'; // Assuming 'db_config.php' refers to your 'config.php' file

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO support_requests (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Support request submitted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit support request']);
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