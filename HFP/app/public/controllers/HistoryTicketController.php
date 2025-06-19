<?php

require_once(__DIR__ . '/../models/HistoryTicketModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');
require_once(__DIR__ . '/../models/PersonalProgramModel.php');
require_once(__DIR__ . '/../middleware/apiAuthMiddleware.php'); 

class HistoryTicketController{
    private $historyTicketModel;
    private $programModel;

    public function __construct() {
        $this->historyTicketModel = new HistoryTicketModel();
        $this->programModel = new PersonalProgramModel();
    }
    public function createTicket() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['location']) && isset($data['date']) && isset($data['language']) && isset($data['ticket_type']) && isset($data['ticket_count']) && isset($data['price'])) {
            try {
                $result = $this->historyTicketModel->createTicket($data);
                if ($result) {
                    //ResponseHelper::sendJson(var_dump($result));
                    // Add to personal program
                    $eventDetailId = $this->historyTicketModel->getFirstDetailId($result['date'], $result['language']);
                    $eventId = $this->historyTicketModel->getEventIdByDetailId($eventDetailId);
                    if ($eventId !== null) {
                        $userId = $_SESSION['user_id']; 
                        $this->programModel->addToProgram(
                            $userId,
                            $eventId,
                            $eventDetailId,
                            $result['ticket_id'],
                            'history'
                        );
                    }
                    else {
                        ResponseHelper::sendJson('Something went wrong: ' 
                            . $userId
                            . $eventId
                            . $eventDetailId
                            . $result['ticket_id']
                            . 'history');
                    }
                    ResponseHelper::sendJson('Successfully created ticket');
                }
            }
            catch (Exception $e){
                ResponseHelper::sendError($e->getMessage(), 400);
            }
        }
        else {
            ResponseHelper::sendError('Missing field information', 400);
        }
    }
}
?>