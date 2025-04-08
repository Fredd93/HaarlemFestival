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
        <img class="banner-image" src="../../assets/images/teyler/lorentz-top.jpeg" alt="Front view of the Teylers museum seen from the water.">
    </div>
    <h1 class="teyler-title">The Lorentz Formula</h1>
    <p class = "teyler-text">In this fun show for those 10 and up you will be shown a small glimpse into the life of Lorentz.</p>
    <div class="teyler-detail-container">
        <div class="teyler-detail-top">
            <h2>A fun experience for all</h2>
            <p>In six tasks children will learn various facts about the world around them</p>
            <p>For The Lorentz Formula register at the museum, you can sign up to participate. There is room for 20 people at a time. The performance is suitable for anyone ages 10 and up.</p>
        </div>
        <div class="teyler-detail-times-container">
            <?php
            $days = ["Friday", "Saturday", "Sunday"];
            $times = ["12:30 - 13:20", "14:00 - 14:50", "15:00 - 15:50"];
            foreach ($days as $day){?>
                <div class = "teyler-detail-time-column">
                    <h2><?php echo "$day"?></h2>
                    <?php foreach ($times as $time) {
                        ?><p><?php echo "$time"?></p><?php
                    }?>
                    </div>
                    <?php
                }
            ?>
            
        </div>
    </div>
    <?php
    require_once(__DIR__ . "/../partials/footer.php");
    ?>
</body>