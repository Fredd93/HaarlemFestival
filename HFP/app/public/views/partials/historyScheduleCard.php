<div class="schedule-item">
    <div class="top"><h2><?php echo $tourTime ?></h2></div>
        <div class="bottom">
            <?php if ($dutchTours > 0){
                if ($dutchTours > 1) {
                    $addedLetter = "s";
                }
                else {
                    $addedLetter = "";
                }
                ?><p><?php echo $dutchTours ?> Dutch tour<?php echo $addedLetter ?><img src="assets/images/history/dutchFlag.png" alt="Dutch flag" width="20" height="15"></p><?php 
            }
            if ($englishTours > 0){
                if ($englishTours > 1) {
                    $addedLetter = "s";
                }
                else {
                    $addedLetter = "";
                }
                ?><p><?php echo $englishTours ?> English tour<?php echo $addedLetter ?><img src="assets/images/history/englishFlag.png" alt="English flag" width="20" height="15"></p><?php 
            }
            if ($chineseTours > 0){
                if ($chineseTours > 1) {
                    $addedLetter = "s";
                }
                else {
                    $addedLetter = "";
                }
                ?><p><?php echo $chineseTours ?> Chinese tour<?php echo $addedLetter ?><img src="assets/images/history/chineseFlag.png" alt="Chinese flag" width="20" height="15"></p><?php 
            }
            ?>
        <div class="ticketButton">Buy tickets</div>
    </div>
</div>