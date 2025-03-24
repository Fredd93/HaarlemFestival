<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/homepageStyle.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f4f4f4;
        }

        .container {
            width: 350px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background: #0056b3;
        }

        .toggle {
            margin-top: 15px;
            font-size: 14px;
            cursor: pointer;
            color: #007BFF;
        }

        .toggle:hover {
            text-decoration: underline;
        }

        #register-section {
            display: none;
        }
    </style>
</head>
<body>
<?php
$activePage = 'login';
//require(__DIR__ . "/../partials/navbar.php");
?>

<div class="container">
        <div id="login-section">
            <h2>Login</h2>
            <div class="form-group">
                <label for="login-username">Username</label>
                <input type="text" id="login-username" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="login-email">Email</label>
                <input type="email" id="login-email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="login-password">Password</label>
                <input type="password" id="login-password" placeholder="Enter your password">
            </div>
            <button onclick="login()">Login</button>
            <p class="toggle" onclick="toggleForm()">Don't have an account? Register</p>
        </div>

        <div id="register-section">
            <h2>Register</h2>
            <div class="form-group">
                <label for="register-username">Username</label>
                <input type="text" id="register-username" placeholder="Choose a username">
            </div>
            <div class="form-group">
                <label for="register-email">Email</label>
                <input type="email" id="register-email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="register-password">Password</label>
                <input type="password" id="register-password" placeholder="Create a password">
            </div>
            <button onclick="register()">Register</button>
            <p class="toggle" onclick="toggleForm()">Already have an account? Login</p>
        </div>
    </div>

    <script>
        function toggleForm() {
            const loginSection = document.getElementById("login-section");
            const registerSection = document.getElementById("register-section");

            if (loginSection.style.display === "none") {
                loginSection.style.display = "block";
                registerSection.style.display = "none";
            } else {
                loginSection.style.display = "none";
                registerSection.style.display = "block";
            }
        }

        async function login() {
            const email = document.getElementById("login-email").value;
            const username = document.getElementById("login-username").value;
            const password = document.getElementById("login-password").value;

            const formData = new URLSearchParams();
            formData.append("email", email);
            formData.append("username", username);
            formData.append("password", password);

            const response = await fetch("api/login/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: formData
            });
            
            if (response.ok) {
                    alert("Login successful!");
            } else {
                const data = await response.json();
                alert("Error: " + data.error);
            }
        }

        async function register() {
            const username = document.getElementById("register-username").value;
            const email = document.getElementById("register-email").value;
            const password = document.getElementById("register-password").value;

            const formData = new URLSearchParams();
            formData.append("username", username);
            formData.append("email", email);
            formData.append("password", password);

            const response = await fetch("/api/login/register", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: formData
            });

            
            if (response.ok) {
                    alert("Registration successful! You can now log in.");
                    toggleForm(); // Switch back to login form
            } else {
                const data = await response.json();
                alert("Error: " + data.error);
            }
        }
    </script>

<?php
//require(__DIR__ . "/../partials/footer.php");
?>
</body>
</html>
