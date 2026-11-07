<?php
/********************************************************
Copyright © 2026 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");

$sql = "SELECT listing_id, ";
$sql.= "page_title, ";
$sql.= "title, ";
$sql.= "location, ";
$sql.= "sub_location, ";
$sql.= "property, ";
$sql.= "building_name, ";
$sql.= "category, ";
$sql.= "listing_type, ";
$sql.= "property_type ";
$sql.= "FROM tbl_listings_portals ";
$sql.= "WHERE listing_status = 'Available' ";
$sql.= "AND permit_number != '' ";
$sql.= "AND permit_expiry >= '".date('Y-m-d')."' ";
$sql.= "AND deleted = false ";
$sql.= "AND published = true ";
$sql.= "AND listing_id = '".$_GET['id']."' ";
$sql.= "LIMIT 1";

$result = $conn->query($sql);
$row = $result->fetch_assoc();

if(!empty($row['page_title'])) {
  $page_title = $row['page_title'];
} else {
  $page_title = $row['title'];
}
if($row['category'] == 'Commercial') {
  $url_category = 'commercials';
} else {
  $url_category = 'residentials';
}
if(in_array($row['property_type'],$property_type_apartment)) {
  $url_type = 'apartments';
} elseif(in_array($row['property_type'],$property_type_villa)) {
  $url_type = 'villas';
} elseif(in_array($row['property_type'],$property_type_office)) {
  $url_type = 'offices';
} elseif($row['property_type'] == "Retail") {
  $url_type = 'shops';
} elseif($row['property_type'] == "Building") {
  $url_type = 'buildings';
} elseif($row['property_type'] == "Land") {
  $url_type = 'plots';
} else {
  $url_type = 'apartments';
}
if(!empty($row['building_name'])) {
  $listing_url = $url_category."/".$url_type."-for-".cleanString($row['listing_type'])."/".cleanString($row['location'])."/".cleanString($row['building_name'])."/".cleanString($page_title)."-".$row['listing_id'].".html";
} elseif(!empty($row['property'])) {
  $listing_url = $url_category."/".$url_type."-for-".cleanString($row['listing_type'])."/".cleanString($row['location'])."/".cleanString($row['property'])."/".cleanString($page_title)."-".$row['listing_id'].".html";
} elseif(!empty($row['sub_location'])) {
  $listing_url = $url_category."/".$url_type."-for-".cleanString($row['listing_type'])."/".cleanString($row['location'])."/".cleanString($row['sub_location'])."/".cleanString($page_title)."-".$row['listing_id'].".html";
} else {
  $listing_url = $url_category."/".$url_type."-for-".cleanString($row['listing_type'])."/".cleanString($row['location'])."/".cleanString($page_title)."-".$row['listing_id'].".html";
}
if($result->num_rows <= 0) {
  header('Location: '.domainhost.'404');
} else {
  header('Location: '.webhost.$listing_url);
}
exit;
$conn->close();
?>
