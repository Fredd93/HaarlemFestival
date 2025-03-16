<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jazz | Haarlem Festival</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/jazzStyle.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
</head>
<body>

    <?php
    $activePage = 'jazz';
    require_once(__DIR__ . "/../partials/navbar.php");
    ?>

    <!-- Hero Section with Slideshow -->
    <div class="hero-section">
        <div class="hero-banner">
            <div class="slideshow-container">
                <!-- 4 Slideshow Panels -->
                <div class="slide fade">
                    <img src="../../assets/images/jazz/Gumbokingsbanner.jpg" alt="Gumbo Kings">
                    <div class="hero-content">
                        <h1>Gumbo Kings</h1>
                        <p>Thursday | Patronaat Main Hall</p>
                        <p class="ticket-price"><strong>Tickets: €15.00</strong></p>
                        <a href="tickets.php" class="hero-btn">Grab your tickets now</a>
                    </div>
                </div>
                <div class="slide fade">
                    <img src="../../assets/images/jazz/Frazerbanner.jpg" alt="Jonna Frazer">
                    <div class="hero-content">
                        <h1>Jonna Frazer</h1>
                        <p>Thursday | Patronaat Second Hall</p>
                        <p class="ticket-price"><strong>Tickets: €10.00</strong></p>
                        <a href="tickets.php" class="hero-btn">Grab your tickets now</a>
                    </div>
                </div>
                <div class="slide fade">
                    <img src="../../assets/images/jazz/Hamelbanner.jpg" alt="Wouter Hammel">
                    <div class="hero-content">
                        <h1>Wouter Hamel</h1>
                        <p>Thursday | Patronaat Second Hall</p>
                        <p class="ticket-price"><strong>Tickets: €10.00</strong></p>
                        <a href="tickets.php" class="hero-btn">Grab your tickets now</a>
                    </div>
                </div>
                <div class="slide fade">
                    <img src="../../assets/images/jazz/Ntjamrosiebanner.jpg" alt="Ntjam Rosie">
                    <div class="hero-content">
                        <h1>Ntjam Rosie</h1>
                        <p>Thursday | Patronaat Main Hall</p>
                        <p class="ticket-price"><strong>Tickets: €15.00</strong></p>
                        <a href="tickets.php" class="hero-btn">Grab your tickets now</a>
                    </div>
                </div>
            </div>
            <!-- Dot indicators -->
            <div class="dot-container">
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
            </div>
        </div>
    </div>

    <!-- Jazz Events Section -->
    <div class="jazz-events-section">
        <h2>Feel the rhythm, Embrace the groove. Haarlem Festival Jazz events invites you to a world of soulful beats and electrifying vibes!</h2>
        
        <!-- Dynamically generated day headers + carousels go here -->
        <div id="jazzEventsContainer"></div>
    </div>

        <!-- Ticket Info Section -->
    <div class="ticket-section">
        <h2>Plan Your Jazz Journey with the Perfect Ticket</h2>
        <p>
            Explore the vibrant performances of the Haarlem Jazz Festival with a ticket option that fits your plans.
            Whether you’re looking for a single show, an all-day pass, or the full festival experience, we have you covered!
        </p>

        <div class="ticket-panels">
            <!-- Single Event Ticket Panel -->
            <div class="ticket-panel single-event">
                <div class="panel-content">
                    <h3>Single Event Ticket</h3>
                    <p>
                        Enjoy a single performance of your choice. Perfect for those who want a taste of the festival!
                    </p>
                    <a href="tickets.php" class="panel-btn">View Details</a>
                </div>
            </div>

            <!-- All Day Pass Panel -->
            <div class="ticket-panel all-day">
                <div class="panel-content">
                    <h3>All Day Pass</h3>
                    <p>
                        Immerse yourself in multiple shows in a single day. One price, endless jazz vibes!
                    </p>
                    <a href="tickets.php" class="panel-btn">View Details</a>
                </div>
            </div>

            <!-- Full Festival Pass Panel -->
            <div class="ticket-panel full-festival">
                <div class="panel-content">
                    <h3>Full Festival Pass</h3>
                    <p>
                        Access all performances across every festival day. The ultimate jazz experience!
                    </p>
                    <a href="tickets.php" class="panel-btn">View Details</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="none">
        <?php require(__DIR__ . "/../partials/footer.php"); ?>
    </div>

    <!-- JavaScript -->
    <script src="../../assets/js/jazzSlideshow.js"></script>
    <script src="../../assets/js/jazzMain.js"></script>

</body>
</html>
