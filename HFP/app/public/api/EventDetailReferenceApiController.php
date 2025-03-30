<?php
require_once(__DIR__ . '/../models/EventDetailReferenceModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class EventDetailReferenceApiController {
    private $model;

    public function __construct() {
        $this->model = new EventDetailReferenceModel();
    }

    public function getByEventType($eventType) {
        try {
            $data = $this->model->getByEventType($eventType);
            
            ResponseHelper::sendJson($data);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to fetch event references", 500);
        }
    }
}
