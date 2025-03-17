<?php
class ResponseHelper {
    public static function sendJson($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        if (empty($data)) {
            error_log("ResponseHelper: Empty JSON response detected");
        } else {
            error_log("ResponseHelper: Sending JSON response with " . count($data) . " records");
        }
        echo json_encode($data);
        exit;
    }

    public static function sendError($message, $statusCode = 400) {
        error_log("ResponseHelper: Sending error response - " . $message);
        self::sendJson(['error' => $message], $statusCode);
    }
}
