<?php
require_once(__DIR__ . '/../models/DanceTicketModel.php');
require_once(__DIR__ . '/../models/PersonalProgramModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class DanceTicketApiController {
    private $danceTicketModel;
    private $programModel;

    public function __construct() {
        /** @var DanceTicketModel $danceTicketModel */
        /** @var PersonalProgramModel $programModel */
        $this->danceTicketModel = new DanceTicketModel();
        $this->programModel = new PersonalProgramModel();
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
    
            if (!isset($data['ticket_type'], $data['event_detail_id'], $data['price'])) {
                ResponseHelper::sendError("Missing required fields", 400);
                return;
            }
    
            $eventDetailId = (int)$data['event_detail_id'];
            $price = (float)$data['price'];
    
            $availableSeats = $this->danceTicketModel->getAvailableSeats($eventDetailId);
    
            if ($availableSeats <= 0) {
                ResponseHelper::sendError("No seats available", 409);
                return;
            }
    
            $ticketId = $this->danceTicketModel->bookTicket(
                $data['ticket_type'],
                $eventDetailId,
                $data['pass_id'] ?? null,
                $price
            );
    
            if (!$ticketId) {
                ResponseHelper::sendError("Failed to book dance ticket", 500);
                return;
            }
    
            $this->danceTicketModel->decreaseSeatCount($eventDetailId);
    
            // Add to personal program
            $eventId = $this->danceTicketModel->getEventIdByDetailId($eventDetailId);
            if ($eventId !== null) {
                $userId = $_SESSION['user_id']; 
                $this->programModel->addToProgram(
                    $userId,
                    $eventId,
                    $eventDetailId,
                    $ticketId,
                    'dance'
                );
            }
    
            ResponseHelper::sendJson([
                "message" => "Dance ticket booked successfully",
                "ticket_id" => $ticketId
            ]);
    
        } catch (Exception $e) {
            ResponseHelper::sendError("Error while booking dance ticket: " . $e->getMessage(), 500);
        }
    }
    
}
?>
