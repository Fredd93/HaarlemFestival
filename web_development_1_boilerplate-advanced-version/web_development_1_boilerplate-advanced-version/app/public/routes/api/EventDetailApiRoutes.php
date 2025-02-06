<?php
require_once(__DIR__ . '/../../api/EventDetailAPIController.php');

// Get All Event Details
Route::add('/api/eventDetails', function () {
    $controller = new EventDetailAPIController();
    $controller->getAllEventDetails();
}, ['GET']);

// Get Event Detail by ID
Route::add('/api/eventDetails/([0-9]+)', function ($id) {
    $controller = new EventDetailAPIController();
    $controller->getEventDetailById(intval($id));
}, ['GET']);

// Get Event Details by Event ID
Route::add('/api/eventDetails/event/([0-9]+)', function ($eventId) {
    $controller = new EventDetailAPIController();
    $controller->getEventDetailsByEventId(intval($eventId));
}, ['GET']);

// Get Event Details by Type (e.g., "Restaurant", "Concert")
Route::add('/api/eventDetails/type/([a-zA-Z]+)', function ($type) {
    $controller = new EventDetailAPIController();
    $controller->getEventDetailsByType($type);
}, ['GET']);
