<?php

//This script parses data from the buffalo news events site and puts it into a database

set_time_limit(1500);//Had to change time limit
include 'simple_html_dom.php'; include 'event.php'; include 'functions.php';

create_mysql_table();
buffaloNewsParserToDB(); //ACTIVATE TO PARSE TO DB


function buffaloNewsParserToDB(){

//create_mysql_table();

//$events = array();//ACTIVATE for debugging

$html=file_get_html('http://thingstodo.buffalonews.com/events/');

$stage=1;

$conn = Connect();

foreach ($html->find('ul.event-items div div p, ul.event-items li h3, div[class=event-img] a') as $a){//this pulls in the correct data from p and h3 tags

    switch($stage){
    case 1:
        $tempLink = $a->href;
        $tempwhole = buffaloNewsEventParser($tempLink);//follows URL to parse that page
        $temppieces = explode("|", $tempwhole);
        $tempCategory = $temppieces[0];
        $tempPrice = $temppieces[1];
        $stage=2;
        break;
    case 2:
        $tempTitle = $a->plaintext;
        $stage=3;
        break;
    case 3:
        $tempLocation = $a->plaintext.', ';//add coma and space to make location more readable
        $stage=4;
        break;
    case 4:
        $whole = $a->plaintext;
        $pieces = explode("|", $whole);//parses this p tag in list view data delimited by "|"
        $tempLocation.=$pieces[0];//first half is City/Town of event
        $tempTime=$pieces[1];//second half is the time of the event
        $array = geocode($tempLocation);
        $tempLatitude = $array['latitude'];
        $tempLongitude = $array['longitude'];
        $stage=5;
        break;
    case 5:
        $stage=6;
        break;
    case 6:
        $tempEvent = new EventContainer($tempLink, $tempTitle, $tempLocation, $tempTime, $tempLatitude, $tempLongitude, $tempCategory, $tempPrice);
        InsertEvent($tempEvent, $conn);
        //$events[] = $tempEvent; //ACTIVATE for debugging
        $stage=1;
        break;      
    }    
}


$conn->close();//closes the connection

//ACTIVATE for debugging
/* 
foreach ($events as $event){  
    echo $event->getTitle().', '.$event->getLocation().', '.$event->getTime().', '.
    $event->getLatitude().$event->getLongitude().', '.$event->getLink().'<br>';
}
*/
}
//END buffaloNewsParserToDB **************************************************************************


/*BuffaloNewsEventParser - This function extracts price and category info by following a URL
  from the event site and returns the extracted data to be exploded by a delimeter*/
  function buffaloNewsEventParser($html){
    
    $html=file_get_html($html);//gets filecontents from passed in URL
    
    $priceCheck = $catCheck = FALSE;//true false checks needed as price and cat info are not formatted the same on each page
    $extractPrice = $extractCat = $extract ="";

    foreach ($html->find('p.special-p') as $a){//iterates through html

        $data = $a->plaintext.' ';//all the text inside p tags is now in data

//finds price
        if($priceCheck == FALSE){
        $price = strstr($data, 'Price:');
            if($price != ""){
                $extractPrice = substr($price, strpos($price, ":") + 1); 
                $priceCheck = TRUE;
            }
        }
//finds category
        if($catCheck ==FALSE){
        $category = strstr($data, 'Category:');
            if($category != ""){
                $extractCat = substr($category, strpos($category, ":") + 1);
                $extractCat = strtolower($extractCat);      
                $catCheck = TRUE;
            }
        }

    }
    $extract = $extractCat . '|' . $extractPrice; //concatenates with | delimeter to be exploded
    //echo $extract;

    return $extract;
}
//END buffaloNewsEventParser *****************************************************

?> 