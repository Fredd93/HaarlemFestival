<?php
require_once(__DIR__ . '/../../api/DanceAPIController.php');
$Controller = new DanceAPIController();

Route::add('/api/artists/all', function () use ($Controller) {
    $Controller->getAllById();
}, ['GET']);

Route::add('/api/artists/events', function () use ($Controller) {
    $Controller->getAllEvents();
}, ['GET']);


Route::add('/api/artists/passes', function () use ($Controller) {
    $Controller->getAllPasses();
}, ['GET']);

Route::add('/api/danceEvents/tickets/([0-9]+)', function ($id) {
    $Controller = new DanceAPIController();
    $Controller->updateTicketsAvailable($id);
}, ['PUT']);

Route::add('/api/dance-events', function () use ($Controller) {
    $Controller->getAllDanceEventDetails();
}, ['GET']);


?>