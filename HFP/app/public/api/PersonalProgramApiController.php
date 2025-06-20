<?php
error_log("USER ID in session: " . ($_SESSION['user_id'] ?? 'NOT SET'));
require_once(__DIR__ . "/../models/PersonalProgramModel.php");
require_once(__DIR__ . "/../api/utils/ResponseHelper.php");

class PersonalProgramApiController
{
    private PersonalProgramModel $model;

    public function __construct()
    {
        $this->model = new PersonalProgramModel();
    }
    public function getAllForUser($userId = null): void
    {
        if(!$userId) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // Debug: Log the current session user ID (or missing)
            error_log("🔍 PersonalProgramApiController - Session user_id: " . ($_SESSION['user_id'] ?? 'NOT SET'));

            if (!isset($_SESSION['user_id'])) {
                ResponseHelper::sendError("Unauthorized", 401);
                return;
            }

            $userId = $_SESSION['user_id'];
        }

        try {
            $items = $this->model->getProgramItemsByUser($userId);
            ResponseHelper::sendJson($items);
        } catch (Exception $e) {
            error_log("❌ Failed to fetch personal program: " . $e->getMessage());
            ResponseHelper::sendError("Internal server error", 500);
        }
    }
    public function delete($id) {
        try {
            $success = $this->model->deleteProgramItem((int)$id);
            if ($success) {
                ResponseHelper::sendJson(["message" => "Item deleted"]);
            } else {
                ResponseHelper::sendError("Item not found", 404);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Error deleting item: " . $e->getMessage(), 500);
        }
    }
    public function scanQrCode($programID){
        try {
            $success = $this->model->scanQrCode((int)$programID);
            if ($success) {
                ResponseHelper::sendJson(["message" => "Personal program was scanned"]);
            } else {
                ResponseHelper::sendError("Personal program already scanned or does not exist", 400);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Error scanning personal program: " . $e->getMessage(), 500);
        }
        
    }
}
