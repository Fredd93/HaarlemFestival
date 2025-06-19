
<head>
    <meta charset="UTF-8">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/historyStyle.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link rel="stylesheet" href="../../assets/css/historyTicketStyle.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <title>History tickets</title>
    <base href="/" />
</head>
<body>
    <?php
    $activePage = 'history';
    require_once(__DIR__ . "/../partials/navbar.php");
    require_once(__DIR__ . "/../partials/historyTicketFormPartial.php");
    ?>
    <script src="/assets/js/historyScriptClasses.js"></script>
</body>
</html>
