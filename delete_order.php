
require_once 'db_connect.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    $stmt = $conn->prepare('DELETE FROM orders WHERE id = ?');
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Order deleted.';
    } else {
        $response['message'] = 'Failed to delete order.';
    }
    $stmt->close();
} else {
    $response['message'] = 'Invalid request.';
}
$conn->close();
echo json_encode($response); 
