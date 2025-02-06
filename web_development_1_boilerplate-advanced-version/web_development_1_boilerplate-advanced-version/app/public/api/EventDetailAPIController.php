<?php
require_once(__DIR__ . '/../models/EventDetailModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class EventDetailAPIController {
    private $eventDetailModel;

    public function __construct() {
        $this->eventDetailModel = new EventDetailModel();
    }

    public function getAllEventDetails() {
        try {
            $eventDetails = $this->eventDetailModel->getAll();
            ResponseHelper::sendJson($eventDetails);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve event details", 500);
        }
    }

    public function getEventDetailById($id) {
        try {
            $eventDetail = $this->eventDetailModel->getById($id);
            if ($eventDetail) {
                ResponseHelper::sendJson($eventDetail);
            } else {
                ResponseHelper::sendError("Event detail not found", 404);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve event detail", 500);
        }
    }

    public function getEventDetailsByEventId($eventId) {
        try {
            $eventDetails = $this->eventDetailModel->getByEventId($eventId);
            ResponseHelper::sendJson($eventDetails);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve event details", 500);
        }
    }
    public function getEventDetailsByType($type) {
        try {
            $eventDetails = $this->eventDetailModel->getByType($type);
            ResponseHelper::sendJson($eventDetails);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve event details by type", 500);
        }
    }
    
}
