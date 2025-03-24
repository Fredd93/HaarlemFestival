<?php

class EventDTO{
    public int $event_id;
    public string $event_name;
    public string $event_description;
    public string $image;

    public function __construct(int $event_id, string $event_name, string $event_decription,string $image){
        $this-> event_id = $event_id;
        $this-> event_name = $event_name;
        $this-> event_description = $event_decription;
        $this->image = $image;
    }
}
?>