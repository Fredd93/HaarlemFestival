<?php
require_once(__DIR__ . '/../../api/JazzTicketApiController.php');

// Get All Jazz Tickets
Route::add('/api/jazzTickets', function () {
    $controller = new JazzTicketApiController();
    $controller->getAllJazzTickets();
}, ['GET']);

// Get Jazz Tickets by Event ID
Route::add('/api/jazzTickets/event/([0-9]+)', function ($eventId) {
    $controller = new JazzTicketApiController();
    $controller->getTicketsByEventId(intval($eventId));
}, ['GET']);

// Book a Jazz Ticket
Route::add('/api/jazzTickets/book', function () {
    $controller = new JazzTicketApiController();
    $controller->bookJazzTicket();
}, ['POST']);
?>
