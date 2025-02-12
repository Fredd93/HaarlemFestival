<?php
require_once(__DIR__ . '/../models/YummyEventModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class YummyEventApiController {
    private $yummyEventModel;

    public function __construct() {
        $this->yummyEventModel = new YummyEventModel();
    }

    // Get all Yummy Events
    public function getAllYummyEvents() {
        try {
            $yummyEvents = $this->yummyEventModel->getAll();
            ResponseHelper::sendJson($yummyEvents);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve Yummy events", 500);
        }
    }

    // Get a specific Yummy Event by ID
    public function getYummyEventById($id) {
        try {
            $event = $this->yummyEventModel->getById($id);
            if ($event) {
                ResponseHelper::sendJson($event);
            } else {
                ResponseHelper::sendError("Yummy event not found", 404);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve Yummy event", 500);
        
        }
    }
    public function getFoodTypes(): void {
        $types = $this->yummyEventModel->getUniqueFoodTypes();
        echo json_encode($types);
    }
    

    // Get Yummy Events by type
    public function getYummyEventsByType($type) {
        try {
            $events = $this->yummyEventModel->getByType($type);
            ResponseHelper::sendJson($events);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve Yummy events by type", 500);
        }
    }
}
?>
