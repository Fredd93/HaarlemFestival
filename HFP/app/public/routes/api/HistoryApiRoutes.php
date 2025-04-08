<?php
require_once(__DIR__ . '/../../controllers/HistoryAPIController.php');
require_once(__DIR__ . '/../../controllers/HistoryTicketController.php');
$controller = new HistoryAPIController();

//Schedule api routes
Route::add('/api/history/schedule', function () use ($controller) {
    $controller->getFullSchedule();
}, ['GET']);
Route::add('/api/history/schedule', function() use ($controller) {
    $controller->createScheduleItem();
}, ['POST']);
Route::add('/api/history/schedule/([0-9]*)', function($id) use ($controller) {
    $controller->deleteScheduleItem($id);
}, ['DELETE']);
Route::add('/api/history/schedule/([0-9]*)', function($id) use ($controller) {
    $controller->updateScheduleItem($id);
}, ['PUT']);
Route::add('/api/history/schedule/([0-9]*)', function($id) use ($controller) {
    $controller->getScheduleItemById($id);
}, ['GET']);

//Locations api routes
Route::add('/api/history/locations', function() use ($controller) {
    $controller->getAllLocations();
}, ['GET']);
Route::add('/api/history/locations/([0-9]*)', function ($id) use ($controller) {
    $controller->getLocationById($id);
}, ['GET']);
Route::add('/api/history/locations', function () use ($controller) {
    $controller->createLocation();
}, ['POST']);
Route::add('/api/history/locations/([0-9]*)', function ($id) use ($controller) {
    $controller->deleteLocation($id);
}, ['DELETE']);
Route::add('/api/history/locations/([0-9]*)', function ($id) use ($controller) {
    $controller->updateLocation($id);
}, ['PUT']);

Route::add('/api/history/book', function() {
    $ticketController = new HistoryTicketController();
    $ticketController->createTicket();
}, ['POST']);
?>