<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/HistoryScheduleDTO.php");


Class HistoryModel extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }

    public function getAllById(int $eventId): array {
        $sql = "SELECT * FROM History_Events WHERE event_detail_id = :id"; 
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $eventId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToScheduleDTO($row), $results);
        //copied from other Models (specifically Dance)
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
