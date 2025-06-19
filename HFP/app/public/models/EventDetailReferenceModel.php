<?php
require_once(__DIR__ . '/BaseModel.php');

class EventDetailReferenceModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }

    // Fetch all entries for a given event type (e.g., 'yummy', 'jazz', 'dance')
    public function getByEventType(string $eventType): array {
        $sql = "SELECT * FROM Event_Detail_Reference WHERE event_type = :event_type AND [name] != :name";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":event_type", $eventType, PDO::PARAM_STR);
        $stmt->bindValue(":name", "HistoryTour"); //Exception required because 
        // events for pages that aren't history are the same as detailpages, unlike history where those are seperate
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Optional: Fetch a single detail reference by detail_id
    public function getByDetailId(int $detailId): ?array {
        $sql = "SELECT * FROM Event_Detail_Reference WHERE event_detail_id = :detail_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":detail_id", $detailId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
    public function getEventTypeByEventId(int $eventId): ?string
    {
        $query = "SELECT TOP 1 event_type FROM Event_Detail_Reference WHERE event_id = :event_id";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(":event_id", $eventId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['event_type'] ?? null;
    }
}
