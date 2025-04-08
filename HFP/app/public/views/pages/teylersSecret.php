<head>
    <meta charset="UTF-8">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/teylerStyle.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>
<?php
    $activePage = 'teyler';
    require_once(__DIR__ . "/../partials/navbar.php");
    ?>
    <div class="banner-image">
        <img class="banner-image" src="../../assets/images/teyler/lorentz-top.jpeg" alt="Front view of the Teylers museum seen from the water.">
    </div>
    <h1 class="teyler-title">The Secret of Professor Teyler</h1>
    <p class = "teyler-text">Through this interactive experience, children aged 4 to 8 will explore the wonders of science with six exciting, hands-on activities designed to spark curiosity, creativity, and a love for learning.</p>
    <div class="teyler-detail-container">
        <div class="teyler-detail-top">
            <h2>Science for the youngest</h2>
            <p>In six tasks children will learn various facts about the world around them</p>
            <p>Participants of The Secret of Professor Teyler need to download the app, buy tickets at the Teylers Museum, no additional cost for participation in Magic@Teylers.</p>
        </div>
        <div class="teyler-detail-times-container">
            <div class = "teyler-detail-bottom">Friday 10:00-17:00</div>
            <div class = "teyler-detail-bottom">Saturday 10:00-17:00</div>
            <div class = "teyler-detail-bottom">Sunday 10:00-17:00</div>
        </div>
        <div style="display:flex; justify-content:center">
        <img class="teyler-mobile-only" style="max-width:70%; min-width:70%" src="../../assets/images/teyler/secret-download.png" alt="Front view of the Teylers museum seen from the water.">
        </div>
    </div>
    <?php
    require_once(__DIR__ . "/../partials/footer.php");
    ?>
</body>