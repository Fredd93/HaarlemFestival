<?php

require_once(__DIR__ . "/../models/RestaurantReservationModel.php");
require_once(__DIR__ . "/../models/YummySessionModel.php");
require_once(__DIR__ . "/../models/PersonalProgramModel.php");
require_once(__DIR__ . "/utils/ResponseHelper.php");

class YummyReservationController
{
    private $reservationModel;
    private $sessionModel;
    private $programModel;

    public function __construct()
    {
        $this->reservationModel = new YummyReservationModel();
        $this->sessionModel = new YummySessionModel();
        $this->programModel = new PersonalProgramModel();
    }

    /**
     * GET /api/yummy/sessions?event_id=1&date=YYYY-MM-DD
     * Get all available sessions for a restaurant on a given date.
     */
    public function getAvailableSessions(): void
    {
        $eventId = $_GET['event_id'] ?? null;
        $date = $_GET['date'] ?? null;

        if (!$eventId || !$date) {
            ResponseHelper::sendError("Missing event_id or date.");
        }

        $sessions = $this->sessionModel->getAvailableSessions((int)$eventId, $date);
        ResponseHelper::sendJson($sessions);
    }

    /**
     * POST /api/yummy/book
     * Create a reservation if seats are available.
     */
    public function bookReservation(): void
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($_SESSION['user_id'])) {
            ResponseHelper::sendError("Unauthorized", 401);
            return;
        }
        $userId = $_SESSION['user_id'];        
        $eventId = $data['event_id'] ?? null;
        $eventDetailId = $data['event_detail_reference_id'] ?? null;
        $sessionId = $data['session_id'] ?? null;
        $restaurantId = $data['restaurant_id'] ?? null;
        $numAdults = $data['num_adults'] ?? 0;
        $numChildren = $data['num_children'] ?? 0;
        $clientName = $data['client_name'] ?? '';
        $specialRequest = $data['special_request'] ?? '';

        if (!$userId || !$eventId || !$eventDetailId || !$sessionId || !$restaurantId) {
            ResponseHelper::sendError("Missing required fields.");
        }

        $totalSeats = $numAdults + $numChildren;

        // Check if session belongs to the restaurant
        if (!$this->sessionModel->sessionBelongsToRestaurant($sessionId, $restaurantId)) {
            ResponseHelper::sendError("Invalid session for selected restaurant.");
        }

        // Check availability
        if (!$this->sessionModel->hasAvailableSeats($sessionId, $totalSeats)) {
            ResponseHelper::sendError("Not enough seats available for this session.");
        }

        // Get session time and date
        $sessionData = $this->sessionModel->getSessionById($sessionId);
        if (!$sessionData) {
            ResponseHelper::sendError("Session not found.");
        }

        // Create reservation
        $ticketId = $this->reservationModel->createReservation(
            $restaurantId,
            $sessionId,
            $sessionData['session_date'],
            $sessionData['session_time'],
            $numAdults,
            $numChildren,
            $clientName,
            $specialRequest
        );

        if (!$ticketId) {
            ResponseHelper::sendError("Failed to create reservation.", 500);
        }

        // Reduce seats
        $this->sessionModel->reduceAvailableSeats($sessionId, $totalSeats);

        // Add to personal program
        $this->programModel->addToProgram(
            $userId,
            $eventId,
            $eventDetailId,
            $ticketId,
            'yummy'
        );

        ResponseHelper::sendJson([
            "message" => "Reservation successful.",
            "ticket_id" => $ticketId
        ]);
    }
}
