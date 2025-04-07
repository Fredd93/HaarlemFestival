<?php

require_once(__DIR__ . '/../../api/EventDetailReferenceApiController.php');

$eventRefController = new EventDetailReferenceApiController();

Route::add('/api/event-detail-references/type/([a-zA-Z0-9_-]+)', function ($eventType) use ($eventRefController) {
    $eventRefController->getByEventType($eventType);
}, ['GET']);
Route::add('/api/events/type/([0-9]+)', function ($eventId) use ($controller) {
    $controller->getEventTypeByEventId($eventId);
}, ['GET']);