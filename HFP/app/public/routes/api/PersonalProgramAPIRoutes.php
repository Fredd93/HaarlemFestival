<?php
require_once(__DIR__ . '/../../api/PersonalProgramAPIController.php');

Route::add('/api/programsById', function () {
    $userId = $_GET['userId'] ?? null;
    
    if ($userId) {
        $controller = new PersonalProgramAPIController();
        $controller->getById((int)$userId);
    } else {
        ResponseHelper::sendError('User ID not provided', 400);
    }
}, ['GET']);
?>