<?php
class ContentDTO {
    public int $content_id;
    public string $page;
    public ?string $title;
    public ?string $description;
    public ?string $image_url;
    public string $content_type;
    public string $description_tag; // New field

    public function __construct(int $content_id, string $page, ?string $title, ?string $description, ?string $image_url, string $content_type, string $description_tag) {
        $this->content_id = $content_id;
        $this->page = $page;
        $this->title = $title;
        $this->description = $description;
        $this->image_url = $image_url;
        $this->content_type = $content_type;
        $this->description_tag = $description_tag;
    }
}

?>
