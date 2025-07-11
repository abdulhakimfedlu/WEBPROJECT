<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

// Get all unique categories, preferring the first row for each category
$result = $conn->query("SELECT MIN(id) as id, category, MAX(description) as description FROM foods WHERE category IS NOT NULL AND category != '' GROUP BY category ORDER BY category ASC");
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = [
        'id' => $row['id'],
        'name' => $row['category'],
        'description' => $row['description']
    ];
}
echo json_encode($categories);
$conn->close(); 