<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/DanceArtistDTO.php");
require_once(__DIR__ . "/../dto/DanceEventDTO.php");
require_once(__DIR__ . "/../dto/DancePassDTO.php");

Class DanceModel extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }

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
            $row["description"] ?? "" ,
            $row["image_url"]
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
            $row["event_date"],
            (int)$row["tickets_available"]
        );
    }
    
    public function getAllEvents(): array{
        $sql = "SELECT
                D.event_detail_id,
                CONVERT(VARCHAR(5), D.time, 108) AS time,
                D.venue,
                D.session_type,
                D.duration,
                D.price,
                D.event_date,
                D.tickets_available,
                STRING_AGG(A.name, '/') AS artists
                FROM Dance_Events D
                JOIN Dance_Event_Artists E ON D.event_detail_id = E.event_detail_id
                JOIN Artists A ON A.artist_id = E.artist_id
                GROUP BY D.event_detail_id, D.time, D.venue, D.session_type, D.duration, D.price, D.event_date, D.tickets_available;";
        
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return array_map(fn($row) => $this->mapToEventsDTO($row), $results);
    }

    public function getAllPasses(): array{
        $sql = "SELECT * FROM Dance_Passes";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return array_map(fn($row) => $this->mapToPassesDTO($row), $results);
    }

    private function mapToPassesDTO(array $row): DancePassDTO {
        return new DancePassDTO(
            $row["pass_name"],
            (int) $row["price"]
        );
    }
}
?>
