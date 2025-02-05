

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | My Account</title>
    <link rel="stylesheet" href="../../assets/css/my-account-styles.css">
</head>
<body>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2>User Dashboard</h2>
            <ul>
                <li><a href="my-account.php" class="active">Account Overview</a></li>
                <li><a href="#">Orders</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Support</a></li>
            </ul>
            <form id="logoutForm">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1>Welcome, <span id="username">Loading...</span>!</h1>

            <div class="account-details">
                <div class="detail-card">
                    <h3>Username</h3>
                    <p id="user-username">Loading...</p>
                </div>

                <div class="detail-card">
                    <h3>Email</h3>
                    <p id="user-email">Loading...</p>
                </div>

                <div class="detail-card">
                    <h3>Role</h3>
                    <p id="user-role">Loading...</p>
                </div>

                <div class="detail-card">
                    <h3>Registration Date</h3>
                    <p id="user-registration">Loading...</p>
                </div>
            </div>
        </main>
    </div>

    <script src="../../assets/js/my-account.js"></script>
</body>
</html>
