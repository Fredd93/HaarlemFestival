<?php

class DanceContentDTO {
    public int $content_id;
    public string $page;
    public string $title;
    public string $description;
    public string $image_url;
    public string $content_type;
   

    public function __construct( int $content_id, string $page, string $title, string $description, string $image_url, string $content_type) {
        $this->content_id = $content_id;
        $this->content_type = $content_type;
        $this->description = $description;
        $this->image_url = $image_url;
        $this->page = $page;
        $this->title = $title;
    }
}
