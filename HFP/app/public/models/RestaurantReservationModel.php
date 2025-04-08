<?php

require_once(__DIR__ . "/BaseModel.php");

class YummyReservationModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create a reservation
     */
    public function createReservation(int $restaurantId, int $sessionId, string $date, string $time, int $numAdults, int $numChildren, string $clientName, ?string $request): ?int
    {
        $sql = "INSERT INTO Yummy_Reservation 
                (num_adults, num_children, reservation_date, reservation_time, client_name, special_request, restaurant_id, session_id)
                VALUES (:adults, :children, :date, :time, :name, :request, :restaurant_id, :session_id)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":adults", $numAdults);
        $stmt->bindParam(":children", $numChildren);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":time", $time);
        $stmt->bindParam(":name", $clientName);
        $stmt->bindParam(":request", $request);
        $stmt->bindParam(":restaurant_id", $restaurantId);
        $stmt->bindParam(":session_id", $sessionId);

        if ($stmt->execute()) {
            return self::$pdo->lastInsertId();
        }
        return null;
    }
}
?>
