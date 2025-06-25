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
        <form id="login-form" autocomplete="off">
            <div class="login-input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" placeholder="Email" required autofocus>
            </div>
            <div class="login-input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" placeholder="Password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div id="error-message" class="error"></div>
    </div>
    <script>
    // If already logged in, go to admin.php
    if (localStorage.getItem('admin_logged_in') === 'true') {
        window.location.href = 'admin.php';
    }
    document.getElementById('login-form').addEventListener('submit', function(e) {
        e.preventDefault();
        var email = document.getElementById('email').value.trim();
        var password = document.getElementById('password').value.trim();
        var errorDiv = document.getElementById('error-message');
        if (email === 'fedluabdulhakim@gmail.com' && password === 'Adidig') {
            localStorage.setItem('admin_logged_in', 'true');
            window.location.href = 'admin.php';
        } else {
            errorDiv.textContent = 'You are not authorized';
        }
    });
    </script>
</body>
</html> 