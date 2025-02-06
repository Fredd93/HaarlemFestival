<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/EventDetailDTO.php");

class EventDetailModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }

    public function getAll(): array {
        $sql = "SELECT * FROM Event_Detail";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }

    public function getById(int $id): ?EventDetailDTO {
        $sql = "SELECT * FROM Event_Detail WHERE detail_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapToDTO($row) : null;
    }

    public function getByEventId(int $eventId): array {
        $sql = "SELECT * FROM Event_Detail WHERE event_id = :eventId";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":eventId", $eventId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }

    private function mapToDTO(array $row): EventDetailDTO {
        return new EventDetailDTO(
            $row["detail_id"],
            $row["event_id"],
            $row["type"],
            $row["description"] ?? null,
            $row["image_url"] ?? null,
            $row["event_time"],
            $row["event_date"],
            $row["location"],
            (float) $row["event_price"],
            (int) $row["current_capacity"],
            (int) $row["max_capacity"],
            $row["tags"] ?? null,
            isset($row["rating"]) ? (float) $row["rating"] : null,
            $row["name"]
        );
    }

    public function getByType(string $type): array {
        $sql = "SELECT * FROM Event_Detail WHERE type = :type";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":type", $type, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }
    
}
