<?php
require_once(__DIR__ . '/../models/DanceModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class DanceAPIController {
    private $DanceModel;

    public function __construct() {
        $this->DanceModel = new DanceModel();
    }

    public function getAllById() {
        $artists = $this->DanceModel->getAllById();
        ResponseHelper::sendJson($artists);
    }

    public function getAllEvents() {
        $events = $this->DanceModel->getAllEvents();
        ResponseHelper::sendJson($events);
    }

    public function getEventById($id) {
        $event = $this->DanceModel->getById($id);
        ResponseHelper::sendJson($event);
    }

    public function createDanceEvent() {
        $data = json_decode(file_get_contents("php://input"), true);
        $event = $this->DanceModel->create($data['time'], $data['venue'], $data['session_type'], $data['duration'], $data['price'], $data['day'], $data['artist_ids']);
        ResponseHelper::sendJson($event, 201);
    }

    public function updateDanceEvent($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $success = $this->DanceModel->update($id, $data['time'], $data['venue'], $data['session_type'], $data['duration'], $data['price'], $data['day']);
        ResponseHelper::sendJson(["message" => $success ? "Updated" : "Failed"], $success ? 200 : 500);
    }

    public function deleteDanceEvent($id) {
        $success = $this->DanceModel->delete($id);
        ResponseHelper::sendJson(["message" => $success ? "Deleted" : "Failed"], $success ? 200 : 500);
    }
}
?>
