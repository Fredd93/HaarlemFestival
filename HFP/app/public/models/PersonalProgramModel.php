<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/PersonalProgramDTO.php");

Class PersonalProgramModel extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }

    public function getById($userId) : array{
        $sql = "SELECT program_id, user_id, event_id, status FROM Personal_Program_Item";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

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