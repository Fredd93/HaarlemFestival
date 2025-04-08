<?php
require_once(__DIR__ . "/BaseModel.php");


Class HistoryTicketModel extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }
    public function createTicket($data) {
        $id = (int)$this->getLastId()["ticket_id"];
        $id = $id + 1;

        $format = "Y-n-j H:i"; // The format for year-month-day hour:minute

        $date = DateTime::createFromFormat($format, $data['time'])->format('Y-m-d H:i:s');
        $query = "INSERT INTO [History_Ticket] (ticket_id, location, time, language, ticket_type) VALUES (:id, :location, :time, :language, :ticket_type)";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(":location", $data['location']);
        $stmt->bindParam(":time", $date);
        $stmt->bindParam(":language", $data['language']);
        $stmt->bindParam(":ticket_type", $data['ticket_type']);
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            $id = (int)$this->getLastId()["ticket_id"];//getLastInsertId didn't work, possibly because it isn't an identity.
            //But I can't change it to an identity because the thing is being annoying with rules
            return $this->getTicketById($id);
        }
        return null;
    }
    public function getLastId() {
        $query = "SELECT TOP 1 ticket_id FROM [History_Ticket] ORDER BY ticket_id DESC";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($results == null) {
            return 0;
        }
        return $results;
    }
    public function getTicketById($id) {
        $query = "SELECT * FROM [History_Ticket] WHERE ticket_id = :id";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

}

?>
