<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

$email = trim($_POST['email'] ?? '');
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email.']);
    exit;
}

// Check if admin exists
$stmt = $conn->prepare('SELECT id FROM admins WHERE email=?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'If this email is registered, a reset link will be sent.']);
    $stmt->close();
    exit;
}
$stmt->close();

// Generate token
$token = bin2hex(random_bytes(32));
$expires = date('Y-m-d H:i:s', time() + 3600); // 1 hour expiry

// Store token
$stmt = $conn->prepare('INSERT INTO admin_password_resets (email, token, expires_at) VALUES (?, ?, ?)');
$stmt->bind_param('sss', $email, $token, $expires);
$stmt->execute();
$stmt->close();

// For demo: show the reset link (in production, send by email)
$reset_link = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/admin_reset_password.php?token=$token";

// TODO: Send $reset_link to $email using mail() in production

echo json_encode([
    'success' => true,
    'message' => 'If this email is registered, a reset link will be sent.',
    'reset_link' => $reset_link // For demo only
]); 