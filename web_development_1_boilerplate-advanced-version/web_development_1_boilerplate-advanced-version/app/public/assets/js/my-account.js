document.addEventListener("DOMContentLoaded", function () {
    fetchUserData();
    setupLogout();
});

function fetchUserData() {
    fetch('/api/user/me', {
        method: 'GET',
        credentials: 'include', // Ensures session cookies are sent
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('User not logged in');
        }
        return response.json();
    })
    .then(data => {
        document.getElementById("username").textContent = data.username;
        document.getElementById("user-username").textContent = data.username;
        document.getElementById("user-email").textContent = data.email;
        document.getElementById("user-role").textContent = data.role;
        document.getElementById("user-registration").textContent = data.registration_date;
    })
    .catch(error => {
        console.error('Error:', error);
        window.location.href = "/views/pages/login.php"; // Redirect to login if not authenticated
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
