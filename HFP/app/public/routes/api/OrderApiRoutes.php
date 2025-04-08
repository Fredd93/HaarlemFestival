<?php
require_once(__DIR__ . '/../../api/OrderAPIController.php');

Route::add('/api/orders', function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new OrderApiController();
        $controller->create();
    }
}, ['POST']);

Route::add('/api/orders/user/([0-9]+)', function ($userId) {
    $controller = new OrderApiController();
    $controller->getByUserId($userId);
}, ['GET']);

Route::add('/api/orders/([0-9]+)', function ($orderId) {
    $controller = new OrderApiController();
    $controller->getById($orderId);
}, ['GET']);
