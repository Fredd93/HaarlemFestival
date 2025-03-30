<?php
$activePage = 'yummy';
$detailId = 1; // Café de Roemer detail ID

require_once(__DIR__ . "/../partials/navbar.php");
require_once(__DIR__ . "/../../controllers/ContentController.php");

// Fetch content for this page and detail
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
    <meta charset="UTF-8">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/roemerStyles.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

<!-- Hero Section -->
<div class="hero-section">
    <div class="hero-overlay">
        <div class="hero-content">
            <h1 class="hero-title"><?= htmlspecialchars($contentMap["hero"][0]->title ?? "Café de Roemer") ?></h1>
            <p class="hero-subtitle"><?= htmlspecialchars(strip_tags($contentMap["hero"][0]->description ?? "Cozy Dutch Dining")) ?></p>
            <a href="#form" class="hero-btn">Make Reservation</a>
        </div>
    </div>
</div>

<!-- About Section -->
<section id="about-ratatouille" class="about-ratatouille">
    <div class="about-container">
        <div class="about-text">
            <h2><?= htmlspecialchars($contentMap["about"][0]->title ?? "About Café de Roemer") ?></h2>
            <?= html_entity_decode($contentMap["about"][0]->description ?? "") ?>
        </div>
        <div class="about-image">
            <?php if (!empty($contentMap["about"][0]->image_url)): ?>
                <img src="<?= $contentMap["about"][0]->image_url ?>" alt="Café de Roemer">
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Glimpse Section -->
<section class="cafe-glimpse">
    <h2>A Glimpse of Café de Roemer</h2>
    <div class="glimpse-container">
        <?php foreach ($contentMap["slider"] ?? [] as $block): ?>
            <div class="glimpse-item">
                <img src="<?= $block->image_url ?>" alt="<?= htmlspecialchars($block->title) ?>">
                <p><?= htmlspecialchars(strip_tags($block->description)) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Dining Sessions -->
<section class="dining-sessions">
    <h2><?= htmlspecialchars($contentMap["schedule"][0]->title ?? "Dining Sessions") ?></h2>
    <p><?= html_entity_decode($contentMap["schedule"][0]->description ?? "") ?></p>
</section>

<!-- Reservation Form -->
<section id="form" class="reservation-section">
    <div class="reservation-container">
        <div class="reservation-form">
            <h2>Reserve Your Table</h2>
            <form>
                <label for="name">Name *</label>
                <input type="text" id="name" placeholder="Type here" required>
                <div class="form-group">
                    <div class="date-field">
                        <label for="date">Date and Session *</label>
                        <input type="date" id="date" required>
                    </div>
                    <div class="session-field">
                        <label for="session">&nbsp;</label>
                        <select id="session" required>
                            <option value="">Session</option>
                            <option value="18:00">18:00</option>
                            <option value="19:30">19:30</option>
                            <option value="21:00">21:00</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="people-field">
                        <label for="adults">Adults *</label>
                        <select id="adults" required>
                            <option value="">Adults</option>
                            <option value="1">1</option><option value="2">2</option>
                            <option value="3">3</option><option value="4">4</option><option value="5+">5+</option>
                        </select>
                    </div>
                    <div class="people-field">
                        <label for="children">&nbsp;</label>
                        <select id="children">
                            <option value="">Children</option>
                            <option value="0">0</option><option value="1">1</option>
                            <option value="2">2</option><option value="3">3</option><option value="4+">4+</option>
                        </select>
                    </div>
                </div>
                <label for="requests">Special Requests</label>
                <textarea id="requests" placeholder="Type here"></textarea>
                <button type="submit" class="reservation-btn">Add To Program</button>
            </form>
        </div>
        <div class="reservation-image">
            <img src="../../assets/images/yummy/roemerformimage.png" alt="Café de Roemer">
        </div>
    </div>
</section>

<!-- Contact Info -->
<?php
$rawDescription = html_entity_decode($contentMap["contact"][0]->description ?? "");
$contactLines = explode("<br>", $rawDescription);
?>

<section class="contact-section">
    <div class="contact-container">
        <h2>Contact Info</h2>
        <div class="contact-info">
            <?php foreach ($contactLines as $line): ?>
                <?php $line = trim($line); ?>
                <?php if (empty($line)) continue; ?>

                <?php if (strpos($line, "@") !== false): ?>
                    <div class="contact-item"><i class="fas fa-envelope"></i><p><a href="mailto:<?= $line ?>"><?= $line ?></a></p></div>
                <?php elseif (strpos($line, "http") !== false): ?>
                    <div class="contact-item"><i class="fas fa-globe"></i><p><a href="<?= $line ?>"><?= $line ?></a></p></div>
                <?php elseif (preg_match("/^\+?\d+/", $line)): ?>
                    <div class="contact-item"><i class="fas fa-phone-alt"></i><p><?= $line ?></p></div>
                <?php else: ?>
                    <div class="contact-item"><i class="fas fa-map-marker-alt"></i><p><?= $line ?></p></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<div class="none"><?php require(__DIR__ . "/../partials/footer.php"); ?></div>

<script src="../../assets/js/ratatouille.js"></script>
<script src="../../assets/js/personalProgram.js"></script>
</body>
<footer>
<?php include(__DIR__ . "/../partials/personalProgram.php"); ?>
</footer>
</html>
