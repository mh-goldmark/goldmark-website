<?php
// Prepare the projects
$sql_projects = "SELECT tbl_projects.project_id, ";
$sql_projects.= "tbl_projects.title, ";
$sql_projects.= "tbl_projects.headline, ";
$sql_projects.= "tbl_projects.sub_type, ";
$sql_projects.= "tbl_projects.description, ";
$sql_projects.= "tbl_projects.city, ";
$sql_projects.= "tbl_projects.location, ";
$sql_projects.= "tbl_projects.sub_location, ";
$sql_projects.= "tbl_projects.project, ";
$sql_projects.= "tbl_projects.developer, ";
$sql_projects.= "tbl_projects.category, ";
$sql_projects.= "tbl_projects.permitted_use, ";
$sql_projects.= "tbl_projects.project_type, ";
$sql_projects.= "tbl_projects.classification, ";
$sql_projects.= "tbl_projects.completion, ";
$sql_projects.= "tbl_projects.features, ";
$sql_projects.= "tbl_projects.amenities, ";
$sql_projects.= "tbl_projects.brochure, ";
$sql_projects.= "tbl_projects.price, ";
$sql_projects.= "tbl_projects.project_no, ";
$sql_projects.= "tbl_projects.permit_number, ";
$sql_projects.= "tbl_projects.qrcode_permit, ";
$sql_projects.= "tbl_projects.image, ";
$sql_projects.= "tbl_projects.video_url, ";
$sql_projects.= "tbl_projects.project_url, ";
$sql_projects.= "tbl_projects.short_url, ";
$sql_projects.= "tbl_projects.coordinates, ";
$sql_projects.= "tbl_projects.featured ";
$sql_projects.= "FROM tbl_projects ";
$sql_projects.= "WHERE tbl_projects.published = true ";
// $sql_projects.= "AND tbl_projects.permit_number != '' ";
// $sql_projects.= "AND tbl_projects.permit_expiry >= '".date('Y-m-d')."' ";
$sql_projects.= "AND tbl_projects.deleted = false ";
if(!empty($_GET['location'])) {
	$sql_projects.= "AND (tbl_projects.location LIKE '%".$_GET['location']."%' ";
	$sql_projects.= "OR tbl_projects.sub_location LIKE '%".$_GET['location']."%' ";
	$sql_projects.= "OR tbl_projects.project LIKE '%".$_GET['location']."%' ";
	$sql_projects.= "OR tbl_projects.developer LIKE '%".$_GET['location']."%') ";
}
if(!empty($_GET['bedroom'])) {
	$sql_projects.= "AND tbl_projects.sub_type LIKE '%".$_GET['bedroom']."%' ";
}
if(!empty($_GET['type'])) {
	$sql_projects.= "AND tbl_projects.category = '".$_GET['type']."' ";
}
if(!empty($_GET['completion'])) {
	$completion = explode(", ",$_GET['completion']);
	$sql_projects.= "AND QUARTER(tbl_projects.completion) = '".str_replace('Q','',$completion[0])."' ";
	$sql_projects.= "AND YEAR(tbl_projects.completion) = '".$completion[1]."' ";
}
$sql_projects.= "AND tbl_projects.image != '' ";
$sql_projects.= "GROUP by tbl_projects.coordinates ";

if(empty($_GET['sort']) || $_GET['sort'] == 'recent') {
	$sql_projects.= "ORDER by tbl_projects.inserted_date DESC ";
} elseif($_GET['sort'] == 'featured') {
	$sql_projects.= "ORDER by tbl_projects.featured DESC, tbl_projects.updated_date DESC ";
} elseif($_GET['sort'] == 'hprice') {
	$sql_projects.= "ORDER by tbl_projects.price DESC ";
} elseif($_GET['sort'] == 'lprice') {
	$sql_projects.= "ORDER by tbl_projects.price ASC ";
}

$result_projects = $conn->query($sql_projects);
$result_projects_center = $conn->query($sql_projects);

$array_coordinates = array();
while($row_projects_center = $result_projects_center->fetch_assoc()) {
	$array_coordinates[] = $row_projects_center['coordinates'];
}
if($result_projects_center->num_rows >= 1) {
	$geocoordinates = explode(",",$array_coordinates[0]);
	$geolatitude  = $geocoordinates[0];
	$geolongitude = $geocoordinates[1];
} else {
	$geolatitude  = '25.276987';
	$geolongitude = '55.296249';
}
?>
