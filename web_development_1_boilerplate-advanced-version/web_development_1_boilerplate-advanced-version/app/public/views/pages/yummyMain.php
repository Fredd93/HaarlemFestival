<?php
$activePage = 'yummy';
require_once(__DIR__ . "/../partials/navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/yummyMainStyles.css">
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
        <div class="restaurant-container" id="restaurant-list">
        </div>
    </div>
    

    <script src="../../assets/js/yummyMain.js"></script>
</body>
</html>
