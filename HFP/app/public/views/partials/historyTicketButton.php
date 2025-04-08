<?php 
$baseURL = '/history/tickets?day=&time=';
$url = $baseURL;
if (isset($day)) {
    $url .= "?day=".$day;

}
if (isset($time)) {
    if (isset($dayArg)) {
        $url .= "&time=".$time;
    }
    else {
        $url .= "?time=".$time;
    }
}

?>
<div class="ticketButton flexCentered" onclick="window.location.href='<?php echo $url ?>'">Buy ticketso</div>