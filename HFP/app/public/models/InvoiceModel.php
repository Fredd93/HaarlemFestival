<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/InvoiceDTO.php");

class InvoiceModel extends BaseModel {

    public function __construct() {
        parent::__construct();
    }

    public function createInvoice(int $orderId, string $dueDate): int {
        $sql = "INSERT INTO invoice (order_id, due_date, status, email_sent)
        VALUES (:order_id, :due_date, 'paid', 0)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":order_id", $orderId, PDO::PARAM_INT);
        $stmt->bindParam(":due_date", $dueDate);
        $stmt->execute();
        return (int) self::$pdo->lastInsertId();
    }

    public function getByOrderId(int $orderId): ?InvoiceDTO {
        $sql = "SELECT * FROM invoice WHERE order_id = :order_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":order_id", $orderId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapToDTO($row) : null;
    }

    public function markAsScanned(int $invoiceId): bool {
        $sql = "UPDATE invoice SET status = 'scanned' WHERE invoice_id = :invoice_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":invoice_id", $invoiceId, PDO::PARAM_INT);
        return $stmt->execute() && $stmt->rowCount() > 0;
    }

    private function mapToDTO(array $row): InvoiceDTO {
        return new InvoiceDTO(
            (int) $row['invoice_id'],
            (int) $row['order_id'],
            $row['due_date'],
            $row['status'],
            $row['email_sent']
        );
    }
}
