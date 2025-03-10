<?php
require_once(__DIR__ . "/BaseModel.php");
require_once(__DIR__ . "/../dto/DanceArtistDTO.php");
require_once(__DIR__ . "/../dto/DanceEventDTO.php");


Class DanceModel extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }

    public function getAllArtists(): array {
        $sql = "SELECT DISTINCT 
        A.artist_id, 
        A.name, 
        A.careerHighlights,
        A.Tracks,
        A.Albums,
        A.LegacyAndInfluence,
        CAST(A.description AS VARCHAR(MAX)) AS description
        FROM Artists A
        JOIN Dance_Event_Artists DEA ON A.artist_id = DEA.artist_id
        JOIN Dance_Events DE ON DEA.event_detail_id = DE.event_detail_id;"; 
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => $this->mapToDTO($row), $results);
    }

    private function mapToDTO(array $row): DanceArtistDTO {
        return new DanceArtistDTO(
            (int) $row["artist_id"],
            $row["name"], 
            $row["description"] ?? "", 
            $row["careerHighlights"] ?? "", 
            $row["tracks"] ?? "", 
            $row["albums"] ?? "", 
            $row["legacyAndInfluence"] ?? ""
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
            $row["day"]
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
                D.day, 
                STRING_AGG(A.name, '/') AS artists
                FROM Dance_Events D
                JOIN Dance_Event_Artists E ON D.event_detail_id = E.event_detail_id
                JOIN Artists A ON A.artist_id = E.artist_id
                GROUP BY D.event_detail_id, D.time, D.venue, D.session_type, D.duration, D.price, D.day;";
        
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return array_map(fn($row) => $this->mapToEventsDTO($row), $results);
    }
}

?>
