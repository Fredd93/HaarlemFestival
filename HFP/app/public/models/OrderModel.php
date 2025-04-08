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

    
    public function getOrderById(int $orderId): ?OrderDTO {
        $sql = "SELECT * FROM [order] WHERE order_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapToDTO($row) : null;
    }

    public function createOrder(int $userId, int $totalPrice, string $paymentMethod): int {
        $sql = "INSERT INTO [order] (user_id, total_price, payment_method, created_at)
        VALUES (:user_id, :total_price, :payment_method, GETDATE())";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":total_price", $totalPrice, PDO::PARAM_INT);
        $stmt->bindParam(":payment_method", $paymentMethod, PDO::PARAM_STR);
        $stmt->execute();
        return (int) self::$pdo->lastInsertId();
    }

    public function deleteOrder(int $id): bool {
        $stmt = self::$pdo->prepare("DELETE FROM [$this->table] WHERE order_id = ?");
        return $stmt->execute([$id]);
    }
    private function mapToDTO(array $row): OrderDTO {
        return new OrderDTO(
            (int) $row['order_id'],
            (int) $row['user_id'],
            (int) $row['total_price'],
            $row['payment_method'],
            $row['created_at']
        );
    }
}
?>
