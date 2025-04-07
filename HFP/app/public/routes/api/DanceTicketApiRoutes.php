<?php
require_once(__DIR__ . '/../../api/DanceTicketApiController.php');

// Get All Dance Tickets
Route::add('/api/danceTickets', function () {
    $controller = new DanceTicketApiController();
    $controller->getAllDanceTickets();
}, ['GET']);

// Get Dance Tickets by Event ID
Route::add('/api/danceTickets/([0-9]+)', function ($id) {
    $controller = new DanceTicketApiController();
    $controller->getTicketsByEventId((int)$id);
}, ['GET']);

// Book a Dance Ticket
Route::add('/api/danceTickets/book', function () {
    $controller = new DanceTicketApiController();
    $controller->bookDanceTicket();
}, ['POST']);
