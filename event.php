<?php
//This class defines an event model

class EventContainer{
    
    protected $link;
    protected $title;
    protected $location;
    protected $time;
    protected $latitude;
    protected $longitude;
    protected $category;
    protected $price;

    public function __construct($link, $title, $location, $time, $latitude, $longitude, $category, $price){
        $this->link=$link;
        $this->title = $title;
        $this->location = $location;
        $this->time = $time;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->category = $category;
        $this->price = $price;
    }

    public function getLink(){return $this->link;}    
    public function getTitle(){return $this->title;}
    public function getLocation(){return $this->location;}
    public function getTime(){return $this->time;}
    public function getLatitude(){return $this->latitude;}
    public function getLongitude(){return $this->longitude;}
    public function getcategory(){return $this->category;}
    public function getprice(){return $this->price;}
}
?>

