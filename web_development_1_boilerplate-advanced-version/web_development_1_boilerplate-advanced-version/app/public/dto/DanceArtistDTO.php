<?php
class DanceArtistDTO{
    public int $artistId;
    public string $name;
    public string $description;
    public string $careerHighlights;
    public string $tracks;
    public string $albums;
    public string $legacyAndInfluence;

    public function __construct(int $artistId, string $name, string $description, string $careerHighlights, string $tracks, string $albums, string $legacyAndInfluence){
        $this->artistId = $artistId;
        $this->name = $name;
        $this->description = $description;
        $this->careerHighlights = $careerHighlights;
        $this->tracks = $tracks;
        $this->albums = $albums;
        $this->legacyAndInfluence = $legacyAndInfluence;
    }
}
?>