<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">


<?php
include 'functions.php';
require("phpsqlajax_dbinfo.php");

$array =[];

// Create connection
$conn = Connect();
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//selects data 
$sql = "SELECT eventID, eventLocation FROM eventstable WHERE NOT eventLatitude";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "eventID: " . $row["eventID"]. " eventLocation: " . $row["eventLocation"]. "<br>";
        $array[$row["eventID"]]=$row["eventLocation"];
    }


} else {
    echo "0 results";
}
$conn->close();



foreach ($array as $ID=>$Location){
    echo $ID . ' ' . $Location . '<br>';


    //$conn = Connect();

    $temparray = geocode($Location);
    $tempLatitude = $temparray['latitude'];
    $tempLongitude = $temparray['longitude'];

    echo  $tempLatitude . ' ' . $tempLongitude . '<br>';
    /*
    $query = "UPDATE eventstable SET eventLatitude = $tempLatitude, eventLongitude = $tempLongitude WHERE eventID = $ID";

    $success = $conn->query($query);
    
    if (!$success) {
        die("Couldn't enter data: ".$conn->error);   
    }

    $conn->close();
*/
}

/*
$sql = "UPDATE eventstable SET email='peterparker_new@mail.com' WHERE id=1";

if(mysqli_query($connection, $sql)){

    echo "Records were updated successfully.";

} else {

    echo "ERROR: Could not able to execute $sql. " . mysqli_error($connection);

}

        $array = geocode($row["eventLocation"]);
        $tempLatitude = $array['latitude'];
        $tempLongitude = $array['longitude'];
        $ID = $row["eventID"];

        $query = "UPDATE eventstable SET eventLatitude=$tempLatitude eventLongitude=$tempLongitude WHERE id=$ID";

        $success = $conn->query($query);
        
        if (!$success) {
            die("Couldn't enter data: ".$conn->error);   
        }





*/
 

// Close connection







/*

if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
*/


//$lat =42.886447;
//$lon =-78.878369;
//buffaloNewsEventParser('http://thingstodo.buffalonews.com/event/48720/kissmas-bash-2017');





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


/*
//TITLE//
$html=file_get_html('http://thingstodo.buffalonews.com/events/');

foreach ($html->find('ul.event-items li h3') as $a){

    echo $a->plaintext.'<br><br>';
}

//location
$html=file_get_html('http://thingstodo.buffalonews.com/events/');

foreach ($html->find('ul.event-items li p a') as $a){

    echo $a->plaintext.'<br><br>';
}




/////$title=$html->find("div#event-details, 0")->plaintext;
//echo $title;

//THIS WORKS
/*
foreach ($html->find('ul.event-items li') as $a){

    echo $a->plaintext.'<br><br>';
}*/

?> 