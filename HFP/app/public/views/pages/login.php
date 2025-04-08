<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Haarlem Festival</title>
    <link rel="stylesheet" href="../../assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form id="loginForm">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p id="loginMessage" class="message"></p>

        <!-- Register Button -->
        <p class="register-link">
            Don’t have an account?
            <a href="/register">Register here</a>
        </p>
    </div>

    <script src="../../assets/js/login.js"></script>
</body>
</html>
