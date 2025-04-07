document.getElementById("registerForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value;

    const response = await fetch("/api/user/register", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ username, email, password })
    });

    const result = await response.json();
    const messageEl = document.getElementById("registerMessage");

    if (response.ok) {
        messageEl.style.color = "green";
        messageEl.textContent = "Account created! Redirecting...";
        setTimeout(() => {
            window.location.href = "/login";
        }, 1500);
    } else {
        messageEl.style.color = "red";
        messageEl.textContent = result.message || "Registration failed.";
    }
});
