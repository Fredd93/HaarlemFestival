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
    $activePage = 'teylers';
    $detailId = 42;
    require_once(__DIR__ . "/../partials/navbar.php");
    //Fetch content for this page and detail
    $contentController = new ContentController();
    $contentBlocks = $contentController->getContentForPage($activePage, $detailId);

    $contentMap = [];
    foreach ($contentBlocks as $block) {
        $contentMap[$block->content_type][] = $block;
    }

    ?>
    <div class="banner-image">
    <?php if (!empty($contentMap["hero"][0]->image_url)): ?>
        <img src="<?= $contentMap["hero"][0]->image_url ?>" alt="teylers museum interior" class="banner-img">
    <?php endif; ?>
</div>
    <h1 class="teyler-title"><?php echo($contentMap["hero"][0]->title)?></h1>
    <p class="teyler-text">
        <?php echo strip_tags($contentMap["hero"][0]->description, '<strong><em><br><a>'); ?>
    </p>
    <div class="teyler-detail-container">
        <div class="teyler-detail-top">
            <h2><?php echo($contentMap["card"][0]->title)?></h2>
            <p><?php echo($contentMap["card"][0]->description)?>.</p>
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