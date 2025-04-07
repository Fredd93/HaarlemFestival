<?php

require_once(__DIR__ . "/BaseModel.php");

class YummySessionModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get available sessions for a given event and date.
     */
    public function getAvailableSessions(int $eventId, string $date): array
    {
        $sql = "SELECT session_id, session_time, available_seats 
                FROM Yummy_Session 
                WHERE event_id = :event_id AND session_date = :date AND available_seats > 0
                ORDER BY session_time";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":event_id", $eventId);
        $stmt->bindParam(":date", $date);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check if there are enough available seats.
     */
    public function hasAvailableSeats(int $sessionId, int $requestedSeats): bool
    {
        $sql = "SELECT available_seats FROM Yummy_Session WHERE session_id = :session_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":session_id", $sessionId);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && $row["available_seats"] >= $requestedSeats;
    }

    /**
     * Reduce available seats after booking.
     */
    public function reduceAvailableSeats(int $sessionId, int $seats): bool
    {
        $sql = "UPDATE Yummy_Session SET available_seats = available_seats - :seats WHERE session_id = :session_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":seats", $seats);
        $stmt->bindParam(":session_id", $sessionId);

        return $stmt->execute();
    }
    public function getSessionById(int $sessionId): ?array
    {
        $sql = "SELECT session_date, session_time FROM Yummy_Session WHERE session_id = :session_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":session_id", $sessionId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }
    
    public function sessionBelongsToRestaurant(int $sessionId, int $restaurantId): bool
    {
        $sql = "SELECT 1 FROM Yummy_Session WHERE session_id = :session_id AND event_id = :restaurant_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":session_id", $sessionId);
        $stmt->bindParam(":restaurant_id", $restaurantId);
        $stmt->execute();
        return (bool)$stmt->fetchColumn();
    }

}
?>
