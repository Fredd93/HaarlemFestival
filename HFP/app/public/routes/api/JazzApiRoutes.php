<?php
require_once(__DIR__ . '/../../api/JazzEventApiController.php');
// Get All Jazz Events
Route::add('/api/jazzEvents', function () {
    $controller = new JazzEventApiController();
    $controller->getAllJazzEvents();
}, ['GET']);

// Get Jazz Event by ID
Route::add('/api/jazzEvents/([0-9]+)', function ($id) {
    $controller = new JazzEventApiController();
    $controller->getJazzEventById(intval($id));
}, ['GET']);

// Get Jazz Events by Date (Keeping it as 'date' to match the model)
Route::add('/api/jazzEvents/date/([0-9]{4}-[0-9]{2}-[0-9]{2})', function ($date) {
    $controller = new JazzEventApiController();
    $controller->getJazzEventsByDate($date);
}, ['GET']);
Route::add('/api/jazzEvents/seats/([0-9]+)', function ($id) {
    $controller = new JazzEventApiController();
    $controller->updateSeats((int) $id);
}, ['PUT']);

?>
