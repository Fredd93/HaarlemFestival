<?php

$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>

<nav class="navbar">
    <div class="logo">
        <a href="index.php"><img src="../../assets/images/global/Website_logo.jpeg" alt="Haarlem Festival"></a>
    </div>
    <ul class="nav-links">
        <li><a href="index.php" class="<?= ($activePage === 'index') ? 'active' : '' ?>">Home</a></li>
        <li class="dropdown">
            <a href="#" class="<?= in_array($activePage, ['yummy', 'jazz', 'dance', 'history', 'teylers']) ? 'active' : '' ?>">Events ▾</a>
            <ul class="dropdown-menu">
                <li><a href="yummy.php" class="<?= ($activePage === 'yummy') ? 'active' : '' ?>">Yummy</a></li>
                <li><a href="jazz.php" class="<?= ($activePage === 'jazz') ? 'active' : '' ?>">Jazz</a></li>
                <li><a href="dance.php" class="<?= ($activePage === 'dance') ? 'active' : '' ?>">DANCE</a></li>
                <li><a href="history.php" class="<?= ($activePage === 'history') ? 'active' : '' ?>">History</a></li>
                <li><a href="teylers.php" class="<?= ($activePage === 'teylers') ? 'active' : '' ?>">Teyler's</a></li>
            </ul>
        </li>
        <li><a href="tickets.php" class="<?= ($activePage === 'tickets') ? 'active' : '' ?>">Tickets</a></li>
        <li><a href="program.php" class="<?= ($activePage === 'program') ? 'active' : '' ?>">My Program</a></li>
    </ul>
</nav>
