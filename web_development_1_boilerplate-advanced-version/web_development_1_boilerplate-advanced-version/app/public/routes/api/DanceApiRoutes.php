<?php
require_once(__DIR__ . '/../../api/DanceAPIController.php');
$Controller = new DanceAPIController();

Route::add('/api/artists/all', function () use ($Controller) {
    $Controller->getAllById();
}, ['GET']);

Route::add('/api/artists/events', function () use ($Controller) {
    $Controller->getAllEvents();
}, ['GET']);
Route::add('/api/dance/events/([0-9]+)', function ($id) use ($Controller) {
    $Controller->getEventById(intval($id));
}, ['GET']);

// ✅ Create a New Dance Event
Route::add('/api/dance/events/create', function () use ($Controller) {
    $Controller->createDanceEvent();
}, ['POST']);

// ✅ Update an Existing Dance Event
Route::add('/api/dance/events/update/([0-9]+)', function ($id) use ($Controller) {
    $Controller->updateDanceEvent(intval($id));
}, ['PUT']);

// ✅ Delete a Dance Event
Route::add('/api/dance/events/delete/([0-9]+)', function ($id) use ($Controller) {
    $Controller->deleteDanceEvent(intval($id));
}, ['DELETE']);
?>