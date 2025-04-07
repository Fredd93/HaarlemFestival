<?php
declare(strict_types=1);

require_once(__DIR__ . "/../models/EventDetailReferenceModel.php");

class EventDetailReferenceController
{
    private EventDetailReferenceModel $model;

    public function __construct()
    {
        $this->model = new EventDetailReferenceModel();
    }

    public function getEventTypeByEventId(int $eventId): ?string
    {
        return $this->model->getEventTypeByEventId($eventId);
    }
}
