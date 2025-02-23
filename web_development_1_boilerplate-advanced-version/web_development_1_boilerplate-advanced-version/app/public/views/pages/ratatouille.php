<?php
$activePage = 'yummy';
require_once(__DIR__ . "/../partials/navbar.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css">
    <link rel="stylesheet" href="../../assets/css/ratatoille.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>

    <div class="hero-section">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1 class="hero-title">Ratatouille</h1>
                <p class="hero-subtitle">French Cuisine with a Modern Twist</p>
                <a href="#form" class="hero-btn">Make Reservation</a>
            </div>
        </div>
    </div>

    <!-- About Ratatouille Section -->
    <section id="about-ratatouille" class="about-ratatouille">
        <div class="about-container">
            <div class="about-text">
                <h2>About Ratatouille</h2>
                <p>
                    Led by Chef Jeroen, Ratatouille is known for blending traditional French flavors with contemporary techniques. 
                    With years of experience in Michelin-starred kitchens, Chef Jeroen ensures every dish is a masterpiece.
                </p>
                <p>
                    Located along the scenic Spaarne River in Haarlem, Ratatouille offers a tranquil dining ambiance 
                    that complements its refined menu.
                </p>
                <p>
                    Specializing in French cuisine, Ratatouille’s menu features sustainably sourced ingredients, including 
                    fresh seafood, exquisite meats, and seasonal vegetables. Each dish is crafted to delight your senses.
                </p>
            </div>
            <div class="about-image">
                <img src="../../assets/images/yummy/aboutRatatouille.png" alt="Ratatouille Restaurant">
            </div>
        </div>
    </section>

    <section class="ratatouille-slider-section">
        <h2>A Glimpse of Ratatouille</h2>
        <div class="slider-container">
            <div class="slider-wrapper">
                <div class="slide fade">
                    <img src="../../assets/images/yummy/ratatoilleslider1.png" alt="Elegant Dining Ambiance">
                    <div class="caption">An elegant dining ambiance that blends modern design with a cozy atmosphere.</div>
                </div>
                <div class="slide fade">
                    <img src="../../assets/images/yummy/ratatoilleslider2.png" alt="Gourmet Dishes">
                    <div class="caption">Savor gourmet dishes crafted with the finest ingredients.</div>
                </div>
                <div class="slide fade">
                    <img src="../../assets/images/yummy/ratatoilleslider3.png" alt="Wine Selection">
                    <div class="caption">A curated wine selection to perfectly complement your meal.</div>
                </div>
            </div>
            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
        </div>
        <div class="dots-container">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
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
                    <td>2 hours</td>
                    <td>17:00</td>
                    <td>52</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>2 hours</td>
                    <td>19:30</td>
                    <td>52</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>2 hours</td>
                    <td>21:30</td>
                    <td>52</td>
                </tr>
            </tbody>
        </table>
        <p class="reservation-note">
            <em>Reservations are mandatory. A €10 fee per person will be charged and deducted from your final bill.</em>
        </p>
    </section>
    <section  id="form" class="reservation-section">
        <div class="reservation-container">
            <!-- Left Side: Form -->
            <div class="reservation-form">
                <h2>Reserve Your Table</h2>
                <form>
                    <label for="name">Name *</label>
                    <input type="text" id="name" placeholder="Type here" required>

                    <div class="form-group">
                        <div class="date-field">
                            <label for="date">Date and Session *</label>
                            <input type="date" id="date" required>
                        </div>
                        <div class="session-field">
                            <label for="session">&nbsp;</label>
                            <select id="session" required>
                                <option value="">Session</option>
                                <option value="17:00">17:00</option>
                                <option value="19:30">19:30</option>
                                <option value="21:30">21:30</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="people-field">
                            <label for="adults">Number of People *</label>
                            <select id="adults" required>
                                <option value="">Adults</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5+">5+</option>
                            </select>
                        </div>
                        <div class="people-field">
                            <label for="children">&nbsp;</label>
                            <select id="children">
                                <option value="">Children</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4+">4+</option>
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
                <img src="../../assets/images/yummy/ratataouilleformpic.png" alt="Restaurant">
            </div>
        </div>
    </section>

    <section class="contact-section">
        <div class="contact-container">
            <h2>Contact Info</h2>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <p>Spaarn 96, 2011 CL Haarlem, Netherlands</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <p>+31 23 553 0303</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <p><a href="mailto:info@ratatouillehaarlem.nl">info@ratatouillehaarlem.nl</a></p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-globe"></i>
                    <p><a href="#">Ratatouille Haarlem</a></p>
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


</body>
<footer>
<?php include(__DIR__ . "/../partials/personalProgram.php"); ?>

</footer>
</html>
