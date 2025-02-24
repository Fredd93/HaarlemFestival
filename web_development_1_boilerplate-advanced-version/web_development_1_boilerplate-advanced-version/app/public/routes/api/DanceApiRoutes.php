<?php
require_once(__DIR__ . '/../../api/DanceAPIController.php');
$Controller = new DanceAPIController();

Route::add('/api/artists/all', function () use ($Controller) {
    $Controller->getAllById();
}, ['GET']);

Route::add('/api/artists/events', function () use ($Controller) {
    $Controller->getAllEvents();
}, ['GET']);
?>