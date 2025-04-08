<?php
require_once(__DIR__ . '/../models/JazzTicketModel.php');
require_once(__DIR__ . '/../models/PersonalProgramModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class JazzTicketApiController {
    private $jazzTicketModel;
    private $programModel;

    public function __construct() {
        $this->jazzTicketModel = new JazzTicketModel();
        $this->programModel = new PersonalProgramModel();
    }

    // Get all Jazz Tickets
    public function getAllJazzTickets() {
        try {
            $tickets = $this->jazzTicketModel->getAll();
            ResponseHelper::sendJson($tickets);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve jazz tickets", 500);
        }
    }

    // Get Jazz Tickets by Event ID
    public function getTicketsByEventId($eventId) {
        try {
            $tickets = $this->jazzTicketModel->getByEventId((int)$eventId);
            ResponseHelper::sendJson($tickets);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve jazz tickets by event ID", 500);
        }
    }

    // Book a Jazz Ticket
    public function bookJazzTicket() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['jazz_type'], $data['ticket_type'], $data['event_detail_id'])) {
                ResponseHelper::sendError("Missing required fields", 400);
                return;
            }

            $price = match (strtolower($data['jazz_type'])) {
                'main event'       => 15.00,
                'secondary event'  => 10.00,
                'free'             => 0.00,
                default            => -1
            };

            if ($price < 0) {
                ResponseHelper::sendError("Invalid jazz_type", 400);
                return;
            }

            $eventDetailId = (int)$data['event_detail_id'];
            $availableSeats = $this->jazzTicketModel->getAvailableSeats($eventDetailId);

            if ($availableSeats <= 0) {
                ResponseHelper::sendError("No seats available", 409);
                return;
            }

            $ticketId = $this->jazzTicketModel->bookTicket(
                $data['jazz_type'],
                $data['ticket_type'],
                $eventDetailId,
                isset($data['pass_id']) ? (int)$data['pass_id'] : null,
                $price
            );

            if (!$ticketId) {
                ResponseHelper::sendError("Failed to book ticket", 500);
                return;
            }

            $this->jazzTicketModel->decreaseSeatCount($eventDetailId);

            // ✅ Add to personal program
            $eventId = $this->jazzTicketModel->getEventIdByDetailId($eventDetailId);
            if ($eventId !== null) {
                if (!isset($_SESSION['user_id'])) {
                    ResponseHelper::sendError("Unauthorized", 401);
                    return;
                }
                $userId = $_SESSION['user_id'];                
                $this->programModel->addToProgram(
                    $userId,
                    $eventId,
                    $eventDetailId,
                    $ticketId,
                    'jazz'
                );
            }

            ResponseHelper::sendJson([
                "message" => "Ticket booked successfully",
                "ticket_id" => $ticketId
            ]);
        } catch (Exception $e) {
            ResponseHelper::sendError("Error while booking ticket: " . $e->getMessage(), 500);
        }
    }
}
