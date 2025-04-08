<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/PersonalProgramDTO.php");

Class PersonalProgramModel extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }

    public function getById($userId): array {
        $sql = "SELECT program_id, user_id, event_id, status 
                FROM Personal_Program_Item 
                WHERE user_id = :id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $userId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as array
    
        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }

    private function mapToDTO(array $row): PersonalProgramDTO {
        return new PersonalProgramDTO(
            (int) $row["program_id"],
            (int) $row["user_id"], 
            (int) $row["event_id"],
            $row["status"], 
        );
    }
}
?>