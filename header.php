<?php

//starts session if it isnt started
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

?>

<!DOCTYPE html >
<html>

<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Event App</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

</head>
