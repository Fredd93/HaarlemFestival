<?php

require_once(__DIR__ . "/../models/YummySessionModel.php");
require_once(__DIR__ . "/utils/ResponseHelper.php");

class YummySessionController
{
    private YummySessionModel $model;

    public function __construct()
    {
        $this->model = new YummySessionModel();
    }

    /**
     * Get all sessions for a restaurant/event.
     */
    public function getAllByEventId(): void
    {
        $eventId = $_GET["event_id"] ?? null;
        if (!$eventId || !is_numeric($eventId)) {
            ResponseHelper::sendError("Missing or invalid event_id.");
        }

        $sessions = $this->model->getAllSessionsByEventId((int)$eventId);
        ResponseHelper::sendJson($sessions);
    }

    /**
     * Update seats for a specific session.
     */
    public function updateSeats(): void
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!$input) {
            ResponseHelper::sendError("Invalid input.");
        }

        $sessionId = $input["session_id"] ?? null;
        $maxSeats = $input["max_seats"] ?? null;
        $availableSeats = $input["available_seats"] ?? null;

        if (
            !$sessionId || !$maxSeats || $availableSeats === null ||
            !is_numeric($sessionId) || !is_numeric($maxSeats) || !is_numeric($availableSeats)
        ) {
            ResponseHelper::sendError("Missing or invalid fields.");
        }

        $success = $this->model->updateSeats((int)$sessionId, (int)$maxSeats, (int)$availableSeats);
        if ($success) {
            ResponseHelper::sendJson(["message" => "Session updated successfully."]);
        } else {
            ResponseHelper::sendError("Failed to update session.");
        }
    }
}
