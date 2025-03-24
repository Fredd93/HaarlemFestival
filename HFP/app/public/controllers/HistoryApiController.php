<?php

require_once(__DIR__ . '/../models/HistoryModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class HistoryAPIController{
    private $historyModel;

    public function __construct() {
        $this->historyModel = new HistoryModel();
    }

    public function getAllById(int $id)
    {
        $schedule = $this->historyModel->getAllById($id);
        if ($schedule) {
            ResponseHelper::sendJson($schedule);
        } else {
            ResponseHelper::sendError('Schedule not found', 404);
        }
    }

    public function getFullSchedule()
    {
        $schedule = $this->historyModel->getFullSchedule();
        if ($schedule) {
            ResponseHelper::sendJson($schedule);
        } else {
            ResponseHelper::sendError('schedule not found', 404);
        }
    }
}
?>
