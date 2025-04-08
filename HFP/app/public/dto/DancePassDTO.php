<?php
class DancePassDTO{
    public string $pass_name;
    public int $price;

    public function __construct(string $pass_name, int $price){
        $this->pass_name = $pass_name;
        $this->price = $price;
    }
}
?>