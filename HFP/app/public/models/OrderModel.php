<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/OrderDTO.php");

class OrderModel extends BaseModel {
    protected $table = "Order";

    public function getAllOrders(): array {
        $stmt = self::$pdo->query("SELECT * FROM [$this->table]");
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => new OrderDTO(
            $row['order_id'],
            $row['user_id'],
            (float)$row['total_price'],
            $row['payment_method'],
            $row['created_at']
        ), $orders);
    }

    public function getOrderById(int $id): ?OrderDTO {
        $stmt = self::$pdo->prepare("SELECT * FROM [$this->table] WHERE order_id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new OrderDTO(
            $row['order_id'],
            $row['user_id'],
            (float)$row['total_price'],
            $row['payment_method'],
            $row['created_at']
        ) : null;
    }

    public function createOrder(int $user_id, float $total_price, string $payment_method): bool {
        $stmt = self::$pdo->prepare("INSERT INTO [$this->table] (user_id, total_price, payment_method) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $total_price, $payment_method]);
    }

    public function deleteOrder(int $id): bool {
        $stmt = self::$pdo->prepare("DELETE FROM [$this->table] WHERE order_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
