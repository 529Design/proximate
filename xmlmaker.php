<?php

require("phpsqlajax_dbinfo.php");

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection=mysqli_connect ('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysqli_error($connection));}

// Set the active MySQL database

$db_selected = mysqli_select_db($connection, $database);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysqli_error($connection));
}

// Select all the rows in the markers table

$query = "SELECT * FROM eventsTable WHERE 1";
$result = mysqli_query($connection, $query);
if (!$result) {
  die('Invalid query: ' . mysqli_error($connection));
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("eventID",$row['eventID']);
  $newnode->setAttribute("eventTitle",$row['eventTitle']);
  $newnode->setAttribute("eventLocation", $row['eventLocation']);
  $newnode->setAttribute("eventTime",$row['eventTime']);
  $newnode->setAttribute("eventLatitude", $row['eventLatitude']);
  $newnode->setAttribute("eventLongitude", $row['eventLongitude']);
  $newnode->setAttribute("eventLink", $row['eventLink']);
  $newnode->setAttribute("eventCategory", $row['eventCategory']);
  $newnode->setAttribute("eventPrice", $row['eventPrice']);
}

echo $dom->saveXML();

?>