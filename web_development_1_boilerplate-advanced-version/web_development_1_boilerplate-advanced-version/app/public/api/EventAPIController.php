<?php
require_once(__DIR__ . '/../models/EventModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class EventApiCOntroller{
    private $eventModel;
    public function __construct()
    {
        $this->eventModel=new EventModel();

    }
    public function getAllEvents(){
        try{
            $events = $this->eventModel->getAllEvents();
            if($events){
                ResponseHelper::sendJson($events);
            }
            else{
                ResponseHelper::sendError("Events not found", 404);
            }
        }catch(Exception $e){
            ResponseHelper::sendError("Could not retrieve events", 500);
        }
    }
}

?>