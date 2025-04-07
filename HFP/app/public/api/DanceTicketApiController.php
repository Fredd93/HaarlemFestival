<?php
require_once(__DIR__ . '/../models/DanceTicketModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class DanceTicketApiController {
    private $danceTicketModel;

    public function __construct() {
        $this->danceTicketModel = new DanceTicketModel();
    }

    // Get all Dance Tickets
    public function getAllDanceTickets() {
        try {
            $tickets = $this->danceTicketModel->getAll();
            ResponseHelper::sendJson($tickets);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve dance tickets", 500);
        }
    }

    // Get Dance Tickets by Event ID
    public function getTicketsByEventId($eventId) {
        try {
            $tickets = $this->danceTicketModel->getByEventId((int)$eventId);
            ResponseHelper::sendJson($tickets);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve dance tickets by event ID", 500);
        }
    }

    // Book a Dance Ticket
    public function bookDanceTicket() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['dance_type'], $data['ticket_type'], $data['event_detail_id'])) {
                ResponseHelper::sendError("Missing required fields", 400);
                return;
            }

            // Dance type → price logic
            $price = match (strtolower($data['dance_type'])) {
                'main event'       => 25.00,
                'secondary event'  => 15.00,
                'free'             => 0.00,
                default            => -1
            };

            if ($price < 0) {
                ResponseHelper::sendError("Invalid dance_type", 400);
                return;
            }

            $eventDetailId = (int)$data['event_detail_id'];

            $availableSeats = $this->danceTicketModel->getAvailableSeats($eventDetailId);

            if ($availableSeats <= 0) {
                ResponseHelper::sendError("No seats available", 409);
                return;
            }

            $success = $this->danceTicketModel->bookTicket(
                $data['dance_type'],
                $data['ticket_type'],
                $eventDetailId,
                isset($data['pass_id']) ? (int)$data['pass_id'] : null,
                $price
            );

            if ($success) {
                $this->danceTicketModel->decreaseSeatCount($eventDetailId);
                ResponseHelper::sendJson(['message' => 'Dance ticket booked successfully']);
            } else {
                ResponseHelper::sendError("Failed to book dance ticket", 500);
            }

        } catch (Exception $e) {
            ResponseHelper::sendError("Error while booking dance ticket: " . $e->getMessage(), 500);
        }
    }
}
?>
