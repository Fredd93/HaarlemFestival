<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/danceDetail.css">
</head>
    <body>
    <div class="container">
        <header>
        <h1 id="artist-title">Dance Artist</h1>
        </header>

        <section class="section" id="career-highlights"></section>
        <section class="section" id="tracks"></section>
        <section class="section" id="albums"></section>
        <section class="section" id="legacy"></section>

        <div class="media-sections">
        <section class="slideshow" id="slideshow"></section>
        <section class="videos" id="videos"></section>
        </div>

        <section id="performance-schedule">
        <?php include('partials/danceScheduleTable.php'); ?>
        </section>

        <?php include('partials/footer.php'); ?>
    </div>

    <script src="assets/js/danceDetail1.js"></script>
    </body>
</html>