document.addEventListener("DOMContentLoaded", function () {
    loadUsers();

    const userForm = document.getElementById("userForm");
    userForm.addEventListener("submit", function (e) {
        e.preventDefault();
        saveUser();
    });
});

/**
 * Load all users from the API.
 */
function loadUsers() {
    fetch("/api/user/all")
        .then(response => response.json())
        .then(users => {
            const tableBody = document.getElementById("userTable");
            tableBody.innerHTML = "";

            users.forEach(user => {
                const row = `
                    <tr>
                        <td>${user.user_id}</td>
                        <td>${user.username}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                        <td>${user.registration_date}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="editUser(${user.user_id}, '${user.username}', '${user.email}', '${user.role}')">Edit</button>
                            <button class="btn btn-warning btn-sm" onclick="changePassword(${user.user_id})">Change Password</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteUser(${user.user_id})">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error("Error loading users:", error));
}

/**
 * Populate form for editing a user.
 */
function editUser(id, username, email, role) {
    document.getElementById("user_id").value = id;
    document.getElementById("username").value = username;
    document.getElementById("email").value = email;
    document.getElementById("role").value = role;

    document.getElementById("passwordField").style.display = "none"; // Hide password field when editing

    const modal = new bootstrap.Modal(document.getElementById("userModal"));
    modal.show();
}

/**
 * Create or update a user.
 */
function saveUser() {
    const id = document.getElementById("user_id").value;
    const username = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const role = document.getElementById("role").value;
    const password = document.getElementById("password").value;

    const method = id ? "PUT" : "POST";
    const url = id ? `/api/user/update` : "/api/user/create";
    const body = JSON.stringify({ username, email, role, ...(id ? {} : { password }) });

    fetch(url, {
        method: method,
        headers: { "Content-Type": "application/json" },
        body: body
    })
    .then(response => response.json())
    .then(() => {
        document.getElementById("userForm").reset();
        loadUsers();
        bootstrap.Modal.getInstance(document.getElementById("userModal")).hide();
    })
    .catch(error => console.error("Error saving user:", error));
}

/**
 * Open a prompt to update password.
 */
function changePassword(userId) {
    const newPassword = prompt("Enter new password:");
    if (!newPassword) return;

    fetch("/api/user/updatePassword", {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ user_id: userId, password: newPassword })
    })
    .then(response => response.json())
    .then(() => {
        alert("Password updated successfully!");
    })
    .catch(error => console.error("Error updating password:", error));
}

/**
 * Delete a user.
 */
function deleteUser(id) {
    if (!confirm("Are you sure you want to delete this user?")) return;

    fetch("/api/user/delete", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ user_id: id })
    })
    .then(response => response.json())
    .then(() => loadUsers())
    .catch(error => console.error("Error deleting user:", error));
}
