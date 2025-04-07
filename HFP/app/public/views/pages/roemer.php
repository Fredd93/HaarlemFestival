<?php
$activePage = 'yummy';
require_once(__DIR__ . "/../partials/navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/roemerStyles.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>

    <div class="hero-section">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1 class="hero-title">Café de roemer</h1>
                <p class="hero-subtitle">Cozy Dutch Dining</p>
                <a href="#form" class="hero-btn">Make Reservation</a>
            </div>
        </div>
    </div>

    <!-- About Ratatouille Section -->
    <section id="about-ratatouille" class="about-ratatouille">
        <div class="about-container">
            <div class="about-text">
                <h2>About Café de Roemer</h2>
                <p>
                Café de Roemer is led by Chef Pieter, who brings a love for traditional Dutch cuisine with a modern twist. 
                Chef Pieter emphasizes fresh, locally sourced seafood and hearty European dishes that delight every palate.
                </p>
                <p>
                Located at Botermarkt 17, Café de Roemer is a short walk from Haarlem's bustling city center.
                Its cozy interior and friendly atmosphere make it the perfect spot for a relaxed dining experience.
                </p>
                <p>
                The menu features a range of Dutch and European dishes, with a focus on seafood and locally inspired flavors.
                Don’t miss their specialty: fresh North Sea fish prepared daily.
                </p>
            </div>
            <div class="about-image">
                <img src="../../assets/images/yummy/roemerAboutimg.png" alt="Ratatouille Restaurant">
            </div>
        </div>
    </section>

    <section class="cafe-glimpse">
        <h2>A Glimpse of Café de Roemer</h2>
        <div class="glimpse-container">
            <div class="glimpse-item">
                <img src="../../assets/images/yummy/roemerslide1.png" alt="Freshly prepared fish dishes">
                <p>Freshly prepared fish dishes.</p>
            </div>
            <div class="glimpse-item">
                <img src="../../assets/images/yummy/roemerslide2.png" alt="Plated with love by chef Riche">
                <p>Plated with love by chef Riche</p>
            </div>
            <div class="glimpse-item">
                <img src="../../assets/images/yummy/roemerslide3.png" alt="The inviting ambiance of Café de Roemer">
                <p>The inviting ambiance of Café de Roemer.</p>
            </div>
        </div>
    </section>

    <section class="dining-sessions">
        <h2>Dining Sessions</h2>
        <table class="dining-table">
            <thead>
                <tr>
                    <th>Session</th>
                    <th>Duration</th>
                    <th>Start Time</th>
                    <th>Seats Available</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>1.5 hours</td>
                    <td>18:00</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>1.5 hours</td>
                    <td>19:30</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>1.5 hours</td>
                    <td>21:00</td>
                    <td>35</td>
                </tr>
            </tbody>
        </table>
        <p class="reservation-note">
            <em>Reservations are mandatory. A €10 fee per person will be charged and deducted from your final bill.</em>
        </p>
    </section>
    <section id="form" class="reservation-section">
    <div class="reservation-container">
        <!-- Left Side: Form -->
        <div class="reservation-form">
            <h2>Reserve Your Table</h2>
            <form id="restaurant-reservation-form">
                <!-- Hidden fields -->
                <input type="hidden" id="restaurant_id" value="6"> 
                <input type="hidden" id="event_detail_reference_id" value="1">
                <input type="hidden" id="session_id">

                <label for="name">Name *</label>
                <input type="text" id="name" placeholder="Type here" required>

                <div class="form-group">
                    <div class="date-field">
                        <label for="date">Date *</label>
                        <select id="date" required>
                            <option value="">Select a date</option>
                        </select>
                    </div>
                    <div class="session-field">
                        <label for="session">Session *</label>
                        <select id="session" required>
                            <option value="">Select a session</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="people-field">
                        <label for="adults">Number of People *</label>
                        <select id="adults" required>
                            <option value="1">1 Adult</option>
                            <option value="2">2 Adults</option>
                            <option value="3">3 Adults</option>
                            <option value="4">4 Adults</option>
                            <option value="5">5 Adults</option>
                        </select>
                    </div>
                    <div class="people-field">
                        <label for="children">Children</label>
                        <select id="children">
                            <option value="0">0 Children</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>

                <label for="requests">Special Requests</label>
                <textarea id="requests" placeholder="Type here"></textarea>

                <button type="submit" class="reservation-btn">Add To Program</button>
            </form>
        </div>

        <!-- Right Side: Image -->
        <div class="reservation-image">
            <img src="../../assets/images/yummy/roemerformimage.png" alt="Restaurant">
        </div>
    </div>
</section>


    <section class="contact-section">
        <div class="contact-container">
            <h2>Contact Info</h2>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Botermarkt 17, Haarlem</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <p>+31 23 678 9123</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <p><a href="info@cafederoemer.nl">info@cafederoemer.nl</a></p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-globe"></i>
                    <p><a href="#">Café De Roemer</a></p>
                </div>
            </div>
        </div>
    </section>

    <div class="none">
        <?php
            require(__DIR__ . "/../partials/footer.php");
        ?>
    </div>




    <script src="../../assets/js/ratatouille.js"></script>
    <script src="../../assets/js/personalProgram.js"></script>
    <script src="../../assets/js/restaurantBooking.js"></script>



</body>
<footer>
<?php include(__DIR__ . "/../partials/personalProgram.php"); ?>

</footer>
</html>
