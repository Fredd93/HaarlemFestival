<?php


// Convert content into an associative array for easy access
$contentMap = [];
foreach ($homepageContent as $content) {
    $contentMap[$content->content_type] = $content;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/homepageStyle.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://js.stripe.com/v3/"></script>
    <title><?= $contentMap["hero"]->title ?? "" ?></title>
</head>
<body>

    <?php
        $activePage = 'home';
        require_once(__DIR__ . "/../partials/navbar.php");
    ?>

    <!-- HERO SECTION (Dynamic) -->
    <div class="hero-section">
        <section class="hero-banner">
            <div class="hero-content">
                <h1><?= $contentMap["hero"]->title ?? "" ?></h1>
                <p><?= html_entity_decode($contentMap["hero"]->description ?? "") ?></p>
                <a href="tickets.php" class="hero-btn">Book now</a>
            </div>
        </section>
    </div>

    <!-- FESTIVAL INFO SECTION (Dynamic) -->
    <div class="festival-info-section">
        <div class="text-content">
            <h2><?= $contentMap["festival-info"]->title ?? "" ?></h2>
            <p><?= html_entity_decode($contentMap["festival-info"]->description ?? "") ?></p>
        </div>

        <!-- SLIDESHOW IMAGES (Dynamic) -->
        <div class="slideshow-wrapper">
            <div class="slideshow-container">
                <?php 
                if (isset($contentMap["slideshow-image"])): 
                    $images = explode(",", $contentMap["slideshow-image"]->image_url);
                    foreach ($images as $imgUrl):
                ?>
                    <div class="slideshow fade">
                        <img src="<?= trim($imgUrl) ?>" alt="Festival Image">
                    </div>
                <?php endforeach; endif; ?>
            </div>
        </div>
    </div>
    <div class="event-carousel">
        <button class="prev-event">&#10094;</button>
        <div class="event-container" id="event-container">
            <!-- Event cards will be dynamically inserted here -->
        </div>
        <button class="next-event">&#10095;</button>
        </div>
    </div>

    <!-- FESTIVAL HIGHLIGHT SECTION (Dynamic) -->
    <div class="festival-highlight">
        <div class="highlight-image">
            <img id="highlight-image" src="<?= $contentMap["festival-highlight"]->image_url ?? '' ?>" alt="Festival Highlight">
        </div>
        <div class="highlight-text">
            <h2><?= $contentMap["festival-highlight"]->title ?? "" ?></h2>
            <p><?= html_entity_decode($contentMap["festival-highlight"]->description ?? "") ?></p>
        </div>
    </div>

    <!-- MAP SECTION (Static for now, can be dynamic if needed) -->
    <div class="map-section">
        <h2>Find Us Around Haarlem</h2>
        <div class="map-container">
            <div id="festival-map"></div>
        </div>
    </div>

    <!-- FOOTER SECTION (Static for now) -->
    <div class="footer-section">
        <h2>Don’t miss out on The Haarlem Festival!</h2>
        <div class="footer-buttons">
            <a href="tickets.php" class="footer-btn">Get Tickets Now</a>
            <a href="schedule.php" class="footer-btn">View Full Schedule</a>
        </div>
    </div>

    <script src="../../assets/js/homePage.js"></script>
    <script src="../../assets/js/maps.js"></script>

    <?php require(__DIR__ . "/../partials/footer.php"); ?>

</body>
<footer>
</footer>
</html>
