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
                        <td>${escapeHTML(user.username)}</td>
                        <td>${escapeHTML(user.email)}</td>
                        <td>${escapeHTML(user.role)}</td>
                        <td>${escapeHTML(user.registration_date)}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="editUser(${user.user_id}, '${escapeHTML(user.username)}', '${escapeHTML(user.email)}', '${escapeHTML(user.role)}')">Edit</button>
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
/**
 * Create or update a user.
 */
function saveUser() {
    const id = document.getElementById("user_id").value.trim();
    const userId = id ? parseInt(id, 10) : null;
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const role = document.getElementById("role").value;
    const passwordField = document.getElementById("password");
    const password = passwordField ? passwordField.value.trim() : "";

    // ✅ **Validation: Check if required fields are empty**
    if (!username || !email || !role || (!userId && !password)) {
        alert("❌ Please fill in all required fields.");
        return;
    }

    // ✅ **Validation: Check email format**
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("❌ Please enter a valid email address.");
        return;
    }

    const method = userId ? "PUT" : "POST";
    const url = userId ? `/api/user/update` : "/api/user/create";
    const body = JSON.stringify({ 
        user_id: userId, 
        username, 
        email, 
        role, 
        ...(userId ? {} : { password }) 
    });


    fetch(url, {
        method: method,
        headers: { "Content-Type": "application/json" },
        body: body
    })
    .then(response => response.json())
    .then((data) => {
        console.log("Server Response:", data);
        if (data.error) {
            console.log("❌ Server Error: " + data.error);
            return;
        }
        document.getElementById("userForm").reset();
        loadUsers();
        bootstrap.Modal.getInstance(document.getElementById("userModal")).hide();
    })
    .catch(error => console.error("❌ Error saving user:", error));
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

    fetch(`/api/user/delete/${id}`, {
        method: "DELETE"
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Failed to delete user");
        }
        return response.json();
    })
    .then(() => {
        alert("User deleted successfully.");
        loadUsers(); // Reload the user list
    })
    .catch(error => {
        console.error("Error deleting user:", error);
        alert("An error occurred while deleting the user.");
    });
}


/**
 * Simple function to escape HTML to prevent XSS attacks.
 */
function escapeHTML(str) {
    return str.replace(/&/g, "&amp;")
              .replace(/</g, "&lt;")
              .replace(/>/g, "&gt;")
              .replace(/"/g, "&quot;")
              .replace(/'/g, "&#039;");
}
