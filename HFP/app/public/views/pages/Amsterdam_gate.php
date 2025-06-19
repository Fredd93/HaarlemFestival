<?php
$activePage = 'history';
$detailId = 41; // Amsterdam gate id

require_once(__DIR__ . "/../../controllers/ContentController.php");

//Fetch content for this page and detail
$contentController = new ContentController();
$contentBlocks = $contentController->getContentForPage($activePage, $detailId);

$contentMap = [];
foreach ($contentBlocks as $block) {
    $contentMap[$block->content_type][] = $block;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://js.stripe.com/v3/"></script>
    <meta charset="UTF-8">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/historyDetail.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Amsterdam gate</title>
</head>
<body>
    <?php
    require_once(__DIR__ . "/../partials/navbar.php"); 
    ?>
<!-- could be done with css probably-->
<br>
<div class="pageTop flexbox">
    <section id="pageText">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-overlay">
            <div class="hero-content">
                <section>
                    <h1 class="hero-title"><?= htmlspecialchars($contentMap["hero"][0]->title ?? "A stroll through history") ?></h1>
                    <h2 class="hero-subtitle"><?= htmlspecialchars(strip_tags($contentMap["hero"][0]->description ?? "test")) ?></h2>
                </section>
            </div>
        </div>
    </div>
        <div class="about-container">
            <?= html_entity_decode($contentMap["about"][0]->description ?? "") ?>
        </div>
    </section>
    <section id="sideImages">
        <div class="detailImage">
            <?php if (!empty($contentMap["slideshow-image"][0]->image_url)): ?>
                <img src="<?= $contentMap["slideshow-image"][0]->image_url ?>" alt="location on map">
                <?= html_entity_decode($contentMap["slideshow-image"][0]->description ?? "") ?>
            <?php endif; ?>
        </div>
        <br>
    </section>
</div>
<div class="pageBottom">
    <section id="bottomImages" class="flexbox">
        <div class="detailImage">
            <?php if (!empty($contentMap["slideshow-image"][2]->image_url)): ?>
                <img src="<?= $contentMap["slideshow-image"][2]->image_url ?>" alt="painting of location">
                <?= html_entity_decode($contentMap["slideshow-image"][2]->description ?? "") ?>
            <?php endif; ?>
        </div>
        <div class="detailImage">
            <?php if (!empty($contentMap["slideshow-image"][3]->image_url)): ?>
                <img src="<?= $contentMap["slideshow-image"][3]->image_url ?>" alt="cannonball in church">
                <?= html_entity_decode($contentMap["slideshow-image"][3]->description ?? "") ?>
            <?php endif; ?>
        </div>
        <div class="detailImage">
            <?php if (!empty($contentMap["slideshow-image"][1]->image_url)): ?>
                <img src="<?= $contentMap["slideshow-image"][1]->image_url ?>" alt="location at night">
                <?= html_entity_decode($contentMap["slideshow-image"][1]->description ?? "") ?>
            <?php endif; ?>
        </div>
    </section>
    <section id="ticketButton" class="flexbox flexCentered">
        <div class="ticketButton flexCentered">Buy tickets</div>
    </section>
</div>
<div class="none"><?php require(__DIR__ . "/../partials/footer.php"); ?></div>

<script src="../../assets/js/personalProgram.js"></script>
</body>
<footer>
</footer>
</html>
