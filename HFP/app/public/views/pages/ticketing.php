<!DOCTYPE html>
<html>
<head>
    <title>Haarlem Festival - Ticketing</title>
    <!-- <link rel="stylesheet" href="ticketing.css"> -->
</head>
<body>
    <h1>Ticketing Page</h1>

    <ul>
        <li><a href="#tab-dance">Dance!</a></li>
        <li><a href="#tab-yummy">Yummy!</a></li>
        <li><a href="#tab-jazz">Haarlem Jazz</a></li>
        <li><a href="#tab-history">A Stroll through History</a></li>
    </ul>

    <!-- =========================
         DANCE CONTENT AREA
         ========================= -->
    <div id="tab-dance" class="tab-content">
        <h2>Dance Events</h2>

        <!-- Day tabs for Dance -->
        <ul class="dance-day-buttons">
        <button class="tab-button dance-day-tab" data-day="FRIDAY">Friday</button>
        <button class="tab-button dance-day-tab" data-day="SATURDAY">Saturday</button>
        <button class="tab-button dance-day-tab" data-day="SUNDAY">Sunday</button>
        <button class="tab-button dance-day-tab" data-day="ALL ACCESS PASSES">All Access Passes</button>
        </ul>

        <!-- We could omit the artist cards if we only want the table -->
        <!-- <div id="artist-cards-container"></div> -->

        <!-- Table for Dance events -->
        <table id="event-table" border="1">
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

        <!-- YUMMY CONTENT AREA -->
    <div id="tab-yummy" class="tab-content" style="display: none;">
        <h2>Reserve Now</h2>
        <div class="yummy-layout">

            <!-- Left side: The form -->
            <div class="yummy-form-section">
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="restaurant">Restaurant</label>
                        <select id="restaurant" name="restaurant">
                            <!-- You can dynamically populate these if needed -->
                            <option value="">-- Select a restaurant --</option>
                            <option value="Cafe de Roemer">Café de Roemer</option>
                            <option value="Restaurant ML">Restaurant ML</option>
                            <option value="Cafe Brinkman">Café Brinkman</option>
                            <!-- etc. -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date">Date & Session</label>
                        <input type="date" id="date" name="date" />
                        <!-- Alternatively, if you have multiple sessions per day, 
                            you could do a separate dropdown for session times -->
                        <select id="session" name="session">
                            <option value="Session 1">Session 1</option>
                            <option value="Session 2">Session 2</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="numPeople">Number of People</label>
                        <input type="number" id="numPeople" name="numPeople" min="1" max="20" value="1" />
                    </div>

                    <div class="form-group">
                        <label for="specialRequests">Special Requests</label>
                        <textarea id="specialRequests" name="specialRequests" rows="3"></textarea>
                    </div>

                    <button type="submit" class="add-to-program-btn">Add to Program</button>
                </form>
            </div>

            <!-- Right side: The table partial -->
            <div class="yummy-table-section">
                <h3>Participating Restaurants</h3>
                <!-- Include your partial that displays the table -->
                <?php require_once(__DIR__ . "/../partials/yummyEventsTable.php"); ?>
            </div>

        </div> <!-- .yummy-layout -->
        <p class="reservation-note">
            Reservations are mandatory. A €10 fee per person will be charged and deducted from your final bill.
        </p>
    </div>


    <!-- =========================
         JAZZ CONTENT AREA
         ========================= -->
    <div id="tab-jazz" class="tab-content">
        <h2>Jazz Events</h2>
        <div>
            <button id="thursdayBtn">Thursday</button>
            <button id="fridayBtn">Friday</button>
            <button id="saturdayBtn">Saturday</button>
            <button id="sundayBtn">Sunday</button>
            <button id="fullPassBtn">Full Access Passes</button>
        </div>

        <table border="1">
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
         ========================= -->
    <div id="tab-history" class="tab-content">
        <h2>A Stroll through History</h2>
        <p>History events go here...</p>
    </div>

    <!-- =========================
         SCRIPTS
         ========================= -->
    <!-- If you only want the table, we can skip dance.js or still include it if you want to fetch artists. -->
    <script src="../../assets/js/dance.js"></script>
    <!-- Insert the partial with the table logic -->
    <?php require_once(__DIR__ . "/../partials/danceEventsTable.php"); ?>

    <!-- Jazz script -->
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
                contents.forEach(c => c.style.display = 'none');
                const targetId = tab.getAttribute('href').replace('#','');
                document.getElementById(targetId).style.display = 'block';
            });
        });
    });
    </script>
</body>
</html>
