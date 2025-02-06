<?php

class EventDetailDTO {
    public int $detail_id;
    public int $event_id;
    public string $type;
    public ?string $description;
    public ?string $image_url;
    public string $event_time;
    public string $event_date;
    public string $location;
    public float $event_price;
    public int $current_capacity;
    public int $max_capacity;
    public ?string $tags;
    public ?float $rating;
    public string $name;

    public function __construct(
        int $detail_id, int $event_id, string $type, ?string $description, ?string $image_url, 
        string $event_time, string $event_date, string $location, float $event_price, 
        int $current_capacity, int $max_capacity, ?string $tags, ?float $rating, string $name
    ) {
        $this->detail_id = $detail_id;
        $this->event_id = $event_id;
        $this->type = $type;
        $this->description = $description;
        $this->image_url = $image_url;
        $this->event_time = $event_time;
        $this->event_date = $event_date;
        $this->location = $location;
        $this->event_price = $event_price;
        $this->current_capacity = $current_capacity;
        $this->max_capacity = $max_capacity;
        $this->tags = $tags;
        $this->rating = $rating;
        $this->name = $name;
    }
}
