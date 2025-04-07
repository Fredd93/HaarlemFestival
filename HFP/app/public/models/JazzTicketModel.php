<?php
require_once(__DIR__ . "/BaseModel.php");

class JazzTicketModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }

    // Fetch all tickets
    public function getAll(): array {
        $sql = "SELECT * FROM Jazz_Ticket";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch tickets by event ID
    public function getByEventId(int $eventId): array {
        $sql = "SELECT * FROM Jazz_Ticket WHERE event_detail_id = :eventId";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":eventId", $eventId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    // Book a ticket
    public function bookTicket(string $jazzType, string $ticketType, int $eventDetailId, ?int $passId, float $price): bool {
        $sql = "INSERT INTO Jazz_Ticket (jazz_type, ticket_type, event_detail_id, pass_id, price)
                VALUES (:jazzType, :ticketType, :eventDetailId, :passId, :price)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":jazzType", $jazzType);
        $stmt->bindParam(":ticketType", $ticketType);
        $stmt->bindParam(":eventDetailId", $eventDetailId, PDO::PARAM_INT);
        $stmt->bindParam(":passId", $passId, PDO::PARAM_INT);
        $stmt->bindParam(":price", $price);
        return $stmt->execute();
    }
    public function getEventIdByDetailId(int $eventDetailId): ?int {
        $sql = "SELECT event_id FROM Event_Detail_Reference WHERE event_detail_id = :detail_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':detail_id', $eventDetailId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['event_id'] : null;
    }

    // Get available seats from Jazz_Events
    public function getAvailableSeats(int $eventDetailId): ?int {
        $sql = "SELECT seats FROM Jazz_Events WHERE event_detail_id = :event_detail_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":event_detail_id", $eventDetailId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
    public function decreaseSeatCount(int $eventDetailId): bool {
        $sql = "UPDATE Jazz_Events SET seats = seats - 1
                WHERE event_detail_id = :event_detail_id AND seats > 0";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":event_detail_id", $eventDetailId, PDO::PARAM_INT);
        return $stmt->execute();
    }    
}
