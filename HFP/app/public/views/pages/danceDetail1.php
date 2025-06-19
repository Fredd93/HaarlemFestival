<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/danceDetail.css">
    <link rel="stylesheet" href="../../assets/css/danceMainStyle.css">
    <script src="https://js.stripe.com/v3/"></script>
</head>
    <body>
    <?php
    $activePage = 'dance';
    require_once(__DIR__ . "/../partials/navbar.php");
    ?>
     <div class="video-container">
        <video autoplay muted loop class="video-frame">
            <source src="../../assets/images/dance/cover-video.mp4" type="video/mp4">
        </video>
        <img src="../../assets/images/dance/logo.png" alt="Dance Logo" class="logo-overlay">
    </div>
    <div class="container">
        <header>
        <h1 id="artist-title">Dance Artist</h1>
        </header>

    <section class="highlight-wrapper">
    <div class="career-text" id="career-highlights"></div>
    <div class="slideshow" id="slideshow">
    <div class="slide-container">
        <img id="slide-image" src="" alt="Slideshow Image">
    </div>
    <div id="slide-dots" class="dot-container"></div>
    </div>

    </section>
    <div class="video-text-wrapper left-video">
    <div class="video-box" id="video1"></div>
    <section class="section" id="tracks"></section>
    </div>

    <section class="section" id="albums"></section>

    <div class="video-text-wrapper right-video">
    <section class="section" id="legacy"></section>
    <div class="video-box" id="video2"></div>
    </div>



        <section id="performance-schedule">
        </section>
    </div>
    <?php
    require_once(__DIR__ . "/../partials/footer.php");
    ?>
    <script src="assets/js/danceDetail1.js"></script>
    </body>
</html>