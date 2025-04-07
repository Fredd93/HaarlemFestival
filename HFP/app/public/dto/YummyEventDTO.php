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
    public int $seats;
    public int $stars;
    public ?string $img;
    public ?string $description;
    public ?float $childPrice; // ✅ New field

    public function __construct(
        int $eventDetailId,
        string $name,
        int $sessions,
        float $sessionDuration,
        string $startTime,
        string $endTime,
        string $type,
        float $price,
        int $seats,
        int $stars,
        ?string $img,
        ?string $description,
        ?float $childPrice = null // ✅ New param
    ) {
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
}
?>
