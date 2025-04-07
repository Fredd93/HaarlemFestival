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
    

    public function bookTicket(string $danceType, string $ticketType, int $eventDetailId, ?int $passId, float $price): bool {
        $sql = "INSERT INTO Dance_Ticket (dance_type, ticket_type, event_detail_id, pass_id, price)
                VALUES (:danceType, :ticketType, :eventDetailId, :passId, :price)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":danceType", $danceType);
        $stmt->bindParam(":ticketType", $ticketType);
        $stmt->bindParam(":eventDetailId", $eventDetailId, PDO::PARAM_INT);
        $stmt->bindParam(":passId", $passId, PDO::PARAM_INT);
        $stmt->bindParam(":price", $price);
        return $stmt->execute();
    }
}
?>
