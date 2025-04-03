<!DOCTYPE html>
<html>
<head>
    <title>Haarlem Festival - Ticketing</title>
    <!-- Make sure this path is correct relative to ticketing.php -->
    <link rel="stylesheet" href="../../assets/css/ticketingStyle.css" />
</head>
<body>
    <h1>Ticketing Page</h1>

    <!-- Main Tabs (Dance, Yummy, Jazz, History) -->
    <ul class="main-tabs">
        <li><a href="#tab-dance" class="active"><img src="danceIcon.png" /> Dance!</a></li>
        <li><a href="#tab-yummy"><img src="forkKnife.png" /> Yummy!</a></li>
        <li><a href="#tab-jazz"><img src="jazzIcon.png" /> Haarlem Jazz</a></li>
        <li><a href="#tab-history"><img src="historyIcon.png" /> A Stroll through History</a></li>
    </ul>

    <!-- =========================
         DANCE CONTENT AREA
         Use BOTH: .tab-content (for tab logic) AND .dance-table-container (for styling)
    ========================= -->
    <div id="tab-dance" class="tab-content dance-table-container">
        <h2>Dance Events</h2>

        <!-- Day tabs container (bookmark style) -->
        <div class="dance-day-tabs" id="dance-day-buttons">
            <!-- JS creates day buttons here -->
        </div>

        <!-- Purple-themed dance table -->
        <table class="dance-table" id="event-table" border="1">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Venue</th>
                    <th>Artist(s)</th>
                    <th>Session Type</th>
                    <th>Duration</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <!-- =========================
         YUMMY CONTENT AREA
         (remains the same, but ensure it has id="tab-yummy" and .tab-content)
    ========================= -->
<!-- The Yummy section -->
<div id="tab-yummy" class="tab-content yummy-container" style="display: none;">
    <h2>Reserve Now</h2>

    <!-- The main layout for the Yummy section: form on the left, table on the right -->
    <div class="yummy-layout">
        <!-- LEFT: Reservation Form -->
        <div class="yummy-form-section">
            <form action="#" method="post">
                <!-- Name field -->
                <div class="form-group">
                    <label for="custName">Name *</label>
                    <input type="text" id="custName" name="custName" required />
                </div>

                <!-- Restaurant -->
                <div class="form-group">
                    <label for="restaurant">Restaurant *</label>
                    <select id="restaurant" name="restaurant" required>
                        <option value="">-- Select a restaurant --</option>
                        <!-- Dynamically filled by yummyTicketing.js -->
                    </select>
                </div>

                <!-- Date -->
                <div class="form-group">
                    <label for="date">Date *</label>
                    <input type="date" id="date" name="date" required />
                </div>

                <!-- Session -->
                <div class="form-group">
                    <label for="sessionTime">Session *</label>
                    <select id="sessionTime" name="sessionTime" required>
                        <option value="">-- Select a session --</option>
                        <!-- Dynamically filled by yummyTicketing.js -->
                    </select>
                </div>

                <!-- Adults & Children -->
                <div class="form-group side-by-side">
                    <div>
                        <label for="adults">Adults</label>
                        <select id="adults" name="adults">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?> Adult<?= ($i>1?'s':'') ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div>
                        <label for="children">Children</label>
                        <select id="children" name="children">
                            <?php for ($i = 0; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?> Child<?= ($i>1?'ren':'') ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <!-- Special Requests -->
                <div class="form-group">
                    <label for="specialRequests">Special Requests</label>
                    <textarea id="specialRequests" name="specialRequests" rows="3"></textarea>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="add-to-program-btn">
                    Add to Program
                </button>
            </form>
        </div> <!-- .yummy-form-section -->

        <!-- RIGHT: Participating Restaurants Table -->
        <div class="yummy-table-section">
            <h3>Participating Restaurants</h3>
            
            <!-- The partial that displays the Yummy events table -->
            <?php require_once(__DIR__ . "/../partials/yummyEventsTable.php"); ?>

            <p class="reservation-note">
                Reservations are mandatory. A €10 fee per person will be charged and deducted from your final bill.
            </p>
        </div> <!-- .yummy-table-section -->
    </div> <!-- .yummy-layout -->
</div> <!-- #tab-yummy -->
    <!-- Yummy script -->
    <script src="../../assets/js/yummyTicketing.js"></script>

    <!-- =========================
         JAZZ CONTENT AREA
         Use BOTH: .tab-content AND .jazz-table-container
    ========================= -->
    <div id="tab-jazz" class="tab-content jazz-table-container">
        <h2>Jazz Events</h2>

        <!-- Day tabs container (bookmark style) for Jazz -->
        <div class="jazz-day-tabs" id="jazz-day-buttons">
            <!-- JS creates date buttons here -->
        </div>

        <!-- Burgundy-themed jazz table -->
        <table class="jazz-table" id="jazz-event-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Venue</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="jazzTableBody"></tbody>
        </table>
    </div>

    <!-- =========================
         HISTORY CONTENT AREA
         (Use the tab-content ID so the tab logic can hide/show it)
    ========================= -->
    <div id="tab-history" class="tab-content">
        <h2>A Stroll through History</h2>
        <p>History events go here...</p>
    </div>

    <!-- Scripts -->
    <!-- dance.js (fetching artists, etc.) -->
    <script src="../../assets/js/dance.js"></script>

    <!-- Insert the partial with setTable(day), fetchDanceDays(), etc. -->
    <?php require_once(__DIR__ . "/../partials/danceEventsTable.php"); ?>

    <!-- Jazz script (fetchJazzDates, fetchJazzEventsByDate, etc.) -->
    <script src="../../assets/js/jazzTicketing.js"></script>

    <script>
    // Basic tab switching logic
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('ul li a');
        const contents = document.querySelectorAll('.tab-content');

        // Hide all tab-content except the first
        contents.forEach((content, index) => {
            content.style.display = index === 0 ? 'block' : 'none';
        });

        tabs.forEach(tab => {
            tab.addEventListener('click', e => {
                e.preventDefault();
                // Hide all .tab-content
                contents.forEach(c => c.style.display = 'none');
                // Show the clicked tab
                const targetId = tab.getAttribute('href').replace('#','');
                document.getElementById(targetId).style.display = 'block';
            });
        });
    });
    </script>

    <!-- ticketing.js (if you have extra front-end logic) -->
    <script src="../../assets/js/ticketing.js"></script>
</body>
</html>
