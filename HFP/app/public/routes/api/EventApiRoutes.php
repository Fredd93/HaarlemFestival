<?php
require_once(__DIR__ . '/../../api/EventApiController.php');

$controller = new EventApiController();

// Get All Events
Route::add('/api/events/all', function () use ($controller) {
    $controller->getAllEvents();
}, ['GET']);

// Get Event by ID
Route::add('/api/events/([0-9]+)', function ($id) use ($controller) {
    $controller->getEventById(intval($id));
}, ['GET']);

// Create an Event
Route::add('/api/events/create', function () use ($controller) {
    $controller->createEvent();
}, ['POST']);

// Update an Event
Route::add('/api/events/update/([0-9]+)', function ($id) use ($controller) {
    $controller->updateEvent(intval($id));
}, ['PUT']);

// Delete an Event
Route::add('/api/events/delete/([0-9]+)', function ($id) use ($controller) {
    $controller->deleteEvent(intval($id));
}, ['DELETE']);
?>
