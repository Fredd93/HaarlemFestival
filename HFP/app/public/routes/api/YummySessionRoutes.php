<?php
require_once(__DIR__ . "/../../api/YummySessionController.php");
$controller = new YummySessionController();

Route::add('/api/yummy/sessions/manage', function () use ($controller) {
    $controller->getAllByEventId();
}, ['GET']);

Route::add('/api/yummy/sessions/update', function () use ($controller) {
    $controller->updateSeats();
}, ['PUT']);
