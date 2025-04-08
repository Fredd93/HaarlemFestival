<?php
require_once(__DIR__ . "/header.php");
?>

<div class="container mt-5">
    <h2 class="mb-4">Manage Users</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#userModal">Add User</button>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="userTable">
            <!-- Users dynamically loaded here -->
        </tbody>
    </table>
</div>

<!-- Modal for Adding/Editing Users -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    <input type="hidden" id="user_id"> <!-- Hidden User ID -->

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role">
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                            <option value="user">User</option>
                        </select>
                    </div>

                    <div class="mb-3" id="passwordField">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password">
                    </div>

                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . "/footer.php"); ?>

<script src="./../../assets/js/cmsUsers.js"></script>
