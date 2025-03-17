<?php

require_once(__DIR__ . '/../models/DanceModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

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
}
?>