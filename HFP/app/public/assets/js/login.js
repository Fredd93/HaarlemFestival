document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;

    const response = await fetch("/api/user/login", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ username, password })
    });

    const result = await response.json();
    const messageEl = document.getElementById("loginMessage");

    if (response.ok) {
        messageEl.style.color = "green";
        messageEl.textContent = "Login successful!";
    
        // Save user info
        localStorage.setItem("user_id", result.user_id);
        localStorage.setItem("role", result.role);
    
        // Redirect based on role
        setTimeout(() => {
            if (result.role === "admin") {
                window.location.href = "/cms";
            } else if (result.role === "employee") {
                window.location.href = "/scan"; 
            } else {
                window.location.href = "/";
            }
        }, 1000);    
    } else {
        messageEl.style.color = "red";
        messageEl.textContent = result.message || "Login failed.";
    }
});
