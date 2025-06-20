<?php
require_once(__DIR__ . '/../../api/OrderApiController.php');

$controller = new OrderApiController();

Route::add('/api/orders', function () use ($controller) {
    $controller->getAllOrders();
}, ['GET']);

Route::add('/api/orders/([0-9]+)', function ($id) use ($controller) {
    $controller->getOrderById((int)$id);
}, ['GET']);

Route::add('/api/orders/create', function () use ($controller) {
    $controller->createOrder();
}, ['POST']);

Route::add('/api/orders/delete/([0-9]+)', function ($id) use ($controller) {
    $controller->deleteOrder((int)$id);
}, ['DELETE']);
