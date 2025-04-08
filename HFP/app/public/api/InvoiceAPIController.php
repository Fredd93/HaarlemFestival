<?php
require_once(__DIR__ . '/../models/InvoiceModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class InvoiceAPIController {
    private InvoiceModel $invoiceModel;

    public function __construct() {
        $this->invoiceModel = new InvoiceModel();
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['order_id'], $data['due_date'])) {
            ResponseHelper::sendError("Missing required fields", 400);
            return;
        }

        $orderId = (int)$data['order_id'];
        $dueDate = $data['due_date'];

        $invoiceId = $this->invoiceModel->createInvoice($orderId, $dueDate);
        $invoice = $this->invoiceModel->getByOrderId($orderId);
        ResponseHelper::sendJson($invoice);
    }

    public function scanInvoice($invoiceId) {
        $success = $this->invoiceModel->markAsScanned((int)$invoiceId);

        if ($success) {
            ResponseHelper::sendJson(["message" => "Invoice marked as scanned"]);
        } else {
            ResponseHelper::sendError("Invoice not found or already scanned", 404);
        }
    }

    public function getByOrderId($orderId) {
        $invoice = $this->invoiceModel->getByOrderId((int)$orderId);

        if ($invoice) {
            ResponseHelper::sendJson($invoice);
        } else {
            ResponseHelper::sendError("Invoice not found", 404);
        }
    }
}
