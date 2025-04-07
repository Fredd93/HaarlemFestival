<?php

class JazzEventDTO {
    public int $event_detail_id;
    public string $name;
    public string $time;
    public string $venue;
    public int $artist_id;
    public float $duration;
    public float $price;
    public string $image;
    public string $event_date;
    public string $description;
    public int $seats;  // new property for number of seats

    public function __construct(
        int $event_detail_id, 
        string $name, 
        string $time, 
        string $venue, 
        int $artist_id, 
        float $duration, 
        float $price, 
        string $image, 
        string $event_date, 
        string $description,
        int $seats   // new constructor parameter
    ) {
        $this->event_detail_id = $event_detail_id;
        $this->name = $name;
        $this->time = $time;
        $this->venue = $venue;
        $this->artist_id = $artist_id;
        $this->duration = $duration;
        $this->price = $price;
        $this->image = $image;
        $this->event_date = $event_date;
        $this->description = $description;
        $this->seats = $seats;  // assign seats
    }
}
?>
