<?php
class HistoryScheduleDTO{
    public int $event_detail_id;
    public string $date;
    public string $language;
    public int $maxTickets;

    public function __construct(int $event_detail_id, string $language, string $date, int $maxTickets) {
        $this->event_detail_id = $event_detail_id;
        $this->language = $language;
        $this->date = $date;
        $this->maxTickets = $maxTickets;
    }
}
?>