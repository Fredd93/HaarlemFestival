<?php
require_once(__DIR__ . '/../../api/PersonalProgramAPIController.php');

Route::add('/api/programsById', function ($userId) {
    $controller = new PersonalProgramAPIController();
    $controller->getById($userId);
}, ['GET']);
?>