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
        <img class="banner-image" src="../../assets/images/teyler/main-top.jpeg" alt="Front view of the Teylers museum seen from the water.">
    </div>
    <h1 class="teyler-title">Magic at Teylers</h1>
    <p class = "teyler-text">During the festival Teylers Museum welcomes you for two exciting events; The Secret of Professor Teyler and The Lorentz Formula. Together these will create a fun experience for young and old.</p>
    <div class="teyler-card-container">
        
        <div class = "teyler-card-desktop teyler-desktop-only">
            <div class = "teyler-card-desktop-division">
                <div style = "width: 100%; position: relative;">
                    <h2 class="teyler-text">The Secret of Professor Teyler</h2>
                    <p class="teyler-text">In this interactive experience children from age 4 to 8 will meet with the world of science in 6 exciting science based exercises.</p>
                    <button class = "teyler-card-desktop-button" onclick="window.location.href='/teylers/secret';">Discover Teylers Secret</button>
                </div>
                <img class="teyler-card-desktop-image" src="../../assets/images/teyler/secret-detail.jpeg" alt="Front view of the Teylers museum seen from the water.">
            </div>
        </div>

        <div class = "teyler-card-desktop teyler-desktop-only">
            <div class = "teyler-card-desktop-division">
                <div style = "width: 100%; position: relative;">
                    <h2 class="teyler-text">The Lorentz Formula</h2>
                    <p class="teyler-text">An exciting performance for audiences aged 10 and older by Toneelschuur Producties transports you to the early 20th century, immersing you in the fascinating world of Nobel Prize-winning physicist Hendrik Antoon Lorentz and his groundbreaking workshop.</p>
                    <button class = "teyler-card-desktop-button" onclick="window.location.href='/teylers/lorentz';">Discover The Lorentz Formula</button>
                </div>
                <img class="teyler-card-desktop-image" src="../../assets/images/teyler/lorentz-detail.jpg" alt="Front view of the Teylers museum seen from the water.">
            </div>
        </div>
            
        <div class = "teyler-card-mobile teyler-mobile-only" style = "position: relative; overflow: hidden;">
            <div style="z-index:2; display:flex; flex-direction: column; align-items: center;">
                <h2 class="teyler-text" style = "text-align: center;">The Secret of Professor Teyler</h2>
                <p style = "font-size:1.3em; text-align: center;">In this interactive experience children from age 4 to 8 will meet with the world of science in 6 exciting science based exercises.</p>
                <button class = "teyler-card-mobile-button" onclick="window.location.href='/teylers/secret';">Discover Teylers Secret</button>
            </div> 
            <img class="teyler-card-mobile-image" src="../../assets/images/teyler/secret-detail.jpeg" alt="Front view of the Teylers museum seen from the water.">
            <div class="teyler-card-mobile-overlay"></div>
        </div>
        <div class = "teyler-card-mobile teyler-mobile-only" style = "position: relative; overflow: hidden;">
            <div style="z-index:2; display:flex; flex-direction: column; align-items: center;">
                <h2 class="teyler-text" style = "text-align: center;">The Lorentz Formula</h2>
                <p style = "font-size:1.3em; text-align: center;">An exciting performance for those aged 10 and older transports you to the early 20th century to the workshop of Nobel Prize-winner Hendrik Antoon Lorentz.</p>
                <button class = "teyler-card-mobile-button" onclick="window.location.href='/teylers/lorentz';">Discover The Lorentz Formula</button>
            </div> 
            <img class="teyler-card-mobile-image" src="../../assets/images/teyler/lorentz-detail.jpg" alt="Front view of the Teylers museum seen from the water.">
            <div class="teyler-card-mobile-overlay"></div>
        </div>
    </div>
    <?php
    require_once(__DIR__ . "/../partials/footer.php");
    ?>
</body>