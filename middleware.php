<?php
require_once 'db_connect.php';
header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'place_order') {
    $cart = json_decode($_POST['cart'], true);
    $total = floatval($_POST['total']);
    if (empty($cart) || $total <= 0) {
        $response['message'] = 'Invalid order data.';
    } else {
        $conn->begin_transaction();
        try {
            $stmt = $conn->prepare("INSERT INTO orders (total_amount) VALUES (?)");
            $stmt->bind_param("d", $total);
            $stmt->execute();
            $order_id = $conn->insert_id;
            $stmt->close();
            foreach ($cart as $item) {
                $stmt = $conn->prepare("SELECT id FROM foods WHERE name = ?");
                $stmt->bind_param("s", $item['name']);
                $stmt->execute();
                $result = $stmt->get_result();
                $food = $result->fetch_assoc();
                $stmt->close();
                if ($food) {
                    $stmt = $conn->prepare("INSERT INTO order_items (order_id, food_id, quantity, price) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("iiid", $order_id, $food['id'], $item['quantity'], $item['price']);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            $conn->commit();
            $response['success'] = true;
            $response['message'] = 'Order placed successfully!';
        } catch (Exception $e) {
            $conn->rollback();
            $response['message'] = 'Failed to place order: ' . $e->getMessage();
        }
    }
} else {
    $response['message'] = 'Invalid action.';
}
echo json_encode($response);
$conn->close();
?>