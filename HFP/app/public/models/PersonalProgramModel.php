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
    public function getProgramItemsByUser(int $userId): array
    {
        $sql = "
            SELECT 
                p.Program_Id,
                p.Event_Type,
                p.Ticket_Or_Reservation_Id,
                p.Event_Id,
                edr.event_detail_id,
                COALESCE(j.event_date, d.event_date, ys.session_date) AS Day,
                COALESCE(j.venue, d.venue, y.name) AS Location,
                COALESCE(j.time, d.time, ys.session_time) AS Start_Time,
                COALESCE(jt.price, dt.price, y.price) AS Price,
                -- Extra fields for jazz events:
                CASE WHEN edr.event_type = 'jazz' THEN j.image ELSE NULL END AS Event_Image,
                CASE WHEN edr.event_type = 'jazz' THEN j.name ELSE NULL END AS Event_Name
            FROM dbo.Personal_Program p
            INNER JOIN dbo.Event_Detail_Reference edr 
                ON edr.id = p.Event_Detail_Reference_Id
    
            LEFT JOIN dbo.Jazz_Events j 
                ON edr.event_type = 'jazz' AND edr.event_detail_id = j.event_detail_id
    
            LEFT JOIN dbo.Dance_Events d 
                ON edr.event_type = 'dance' AND edr.event_detail_id = d.event_detail_id
    
            LEFT JOIN dbo.Yummy_Events y 
                ON edr.event_type = 'yummy' AND edr.event_detail_id = y.event_detail_id
    
            LEFT JOIN dbo.Yummy_Reservation yr 
                ON p.Event_Type = 'yummy' AND yr.ticket_id = p.Ticket_Or_Reservation_Id
    
            LEFT JOIN dbo.Yummy_Session ys 
                ON yr.session_id = ys.session_id
    
            LEFT JOIN dbo.Jazz_Ticket jt 
                ON p.Event_Type = 'jazz' AND jt.ticket_id = p.Ticket_Or_Reservation_Id
    
            LEFT JOIN dbo.Dance_Ticket dt 
                ON p.Event_Type = 'dance' AND dt.ticket_id = p.Ticket_Or_Reservation_Id
    
            WHERE p.User_Id = :user_id
            ORDER BY Day, Start_Time;
        ";
    
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
    public function deleteProgramItem(int $programId): bool {
        $sql = "DELETE FROM Personal_Program WHERE Program_Id = :program_id";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(":program_id", $programId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function scanQrCode(int $programId) {

         $existsSql = "SELECT 1 FROM Personal_Program WHERE Program_ID = :program_id";
    $existsStmt = self::$pdo->prepare($existsSql);
    $existsStmt->bindParam(":program_id", $programId, PDO::PARAM_INT);
    $existsStmt->execute();
    if (!$existsStmt->fetch()) {
        // The ID does not exist — bail out
        return false;
    }
    // Step 1: Check if the programId is already scanned
    $checkSql = "SELECT TOP 1 1 FROM QR_Scan_PersonalProgram WHERE Personal_Program_ID = :program_id";
    $checkStmt = self::$pdo->prepare($checkSql);
    $checkStmt->bindParam(":program_id", $programId, PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->fetch()) {
        // Already scanned
        return false;
    }

    // Step 2: Insert new row into QR_Scan
    $insertSql = "INSERT INTO QR_Scan_PersonalProgram (Personal_Program_ID, scan_datetime, scanned_by)
                  VALUES (:program_id, :scan_datetime, :scanned_by)";
    $insertStmt = self::$pdo->prepare($insertSql);
    $insertStmt->bindParam(":program_id", $programId, PDO::PARAM_INT);
    
    $date = date('Y-m-d H:i:s');
    $insertStmt->bindParam(":scan_datetime", $date);
    $insertStmt->bindParam(":scanned_by", $_SESSION['user_id']);

    return $insertStmt->execute();
    }

    
}
?>
