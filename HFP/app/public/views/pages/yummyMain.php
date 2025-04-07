<?php
$activePage = 'yummy';
$detailId = 0; // Yummy main page content block ID
require_once(__DIR__ . "/../partials/navbar.php");

$contentMap = [];
foreach ($contentBlocks as $block) {
    $contentMap[$block->content_type][] = $block;
}
// Optional: sort slideshow images by content_id
if (isset($contentMap["slideshow-image"])) {
    usort($contentMap["slideshow-image"], fn($a, $b) => $a->content_id <=> $b->content_id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/navbarStyle.css">
    <link rel="stylesheet" href="/assets/css/yummyMainStyles.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1 class="hero-title"><?= htmlspecialchars($contentMap["hero"][0]->title ?? "YUMMY!") ?></h1>
            <p class="hero-subtitle"><?= htmlspecialchars(strip_tags($contentMap["hero"][0]->description ?? "EXPLORE HAARLEM’S CULINARY DELIGHTS")) ?></p>
            <a href="#about-yummy" class="hero-btn">Explore Restaurants</a>
        </div>
    </div>
</div>

<!-- About Yummy Section -->
<div class="about-yummy-section">
    <div class="about-content">
        <div class="about-text">
            <h2><?= htmlspecialchars($contentMap["festival-info"][0]->title ?? "About the Yummy! Experience") ?></h2>
            <?= html_entity_decode($contentMap["festival-info"][0]->description ?? "") ?>
        </div>
        <div class="about-image">
            <div class="slideshow-container">
                <?php foreach ($contentMap["slideshow-image"] ?? [] as $block): ?>
                    <img class="about-slide" src="<?= $block->image_url ?>" alt="<?= htmlspecialchars($block->title) ?>">
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Participating Restaurants -->
<div id="about-yummy" class="restaurant-section">
    <h2>Participating Restaurants</h2>
    <div class="filter-container">
        <button id="filter-btn" class="filter-button">Filter ▼</button>
        <div id="filter-dropdown" class="filter-dropdown"></div>
    </div>
    <div class="restaurant-container" id="restaurant-list"></div>
</div>

<!-- Map Section -->
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

<div class="none">
    <?php require(__DIR__ . "/../partials/footer.php"); ?>
</div>

<script src="/assets/js/yummyMain.js"></script>
<script src="/assets/js/maps.js"></script>
<script src="/assets/js/personalProgram.js"></script>
<script>
// Simple slideshow
let slideIndex = 0;
function showSlides() {
    const slides = document.querySelectorAll(".about-slide");
    slides.forEach(slide => slide.style.display = "none");
    slideIndex++;
    if (slideIndex > slides.length) slideIndex = 1;
    slides[slideIndex - 1].style.display = "block";
    setTimeout(showSlides, 3500);
}
document.addEventListener("DOMContentLoaded", showSlides);
</script>
</body>

<footer>
</footer>
</html>
