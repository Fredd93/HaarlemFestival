<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once(__DIR__ . '/../models/JazzEventModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');
require_once(__DIR__ . '/../middleware/apiAuthMiddleware.php'); 


class JazzEventApiController {
    private $jazzEventModel;

    public function __construct() {
        $this->jazzEventModel = new JazzEventModel();
    }

    // Get all Jazz Events
    public function getAllJazzEvents() {
        try {
            $jazzEvents = $this->jazzEventModel->getAllJazzEvents();
            ResponseHelper::sendJson($jazzEvents);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve Jazz events: " . $e->getMessage(), 500);
        }
    }

    // Get Jazz Event by ID
    public function getJazzEventById($id) {
        try {
            $event = $this->jazzEventModel->getJazzEventById($id);
            if ($event) {
                ResponseHelper::sendJson($event);
            } else {
                ResponseHelper::sendError("Jazz event not found", 404);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve Jazz event", 500);
        }
    }

    // Get Jazz Events by Date
    public function getJazzEventsByDate($date) {
        try {
            $events = $this->jazzEventModel->getJazzEventsByDate($date);
            ResponseHelper::sendJson($events);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve Jazz events by date", 500);
        }
    }
    public function updateSeats($id) {
        requireApiRole(['admin']);

        try {
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (!isset($data['seats'])) {
                ResponseHelper::sendError("Missing 'seats' field", 400);
                return;
            }
    
            $seats = (int) $data['seats'];
    
            if ($this->jazzEventModel->updateSeats((int) $id, $seats)) {
                ResponseHelper::sendJson(["message" => "Seats updated successfully"]);
            } else {
                ResponseHelper::sendError("Failed to update seats", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error", 500);
        }
    }
    

}
?>
