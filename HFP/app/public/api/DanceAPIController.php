<?php

require_once(__DIR__ . '/../models/DanceModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');
require_once(__DIR__ . '/../middleware/apiAuthMiddleware.php'); 


class DanceAPIController{
    private $DanceModel;

    public function __construct() {
        $this->DanceModel = new DanceModel();
    }

    public function getAllById()
    {
        $Artists = $this->DanceModel->getAllById();
        if ($Artists) {
            ResponseHelper::sendJson($Artists);
        } else {
            ResponseHelper::sendError('Artists not found', 404);
        }
    }

    public function getAllEvents()
    {
        $Events = $this->DanceModel->getAllEvents();
        if ($Events) {
            ResponseHelper::sendJson($Events);
        } else {
            ResponseHelper::sendError('Artists not found', 404);
        }
    }
    public function getAllDanceEventDetails() {
        try {
            $events = $this->DanceModel->getAllEventDetails();
            ResponseHelper::sendJson($events);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve dance events", 500);
        }
    }
    public function updateTicketsAvailable($id) {
        requireApiRole(['admin']);

        try {
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (!isset($data['tickets_available'])) {
                ResponseHelper::sendError("Missing 'tickets_available' field", 400);
                return;
            }
    
            $amount = (int)$data['tickets_available'];
    
            if ($this->DanceModel->updateTicketsAvailable((int)$id, $amount)) {
                ResponseHelper::sendJson(["message" => "Tickets updated successfully"]);
            } else {
                ResponseHelper::sendError("Failed to update tickets", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error", 500);
        }
    }
    
    
}
?>
