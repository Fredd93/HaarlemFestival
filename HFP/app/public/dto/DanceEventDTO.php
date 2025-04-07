<?php
class DanceEventDTO {
    public string $artist;
    public int $event_detail_id;
    public string $time;
    public string $venue;
    public string $session_type;
    public int $duration;
    public int $price;
    public string $day;
    public int $tickets_available;


    public function __construct(
        string $artist,
        int $event_detail_id,
        string $time,
        string $venue,
        string $session_type,
        int $duration,
        int $price,
        string $day,
        ?int $tickets_available = null // ✅ Optional to allow nulls
    ) {
        $this->artist = $artist;
        $this->event_detail_id = $event_detail_id;
        $this->time = $time;
        $this->venue = $venue;
        $this->session_type = $session_type;
        $this->duration = $duration;
        $this->price = $price;
        $this->day = $day;
        $this->tickets_available = $tickets_available;
    }
}
?>
