<?php
require_once 'db_connect.php';
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'Email and password are required.';
    } else {
        $stmt = $conn->prepare("SELECT id, email, password FROM admins WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();
        $stmt->close();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            header('Location: admin.php');
            exit;
        } else {
            $error = 'Invalid email or password.';
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Juice Plus+</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #fff;
            min-height: 100vh;
        }
        .login-container {
            max-width: 520px;
            margin: 7rem auto;
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 8px 40px rgba(255,152,0,0.13), 0 2px 8px rgba(0,0,0,0.07);
            border: 2.5px solid #ff9800;
            padding: 4.5rem 3.5rem 3.5rem 3.5rem;
            text-align: center;
            position: relative;
        }
        .login-logo {
            font-size: 2.6rem;
            font-weight: 800;
            color: #ff9800;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }
        .login-container h2 {
            margin-bottom: 2.2rem;
            font-size: 2.2rem;
            color: #222;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        .login-input-group {
            position: relative;
        }
        .login-container input {
            width: 100%;
            padding: 1.3rem 1.1rem 1.3rem 3.2rem;
            border-radius: 12px;
            border: 1.7px solid #ffd699;
            font-size: 1.22rem;
            background: #fff7ed;
            transition: border 0.2s, box-shadow 0.2s;
        }
        .login-container input:focus {
            border: 1.7px solid #ff9800;
            outline: none;
            background: #fff;
            box-shadow: 0 0 0 2px #ffd699;
        }
        .login-input-group i {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
            color: #ff9800;
            font-size: 1.25rem;
            transition: color 0.2s;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 1rem;
            transform: translateY(-50%);
            color: #ff9800;
            font-size: 1.25rem;
            cursor: pointer;
            transition: color 0.2s, transform 0.2s;
        }
        .toggle-password.active {
            color: #ff9800;
            transform: translateY(-50%) scale(1.15) rotate(-10deg);
        }
        .login-container button {
            background: linear-gradient(90deg, #ff9800 60%, #ffd699 100%);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 1.2rem 0;
            font-size: 1.35rem;
            font-weight: 800;
            cursor: pointer;
            margin-top: 0.5rem;
            box-shadow: 0 2px 12px rgba(255,152,0,0.10);
            transition: background 0.2s, transform 0.2s;
            letter-spacing: 1px;
        }
        .login-container button:hover {
            background: #ff9800;
            transform: translateY(-2px) scale(1.04);
        }
        .login-container .error {
            color: #ff3b3b;
            margin-top: 1.2rem;
            font-size: 1.13rem;
            background: rgba(255,107,107,0.08);
            border-radius: 8px;
            padding: 0.7rem 0.5rem;
            font-weight: 500;
        }
        @media (max-width: 700px) {
            .login-container { padding: 2.2rem 0.7rem; max-width: 98vw; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-logo"><i class="fas fa-lemon"></i> Juice <span style="color:#ff9800;">Plus+</span></div>
        <h2>Admin Login</h2>
        <p style="font-size:1.15rem;color:#555;margin-bottom:2.2rem;">Enter your credentials to access the admin dashboard.</p>
        <form id="login-form" method="POST" autocomplete="off">
            <div class="login-input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Email" required autofocus value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>
            <div class="login-input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div style="margin-top:1.2rem;">
            <a href="#" id="forgotPasswordLink" style="color:#ff9800;text-decoration:underline;font-size:1.05rem;">Forgot Password?</a>
        </div>
        <?php if ($error): ?>
            <div id="error-message" class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Forgot Password Modal -->
        <div id="forgotPasswordModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);z-index:2000;justify-content:center;align-items:center;">
            <div style="background:#fff;padding:2.5rem 2rem 2rem 2rem;border-radius:16px;max-width:350px;width:90%;margin:0 auto;text-align:center;box-shadow:0 8px 32px rgba(80,80,80,0.13);position:relative;">
                <h2 style="margin-bottom:1.2rem;font-size:1.5rem;color:#ff9800;">Reset Password</h2>
                <form id="forgotPasswordForm">
                    <div class="form-group" style="margin-bottom:1.2rem;">
                        <input type="email" id="forgotEmail" name="forgot_email" placeholder="Enter your admin email" required style="width:100%;padding:0.9rem 1rem;border-radius:8px;border:1.5px solid #ffd699;font-size:1.1rem;">
                    </div>
                    <button type="submit" style="background:#ff9800;color:#fff;padding:0.8rem 2.2rem;border:none;border-radius:50px;font-size:1.1rem;font-weight:600;cursor:pointer;">Send Reset Link</button>
                    <button type="button" id="closeForgotModal" style="background:#eee;color:#333;padding:0.8rem 2.2rem;border:none;border-radius:50px;font-size:1.1rem;margin-left:0.7rem;">Cancel</button>
                </form>
                <div id="forgotMsg" style="margin-top:1.2rem;display:none;"></div>
            </div>
        </div>

        <script>
        // Forgot Password Modal logic
        const forgotPasswordLink = document.getElementById('forgotPasswordLink');
        const forgotPasswordModal = document.getElementById('forgotPasswordModal');
        const closeForgotModal = document.getElementById('closeForgotModal');
        forgotPasswordLink.onclick = function(e) {
            e.preventDefault();
            forgotPasswordModal.style.display = 'flex';
        };
        closeForgotModal.onclick = function() {
            forgotPasswordModal.style.display = 'none';
        };
        forgotPasswordModal.onclick = function(e) {
            if (e.target === forgotPasswordModal) forgotPasswordModal.style.display = 'none';
        };
        </script>
        <script>
        // Forgot Password AJAX
        document.getElementById('forgotPasswordForm').onsubmit = function(e) {
            e.preventDefault();
            var email = document.getElementById('forgotEmail').value.trim();
            var msgDiv = document.getElementById('forgotMsg');
            msgDiv.style.display = 'none';
            msgDiv.textContent = '';
            fetch('admin_forgot_password.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: new URLSearchParams({email: email})
            })
            .then(res => res.json())
            .then(data => {
                msgDiv.style.display = 'block';
                msgDiv.style.color = data.success ? '#4ecdc4' : '#ff6b6b';
                msgDiv.textContent = data.message;
                if (data.success && data.reset_link) {
                    msgDiv.innerHTML += '<br><span style="font-size:0.95rem;color:#888;">(Demo: <a href="'+data.reset_link+'" target="_blank">Reset Link</a>)</span>';
                }
            });
        };
        </script>
    </div>
    <script>
        // Toggle password visibility
        const passwordInput = document.getElementById('password');
        const togglePassword = document.createElement('i');
        togglePassword.className = 'fas fa-eye toggle-password';
        document.querySelector('.login-input-group:last-child').appendChild(togglePassword);

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePassword.classList.toggle('fa-eye', type === 'password');
            togglePassword.classList.toggle('fa-eye-slash', type === 'text');
            togglePassword.classList.toggle('active');
        });
    </script>
</body>
</html>