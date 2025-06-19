<?php
if(key_exists('day', $_GET)) {
    $day = $_GET['day'];
}
if (key_exists('time', $_GET)) {
    $time = $_GET['time'];
}
?>
<div id="HistoryTicketing" class="ticket-flexbox hidden">
    <form id="form" class="historyForm" action="/submit" method="POST">
        <!-- Day Dropdown -->
        <label for="day">Day:</label>
        <select id="day" name="day" required>
        </select><br><br>

        <!-- Time Dropdown -->
        <label for="time">Time:</label>
        <select id="time" name="time" required>
        </select><br><br>

        <!-- Language Dropdown -->
        <label for="language">Language:</label>
        <select id="language" name="language" required>
        </select><br><br>

        <!-- Count Field -->
        <label for="count">Amount:</label>
        <input type="number" id="count" name="count" value="1" min="1" max="12"required><br><br>

        <!-- Checkbox -->
        <label for="familyTicket">Family ticket:</label>
        <input type="checkbox" id="familyTicket" name="familyTicket"><br><br>

        <button id="historySubmit" type="submit" class="submitButton" disabled>Submit</button>
        <p id="InfoLabel" class="InfoLabel"></p>
    </form>
    <div id="priceTag">
        <div class="program-card-header">
            <img src="assets/images/default-event.jpg" alt="Event Image" />
            <div class="event-title">A stroll through history</div>
        </div>
        <div class="program-card-body">
            <p id="historyTicketDay"><strong>Day:</strong> N/A</p>
            <p><strong>Location:</strong> St. Bavo church</p>
            <p id="historyTicketTime"><strong>Time:</strong> N/A</p>
            <p id="historyTicketLanguage"><strong>Language:</strong> Dutch</p>
            <div class="card-footer">
                <span class="price" id="historyTicketPrice">€17.50</span>
            </div>
        </div>
    </div>
</div>
<script src="/assets/js/loadHistoryTicketformData.js">
    //Javascript file file all of the history main page
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        //If data is obtained from the url, set the day and/or time
        <?php if (isset($day)) {
            ?>setDay('<?php echo $day?>');<?php
        }
        if (isset($time)) {
            ?>setTime('<?php echo ((string) $time)?>');<?php
        }?>
        //Load the schedule
        FetchTicketingSchedule();
    });
</script>