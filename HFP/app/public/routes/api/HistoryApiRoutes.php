<?php
require_once(__DIR__ . '/../../controllers/HistoryAPIController.php');
$controller = new HistoryAPIController();

Route::add('/api/history/schedule', function () use ($controller) {
    $controller->getFullSchedule();
}, ['GET']);

Route::add('/api/history/([a-z-0-9-]*)', function ($id) use ($controller) {
    $controller->getAllById($id);
}, ['GET']);
?>