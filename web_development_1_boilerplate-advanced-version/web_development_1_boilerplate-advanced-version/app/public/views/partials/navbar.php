<?php

// Define event names mapping
$eventNames = [
    'yummy' => 'Yummy',
    'jazz' => 'Jazz',
    'dance' => 'Dance',
    'history' => 'History',
    'teylers' => "Teyler's"
];

// Determine if we should replace "Events" with an active event name
$eventActive = in_array($activePage, array_keys($eventNames));
$eventLabel = $eventActive ? $eventNames[$activePage] : 'Events';

?>

<nav class="navbar">
    <div class="logo">
        <a href="/"><img src="../../assets/images/global/Website_logo.jpeg" alt="Haarlem Festival"></a>
    </div>
    <ul class="nav-links">
        <li><a href="/" class="<?= ($activePage === 'index') ? 'active' : '' ?>">Home</a></li>

        <!-- Events Dropdown -->
        <li class="dropdown">
            <a href="#" class="<?= $eventActive ? 'active' : '' ?>"><?= $eventLabel ?> ▾</a>
            <ul class="dropdown-menu">
                <li><a href="yummy" class="<?= ($activePage === 'yummy') ? 'active' : '' ?>">Yummy</a></li>
                <li><a href="jazz.php" class="<?= ($activePage === 'jazz') ? 'active' : '' ?>">Jazz</a></li>
                <li><a href="dance.php" class="<?= ($activePage === 'dance') ? 'active' : '' ?>">Dance</a></li>
                <li><a href="history" class="<?= ($activePage === 'history') ? 'active' : '' ?>">History</a></li>
                <li><a href="teylers.php" class="<?= ($activePage === 'teylers') ? 'active' : '' ?>">Teyler's</a></li>
            </ul>
        </li>

        <li><a href="tickets.php" class="<?= ($activePage === 'tickets') ? 'active' : '' ?>">Tickets</a></li>
        <li><a href="program.php" class="<?= ($activePage === 'program') ? 'active' : '' ?>">My Program</a></li>
        <li>
        <div class="nav-right">
            <?php include(__DIR__ . "/personalProgram.php"); ?> <!-- 🔹 Now inside Navbar -->
        </div>
        </li>
    </ul>

    <!-- Personal Program Button -->
    
</nav>
