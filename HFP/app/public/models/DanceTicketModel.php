<?php
require_once(__DIR__ . "/BaseModel.php");

class DanceTicketModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }

    public function getAll(): array {
        $sql = "SELECT * FROM Dance_Ticket";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getEventIdByDetailId(int $eventDetailId): ?int {
        $sql = "SELECT event_id FROM Event_Detail_Reference WHERE event_detail_id = :detail_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':detail_id', $eventDetailId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['event_id'] : null;
    }
    
    public function getByEventId(int $eventDetailId): array {
        $sql = "SELECT * FROM Dance_Ticket WHERE event_detail_id = :event_detail_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":event_detail_id", $eventDetailId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableSeats(int $eventDetailId): ?int {
        $sql = "SELECT tickets_available FROM Dance_Events WHERE event_detail_id = :event_detail_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":event_detail_id", $eventDetailId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    

    public function decreaseSeatCount(int $eventDetailId): bool {
        $sql = "UPDATE Dance_Events
                SET tickets_available = tickets_available - 1
                WHERE event_detail_id = :event_detail_id AND tickets_available > 0";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":event_detail_id", $eventDetailId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    

    public function bookTicket(string $ticketType, int $eventDetailId, ?int $passId, float $price): ?int {
        $sql = "INSERT INTO Dance_Ticket (ticket_type, event_detail_id, pass_id, price)
                VALUES (:ticket_type, :event_detail_id, :pass_id, :price)";
    
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":ticket_type", $ticketType);
        $stmt->bindParam(":event_detail_id", $eventDetailId);
        $stmt->bindParam(":pass_id", $passId);
        $stmt->bindParam(":price", $price);
    
        if ($stmt->execute()) {
            return (int)self::$pdo->lastInsertId();
        }
        return null;
    }
    
    
}
?>
