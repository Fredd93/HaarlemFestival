
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
    <div class="schedule-area" id="schedule-cards-container">
    </div>
    <img class="tourMap" src="assets/images/history/tourMap.png" alt="Tour map" width="941" height="554">
    <h2>The locations that are visited</h2>
    <div class="locationContainer" id="locationContainer">
    </div>
    <?php
        require(__DIR__ . "/../partials/footer.php");
    ?>
    <script src="assets/js/historyScriptClasses.js"></script>
    <script src="assets/js/history.js">
        //Javascript file file all of the history main page
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            FetchSchedule();
            //Load the schedule
            FetchLocations();
            //Load the location cards
        });
    </script>
</body>
</html>
