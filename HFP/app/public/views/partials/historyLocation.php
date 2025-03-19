<?php 
$locationImage = "assets/images/history/" . $locationImage;

if ($direction == "left") {
    ?>
    <div class="locationCard left">    
    <?php
}
else {
    ?>
    <div class="locationCard right">
    <?php    
}
?>
    <img src=<?php echo $locationImage ?> width="200" height="150" alt="Location Image">
    <a class="locationButton" href=<?php echo "history/" . str_replace(" ", "_", $locationName) ?>>Learn more</a>
    <p class="locationCardText"><strong><?php echo $locationName ?></strong> <br><?php echo $locationDescription ?></p>
</div>
