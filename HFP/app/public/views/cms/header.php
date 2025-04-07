<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/cms">Haarlem Festival CMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="/cms/events">Events</a></li>
                <li class="nav-item"><a class="nav-link" href="/cms/content">Content</a></li>
                <li class="nav-item"><a class="nav-link" href="/cms/users">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="/cms/orders">Orders</a></li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="#" onclick="logoutUser(event)">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
function logoutUser(event) {
    event.preventDefault();

    fetch("/api/user/logout", {
        method: "POST"
    })
    .then(res => {
        if (!res.ok) throw new Error("Logout failed");
        return res.json();
    })
    .then(() => {
        // Clear local storage (optional if you’re using it)
        localStorage.removeItem("user_id");
        localStorage.removeItem("role");

        // Redirect to login page
        window.location.href = "/login";
    })
    .catch(err => {
        alert("Logout failed. Please try again.");
        console.error(err);
    });
}
</script>


