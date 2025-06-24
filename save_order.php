<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$response = ['success' => false, 'message' => ''];

if (!$data || !isset($data['customer_name'], $data['table_number'], $data['total_amount'], $data['items']) || !is_array($data['items'])) {
    $response['message'] = 'Invalid order data.';
    echo json_encode($response);
    exit;
}

$customer_name = trim($data['customer_name']);
$table_number = trim($data['table_number']);
$total_amount = floatval($data['total_amount']);
$items = $data['items'];

if (empty($customer_name) || empty($table_number) || $total_amount <= 0 || count($items) === 0) {
    $response['message'] = 'All fields are required.';
    echo json_encode($response);
    exit;
}

// Insert order
$stmt = $conn->prepare("INSERT INTO orders (customer_name, table_number, total_amount) VALUES (?, ?, ?)");
$stmt->bind_param("ssd", $customer_name, $table_number, $total_amount);
if ($stmt->execute()) {
    $order_id = $stmt->insert_id;
    $stmt->close();
    // Insert order items
    $success = true;
    foreach ($items as $item) {
        $food_name = $item['name'];
        $quantity = intval($item['quantity']);
        $price = floatval($item['price']);
        // Get food_id by name
        $food_id = null;
        $food_stmt = $conn->prepare("SELECT id FROM foods WHERE name = ? LIMIT 1");
        $food_stmt->bind_param("s", $food_name);
        $food_stmt->execute();
        $food_stmt->bind_result($food_id);
        $food_stmt->fetch();
        $food_stmt->close();
        if ($food_id) {
            $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, food_id, quantity, price) VALUES (?, ?, ?, ?)");
            $item_stmt->bind_param("iiid", $order_id, $food_id, $quantity, $price);
            if (!$item_stmt->execute()) {
                $success = false;
            }
            $item_stmt->close();
        } else {
            $success = false;
        }
    }
    if ($success) {
        $response['success'] = true;
        $response['message'] = 'Order saved successfully.';
    } else {
        $response['message'] = 'Order saved, but some items failed.';
    }
} else {
    $response['message'] = 'Failed to save order.';
}

$conn->close();
echo json_encode($response); 