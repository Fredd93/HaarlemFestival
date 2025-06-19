<?php
    $activePage = 'tickets';
    require_once(__DIR__ . "/../partials/navbar.php");
    ?>

<!DOCTYPE html>
<html>
<head>
    <title>Haarlem Festival - Ticketing</title>
    <!-- Adjust the path so ticketingStyle.css is correctly loaded -->
    <link rel="stylesheet" href="../../assets/css/ticketingStyle.css" />
    <link rel="stylesheet" href="../../assets/css/navbarStyle.css"/>
    <link rel="stylesheet" href="../../danceMainStyles.css">
    <link rel="stylesheet" href="../../assets/css/footer.css">
    <script src="https://js.stripe.com/v3/"></script>

</head>
<body>
    <?php
    $activePage = 'tickets';
    require_once(__DIR__ . "/../partials/navbar.php");
    ?>
    
    <h1>Ticketing Page</h1>

    <!-- Main Tabs (Dance, Yummy, Jazz, History) -->
    <ul class="main-tabs">
        <li><a href="#tab-dance" class="active"><img src="../../assets/images/Ticketing/Dance.png" alt="Dance Icon" /> Dance!</a></li>
        <li><a href="#tab-yummy"><img src="../../assets/images/Ticketing/Yummy.png" alt="Yummy Icon" /> Yummy!</a></li>
        <li><a href="#tab-jazz"><img src="../../assets/images/Ticketing/Jazz.png" alt="Jazz Icon" /> Haarlem Jazz</a></li>
        <li><a href="#tab-history"><img src="../../assets/images/Ticketing/History.png" alt="History Icon" /> A Stroll through History</a></li>
    </ul>

    <!-- =========================
         DANCE CONTENT AREA
    ========================= -->
    <div id="tab-dance" class="tab-content dance-table-container">
        <h2>Dance Events</h2>
        <?php require_once(__DIR__ . "/../partials/danceEventsTable.php"); ?>
    </div>

    <!-- =========================
         YUMMY CONTENT AREA
    ========================= -->
    <div id="tab-yummy" class="tab-content yummy-container" style="display: none;">
        <h2>Reserve Now</h2>
        <div class="yummy-layout">
            <!-- LEFT: Reservation Form -->
            <div class="yummy-form-section">
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="custName">Name *</label>
                        <input type="text" id="custName" name="custName" required />
                    </div>
                    <div class="form-group">
                        <label for="restaurant">Restaurant *</label>
                        <select id="restaurant" name="restaurant" required>
                            <option value="">-- Select a restaurant --</option>
                            <!-- Dynamically filled by yummyTicketing.js -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Date *</label>
                        <select id="date" name="date" required>
                            <option value="">-- Select a date --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sessionTime">Session *</label>
                        <select id="sessionTime" name="sessionTime" required>
                            <option value="">-- Select a session --</option>
                            <!-- Dynamically filled by yummyTicketing.js -->
                        </select>
                    </div>
                    <div class="form-group side-by-side">
                        <div>
                            <label for="adults">Adults</label>
                            <select id="adults" name="adults">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> Adult<?= ($i > 1 ? 's' : '') ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div>
                            <label for="children">Children</label>
                            <select id="children" name="children">
                                <?php for ($i = 0; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> Child<?= ($i > 1 ? 'ren' : '') ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="specialRequests">Special Requests</label>
                        <textarea id="specialRequests" name="specialRequests" rows="3"></textarea>
                        <input type="hidden" id="sessionId" name="sessionId" />
                    </div>
                    <button type="submit" class="add-to-program-btn">Add to Program</button>
                </form>
            </div>
            <!-- RIGHT: Participating Restaurants Table -->
            <div class="yummy-table-section">
                <h3>Participating Restaurants</h3>
                <?php require_once(__DIR__ . "/../partials/yummyEventsTable.php"); ?>
                <p class="reservation-note">
                    Reservations are mandatory. A €10 fee per person will be charged and deducted from your final bill.
                </p>
            </div>
        </div>
    </div>

    <!-- =========================
         JAZZ CONTENT AREA
    ========================= -->
    <?php require_once(__DIR__ . "/../partials/jazzEventsTable.php"); ?>

    <!-- =========================
         HISTORY CONTENT AREA
    ========================= -->
    <div id="tab-history" class="tab-content history">
        <h2>A Stroll through History</h2>
        <!-- name is a little unclear, but the script wants this id 
         and making an exception for the ticketing page while it isn't taken
         doesn't make much sense-->
         <?php 
            $isMainTicketingPage = true;
            require_once(__DIR__ . "/../partials/historySchedule.php");
            require_once(__DIR__ . "/../partials/historyTicketFormPartial.php"); 
         ?>
    </div>
    <?php
            
        require(__DIR__ . "/../partials/footer.php");
    ?>

    <!-- =========================
         SCRIPTS
    ========================= -->
    <!-- Dance Events Table JS -->
    <script src="../../assets/js/danceTicketing.js"></script>
    <!-- Yummy script (handles reservation form and restaurant dropdown) -->
    <script src="../../assets/js/yummyTicketing.js"></script>
    <!-- Reservation JS (handles booking the reservation) -->
    <script src="../../assets/js/reservation.js"></script>
    <!-- Jazz script -->
    <script src="../../assets/js/jazzTicketing.js"></script>
    <!-- Main ticketing JS for tab switching -->
    <script src="../../assets/js/ticketing.js"></script>
    <script src="../../assets/js/danceBooking.js"></script>
    <script src="../../assets/js/personalProgram.js"></script>
</body>
</html>
