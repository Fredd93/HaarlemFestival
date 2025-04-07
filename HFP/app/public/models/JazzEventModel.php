<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/JazzEventDTO.php");

class JazzEventModel extends BaseModel {
    protected $table = "Jazz_Events"; // Table name

    // Get all Jazz Events
    public function getAllJazzEvents() {
        $sql = "SELECT event_detail_id, name, time, venue, artist_id, duration, price, image, event_date, description, seats FROM " . $this->table;
        $stmt = self::$pdo->query($sql);
        $stmt->execute();
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convert database results to DTO objects
        $eventDTOs = [];
        foreach ($events as $event) {
            $eventDTOs[] = new JazzEventDTO(
                $event['event_detail_id'],
                $event['name'],
                $event['time'],
                $event['venue'],
                $event['artist_id'],
                (float) $event['duration'],
                (float) $event['price'],
                $event['image'],
                $event['event_date'],
                $event['description'],
                (int) $event['seats'] // Added seats
            );
        }

        return $eventDTOs;
    }

    // Get Jazz Event by ID
    public function getJazzEventById(int $id) {
        $sql = "SELECT event_detail_id, name, time, venue, artist_id, duration, price, image, event_date, description, seats 
                FROM " . $this->table . " 
                WHERE event_detail_id = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$event) {
            return null;
        }

        return new JazzEventDTO(
            $event['event_detail_id'],
            $event['name'],
            $event['time'],
            $event['venue'],
            $event['artist_id'],
            (float) $event['duration'],
            (float) $event['price'],
            $event['image'],
            $event['event_date'],
            $event['description'],
            (int) $event['seats'] // Added seats
        );
    }

    // Get Jazz Events by Date
    public function getJazzEventsByDate(string $date) {
        $sql = "SELECT event_detail_id, name, time, venue, artist_id, duration, price, image, event_date, description, seats 
                FROM " . $this->table . " 
                WHERE event_date = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$date]);
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $eventDTOs = [];
        foreach ($events as $event) {
            $eventDTOs[] = new JazzEventDTO(
                $event['event_detail_id'],
                $event['name'],
                $event['time'],
                $event['venue'],
                $event['artist_id'],
                (float) $event['duration'],
                (float) $event['price'],
                $event['image'],
                $event['event_date'],
                $event['description'],
                (int) $event['seats'] // Added seats
            );
        }

        return $eventDTOs;
    }
}
?>