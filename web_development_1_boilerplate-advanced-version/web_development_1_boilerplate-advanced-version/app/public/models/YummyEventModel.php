<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/YummyEventDTO.php");

class YummyEventModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }

    // Fetch all Yummy Events
    public function getAll(): array {
        $sql = "SELECT * FROM Yummy_Events";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }

    // Fetch a single Yummy Event by ID
    public function getById(int $id): ?YummyEventDTO {
        $sql = "SELECT * FROM Yummy_Events WHERE event_detail_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->mapToDTO($row) : null;
    }

    // Fetch Yummy Events by type (e.g., "French", "Seafood")
    public function getByType(string $type): array {
        $sql = "SELECT * FROM Yummy_Events WHERE type LIKE :type";
        $stmt = self::$pdo->prepare($sql);
        $type = "%" . $type . "%"; // Allow partial matching
        $stmt->bindParam(":type", $type, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }

    public function getUniqueFoodTypes(): array {
        $sql = "SELECT type FROM Yummy_Events";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $allTypes = [];
    
        foreach ($results as $row) {
            $types = explode(',', $row['type']); // Split the comma-separated types
            foreach ($types as $type) {
                $trimmedType = trim($type); // Remove spaces
                if (!in_array($trimmedType, $allTypes)) {
                    $allTypes[] = $trimmedType; // Store unique types
                }
            }
        }
    
        return $allTypes; // Return array of unique food types
    }

    public function createYummyEvent(string $name, int $sessions, float $session_duration, string $start_time, string $end_time, string $type, float $price, int $seats, ?string $img, ?string $description, int $stars = 0): ?YummyEventDTO {
        $sql = "INSERT INTO Yummy_Events (name, sessions, session_duration, start_time, end_time, type, price, seats, img, description, stars) 
                VALUES (:name, :sessions, :session_duration, :start_time, :end_time, :type, :price, :seats, :img, :description, :stars)";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":sessions", $sessions, PDO::PARAM_INT);
        $stmt->bindParam(":session_duration", $session_duration);
        $stmt->bindParam(":start_time", $start_time);
        $stmt->bindParam(":end_time", $end_time);
        $stmt->bindParam(":type", $type);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":seats", $seats, PDO::PARAM_INT);
        $stmt->bindParam(":img", $img);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":stars", $stars, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $id = self::$pdo->lastInsertId();
            return $this->getById($id);
        }
        return null;
    }
    public function updateYummyEvent(int $id, string $name, int $sessions, float $session_duration, string $start_time, string $end_time, string $type, float $price, int $seats, ?string $img, ?string $description, int $stars): bool {
        $sql = "UPDATE Yummy_Events SET name = :name, sessions = :sessions, session_duration = :session_duration, 
                start_time = :start_time, end_time = :end_time, type = :type, price = :price, seats = :seats, 
                img = :img, description = :description, stars = :stars WHERE event_detail_id = :id";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":sessions", $sessions, PDO::PARAM_INT);
        $stmt->bindParam(":session_duration", $session_duration);
        $stmt->bindParam(":start_time", $start_time);
        $stmt->bindParam(":end_time", $end_time);
        $stmt->bindParam(":type", $type);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":seats", $seats, PDO::PARAM_INT);
        $stmt->bindParam(":img", $img);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":stars", $stars, PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
    public function deleteYummyEvent(int $id): bool {
        $sql = "DELETE FROM Yummy_Events WHERE event_detail_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    

    // Map a database row to YummyEventDTO
    private function mapToDTO(array $row): YummyEventDTO {
        return new YummyEventDTO(
            $row["event_detail_id"],
            $row["name"],
            (int) $row["sessions"],
            (float) $row["session_duration"],
            $row["start_time"],
            $row["end_time"],
            $row["type"],
            (float) $row["price"],
            (int) $row["seats"],
            (int) $row["stars"],
            $row["img"] ?? null,
            $row["description"] ?? null
        );
    }
}
?>
