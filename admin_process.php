<?php
require_once 'db_connect.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add_food') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);
        $category = trim($_POST['category']);
        $image = trim($_POST['image']);
        $badge = trim($_POST['badge']);

        if (empty($name) || empty($description) || !isset($_POST['price']) || $price < 0 || empty($category)) {
            $response['message'] = 'All required fields must be filled.';
        } else {
            $stmt = $conn->prepare("INSERT INTO foods (name, description, price, category, image, badge) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsss", $name, $description, $price, $category, $image, $badge);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Food item added successfully.';
            } else {
                $response['message'] = 'Failed to add food item.';
            }
            $stmt->close();
        }
    } elseif ($action === 'delete_food') {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM foods WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Food item deleted successfully.';
        } else {
            $response['message'] = 'Failed to delete food item.';
        }
        $stmt->close();
    } elseif ($action === 'add_employee') {
        $name = trim($_POST['name']);
        $role = trim($_POST['role']);
        $image = trim($_POST['image']);

        if (empty($name) || empty($role)) {
            $response['message'] = 'Name and role are required.';
        } else {
            $stmt = $conn->prepare("INSERT INTO employees (name, role, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $role, $image);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Employee added successfully.';
            } else {
                $response['message'] = 'Failed to add employee.';
            }
            $stmt->close();
        }
    } elseif ($action === 'delete_employee') {
        $id = intval($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Employee deleted successfully.';
        } else {
            $response['message'] = 'Failed to delete employee.';
        }
        $stmt->close();
    } elseif ($action === 'edit_employee') {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $role = trim($_POST['role']);
        $phone = trim($_POST['phone']);
        $salary = floatval($_POST['salary']);
        $image = trim($_POST['image']);

        if (empty($name) || empty($role)) {
            $response['message'] = 'Name and role are required.';
        } else {
            $stmt = $conn->prepare("UPDATE employees SET name=?, role=?, phone=?, salary=?, image=? WHERE id=?");
            $stmt->bind_param("ssssdi", $name, $role, $phone, $salary, $image, $id);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Employee updated successfully.';
            } else {
                $response['message'] = 'Failed to update employee.';
            }
            $stmt->close();
        }
    } elseif ($action === 'delete_category') {
        $name = trim($_POST['name']);
        $stmt = $conn->prepare("DELETE FROM foods WHERE category = ?");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Category and its foods deleted successfully.';
        } else {
            $response['message'] = 'Failed to delete category.';
        }
        $stmt->close();
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
$conn->close();
?>