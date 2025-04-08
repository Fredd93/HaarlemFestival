<?php
class HistoryLocationDTO{
    public int $location_id;
    public string $image_name;
    public string $name;
    public string $description;

    public function __construct(int $location_id, string $image_name, string $name, string $description) {
        $this->location_id = $location_id;
        $this->image_name = $image_name;
        $this->name = $name;
        $this->description = $description;
    }
}
?>