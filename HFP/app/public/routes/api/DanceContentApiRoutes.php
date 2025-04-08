<?php
require_once(__DIR__ . '/../../api/DanceContentApiController.php');

$controller = new DanceContentApiController();

Route::add('/api/dancecontent/page', function () use ($controller) {
    $controller->getContentByPage($_GET);
}, ['GET']);
