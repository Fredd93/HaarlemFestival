<?php
require_once(__DIR__ . '/../api/orderApiRoutes.php');
require_once(__DIR__ . '/../../api/OrderApiController.php');


$controller = new OrderApiController();


Route::add('/api/orders', function () {
    $controller = new OrderApiController();
    $controller->getAllOrders();
}, ['GET']);

Route::add('/api/orders/([0-9]+)', function ($id) {
    $controller = new OrderApiController();
    $controller->getOrderById((int)$id);
    
}, ['GET']);

Route::add('/api/orders/create', function () {
    $controller = new OrderApiController();
    $controller->createOrder();
}, ['POST']);

Route::add('/api/orders/delete/([0-9]+)', function ($id) {
    $controller = new OrderApiController();
    $controller->deleteOrder($id);
}, ['DELETE']);
