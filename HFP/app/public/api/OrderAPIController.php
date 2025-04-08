<?php
require_once(__DIR__ . '/../models/OrderModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');

class OrderAPIController {
    private OrderModel $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    public function create() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['user_id'], $data['total_price'], $data['payment_method'])) {
            ResponseHelper::sendError("Missing required fields", 400);
            return;
        }

        $userId = (int)$data['user_id'];
        $totalPrice = (int)$data['total_price'];
        $paymentMethod = $data['payment_method'];

        $orderId = $this->orderModel->createOrder($userId, $totalPrice, $paymentMethod);
        $order = $this->orderModel->getOrderById($orderId);

        ResponseHelper::sendJson($order);
    }

    public function getByUserId($userId) {
        $orders = $this->orderModel->getOrdersByUserId((int)$userId);
        ResponseHelper::sendJson($orders);
    }

    public function getById($orderId) {
        $order = $this->orderModel->getOrderById((int)$orderId);
        if ($order) {
            ResponseHelper::sendJson($order);
        } else {
            ResponseHelper::sendError("Order not found", 404);
        }
    }
}
?>