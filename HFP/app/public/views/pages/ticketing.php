<!DOCTYPE html>
<html>
<head>
    <title>Haarlem Festival - Ticketing</title>
    <!-- Adjust the path so ticketingStyle.css is correctly loaded -->
    <link rel="stylesheet" href="../../assets/css/ticketingStyle.css" />
</head>
<body>
    <h1>Ticketing Page</h1>

    <!-- Main Tabs (Dance, Yummy, Jazz, History) -->
    <ul class="main-tabs">
        <li><a href="#tab-dance" class="active"><img src="danceIcon.png" alt="Dance Icon" /> Dance!</a></li>
        <li><a href="#tab-yummy"><img src="forkKnife.png" alt="Yummy Icon" /> Yummy!</a></li>
        <li><a href="#tab-jazz"><img src="jazzIcon.png" alt="Jazz Icon" /> Haarlem Jazz</a></li>
        <li><a href="#tab-history"><img src="historyIcon.png" alt="History Icon" /> A Stroll through History</a></li>
    </ul>

    <!-- =========================
         DANCE CONTENT AREA
         (Uses .tab-content and .dance-table-container for styling)
    ========================= -->
    <div id="tab-dance" class="tab-content dance-table-container">
        <h2>Dance Events</h2>
        <!-- The partial provides only the container markup for the dance table -->
        <?php require_once(__DIR__ . "/../partials/danceEventsTable.php"); ?>
    </div>

    <!-- =========================
         YUMMY CONTENT AREA
         (Ensure it has id="tab-yummy" and .tab-content)
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
                        <input type="date" id="date" name="date" required />
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
         (Jazz content is now in its own partial)
    ========================= -->
    <?php require_once(__DIR__ . "/../partials/jazzEventsTable.php"); ?>

    <!-- =========================
         HISTORY CONTENT AREA
         (Ensure it has id="tab-history" and .tab-content)
    ========================= -->
    <div id="tab-history" class="tab-content">
        <h2>A Stroll through History</h2>
        <p>History events go here...</p>
    </div>

    <!-- =========================
         SCRIPTS
    ========================= -->
    <!-- Dance Events Table JS (handles fetching days and setting table data) -->
    <script src="../../assets/js/danceTicketing.js"></script>
    <!-- Yummy script (handles reservation form and restaurant dropdown) -->
    <script src="../../assets/js/yummyTicketing.js"></script>
    <!-- Jazz script (handles dynamic Jazz date buttons and table population) -->
    <script src="../../assets/js/jazzTicketing.js"></script>
    <!-- Main ticketing JS for tab switching and any additional logic -->
    <script src="../../assets/js/ticketing.js"></script>
</body>
</html>
