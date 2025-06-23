<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM foods ORDER BY created_at DESC");
$foods = [];

while ($row = $result->fetch_assoc()) {
    $foods[] = $row;
}

echo json_encode($foods);
$conn->close();
?>