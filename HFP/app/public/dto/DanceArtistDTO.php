<?php
class DanceArtistDTO{
    public int $artistId;
    public string $name;
    public string $description;
    public string $image_url;

    public function __construct(int $artistId, string $name, string $description, string $image_url){
        $this->artistId = $artistId;
        $this->name = $name;
        $this->description = $description;
        $this->image_url = $image_url;
    }
}
?>