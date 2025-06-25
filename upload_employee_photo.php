<?php
header('Content-Type: application/json');
$targetDir = 'uploads/employees/';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}
$response = ['success' => false, 'file' => '', 'message' => ''];
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['photo']['tmp_name'];
    $fileName = basename($_FILES['photo']['name']);
    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($ext, $allowed)) {
        $response['message'] = 'Invalid file type.';
    } else {
        $newName = uniqid('emp_', true) . '.' . $ext;
        $targetFile = $targetDir . $newName;
        if (move_uploaded_file($fileTmp, $targetFile)) {
            $response['success'] = true;
            $response['file'] = $targetFile;
        } else {
            $response['message'] = 'Failed to save file.';
        }
    }
} else {
    $response['message'] = 'No file uploaded.';
}
echo json_encode($response); 