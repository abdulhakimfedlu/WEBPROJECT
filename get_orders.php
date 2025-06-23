<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

$result = $conn->query("SELECT o.*, GROUP_CONCAT(CONCAT(f.name, ':', oi.quantity, ':', oi.price) SEPARATOR ';') as items
                       FROM orders o
                       LEFT JOIN order_items oi ON o.id = oi.order_id
                       LEFT JOIN foods f ON oi.food_id = f.id
                       GROUP BY o.id
                       ORDER BY o.created_at DESC");

$orders = [];
while ($row = $result->fetch_assoc()) {
    $items = [];
    if ($row['items']) {
        foreach (explode(';', $row['items']) as $item) {
            list($name, $quantity, $price) = explode(':', $item);
            $items[] = ['name' => $name, 'quantity' => $quantity, 'price' => $price];
        }
    }
    $row['items'] = $items;
    $orders[] = $row;
}

echo json_encode($orders);
$conn->close();
?>