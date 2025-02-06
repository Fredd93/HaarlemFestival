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
}
?>
