<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
if($_SERVER['SERVER_NAME']) {
  $domain_name = $_SERVER['SERVER_NAME']."/";
} else {
  $domain_name = "www.goldmark.ae/";
}
// Host url's
define("webhost", "https://www.goldmark.ae/");
define("localhost", "https://my.goldmark.ae/");
define("domainhost", "https://".$domain_name);

// Url path
define("path", "/"); // Change this to the path relative to your domain or host (www.yourdomian.com)

// Absolute path
define("absolutedir", "/home/u647025890/domains/goldmark.ae/public_html/"); // Change this to the path of your public_html
define("rootdir", "/home/u647025890/domains/goldmark.ae/"); // Change this to the path of your public_html

// Set the variables to connect with database
// $db_database = "goldma15_db_master";	 // Database name
// $db_username = "goldma15_admin";		   // Username to the database
// $db_password = "G07dM4rk!!";	         // Username password
// $db_hostname = "192.249.121.8";		     // Database host (localhost)

$db_database = "u647025890_db_master";	 // Database name
$db_username = "u647025890_goldmark";		 // Username to the database
$db_password = "G07dM4rk!!";	           // Username password
$db_hostname = "localhost";		           // Database host (localhost)

$page_og_image = 'gold-mark-real-estate-1080x1080.jpg';
$user_400x400  = 'gold-mark-real-estate-400x400.jpg';
$user_400x500  = 'gold-mark-real-estate-400x500.jpg';
?>
