
<head>
    <meta charset="UTF-8">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/historyStyle.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
    <title>A stroll through history</title>
</head>
<body>
    <?php
        $activePage = 'history';
        require_once(__DIR__ . "/../partials/navbar.php");
        require_once(__DIR__ . "/../../controllers/ContentController.php");

        //Fetch content for this page and detail
        $contentController = new ContentController();
        $contentBlocks = $contentController->getContentForPage($activePage, null);

        $contentMap = [];
        foreach ($contentBlocks as $block) {
            $contentMap[$block->content_type][] = $block;
        }
    ?>
    <!-- About History Section -->
    <div  class="about-history-section">
        <div class="hero-section">
            <div class="hero-overlay">
                <div class="hero-content">
                        <h1 class="hero-title"><?= htmlspecialchars($contentMap["hero"][0]->title ?? "A stroll through history") ?></h1>
                </div>
            </div>
        </div>
        <div class="about-text">
            <?= html_entity_decode($contentMap["about"][0]->description ?? "") ?>
        </div>
    </div>
    <!-- The following 2 are partials, and thus can't be edited through the CMS -->
    <?= html_entity_decode($contentMap["scheduleText"][0]->description ?? "") ?>
    <?php require_once(__DIR__ . "/../partials/historySchedule.php"); ?>

    <?= html_entity_decode($contentMap["mapText"][0]->description ?? "") ?>
    <img class="tourMap" src="assets/images/history/tourMap.png" alt="Tour map" width="941" height="554">

    <?= html_entity_decode($contentMap["locationText"][0]->description ?? "") ?>
    <div class="locationContainer" id="locationContainer">
    </div>
    <?php
        require(__DIR__ . "/../partials/footer.php");
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            FetchLocations();
            //Load the location cards
        });
    </script>
</body>
</html>
