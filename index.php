<?php
include 'functions.php';

require 'header.php';
//require header here with CSS styles

//coords for buffalo
//$lat =42.886447;
//$lon =-78.878369;

$_SESSION["lat"] = 42.886447;
$_SESSION["lon"] = -78.878369;
$_SESSION["location"] = "Buffalo";

require 'nav.php';
require 'mapGen.php';

/*CHANGE FOR LOCAL/LIVE SERVER
//Processes form data from launch.php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (empty($_POST["location"])) {
        //automatic location using javascript
        }else{    
            $tempLocation = $_POST["location"];
            $tempArray = geocode($tempLocation);
            $_SESSION["lat"] = $tempArray['latitude'];
            $_SESSION["lon"] = $tempArray['longitude'];
            //$_SESSION["lat"] = 42.886447;
            //$_SESSION["lon"] = -78.878369;
            $_SESSION["location"] = $tempLocation;
        }
    }

  


//returns user to home screen by destroying the session
    if (isset($_GET['home'])){
            session_destroy();
            $_SESSION = array();
    }

//load launch screen - because no session coords are set
    if (!isset($_SESSION['lat']))
    {
        require 'launch.php';
    }
//load main interface - because session data is set
    else{
        require 'nav.php';
        require 'mapGen.php';
    }
*/
?>