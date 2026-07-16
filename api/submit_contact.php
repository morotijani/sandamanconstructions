<?php
require_once '../db/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$name = $_POST['name'] ?? '';
$company = $_POST['company'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$service = $_POST['service'] ?? '';
$location = $_POST['location'] ?? '';
$message = $_POST['message'] ?? '';

if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'Required fields are missing.']);
    exit;
}

try {
    $stmt = $pdo->prepare('INSERT INTO contacts (name, company, email, phone, service, location, message) VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$name, $company, $email, $phone, $service, $location, $message]);
    
    echo json_encode(['success' => true, 'message' => 'Thanks — your enquiry has been noted.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
