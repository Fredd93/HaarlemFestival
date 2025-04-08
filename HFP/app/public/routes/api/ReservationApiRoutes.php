<?php
// routes/ReservationApiRoutes.php

require_once __DIR__ . '/../../api/ReservationApiController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$uri = parse_url($requestUri, PHP_URL_PATH);

// Only proceed if the URI starts with /api/reservations
if (strpos($uri, '/api/reservations') === 0) {
    $reservationApiController = new ReservationApiController();

    switch ($requestMethod) {
        case 'POST':
            $reservationApiController->bookReservation();
            break;

        default:
            http_response_code(405);
            echo json_encode(["message" => "Method not allowed"]);
            exit;
    }
}

