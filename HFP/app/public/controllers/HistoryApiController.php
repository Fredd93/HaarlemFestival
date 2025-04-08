<?php

require_once(__DIR__ . '/../models/HistoryModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');
require_once(__DIR__ . '/../middleware/apiAuthMiddleware.php'); 

class HistoryAPIController{
    private $historyModel;

    public function __construct() {
        $this->historyModel = new HistoryModel();
    }

    public function getLocationById(int $id)
    {
        $schedule = $this->historyModel->getLocationById($id);
        if ($schedule) {
            ResponseHelper::sendJson($schedule);
        } else {
            ResponseHelper::sendError('Location not found', 404);
        }
    }
    public function getAllLocations() {
        $locations = $this->historyModel->getAllLocations();
        if ($locations) {
            ResponseHelper::sendJson($locations);
        } else {
            ResponseHelper::sendError('Locations not found', 404);
        }
    }

    public function getFullSchedule()
    {
        $schedule = $this->historyModel->getFullSchedule();
        if ($schedule) {
            ResponseHelper::sendJson($schedule);
        } else {
            ResponseHelper::sendError('Schedule not found', 404);
        }
    }
    public function createScheduleItem() {
        requireApiRole(['admin']);
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['language']) && isset($data['maxTickets']) && isset($data['timeStamp'])) {
            $scheduleItem = $this->historyModel->createScheduleItem($data);
            ResponseHelper::sendJson($scheduleItem);
        }
        else {
            ResponseHelper::sendError('Missing information for item creation', 404);
        }
    }
    public function deleteScheduleItem($id) {
        requireApiRole(['admin']);
        $success = $this->historyModel->deleteScheduleItem($id);
        if ($success)
        {
            ResponseHelper::sendJson('Successfully deleted item with id: ' . $id);
        }
        else {
            ResponseHelper::sendError('Could not delete item with id: ' . $id, 404);
        }
    }
    public function updateScheduleItem($id) {
        requireApiRole(['admin']);
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['language']) && isset($data['maxTickets']) && isset($data['timeStamp']) && isset($id)) {
            $scheduleItem = $this->historyModel->updateScheduleItem($id, $data);
            ResponseHelper::sendJson($scheduleItem);
        }
        else {
            ResponseHelper::sendError('Missing information for item updates', 404);
        }
    }
    public function getScheduleItemById($id) {
        $scheduleItem = $this->historyModel->getScheduleItemById($id);
        if ($scheduleItem) {
            ResponseHelper::sendJson($scheduleItem);
        } else {
            ResponseHelper::sendError('Schedule item not found', 404);
        }
    }
    public function createLocation() {
        requireApiRole(['admin']);
        $data = json_decode(file_get_contents("php://input"), true);

        if (isset($data['image_name']) && isset($data['name']) && isset($data['description'])) {
            $location = $this->historyModel->createLocation($data);
            ResponseHelper::sendJson($location);
        }
        else {
            ResponseHelper::sendError('Missing information for location creation', 404);
        }
    }
    public function deleteLocation($id) {
        requireApiRole(['admin']);
        $success = $this->historyModel->deleteLocation($id);
        if ($success)
        {
            ResponseHelper::sendJson('Successfully deleted location with id: ' . $id);
        }
        else {
            ResponseHelper::sendError('Could not delete location with id: ' . $id, 404);
        }
    }
    public function updateLocation($id) {
        requireApiRole(['admin']);
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['image_name']) && isset($data['name']) && isset($data['description']) && isset($id)) {
            $location = $this->historyModel->updateLocation($id, $data);
            ResponseHelper::sendJson($location);
        }
        else {
            ResponseHelper::sendError('Missing information for location updates', 404);
        }
    }
}
?>
