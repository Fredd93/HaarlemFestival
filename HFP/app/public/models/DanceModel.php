<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/DanceArtistDTO.php");
require_once(__DIR__ . "/../dto/DanceEventDTO.php");

class DanceModel extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }

    // Get all Dance Event Artists
    public function getAllById(): array {
        $sql = "SELECT * FROM Artists WHERE event_id = 10"; 
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }

    private function mapToDTO(array $row): DanceArtistDTO {
        return new DanceArtistDTO(
            (int) $row["artist_id"],
            $row["name"], 
            $row["description"] ?? "" 
        );
    }

    private function mapToEventsDTO(array $row): DanceEventDTO{
        return new DanceEventDTO(
            $row["artists"],
            (int)$row["event_detail_id"],
            $row["time"],
            $row["venue"],
            $row["session_type"],
            (int)$row["duration"],
            (int)$row["price"],
            $row["day"]
        );
    }

    // Get all Dance Events
    public function getAllEvents(): array {
        $sql = "SELECT 
                D.event_detail_id, 
                CONVERT(VARCHAR(5), D.time, 108) AS time,
                D.venue, 
                D.session_type, 
                D.duration, 
                D.price, 
                D.day, 
                STRING_AGG(A.name, '/') AS artists
                FROM Dance_Events D
                JOIN Dance_Event_Artists E ON D.event_detail_id = E.event_detail_id
                JOIN Artists A ON A.artist_id = E.artist_id
                GROUP BY D.event_detail_id, D.time, D.venue, D.session_type, D.duration, D.price, D.day;";
        
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return array_map(fn($row) => $this->mapToEventsDTO($row), $results);
    }

    // Get a single Dance Event by ID
    public function getById(int $id): ?DanceEventDTO {
        $sql = "SELECT 
                D.event_detail_id, 
                CONVERT(VARCHAR(5), D.time, 108) AS time,
                D.venue, 
                D.session_type, 
                D.duration, 
                D.price, 
                D.day, 
                STRING_AGG(A.name, '/') AS artists
                FROM Dance_Events D
                JOIN Dance_Event_Artists E ON D.event_detail_id = E.event_detail_id
                JOIN Artists A ON A.artist_id = E.artist_id
                WHERE D.event_detail_id = :id
                GROUP BY D.event_detail_id, D.time, D.venue, D.session_type, D.duration, D.price, D.day;";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapToEventsDTO($row) : null;
    }

    // Create a new Dance Event
    public function create(string $time, string $venue, string $sessionType, int $duration, float $price, string $day, array $artistIds): ?DanceEventDTO {
        $sql = "INSERT INTO Dance_Events (time, venue, session_type, duration, price, day)
                VALUES (:time, :venue, :sessionType, :duration, :price, :day)";
        
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":time", $time);
        $stmt->bindParam(":venue", $venue);
        $stmt->bindParam(":sessionType", $sessionType);
        $stmt->bindParam(":duration", $duration, PDO::PARAM_INT);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":day", $day);

        if ($stmt->execute()) {
            $eventId = self::$pdo->lastInsertId();

            foreach ($artistIds as $artistId) {
                $sql = "INSERT INTO Dance_Event_Artists (event_detail_id, artist_id) VALUES (:eventId, :artistId)";
                $stmt = self::$pdo->prepare($sql);
                $stmt->bindParam(":eventId", $eventId, PDO::PARAM_INT);
                $stmt->bindParam(":artistId", $artistId, PDO::PARAM_INT);
                $stmt->execute();
            }
            return $this->getById($eventId);
        }
        return null;
    }

    // Update Dance Event
    public function update(int $id, string $time, string $venue, string $sessionType, int $duration, float $price, string $day): bool {
        $sql = "UPDATE Dance_Events SET time = :time, venue = :venue, session_type = :sessionType, duration = :duration, price = :price, day = :day WHERE event_detail_id = :id";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":time", $time);
        $stmt->bindParam(":venue", $venue);
        $stmt->bindParam(":sessionType", $sessionType);
        $stmt->bindParam(":duration", $duration, PDO::PARAM_INT);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":day", $day);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Delete Dance Event
    public function delete(int $id): bool {
        $sql = "DELETE FROM Dance_Events WHERE event_detail_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
?>
