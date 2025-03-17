<?php function checkPlural(int $tourCount) {
    if ($tourCount > 1) {
        return "s";
    }
    return "";
}
?>