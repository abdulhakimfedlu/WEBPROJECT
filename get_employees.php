<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM employees ORDER BY created_at DESC");
$employees = [];

while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

echo json_encode($employees);
$conn->close();
?>