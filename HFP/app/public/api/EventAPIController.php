<?php
require_once(__DIR__ . '/../models/EventModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class EventApiController {
    private $eventModel;

    public function __construct() {
        $this->eventModel = new EventModel();
    }

    // Get all events
    public function getAllEvents() {
        try {
            $events = $this->eventModel->getAllEvents();
            ResponseHelper::sendJson($events);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve events", 500);
        }
    }

    // Get a specific event by ID
    public function getEventById($id) {
        try {
            $event = $this->eventModel->getEventById($id);
            if ($event) {
                ResponseHelper::sendJson($event);
            } else {
                ResponseHelper::sendError("Event not found", 404);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve event", 500);
        }
    }

    // Create a new event
    public function createEvent() {
        try {
            // Access fields from FormData
            $name = $_POST['name'] ?? null;
            $description = $_POST['description'] ?? null;
    
            if (!$name || !$description) {
                ResponseHelper::sendError("Invalid input", 400);
                return;
            }
    
            // Handle image upload
            $imagePath = "";
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../assets/uploads/events/';
                $uploadUrl = '/assets/uploads/events/';
    
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
    
                $filename = time() . '_' . basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $filename;
    
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $imagePath = $uploadUrl . $filename;
                } else {
                    ResponseHelper::sendError("Image upload failed", 500);
                    return;
                }
            } elseif (isset($_POST['image'])) {
                $imagePath = $_POST['image']; // Existing image for update case
            }
    
            // Save event to DB
            $success = $this->eventModel->createEvent($name, $description, $imagePath);
    
            if ($success) {
                ResponseHelper::sendJson(["message" => "Event created successfully"], 201);
            } else {
                ResponseHelper::sendError("Failed to create event", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error", 500);
        }
    }
    

    // Update an existing event
    public function updateEvent($id) {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['name'], $data['description'], $data['image'])) {
                ResponseHelper::sendError("Invalid input", 400);
                return;
            }

            $success = $this->eventModel->updateEvent(
                $id,
                $data['name'],
                $data['description'],
                $data['image']
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

    // Delete an event
    public function deleteEvent($id) {
        try {
            $success = $this->eventModel->deleteEvent($id);

            if ($success) {
                ResponseHelper::sendJson(["message" => "Event deleted successfully"]);
            } else {
                ResponseHelper::sendError("Failed to delete event", 500);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Internal Server Error", 500);
        }
    }
}
?>
