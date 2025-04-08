<?php
require_once(__DIR__ . '/../models/YummyEventModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');
require_once(__DIR__ . '/../middleware/apiAuthMiddleware.php'); 



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

    public function createYummyEvent() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['name'], $data['sessions'], $data['session_duration'], $data['start_time'], $data['end_time'], $data['type'], $data['price'], $data['seats'])) {
                ResponseHelper::sendError("Invalid input", 400);
                return;
            }

            $event = $this->yummyEventModel->createYummyEvent(
                $data['name'],
                (int) $data['sessions'],
                (float) $data['session_duration'],
                $data['start_time'],
                $data['end_time'],
                $data['type'],
                (float) $data['price'],
                (int) $data['seats'],
                $data['img'] ?? null,
                $data['description'] ?? null,
                (int) ($data['stars'] ?? 0)
            );

            if ($event) {
                ResponseHelper::sendJson($event, 201);
            } else {
                ResponseHelper::sendError("Failed to create event", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error", 500);
        }
    }

    public function updateYummyEvent($id) {
                requireApiRole(['admin']);

        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['name'], $data['sessions'], $data['session_duration'], $data['start_time'], $data['end_time'], $data['type'], $data['price'], $data['seats'])) {
                ResponseHelper::sendError("Invalid input", 400);
                return;
            }

            $success = $this->yummyEventModel->updateYummyEvent(
                (int) $id,
                $data['name'],
                (int) $data['sessions'],
                (float) $data['session_duration'],
                $data['start_time'],
                $data['end_time'],
                $data['type'],
                (float) $data['price'],
                (int) $data['seats'],
                $data['img'] ?? null,
                $data['description'] ?? null,
                (int) ($data['stars'] ?? 0)
            );

            if ($success) {
                ResponseHelper::sendJson(["message" => "Event updated successfully"]);
            } else {
                ResponseHelper::sendError("Failed to update event", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error", 500);
        }
    }

    public function deleteYummyEvent($id) {
        requireApiRole(['admin']);

        try {
            if ($this->yummyEventModel->deleteYummyEvent((int) $id)) {
                ResponseHelper::sendJson(["message" => "Event deleted successfully"]);
            } else {
                ResponseHelper::sendError("Failed to delete event", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error", 500);
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
    
            if ($this->yummyEventModel->updateSeats((int) $id, $seats)) {
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
