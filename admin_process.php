

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
    } elseif ($action === 'add_category') {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        if (empty($name)) {
            $response['message'] = 'Category name is required.';
        } else {
            // Insert as a special row in foods: price = 0, badge = 'category'
            $stmt = $conn->prepare("INSERT INTO foods (name, description, price, category, image, badge) VALUES (?, ?, 0, ?, '', 'category')");
            $stmt->bind_param("sss", $name, $description, $name);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Category added successfully.';
            } else {
                $response['message'] = 'Failed to add category.';
            }
            $stmt->close();
        }
    } elseif ($action === 'add_employee') {
        $name = trim($_POST['name'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $salary = floatval($_POST['salary'] ?? 0);
        $image = trim($_POST['image'] ?? '');

        // Validate required fields
        if (empty($name) || empty($role) || empty($phone) || empty($salary) || empty($image)) {
            $response['message'] = 'All fields are required.';
        } else {
            $stmt = $conn->prepare("INSERT INTO employees (name, role, phone, salary, image, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("sssds", $name, $role, $phone, $salary, $image);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Employee added successfully.';
            } else {
                $response['message'] = 'Failed to add employee.';
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
    } elseif ($action === 'delete_category') {
        $id = intval($_POST['id']);
        // Get the category name for this id
        $result = $conn->query("SELECT category FROM foods WHERE id = $id");
        if ($result && $row = $result->fetch_assoc()) {
            $category = $row['category'];
            // Delete all rows with this category
            $stmt = $conn->prepare("DELETE FROM foods WHERE category = ?");
            $stmt->bind_param("s", $category);
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Category deleted successfully.';
            } else {
                $response['message'] = 'Failed to delete category.';
            }
            $stmt->close();
        } else {
            $response['message'] = 'Category not found.';
        }
    }
    // Add edit_category, delete_category as needed (by updating/deleting the special foods row)
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
$conn->close();
?>
