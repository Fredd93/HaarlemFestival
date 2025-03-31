<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/HistoryScheduleDTO.php");
require_once(__DIR__ . "/../dto/HistoryLocationDTO.php");


Class HistoryModel extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }

    public function getLocationById(int $locationId): HistoryLocationDTO {
        $sql = "SELECT * FROM History_Locations WHERE location_id = :id"; 
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $locationId);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

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
    private function mapToLocationDTO(array $row) {
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
}

?>
