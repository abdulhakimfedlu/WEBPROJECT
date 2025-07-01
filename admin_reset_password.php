<?php
require_once 'db_connect.php';
$token = $_GET['token'] ?? '';
$show_form = false;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    if (strlen($password) < 6) {
        $message = 'Password must be at least 6 characters.';
    } else {
        // Validate token
        $stmt = $conn->prepare('SELECT email, expires_at, used FROM admin_password_resets WHERE token=?');
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $stmt->bind_result($email, $expires_at, $used);
        if ($stmt->fetch() && !$used && strtotime($expires_at) > time()) {
            $stmt->close();
            // Update password
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt2 = $conn->prepare('UPDATE admins SET password=? WHERE email=?');
            $stmt2->bind_param('ss', $hash, $email);
            $stmt2->execute();
            $stmt2->close();
            // Invalidate token
            $stmt3 = $conn->prepare('UPDATE admin_password_resets SET used=1 WHERE token=?');
            $stmt3->bind_param('s', $token);
            $stmt3->execute();
            $stmt3->close();
            $message = 'Password reset successful! You can now <a href="login.php">login</a>.';
        } else {
            $message = 'Invalid or expired token.';
            $stmt->close();
        }
    }
} else if ($token) {
    // Validate token for GET
    $stmt = $conn->prepare('SELECT expires_at, used FROM admin_password_resets WHERE token=?');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $stmt->bind_result($expires_at, $used);
    if ($stmt->fetch() && !$used && strtotime($expires_at) > time()) {
        $show_form = true;
    } else {
        $message = 'Invalid or expired token.';
    }
    $stmt->close();
} else {
    $message = 'Invalid request.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Admin Password</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #fff; min-height: 100vh; }
        .reset-container { max-width: 420px; margin: 7rem auto; background: #fff; border-radius: 22px; box-shadow: 0 8px 40px rgba(255,152,0,0.13), 0 2px 8px rgba(0,0,0,0.07); border: 2.5px solid #ff9800; padding: 3.5rem 2.5rem 2.5rem 2.5rem; text-align: center; position: relative; }
        .reset-container h2 { margin-bottom: 2.2rem; font-size: 2.2rem; color: #222; }
        .reset-container form { display: flex; flex-direction: column; gap: 1.5rem; }
        .reset-container input { width: 100%; padding: 1.3rem 1.1rem; border-radius: 12px; border: 1.7px solid #ffd699; font-size: 1.22rem; background: #fff7ed; transition: border 0.2s, box-shadow 0.2s; }
        .reset-container input:focus { border: 1.7px solid #ff9800; outline: none; background: #fff; box-shadow: 0 0 0 2px #ffd699; }
        .reset-container button { background: #ff9800; color: #fff; padding: 1rem 2.5rem; border: none; border-radius: 50px; font-size: 1.2rem; font-weight: 700; margin-top: 1.2rem; cursor: pointer; transition: background 0.2s; }
        .reset-container button:hover { background: #ffb84d; }
        .reset-message { margin-top: 1.5rem; font-size: 1.1rem; color: #ff6b6b; }
        .reset-success { color: #4ecdc4; }
    </style>
</head>
<body>
    <div class="reset-container">
        <h2>Reset Password</h2>
        <?php if ($show_form): ?>
            <form method="POST">
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <input type="password" name="password" placeholder="Enter new password" required minlength="6">
                <button type="submit">Reset Password</button>
            </form>
        <?php endif; ?>
        <?php if ($message): ?>
            <div class="reset-message<?php if (strpos($message, 'successful') !== false) echo ' reset-success'; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html> 