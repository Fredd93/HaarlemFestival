<?php
require_once(__DIR__ . '/../../api/YummyEventApiController.php');
require_once(__DIR__ . '/../../api/ReservationApiController.php');


// Get All Yummy Events
Route::add('/api/yummyEvents', function () {
    $controller = new YummyEventApiController();
    $controller->getAllYummyEvents();
}, ['GET']);

// Get Yummy Event by ID
Route::add('/api/yummyEvents/([0-9]+)', function ($id) {
    $controller = new YummyEventApiController();
    $controller->getYummyEventById(intval($id));
}, ['GET']);

// Get Yummy Events by Type
Route::add('/api/yummyEvents/type/([a-zA-Z]+)', function ($type) {
    $controller = new YummyEventApiController();
    $controller->getYummyEventsByType($type);
}, ['GET']);
Route::add('/api/yummyEvents/types', function () {
    $controller = new YummyEventApiController();
    $controller->getFoodTypes();
}, ['GET']);

$Controller = new YummyReservationController();

Route::add('/api/yummy/sessions', function () use ($Controller) {
    $Controller->getAvailableSessions();
}, ['GET']);

Route::add('/api/yummy/book', function () use ($Controller) {
    $Controller->bookReservation();
}, ['POST']);
?>
