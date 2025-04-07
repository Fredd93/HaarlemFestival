<?php
require_once(__DIR__ . "/BaseModel.php");

class RestaurantReservationModel extends BaseModel {
    /**
     * Inserts a new reservation into the Yummy_Reservation table.
     */
    public function insertReservation($restaurantId, $clientName, $date, $time, $numAdults, $numChildren, $specialRequest): bool {
        $pdo = self::$pdo;
        $pdo->beginTransaction();
    
        try {
            // 1. Insert the reservation
            $insertSql = "INSERT INTO Yummy_Reservation 
                (restaurant_id, client_name, reservation_date, reservation_time, num_adults, num_children, special_request)
                VALUES (:restaurant_id, :client_name, :reservation_date, :reservation_time, :num_adults, :num_children, :special_request)";
            
            $stmt = $pdo->prepare($insertSql);
            $stmt->execute([
                ':restaurant_id'    => $restaurantId,
                ':client_name'      => $clientName,
                ':reservation_date' => $date,
                ':reservation_time' => $time,
                ':num_adults'       => $numAdults,
                ':num_children'     => $numChildren,
                ':special_request'  => $specialRequest
            ]);
    
            // 2. Reduce seats in the Yummy_Events table
            $totalPeople = $numAdults + $numChildren;
    
            $updateSql = "UPDATE Yummy_Events
                          SET seats = seats - :total
                          WHERE event_detail_id = :restaurant_id AND seats >= :total";
    
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                ':total'         => $totalPeople,
                ':restaurant_id' => $restaurantId
            ]);
    
            // Check if the update affected any rows (i.e., if there were enough seats)
            if ($updateStmt->rowCount() === 0) {
                // Rollback if not enough seats and log an error for debugging
                $pdo->rollBack();
                error_log("Reservation failed: Not enough seats available for restaurant_id " . $restaurantId);
                return false;
            }
    
            $pdo->commit();
            return true;
    
        } catch (Exception $e) {
            $pdo->rollBack();
            error_log("Reservation failed: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Checks if a given time slot for a restaurant on a specific date is already booked.
     */
    public function isSlotBooked($restaurant_id, $reservation_date, $reservation_time) {
        $sql = "SELECT COUNT(*) as count FROM yummy_reservation 
                WHERE restaurant_id = :restaurant_id 
                  AND reservation_date = :reservation_date 
                  AND reservation_time = :reservation_time";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":restaurant_id", $restaurant_id, PDO::PARAM_INT);
        $stmt->bindParam(":reservation_date", $reservation_date);
        $stmt->bindParam(":reservation_time", $reservation_time);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}
?>
