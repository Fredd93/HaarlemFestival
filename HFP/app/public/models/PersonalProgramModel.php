<?php

require_once(__DIR__ . "/BaseModel.php");

class PersonalProgramModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add a reservation or ticket to the personal program.
     */
    public function addToProgram(
        int $userId,
        int $eventId,
        int $eventDetailRefId,
        int $ticketOrReservationId,
        string $eventType
    ): bool {
        $sql = "INSERT INTO Personal_Program (
                    User_Id, Event_Id, Event_Detail_Reference_Id, 
                    Ticket_Or_Reservation_Id, Event_Type, Created_At
                ) VALUES (
                    :user_id, :event_id, :detail_ref_id, 
                    :ticket_id, :event_type, GETDATE()
                )";

        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":event_id", $eventId, PDO::PARAM_INT);
        $stmt->bindParam(":detail_ref_id", $eventDetailRefId, PDO::PARAM_INT);
        $stmt->bindParam(":ticket_id", $ticketOrReservationId, PDO::PARAM_INT);
        $stmt->bindParam(":event_type", $eventType, PDO::PARAM_STR);

        return $stmt->execute();
    }
}
?>
