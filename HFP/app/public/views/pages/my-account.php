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
                <li><a href="#" class="active" data-section="overview">Account Overview</a></li>
                <li><a href="#" data-section="settings">Settings</a></li>
            </ul>
            <form id="logoutForm">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <h1>Welcome, <span id="username">Loading...</span>!</h1>
            <section id="overview" class="content-section active">
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
            </section>
            
            <!-- Settings Section -->
            <section id="settings" class="content-section">
                <h1>Settings</h1>
                <div class="settings-section">
                    <h2>User Details <button id="edit-btn" class="edit-btn">Edit</button></h2>
                    <div id="userDetails">
                        <p><strong>Username:</strong> <span id="edit-user-username">Loading...</span></p>
                        <p><strong>Email:</strong> <span id="edit-user-email">Loading...</span></p>
                        <p><strong>Registration Date:</strong> <span id="edit-user-registration">Loading...</span></p>
                    </div>

                    <!-- Edit Form (Hidden Initially) -->
                    <form id="editUserForm" class="edit-form hidden">
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" id="edit-username" required>
                        </div>

                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" id="edit-email" required>
                        </div>

                        <div class="form-group">
                            <label>New Password (Optional):</label>
                            <div class="password-container">
                                <input type="password" id="edit-password">
                                <span id="toggle-password" class="toggle-password"></span>
                            </div>
                        </div>

                        <div class="button-group">
                            <button type="submit" class="save-btn">Save</button>
                            <button type="button" class="cancel-btn" onclick="toggleEditForm()">Cancel</button>
                        </div>
                    </form>
                </div>
            </section>

        </main>
    </div>
    <script src="../../assets/js/my-account.js"></script>
</body>
</html>
