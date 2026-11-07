<?php
function headLine($section,$headline){

	global $conn;

	$sql_headline = "SELECT title, ";
	$sql_headline.= "headline, ";
	$sql_headline.= "tagline ";
	$sql_headline.= "FROM tbl_pages_headlines ";
	$sql_headline.= "WHERE section = '".$section."' ";
	$sql_headline.= "LIMIT 1";

	$result_headline = $conn->query($sql_headline);
	$row_headline = $result_headline->fetch_assoc();

	if($headline == "title") {
		return stripslashes($row_headline['title']);
	} elseif($headline == "headline") {
		return stripslashes($row_headline['headline']);
	} elseif($headline == "tagline") {
		return stripslashes($row_headline['tagline']);
	}
}
function callAction($section,$headline){

	global $conn;

	$sql_call_action = "SELECT title, ";
	$sql_call_action.= "tagline ";
	$sql_call_action.= "FROM tbl_call_actions ";
	$sql_call_action.= "WHERE section = '".$section."' ";
	$sql_call_action.= "LIMIT 1";

	$result_call_action = $conn->query($sql_call_action);
	$row_call_action = $result_call_action->fetch_assoc();

	if($headline == "title") {
		return stripslashes($row_call_action['title']);
	} elseif($headline == "tagline") {
		return stripslashes($row_call_action['tagline']);
	}
}

function getImage($section,$localhost){

	global $conn;

	$sql_sliders = "SELECT image ";
	$sql_sliders.= "FROM tbl_sliders ";
	$sql_sliders.= "WHERE section = '".$section."' ";
	$sql_sliders.= "AND status = true ";
	$sql_sliders.= "ORDER by sort_order ASC ";
	$sql_sliders.= "LIMIT 1";

	$result_sliders = $conn->query($sql_sliders);
	$row_sliders = $result_sliders->fetch_assoc();


	if($result_sliders->num_rows >= 1) {
		return $localhost.'images/sliders/'.stripslashes($row_sliders['image']);
	} else {
		if($section == 'About') {
			return 'images/about-gold-mark-real-estate.gif';
		} else {
			return 'images/gold-mark-real-estate-1080x1080.svg';
		}
	}
}

//Prepare search property type
$search_property_types = "SELECT property_type ";
$search_property_types.= "FROM tbl_listings_portals ";
$search_property_types.= "WHERE listing_status = 'Available' ";
if(empty($_GET['category']) || $_GET['category'] == 'Residential for Sale') {
	$search_property_types.= "AND category = 'Residential' ";
	$search_property_types.= "AND listing_type = 'Sale' ";
	$search_property_types.= "AND building_status = 'Completed' ";
} elseif($_GET['category'] == 'Residential for Rent') {
	$search_property_types.= "AND category = 'Residential' ";
	$search_property_types.= "AND listing_type = 'Rent' ";
	$search_property_types.= "AND building_status = 'Completed' ";
} elseif($_GET['category'] == 'Off-plan Properties') {
	$search_property_types.= "AND building_status = 'Off Plan' ";
} elseif($_GET['category'] == 'Commercial') {
	$search_property_types.= "AND category = 'Commercial' ";
	$search_property_types.= "AND building_status = 'Completed' ";
}
$search_property_types.= "AND permit_number != '' ";
$search_property_types.= "AND permit_expiry >= '".date('Y-m-d')."' ";
$search_property_types.= "AND deleted = false ";
$search_property_types.= "AND published = true ";
$search_property_types.= "AND images != '' ";
$search_property_types.= "GROUP by property_type ";
$search_property_types.= "ORDER by property_type ASC";

$property_types_search = $conn->query($search_property_types);
?>
