<?php
session_start();
header('Content-Type: application/json');
require_once 'db_connect.php';

// Only allow if logged in as admin
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authorized.']);
    exit;
}

$admin_id = $_SESSION['admin_id'];
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// List all admins
if ($action === 'list') {
    $result = $conn->query('SELECT id, email, created_at FROM admins ORDER BY id ASC');
    $admins = [];
    while ($row = $result->fetch_assoc()) {
        $admins[] = $row;
    }
    // Get current admin email
    $stmt = $conn->prepare('SELECT email FROM admins WHERE id=?');
    $stmt->bind_param('i', $admin_id);
    $stmt->execute();
    $stmt->bind_result($current_email);
    $stmt->fetch();
    $stmt->close();
    echo json_encode(['success' => true, 'admins' => $admins, 'current_email' => $current_email]);
    exit;
}

// Add new admin
if ($action === 'add') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Valid email and password (min 6 chars) required.']);
        exit;
    }
    // Check if email exists
    $stmt = $conn->prepare('SELECT id FROM admins WHERE email=?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists.']);
        $stmt->close();
        exit;
    }
    $stmt->close();
    // Insert new admin
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare('INSERT INTO admins (email, password, created_at) VALUES (?, ?, NOW())');
    $stmt->bind_param('ss', $email, $hash);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Admin added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add admin.']);
    }
    $stmt->close();
    exit;
}

// Delete admin (not self)
if ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if ($id === $admin_id) {
        echo json_encode(['success' => false, 'message' => 'You cannot delete your own account.']);
        exit;
    }
    $stmt = $conn->prepare('DELETE FROM admins WHERE id=?');
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Admin deleted.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete admin.']);
    }
    $stmt->close();
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid action.']); 