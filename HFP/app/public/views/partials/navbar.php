<?php
$eventNames = [
    'yummy' => 'Yummy',
    'jazz' => 'Jazz',
    'dance' => 'Dance',
    'history' => 'History',
    'teylers' => "Teyler's"
];

$eventActive = in_array($activePage, array_keys($eventNames));
$eventLabel = $eventActive ? $eventNames[$activePage] : 'Events';
$isLoggedIn = isset($_SESSION['user_id']);
?>

<nav class="navbar">
    <div class="logo">
        <a href="/"><img src="../../assets/images/global/Website_logo.jpeg" alt="Haarlem Festival"></a>
    </div>

    <!-- Hamburger Menu Icon -->
    <div class="hamburger" id="hamburger">&#9776;</div>
    <div class="close-btn" id="closeBtn">&times;</div>

    <ul class="nav-links" id="navLinks">
        <li><a href="/" class="<?= ($activePage === 'index') ? 'active' : '' ?>">Home</a></li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle <?= $eventActive ? 'active' : '' ?>" id="eventsDropdown"><?= $eventLabel ?> ▾</a>
            <ul class="dropdown-menu" id="eventsDropdownMenu">
                <li><a href="/yummy" class="<?= ($activePage === 'yummy') ? 'active' : '' ?>">Yummy</a></li>
                <li><a href="/jazz" class="<?= ($activePage === 'jazz') ? 'active' : '' ?>">Jazz</a></li>
                <li><a href="/dance" class="<?= ($activePage === 'dance') ? 'active' : '' ?>">Dance</a></li>
                <li><a href="/history" class="<?= ($activePage === 'history') ? 'active' : '' ?>">History</a></li>
                <li><a href="/teylers" class="<?= ($activePage === 'teylers') ? 'active' : '' ?>">Teyler's</a></li>
            </ul>
        </li>
        <li><a href="ticketing" class="<?= ($activePage === 'tickets') ? 'active' : '' ?>">Tickets</a></li>
        <li><a href="program" class="<?= ($activePage === 'program') ? 'active' : '' ?>">My Program</a></li>
        <li>
            <a href="<?= $isLoggedIn ? '#' : 'login' ?>" 
               id="auth-button" 
               class="<?= ($activePage === 'login') ? 'active' : '' ?>"
               onclick="<?= $isLoggedIn ? 'logoutUser(event)' : '' ?>">
               <?= $isLoggedIn ? 'Logout' : 'Login' ?>
            </a>
        </li>
        <li>
            <div class="nav-right">
                <?php include(__DIR__ . "/personalProgram.php"); ?>
            </div>
        </li>
    </ul>
</nav>

<script>
function logoutUser(event) {
    event.preventDefault();
    fetch('/api/user/logout', { method: 'POST' })
        .then(response => {
            if (!response.ok) throw new Error("Logout failed");
            return response.text();
        })
        .then(() => window.location.href = "/")
        .catch(error => alert("Logout failed."));
}

document.getElementById("hamburger").addEventListener("click", function () {
    document.getElementById("navLinks").classList.add("open");
    document.getElementById("closeBtn").style.display = "block";
    this.style.display = "none";
});

document.getElementById("closeBtn").addEventListener("click", function () {
    document.getElementById("navLinks").classList.remove("open");
    this.style.display = "none";
    document.getElementById("hamburger").style.display = "block";
});


document.getElementById("eventsDropdown").addEventListener("click", function (e) {
    e.preventDefault(); // Prevent page jump
    const menu = document.getElementById("eventsDropdownMenu");
    menu.style.display = menu.style.display === "flex" ? "none" : "flex";
});


</script>
