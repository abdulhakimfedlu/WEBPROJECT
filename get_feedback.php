<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

$result = $conn->query('SELECT id, name, email, subject, message, created_at FROM messages ORDER BY created_at DESC');
$feedback = [];
while ($row = $result->fetch_assoc()) {
    $feedback[] = $row;
}
echo json_encode($feedback); 