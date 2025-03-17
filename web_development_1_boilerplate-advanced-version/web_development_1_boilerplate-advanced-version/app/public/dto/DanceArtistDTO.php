<?php
class DanceArtistDTO{
    public int $artistId;
    public string $name;
    public string $description;

    public function __construct(int $artistId, string $name, string $description){
        $this->artistId = $artistId;
        $this->name = $name;
        $this->description = $description;
    }
}
?>