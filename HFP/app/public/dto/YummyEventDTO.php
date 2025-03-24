<?php
class YummyEventDTO {
    public int $eventDetailId;
    public string $name;
    public int $sessions;
    public float $sessionDuration;
    public string $startTime;
    public string $endTime;
    public string $type;
    public float $price;
    public float $childPrice;
    public int $seats;
    public int $stars;
    public ?string $img;
    public ?string $description;

    public function __construct($eventDetailId, $name, $sessions, $sessionDuration, $startTime, $endTime, $type, $price, $seats, $stars, $img, $description, float $childPrice = 0.0) {
        $this->eventDetailId = $eventDetailId;
        $this->name = $name;
        $this->sessions = $sessions;
        $this->sessionDuration = $sessionDuration;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->type = $type;
        $this->price = $price;
        $this->seats = $seats;
        $this->stars = $stars;
        $this->img = $img;
        $this->description = $description;
        $this->childPrice = $childPrice;
    }
    public function __defaultConstructor()
    {
    }
}
?>
