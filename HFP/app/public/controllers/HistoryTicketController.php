<?php

require_once(__DIR__ . '/../models/HistoryTicketModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');
require_once(__DIR__ . '/../middleware/apiAuthMiddleware.php'); 

class HistoryTicketController{
    private $historyTicketModel;

    public function __construct() {
        $this->historyTicketModel = new HistoryTicketModel();
    }
    public function createTicket() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['location']) && isset($data['time']) && isset($data['language']) && isset($data['ticket_type']) && isset($data['ticket_count'])) {
            $result = $this->historyTicketModel->createTicket($data);
            if ($result) {
                ResponseHelper::sendJson('Successfully created ticket');
            }
        }
        else {
            ResponseHelper::sendError('Missing field information', 404);
        }
    }
}
?>