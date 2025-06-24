<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Juice Plus+</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { background: #f4f7fa; }
        .login-container {
            max-width: 400px;
            margin: 8rem auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 2.5rem 2rem 2rem 2rem;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 2rem;
        }
        .login-container input {
            width: 100%;
            padding: 1rem;
            margin-bottom: 1.2rem;
            border-radius: 8px;
            border: 1px solid #eee;
            font-size: 1.2rem;
        }
        .login-container button {
            background: var(--bg-gradient);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.8rem 2rem;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
        }
        .login-container .error {
            color: #ff3b3b;
            margin-top: 1rem;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <form id="login-form" autocomplete="off">
            <input type="email" id="email" placeholder="Email" required autofocus>
            <input type="password" id="password" placeholder="Password" required>
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