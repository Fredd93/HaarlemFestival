
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
</head>
<body>
    <?php
    $activePage = 'history';
    require_once(__DIR__ . "/../partials/navbar.php");
    ?>
    <!-- About History Section -->
    <div  class="about-history-section">
        <div class="about-text">
            <h1>A Stroll through History</h1>
            <h2>General information</h2>
            <p>A Stroll through History is a 2.5 hour long walking event where you discover and learn about important landmarks of Haarlems history, from churches to courts, together with 11 others.As this stroll is of an historic nature, participants have to be of ages 12 or up and no strollers are allowed during the stroll. The stroll will visit 9 historical landmarks and a has a break after the 5th location, the Jopenkerk. During the break there will be 1 free drink per participant.</p>
            <h3>Pricing</h3>
            <p>Tickets for a Stroll through History are sold as personal ticket or as a family ticket. <br>• Regular Participant: € 17,50  <br>• Family ticket (max. 4 participants): € 60,-</p>
        </div>
    </div>
    <h2>Schedule</h2>
    <div class="schedule-area">
        <div>
            <h2>Thursday</h2>
            <div class="schedule-item-collection">
                <?php 
                $tourTime = "10:00"; $dutchTours = 1; $englishTours = 1; $chineseTours = 0;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
                                <?php 
                $tourTime = "13:00"; $dutchTours = 1; $englishTours = 1; $chineseTours = 0;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
                                <?php 
                $tourTime = "16:00"; $dutchTours = 1; $englishTours = 1; $chineseTours = 0;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
            </div>
        </div>
        <div>
            <h2>Friday</h2>
            <div class="schedule-item-collection">
            <?php 
                $tourTime = "10:00"; $dutchTours = 1; $englishTours = 1; $chineseTours = 0;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
                                <?php 
                $tourTime = "13:00"; $dutchTours = 1; $englishTours = 1; $chineseTours = 1;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
                                <?php 
                $tourTime = "16:00"; $dutchTours = 1; $englishTours = 1; $chineseTours = 0;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
            </div>
        </div>
        <div>
            <h2>Saturday</h2>
            <div class="schedule-item-collection">
            <?php 
                $tourTime = "10:00"; $dutchTours = 2; $englishTours = 2; $chineseTours = 0;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
                                <?php 
                $tourTime = "13:00"; $dutchTours = 2; $englishTours = 2; $chineseTours = 1;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
                                <?php 
                $tourTime = "16:00"; $dutchTours = 1; $englishTours = 1; $chineseTours = 1;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
            </div>
        </div>
        <div>
            <h2>Sunday</h2>
            <div class="schedule-item-collection">
                <?php 
                $tourTime = "10:00"; $dutchTours = 2; $englishTours = 2; $chineseTours = 1;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
                <?php 
                $tourTime = "13:00"; $dutchTours = 3; $englishTours = 3; $chineseTours = 2;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
                <?php 
                $tourTime = "16:00"; $dutchTours = 1; $englishTours = 1; $chineseTours = 0;
                require(__DIR__ . "/../partials/historyScheduleCard.php"); ?>
            </div>
        </div>
    </div>
    <img class="tourMap" src="assets/images/history/tourMap.png" alt="Tour map" width="941" height="554">
    <h2>The locations that are visited</h2>
    <div class="locationContainer">
        <?php $direction = "left"; $locationName = "Church of St.Bavo"; $locationImage = "bavoKerkImage.png"; 
        $locationDescription = "The church of St.Bavo is a major landmark in the middle of the old center of Haarlem build around 1370-1520 after the previous church burned down."; 
        require(__DIR__ . "/../partials/historyLocation.php"); ?>

        <?php $direction = "right"; $locationName = "Grote markt"; $locationImage = "groteMarktImage.jpg"; 
        $locationDescription = "The grote markt is in the old center of Haarlem next to the church of St.Bavo. It is one of the busiest places of Haarlem."; 
        require(__DIR__ . "/../partials/historyLocation.php"); ?>

        <?php $direction = "left"; $locationName = "De Hallen"; $locationImage = "hallenImage.jpg"; 
        $locationDescription = "A museum in Haarlem dedicated to the famous painter Frans Hals who lived from 1582 to 1666."; 
        require(__DIR__ . "/../partials/historyLocation.php"); ?>

        <?php $direction = "right"; $locationName = "Proveniershof"; $locationImage = "proveniersHofImage.jpg"; 
        $locationDescription = "The Proverniershof is a court on the busiest shopping street of Haarlem that is unique among its kind."; 
        require(__DIR__ . "/../partials/historyLocation.php"); ?>

        <?php $direction = "left"; $locationName = "Jopenkerk"; $locationImage = "jopenKerkImage.jpg"; 
        $locationDescription = "The Jopenkerk used to be a church but has since been transformed into a brewery with both a Café and restaurant by the Jopen brewery. \n\nBreak Location"; 
        require(__DIR__ . "/../partials/historyLocation.php"); ?>

        <?php $direction = "right"; $locationName = "Waalse Kerk"; $locationImage = "waalseKerkImage.jpg"; 
        $locationDescription = "The Waalse church dates back to 1348, making it the oldest church that Haarlem has."; 
        require(__DIR__ . "/../partials/historyLocation.php"); ?>

        <?php $direction = "left"; $locationName = "Molen de Adriaan"; $locationImage = "adriaanMolenImage.jpg"; 
        $locationDescription = "Molen de Adriaan is a windmill that has been used to make a variety of different of products over the years, such as trass, tobacco and corn, but is now a museum."; 
        require(__DIR__ . "/../partials/historyLocation.php"); ?>

        <?php $direction = "right"; $locationName = "Amsterdamse Poort"; $locationImage = "amsterdamsePoortImage.jpg"; 
        $locationDescription = "The Amsterdamse poort is one of Haarlem’s city gates from the 14th century. The gate was build on the path from Haarlem to Amsterdam."; 
        require(__DIR__ . "/../partials/historyLocation.php"); ?>

        <?php $direction = "left"; $locationName = "Hof van Bakenes"; $locationImage = "bakenesHofImage.jpg"; 
        $locationDescription = "The hof van Bakenes is a court that was meant exclusively for women that were 60 years or older and could house 20 women. Later, one of the buildings got changed into something else, leaving room for only 12."; 
        require(__DIR__ . "/../partials/historyLocation.php"); ?>
        
    </div>
    <?php
        require(__DIR__ . "/../partials/footer.php");
    ?>
</body>
</html>
