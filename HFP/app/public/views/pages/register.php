<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Haarlem Festival</title>
    <link rel="stylesheet" href="../../assets/css/register.css">
</head>
<body>
    <div class="register-container">
        <h2>Create Account</h2>
        <form id="registerForm">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="email" id="email" name="email" placeholder="Email address" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
            <p id="registerMessage" class="message"></p>
        </form>
    </div>

    <script src="../../assets/js/register.js"></script>
</body>
</html>
