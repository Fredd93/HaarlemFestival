<?php
$activePage = 'dance';
require_once(__DIR__ . "/../partials/navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dance | Haarlem Festival</title>
    <link rel="stylesheet" href="../../assets/css/danceMainStyle.css">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="video-container">
        <video autoplay muted loop class="video-frame">
            <source src="../../assets/images/dance/cover-video.mp4" type="video/mp4">
        </video>
        <img src="../../assets/images/dance/logo.png" alt="Dance Logo" class="logo-overlay">
    </div>
    <div class="header-container">
        <h1 class="header1">Welcome to DANCE!</h1>
        <h1 class="header1">The Ultimate Celebration Of</h1>
        <h1 class="header1">Music and Movement</h1>
        <h2 class="header2"><br>Spotlight on the Artists of DANCE!</h2>
    </div>
    <div class="artists-container">
        <div id="artist-cards-container" class="artist-cards"></div>
    </div>

    <h2 class="header3"> Catch Them Live at the DANCE! Event</h2>

    <h2 class="header3">SCHEDULES: Friday  25th July, Saturday 26th July and Sunday 27th July </h2>

    <div>
        <div class="table-container">
        <div class="tabs">
            <button class="tab-button active" data-day="FRIDAY">FRIDAY</button>
            <button class="tab-button" data-day="SATURDAY">SATURDAY</button>
            <button class="tab-button" data-day="SUNDAY">SUNDAY</button>
            <button class="tab-button" data-day="ALL ACCESS PASSES">ALL ACCESS PASSES</button>
        </div>

        <table id="event-table">
            <thead>
                <tr>
                    <th>TIME</th>
                    <th>VENUE</th>
                    <th>ARTIST(S)</th>
                    <th>SESSION TYPE</th>
                    <th>DURATION</th>
                    <th>PRICE</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script src="../../assets/js/dance.js"></script>
    <script src="../../assets/js/personalProgram.js"></script>
    <footer>
    <?php include(__DIR__ . "/../partials/personalProgram.php"); ?>

    </footer>
</body>
</html>
<?php
require_once(__DIR__ . "/../partials/footer.php");
?>
