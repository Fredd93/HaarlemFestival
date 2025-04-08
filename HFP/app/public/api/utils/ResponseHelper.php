<?php
class ResponseHelper {
    public static function sendJson($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');

        // Logging
        if (empty($data)) {
            error_log("ResponseHelper: Empty JSON response detected");
        } elseif (is_array($data) || $data instanceof Countable) {
            error_log("ResponseHelper: Sending JSON response with " . count($data) . " records");
        } else {
            error_log("ResponseHelper: Sending JSON response (non-countable object)");
        }

        // Object serialization check
        if (is_object($data) && method_exists($data, 'jsonSerialize')) {
            echo json_encode($data->jsonSerialize());
        } else {
            echo json_encode($data);
        }

        exit;
    }

    public static function sendError($message, $statusCode = 400) {
        error_log("ResponseHelper: Sending error response - " . $message);
        self::sendJson(['error' => $message], $statusCode);
    }
}
