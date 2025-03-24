<?php
class HistoryScheduleDTO{
    public string $date;
    public int $dutchTours;
    public int $englishTours;
    public int $chineseTours;

    public function __construct(string $date) {
        $this->date = $date;
    }
}
?>