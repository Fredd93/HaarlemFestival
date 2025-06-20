<?php
require_once(__DIR__ . '/../models/OrderModel.php');
require_once(__DIR__ . '/../api/utils/ResponseHelper.php');
require_once(__DIR__ . '/../middleware/apiAuthMiddleware.php');

class OrderApiController {
    private OrderModel $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    public function getAllOrders() {
        requireApiRole(['admin']);
        try {
            $orders = $this->orderModel->getAllOrders();
            ResponseHelper::sendJson($orders);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve orders", 500);
        }
    }

    public function getOrderById(int $id) {
        requireApiRole(['admin']);
        try {
            $order = $this->orderModel->getOrderById($id);
            if ($order) {
                ResponseHelper::sendJson($order);
            } else {
                ResponseHelper::sendError("Order not found", 404);
            }
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to retrieve order", 500);
        }
    }

    public function createOrder() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            if (!isset($data['user_id'], $data['total_price'], $data['payment_method'])) {
                ResponseHelper::sendError("Missing required fields", 400);
                return;
            }

            $orderId = $this->orderModel->createOrder(
                (int)$data['user_id'],
                (float)$data['total_price'],
                (string)$data['payment_method']
            );

            if ($orderId > 0) {
                ResponseHelper::sendJson(["message" => "Order created", "order_id" => $orderId], 201);
            } else {
                ResponseHelper::sendError("Failed to create order", 500);
            }

        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to create order", 500);
        }
    }

    public function deleteOrder(int $id) {
        requireApiRole(['admin']);
        try {
            $success = $this->orderModel->deleteOrder($id);
            $success
                ? ResponseHelper::sendJson(["message" => "Order deleted"])
                : ResponseHelper::sendError("Failed to delete order", 500);
        } catch (Exception $e) {
            ResponseHelper::sendError("Failed to delete order", 500);
        }
    }
}
