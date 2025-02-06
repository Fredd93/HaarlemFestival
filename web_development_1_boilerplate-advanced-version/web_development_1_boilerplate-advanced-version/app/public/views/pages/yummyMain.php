<?php
$activePage = 'yummy';
require_once(__DIR__ . "/../partials/navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/yummyMainStyles.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1 class="hero-title">YUMMY!</h1>
                <p class="hero-subtitle">EXPLORE HAARLEM’S CULINARY DELIGHTS</p>
                <a href="#about-yummy" class="hero-btn">Explore Restaurants</a>
            </div>
        </div>
    </div>

    <!-- About Yummy Section -->
    <div id="about-yummy" class="about-yummy-section">
        <div class="about-content">
            <div class="about-text">
                <h2>About the Yummy! Experience</h2>
                <p>From Thursday, July 24, to Sunday, July 27, 2025, Yummy! brings together Haarlem’s finest restaurants to offer you exclusive festival menus at reduced prices. Each participating restaurant offers a unique dining experience, from vegan delights to rooftop views and sustainable seafood.</p>
                <p>Secure your spot through our festival reservation system and enjoy a memorable evening filled with flavor and charm.</p>
                <p><strong>Dates:</strong> Thursday, July 24 – Sunday, July 27, 2025</p>
                <p class="reservation-text"><em>Reservations are mandatory and include a €10 fee per person, which will be deducted from your final bill.</em></p>
            </div>
            <div class="about-image">
                <div class="slideshow-container">
                    <img class="about-slide" src="../../assets/images/yummy/yummySlide1.png" alt="Restaurant 1">
                    <img class="about-slide" src="../../assets/images/yummy/yummySlide2.png" alt="Restaurant 2">
                    <img class="about-slide" src="../../assets/images/yummy/yummySlide3.png" alt="Restaurant 3">
                    <img class="about-slide" src="../../assets/images/yummy/yummySlide4.png" alt="Restaurant 4">
                </div>
            </div>
        </div>
    </div>

    <div class="restaurant-section">
        <h2>Participating Restaurants</h2>
        <div class="filter-container">
            <button id="filter-btn" class="filter-button">Filter ▼</button>
            <div id="filter-dropdown" class="filter-dropdown">
            <!-- Filter options will be populated dynamically -->
        </div>
    </div>
    <div class="restaurant-container" id="restaurant-list"></div>
</div>
    <div class="map-section">
            <h2>Find Your Way!</h2>
            <p>Explore our curated dining experiences across Haarlem. Click a location for more details.</p>
        <div class="map-container">
            <div id="festival-map"></div>
            <div class="map-legend">
                <h3>Legend</h3>
                <ul>
                    <li data-category="jazz">🎷 Jazz</li>
                    <li data-category="yummy">🍽 Yummy</li>
                    <li data-category="teylers">🏛 Teylers Museum</li>
                    <li data-category="history">🏰 A Stroll Through History</li>
                    <li data-category="dance">💃 Dance</li>
                </ul>
                <h4>Filter by</h4>
                <div class="filter-buttons">
                    <button data-filter="jazz">🎷</button>
                    <button data-filter="yummy">🍽</button>
                    <button data-filter="teylers">🏛</button>
                    <button data-filter="history">🏰</button>
                    <button data-filter="dance">💃</button>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="none">
        <?php
            require(__DIR__ . "/../partials/footer.php");
        ?>
    </div>

    
    

    <script src="../../assets/js/yummyMain.js"></script>
    <script src="../../assets/js/maps.js"></script>
    


</body>
</html>
