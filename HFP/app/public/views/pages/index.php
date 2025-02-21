<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/homepageStyle.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $activePage = 'index';
    require(__DIR__ . "/../partials/navbar.php");
    ?>
    <div class="hero-section">
        <section class="hero-banner">
            <div class="hero-content">
                <h1>Haarlem Festival</h1>
                <p>Experience Haarlem Like Never Before</p>
                <a href="tickets.php" class="hero-btn">Book now</a>
            </div>
        </section>
    </div>
    <div class="festival-info-section">
    <div class="text-content">
        <h2>What is the Haarlem Festival?</h2>
        <p>
            The Haarlem Festival is a unique celebration of culture, food, and history, 
            showcasing Haarlem as a vibrant cultural hub. Spanning four unforgettable days, 
            the festival offers diverse events designed to delight visitors of all ages and backgrounds.
        </p>
    </div>
    <div class="slideshow-wrapper">
        <div class="slideshow-container">
            <div class="slideshow fade">
                <img src="../../assets/images/homepage/banner image 1.png" alt="Festival Crowd">
            </div>
            <div class="slideshow fade">
                <img src="../../assets/images/homepage/banner image2.jpeg" alt="Live Performance">
            </div>
            <div class="slideshow fade">
                <img src="../../assets/images/homepage/banner imag 3.jpeg" alt="Food Stalls">
            </div>
        </div>
    </div>
</div>
    <div class="events-section">
    <h2>Explore Our Events</h2>
    
    <div class="event-carousel">
        <button class="prev-event">&#10094;</button>
        <div class="event-container" id="event-container">
            <!-- Event cards will be dynamically inserted here -->
        </div>
        <button class="next-event">&#10095;</button>
        </div>
    </div>
    <div class="festival-highlight">
    <div class="highlight-image">
        <img src="../../assets/images/homepage/2ndBannerimage.png" alt="Haarlem Festival">
    </div>
    <div class="highlight-text">
        <h2>Why You’ll Love the Haarlem Festival?</h2>
        <p><strong>Cultural Diversity:</strong> Representing Haarlem’s rich history and global appeal.</p>
        <p><strong>Exclusive Dining Experiences:</strong> Yummy! features top restaurants with special menus.</p>
        <p><strong>World-Class Performances:</strong> Jazz and Dance events feature top talent.</p>
    </div>
</div>
<div class="map-section">
    <h2>Find Us Around Haarlem</h2>
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

<div class="footer-section">
    <h2>Don’t miss out on The Haarlem Festival!</h2>
    <div class="footer-buttons">
        <a href="tickets.php" class="footer-btn">Get Tickets Now</a>
        <a href="schedule.php" class="footer-btn">View Full Schedule</a>
    </div>
</div>
    <script src="assets/js/homePage.js"></script>
    <script src="assets/js/maps.js"></script>
    <?php
        require(__DIR__ . "/../partials/footer.php");
    ?>
</body>
</html>


