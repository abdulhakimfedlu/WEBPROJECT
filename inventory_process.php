<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// List all inventory items
if ($action === 'list') {
    $result = $conn->query('SELECT * FROM inventory ORDER BY id DESC');
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    echo json_encode(['success' => true, 'items' => $items]);
    exit;
}

// Add inventory item
if ($action === 'add') {
    $item = trim($_POST['item'] ?? '');
    $quantity = floatval($_POST['quantity'] ?? 0);
    $unit = trim($_POST['unit'] ?? '');
    $status = trim($_POST['status'] ?? 'In Stock');
    if ($item === '' || $unit === '') {
        echo json_encode(['success' => false, 'message' => 'Item name and unit are required.']);
        exit;
    }
    $stmt = $conn->prepare('INSERT INTO inventory (item, quantity, unit, status) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('sdss', $item, $quantity, $unit, $status);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Inventory item added.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add item.']);
    }
    $stmt->close();
    exit;
}

// Edit inventory item
if ($action === 'edit') {
    $id = intval($_POST['id'] ?? 0);
    $item = trim($_POST['item'] ?? '');
    $quantity = floatval($_POST['quantity'] ?? 0);
    $unit = trim($_POST['unit'] ?? '');
    $status = trim($_POST['status'] ?? 'In Stock');
    if ($id <= 0 || $item === '' || $unit === '') {
        echo json_encode(['success' => false, 'message' => 'Invalid data.']);
        exit;
    }
    $stmt = $conn->prepare('UPDATE inventory SET item=?, quantity=?, unit=?, status=? WHERE id=?');
    $stmt->bind_param('sdssi', $item, $quantity, $unit, $status, $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Inventory item updated.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update item.']);
    }
    $stmt->close();
    exit;
}

// Delete inventory item
if ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid item ID.']);
        exit;
    }
    $stmt = $conn->prepare('DELETE FROM inventory WHERE id=?');
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Inventory item deleted.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete item.']);
    }
    $stmt->close();
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid action.']); 