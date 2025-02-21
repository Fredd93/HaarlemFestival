document.addEventListener("DOMContentLoaded", function () {
    fetchUserData();
    setupLogout();
    setupEditForms();
});

document.addEventListener("DOMContentLoaded", function () {
    const sidebarLinks = document.querySelectorAll(".sidebar ul li a");
    const sections = document.querySelectorAll(".content-section");

    function switchSection(sectionId) {
        sections.forEach(section => {
            section.classList.remove("active");
            section.style.display = "none";
        });

        const activeSection = document.getElementById(sectionId);
        if (activeSection) {
            activeSection.classList.add("active");
            activeSection.style.display = "block";
        }

        sidebarLinks.forEach(link => link.classList.remove("active"));
        document.querySelector(`[data-section="${sectionId}"]`).classList.add("active");
    }

    sidebarLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            const sectionId = this.getAttribute("data-section");
            switchSection(sectionId);
        });
    });

    switchSection("overview");
});


function fetchUserData() {
    fetch('/api/user/me', {
        method: 'GET',
        credentials: 'include', 
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => {
        if (!response.ok) throw new Error('User not logged in');
        return response.json();
    })
    .then(data => {
        document.getElementById("username").textContent = data.username;
        document.getElementById("user-username").textContent = data.username;
        document.getElementById("user-email").textContent = data.email;
        document.getElementById("user-role").textContent = data.role;
        document.getElementById("user-registration").textContent = data.registration_date;

        // Prefill Settings Section
        document.getElementById("edit-user-email").textContent = data.email;
        document.getElementById("edit-user-registration").textContent = data.registration_date;
        document.getElementById("edit-user-username").textContent = data.username;

        // Autofill Edit Forms
        document.getElementById("edit-email").value = data.email;
        document.getElementById("edit-username").value = data.username;
    })
    .catch(error => {
        console.error('Error:', error);
        window.location.href = "/views/pages/login.php";
    });
}

function toggleEditForm() {
    const form = document.getElementById("editUserForm");
    const details = document.getElementById("userDetails");

    if (form.classList.contains("hidden")) {
        form.classList.remove("hidden");
        details.style.display = "none";
    } else {
        form.classList.add("hidden");
        details.style.display = "block";
    }
}

function setupEditForms() {
    document.getElementById("edit-btn").addEventListener("click", function () {
        toggleEditForm();
    });

    document.getElementById("editUserForm").addEventListener("submit", function (event) {
        event.preventDefault();
        const username = document.getElementById("edit-username").value;
        const email = document.getElementById("edit-email").value;
        const password = document.getElementById("edit-password").value;

        // Update Username & Email
        fetch('/api/user/update', {
            method: 'PUT',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ username, email })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                fetchUserData();
            } else {
                alert("Error: " + (data.error || "Unknown error"));
            }
        })
        .catch(error => console.error('Error updating details:', error));

        // Update Password (if provided)
        if (password.trim() !== "") {
            fetch('/api/user/updatePassword', {
                method: 'PATCH',
                credentials: 'include',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                } else {
                    alert("Error: " + (data.error || "Unknown error"));
                }
            })
            .catch(error => console.error('Error updating password:', error));
        }

        // Close form after submission
        toggleEditForm();
    });
}


// Setup Logout Button
function setupLogout() {
    const logoutForm = document.getElementById("logoutForm");

    if (logoutForm) {
        logoutForm.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent default form submission

            fetch('/api/logout', {
                method: 'POST',
                credentials: 'include'
            })
            .then(() => {
                window.location.href = "/views/pages/login.php"; // Redirect to login after logout
            })
            .catch(error => console.error('Logout failed:', error));
        });
    }
}
