<?php
require_once(__DIR__ . '/../../api/DanceContentApiController.php');

$controller = new DanceContentApiController();

Route::add('/api/dancecontent/all', function () use ($controller) {
    $controller->getAllContent(); // This method should fetch all dance content
}, ['GET']);

Route::add('/api/dancecontent/page', function () use ($controller) {
    $controller->getContentByPage($_GET); // This will use ?page=danceAfrojack
}, ['GET']);
