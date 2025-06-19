<div class="schedule-area" id="schedule-cards-container">
</div>

<script src="assets/js/historyScriptClasses.js"></script>

<script src="assets/js/history.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php
        if (isset($isMainTicketingPage) && $isMainTicketingPage) 
        {
            ?>setTicketingPage(true);<?php
        }?>
        FetchHistorySchedule();
        //Load the schedule
            
    });
</script>