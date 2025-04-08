
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
    $day = $_GET['day'];
    $time = $_GET['time'];
    ?>
    <div class="flexbox">
        <form id="form" class="historyForm" action="/submit" method="POST">
            <!-- Day Dropdown -->
            <label for="day">Day:</label>
            <select id="day" name="day" required>
            </select><br><br>

            <!-- Time Dropdown -->
            <label for="time">Time:</label>
            <select id="time" name="time" required>
            </select><br><br>

            <!-- Language Dropdown -->
            <label for="language">Language:</label>
            <select id="language" name="language" required>
            </select><br><br>

            <!-- Count Field -->
            <label for="count">Amount:</label>
            <input type="number" id="count" name="count" value="1" min="1" max="12"required><br><br>

            <!-- Checkbox -->
            <label for="familyTicket">Family ticket:</label>
            <input type="checkbox" id="familyTicket" name="familyTicket"><br><br>

            <button type="submit">Submit</button>
        </form>
        <div id="priceTag"></div>
    </div>
    <script src="/assets/js/historyScriptClasses.js"></script>
    <script src="/assets/js/loadHistoryTicketformData.js">
        //Javascript file file all of the history main page
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            FetchSchedule();
            //Load the schedule

            /*
            Would have used the parameters to set the time and day ahead of time, but the values wouldn't get set
            if (<?php echo (isset($day) && isset($time))?>) {
                AddLinkValues('<?php echo $day ?>', '<?php echo $time ?>');
            }*/
        });
    </script>
</body>
</html>
