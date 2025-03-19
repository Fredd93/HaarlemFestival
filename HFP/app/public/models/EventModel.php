<?php
require_once 'BaseModel.php';
require_once 'dto/EventDTO.php';

class EventModel extends BaseModel {
    protected $table = "Event"; // Table name

    public function getAllEvents() {
        $sql = "SELECT event_id, name, description, image FROM " . $this->table;
        $stmt = self::$pdo->query($sql);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert database results to DTO objects
        $eventDTOs = [];
        foreach ($events as $event) {
            $eventDTOs[] = new EventDTO($event['event_id'], $event['name'], $event['description'], $event['image']);
        }

        return $eventDTOs;
    }

    public function getEventById(int $id): ?EventDTO {
        $sql = "SELECT event_id, name, description, image FROM " . $this->table . " WHERE event_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        return $event ? new EventDTO($event['event_id'], $event['name'], $event['description'], $event['image']) : null;
    }

    public function createEvent(string $name, string $description, string $image): bool {
        $sql = "INSERT INTO " . $this->table . " (name, description, image) VALUES (:name, :description, :image)";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute(["name" => $name, "description" => $description, "image" => $image]);
    }

    public function updateEvent(int $id, string $name, string $description, string $image): bool {
        $sql = "UPDATE " . $this->table . " SET name = :name, description = :description, image = :image WHERE event_id = :id";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute(["id" => $id, "name" => $name, "description" => $description, "image" => $image]);
    }

    public function deleteEvent(int $id): bool {
        $sql = "DELETE FROM " . $this->table . " WHERE event_id = :id";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute(["id" => $id]);
    }
}
?>
