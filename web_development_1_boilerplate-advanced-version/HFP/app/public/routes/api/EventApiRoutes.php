<?php
require_once(__DIR__ . '/../../api/EventAPIController.php');
$controller = new EventApiCOntroller();

Route::add('/api/events/all', function () use ($controller) {
    $controller->getAllEvents();
}, ['GET']);

?>