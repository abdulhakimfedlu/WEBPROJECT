<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

// Fetch only pending orders (not completed)
$orderResult = $conn->query("SELECT * FROM orders WHERE status != 'completed' ORDER BY created_at DESC");
$orders = [];
while ($order = $orderResult->fetch_assoc()) {
    $order_id = $order['id'];
    // Fetch items for this order
    $items = [];
    $itemStmt = $conn->prepare("SELECT f.name, oi.quantity, oi.price FROM order_items oi JOIN foods f ON oi.food_id = f.id WHERE oi.order_id = ?");
    $itemStmt->bind_param("i", $order_id);
    $itemStmt->execute();
    $itemResult = $itemStmt->get_result();
    while ($item = $itemResult->fetch_assoc()) {
        $items[] = $item;
    }
    $itemStmt->close();
    $order['items'] = $items;
    $orders[] = $order;
}
echo json_encode($orders);
$conn->close();
?>