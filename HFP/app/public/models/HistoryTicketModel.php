<?php
require_once(__DIR__ . "/BaseModel.php");


Class HistoryTicketModel extends BaseModel
{
    public function __construct() {
        parent::__construct();
    }
    private function getTicketCapacityForSlot($date, $language) {
        $stmt = self::$pdo->prepare("
            SELECT SUM(maxTickets) AS total_tickets
            FROM [History_Events]
            WHERE date = :date AND language = :language
        ");
        $stmt->bindParam(":language", $language);
        $stmt->bindParam(":date", $date);

        $stmt->execute();

        return $stmt->fetchColumn() ?? 0;
    }
    private function getBookingsForSlot($date, $language) {
        $stmt = self::$pdo->prepare("
            SELECT SUM(count) AS total_tickets
            FROM [History_Ticket]
            WHERE date = :date AND language = :language
        ");
        $stmt->bindParam(":language", $language);
        $stmt->bindParam(":date", $date);

        $stmt->execute();

        return $stmt->fetchColumn() ?? 0;
    }
    public function createTicket($data) {
        //$id = (int)$this->getLastId()["ticket_id"];
        //$id = $id + 1;

        $format = "Y-n-j H:i"; // The format for year-month-day hour:minute
        $date = DateTime::createFromFormat($format, $data['time'])->format('Y-m-d H:i:s');
        $maxTickets = $this->getTicketCapacityForSlot($date, $data['language']);
        $bookedTickets = $this->getBookingsForSlot($date, $data['language']);
        $wantedTickets = intval($data['ticket_count']);
        if ($bookedTickets + $wantedTickets > $maxTickets) {
            //More tickets than available
            throw new Exception("Ticket count passes capacity");
        }

        $query = "INSERT INTO [History_Ticket] (location, date, language, ticket_type, count, price) VALUES (:location, :date, :language, :ticket_type, :count, :price)";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(":location", $data['location']);
        $stmt->bindParam(":date", $date);
        $stmt->bindParam(":language", $data['language']);
        $stmt->bindParam(":ticket_type", $data['ticket_type']);
        $stmt->bindParam(":count", $wantedTickets);
        $stmt->bindParam(":price", $data['price']);
        if ($stmt->execute()) {
            $id = self::$pdo->lastInsertId();
            return $this->getTicketById($id);
        }
        return null;
    }
    public function getLastInsertId() {
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
