<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
$db 		= "goldma15_goldmark_crm";	// Database name
$dbuser = "goldma15";								// Username to the database
$dbpass = "G07dM4rk!#$%";						// Username password
$dbhost = "192.249.121.8";					// Database host (localhost)

// Create connections
$conn = new mysqli($dbhost, $dbuser, $dbpass, $db);
// Set session time zone
$conn->query("SET time_zone='+04:00'");
$conn->set_charset("utf8");
// Check for connection errors
if ($conn->connect_error) {
	die("Could not connect to the server: ".$conn->connect_error);
}

// Check if database is not open
if (!$conn->select_db("$db")) {
	die("Could not open database ".$db);
}
error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED);
date_default_timezone_set("Asia/Dubai"); // Time zone use for insert and update
?>
