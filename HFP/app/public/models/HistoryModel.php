<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/HistoryScheduleDTO.php");
require_once(__DIR__ . "/../dto/HistoryLocationDTO.php");


Class HistoryModel extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }

    public function getLocationById(int $locationId) {
        $sql = "SELECT * FROM History_Locations WHERE location_id = :id"; 
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $locationId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToLocationDTO($row), $results);
        //copied from other Models (specifically Dance)
    }
    public function getAllLocations(): array {
        $sql = "SELECT * from History_Locations";
        
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return array_map(fn($row) => $this->mapToLocationDTO($row), $results);
    }
    private function mapToLocationDTO(array $row): HistoryLocationDTO {
        return new HistoryLocationDTO(
            (int) $row["location_id"],
            $row["image_name"],
            $row["name"],
            $row["description"]
        );
    }

    private function mapToScheduleDTO(array $row): HistoryScheduleDTO {
        return new HistoryScheduleDTO(
            (int) $row["event_detail_id"],
            $row["language"],
            DateTime::createFromFormat('Y-m-d H:i:s.v', $row["date"])->format('Y-m-d H:i')
        );
    }
    
    public function getFullSchedule(): array{
        $sql = "SELECT * from History_Events";
        
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return array_map(fn($row) => $this->mapToScheduleDTO($row), $results);
    }

    public function createScheduleItem($data) {

        $query = "INSERT INTO [History_Events] (language, maxTickets, date) VALUES (:language, :maxTickets, :timeStamp)";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(":language", $data['language']);
        $stmt->bindParam(":maxTickets", $data['maxTickets']);
        $stmt->bindParam(":timeStamp", $data['timeStamp']);
        if ($stmt->execute()) {
            $id = self::$pdo->lastInsertId();
            return $this->getScheduleItemById($id);
        }
        return null;
    }
    public function deleteScheduleItem($id) {
        $query = "DELETE FROM [History_Events] WHERE event_detail_id = :id";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function updateScheduleItem($id, $data) {
        $query = "UPDATE [History_Events] SET language = :language, maxTickets = :maxTickets, date = :timeStamp WHERE event_detail_id = :id";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(":language", $data['language']);
        $stmt->bindParam(":maxTickets", $data['maxTickets']);
        $stmt->bindParam(":timeStamp", $data['timeStamp']);
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return $this->getScheduleItemById($id);
        }
        return null;
    }
    public function getScheduleItemById($id) {
        $sql = "SELECT * FROM [History_Events] WHERE event_detail_id = :id"; 
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToScheduleDTO($row), $results);
    }
    public function createLocation($data) {
        $query = "INSERT INTO [History_Locations] (image_name, name, description) VALUES (:image_name, :name, :description)";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(":image_name", $data['image_name']);
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":description", $data['description']);
        if ($stmt->execute()) {
            $id = self::$pdo->lastInsertId();
            return $this->getLocationById($id);
        }
        return null;
    }
    public function deleteLocation($id) {
        $query = "DELETE FROM [History_Locations] WHERE location_id = :id";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function updateLocation($id, $data) {
        $query = "UPDATE [History_Locations] SET image_name = :image_name, name = :name, description = :description WHERE location_id = :id";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(":image_name", $data['image_name']);
        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            return $this->getLocationById($id);
        }
        return null;
    }
}

?>
