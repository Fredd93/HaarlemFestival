<?php
require_once(__DIR__ . '/../../api/InvoiceAPIController.php');

Route::add('/api/invoices', function () {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new InvoiceApiController();
        $controller->create();
    }
}, ['POST']);

Route::add('/api/invoices/order/([0-9]+)', function ($orderId) {
    $controller = new InvoiceApiController();
    $controller->getByOrderId($orderId);
}, ['GET']);

Route::add('/api/invoices/scan/([0-9]+)', function ($invoiceId) {
    $controller = new InvoiceApiController();
    $controller->scanInvoice($invoiceId);
}, ['GET']);
