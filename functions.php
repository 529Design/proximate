<?php
/* Connect - establishes a connection to a MYSQL database on a server*/
function Connect()
{
 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $dbname = "marronja01";
 
 // Create connection
 $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die("Connection failed: " . $conn->connect_error);

 return $conn;
}
//END Connect***************************************************************

//GEOCODER***********************************************************************************
function geocode($string){
    
      $string = str_replace (" ", "+", urlencode($string));
      $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$string."&sensor=false";
    
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $details_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = json_decode(curl_exec($ch), true);
    
      // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
      if ($response['status'] != 'OK') {
       return null;
      }
    
      //print_r($response);
      $geometry = $response['results'][0]['geometry'];
    
       $longitude = $geometry['location']['lng'];
       $latitude = $geometry['location']['lat'];
    
       $array = array(
           'latitude' => $geometry['location']['lat'],
           'longitude' => $geometry['location']['lng'],
           'location_type' => $geometry['location_type'],
       );
    
       return $array;
    
   }
//END GEOCODER *******************************************************************

/* Create MYSQL Table - This is for portability to create a functional MYSQL table
    in different server environments*/
    function create_mysql_table(){
        $conn = Connect();
    
            $conn->query("DROP TABLE IF EXISTS eventsTable");//deletes table if it already exists

        //sql to create table
            $sql = "CREATE TABLE eventsTable (
            eventID INT NOT NULL AUTO_INCREMENT,
            eventTitle VARCHAR(255),
            eventLocation VARCHAR(150),
            eventTime VARCHAR(10),
            eventLatitude VARCHAR(15),
            eventLongitude VARCHAR(15),
            eventLink VARCHAR(255),
            eventCategory VARCHAR(150),
            eventPrice VARCHAR(30),
            PRIMARY KEY (eventID)
            )";
    
        //tests if sql table was created
            if ($conn->query($sql) === TRUE) {
                echo "eventsTable created successfully";
            } else {
                echo "Error creating table: " . $conn->error;//outputs error code
            }
            $conn->close();//close connection
    
    }
//END Create MYSQL Table******************************
    

//Insert Event - This inserts an event class object into the database
    function InsertEvent($event, $connection){

        $link = $event->getLink();
        echo $link;
        $link = $connection->real_escape_string($link);

        $title = $event->getTitle();
        echo $title;
        $title = $connection->real_escape_string($title);

        $location = $event->getLocation();
        echo $location;
        $location = $connection->real_escape_string($location);

        $time = $event->getTime();
        echo $time;
        $time = $connection->real_escape_string($time);

        $latitude = $event->getLatitude();
        echo $latitude;
        $latitude = $connection->real_escape_string($latitude);

        $longitude = $event->getLongitude();
        echo $longitude;
        $longitude = $connection->real_escape_string( $longitude);

        $category = $event->getCategory();
        echo $category;
        $category = $connection->real_escape_string( $category);

        $price = $event->getPrice();
        echo $price;
        $price = $connection->real_escape_string( $price);

        echo '<br>';
//insert into database
        $query   = "INSERT into eventsTable (eventTitle, eventLocation, eventTime, eventLatitude, eventLongitude, eventLink, eventCategory, eventPrice) 
        VALUES('" . $title . "','" .             
                    $location . "','" .
                    $time . "','" .
                    $latitude . "','" .
                    $longitude . "','" .
                    $link . "','" .
                    $category . "','" .
                    $price . "')";
                    $success = $connection->query($query);
        
        if (!$success) {
            die("Couldn't enter data: ".$connection->error);   
        }
    }
    //$conn = Connect();//creates a connection named conn
    //$conn->close();//closes the connection
//END InsertEvent ***************************************************************
?>