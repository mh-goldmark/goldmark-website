<?php
if(!empty($_GET["page"])) {
	$page = $_GET["page"];
} else {
	$page = 1;
}
$limit 		  = $page_views;
$startpoint = ($page * $limit) - $limit;

$param = '';
if(!empty($_GET['location'])) {
	$param.= '&location='.str_replace(' ','+',$_GET['location']);
}
if($_GET['bedroom'] != '') {
	$param.= '&bedroom='.$_GET['bedroom'];
}
if($_GET['type'] != '') {
	$param.= '&type='.str_replace(' ','+',$_GET['type']);
}
if($_GET['completion'] != '') {
	$param.= '&completion='.str_replace(' ','+',$_GET['completion']);
}
if($_GET['sort'] != '') {
	$param.= '&sort='.$_GET['sort'];
}

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
$sql_projects.= "tbl_projects.chk_url, ";
$sql_projects.= "tbl_projects.short_url, ";
$sql_projects.= "tbl_projects.coordinates, ";
$sql_projects.= "tbl_projects.featured ";
$sql_projects.= "FROM tbl_projects ";
$sql_projects.= "WHERE tbl_projects.published = true ";
//$sql_projects.= "AND tbl_projects.permit_number != '' ";
//$sql_projects.= "AND tbl_projects.permit_expiry >= '".date('Y-m-d')."' ";
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
//$sql_projects.= "AND tbl_projects.image != '' ";

if(empty($_GET['sort']) || $_GET['sort'] == 'recent') {
	$sql_projects.= "ORDER by tbl_projects.inserted_date DESC ";
} elseif($_GET['sort'] == 'featured') {
	$sql_projects.= "ORDER by tbl_projects.featured DESC, tbl_projects.updated_date DESC ";
} elseif($_GET['sort'] == 'hprice') {
	$sql_projects.= "ORDER by tbl_projects.price DESC ";
} elseif($_GET['sort'] == 'lprice') {
	$sql_projects.= "ORDER by tbl_projects.price ASC ";
}
$sql_projects.= "LIMIT ".$startpoint.", ".$limit;

$result_projects = $conn->query($sql_projects);

// Count the total projects
$sql_count_projects = "SELECT COUNT(*) as total ";
$sql_count_projects.= "FROM tbl_projects ";
$sql_count_projects.= "WHERE tbl_projects.published = true ";
//$sql_count_projects.= "AND tbl_projects.permit_number != '' ";
//$sql_count_projects.= "AND tbl_projects.permit_expiry >= '".date('Y-m-d')."' ";
$sql_count_projects.= "AND tbl_projects.deleted = false ";
if(!empty($_GET['location'])) {
	$sql_count_projects.= "AND (tbl_projects.location LIKE '%".$_GET['location']."%' ";
	$sql_count_projects.= "OR tbl_projects.sub_location LIKE '%".$_GET['location']."%' ";
	$sql_count_projects.= "OR tbl_projects.project LIKE '%".$_GET['location']."%' ";
	$sql_count_projects.= "OR tbl_projects.developer LIKE '%".$_GET['location']."%') ";
}
if(!empty($_GET['bedroom'])) {
	$sql_count_projects.= "AND tbl_projects.sub_type LIKE '%".$_GET['bedroom']."%' ";
}
if(!empty($_GET['type'])) {
	$sql_count_projects.= "AND tbl_projects.category = '".$_GET['type']."' ";
}
if(!empty($_GET['completion'])) {
	$completion = explode(", ",$_GET['completion']);
	$sql_count_projects.= "AND QUARTER(tbl_projects.completion) = '".str_replace('Q','',$completion[0])."' ";
	$sql_count_projects.= "AND YEAR(tbl_projects.completion) = '".$completion[1]."' ";
}
//$sql_count_projects.= "AND tbl_projects.image != ''";

$count      = $conn->query($sql_count_projects);
$total 	    = $count->fetch_assoc();
$chk_count 	= ceil($total['total']/$limit);

// Prepare property types
$sql_property_types = "SELECT category as property_type ";
$sql_property_types.= "FROM tbl_projects ";
$sql_property_types.= "WHERE published = true ";
//$sql_property_types.= "AND permit_number != '' ";
//$sql_property_types.= "AND permit_expiry >= '".date('Y-m-d')."' ";
$sql_property_types.= "AND deleted = false ";
$sql_property_types.= "AND image != '' ";
$sql_property_types.= "GROUP by property_type ";
$sql_property_types.= "ORDER by property_type ASC";

$result_property_types = $conn->query($sql_property_types);

// Prepare completion
$sql_completion = "SELECT CONCAT('Q',QUARTER(tbl_projects.completion),', ',YEAR(tbl_projects.completion)) as completion_date ";
$sql_completion.= "FROM tbl_projects ";
$sql_completion.= "WHERE tbl_projects.published = true ";
//$sql_completion.= "AND tbl_projects.permit_number != '' ";
//$sql_completion.= "AND tbl_projects.permit_expiry >= '".date('Y-m-d')."' ";
$sql_completion.= "AND tbl_projects.deleted = false ";
//$sql_completion.= "AND tbl_projects.image != '' ";
$sql_completion.= "AND tbl_projects.completion != '0000-00-00' ";
$sql_completion.= "GROUP by completion_date ";
$sql_completion.= "ORDER by completion_date ASC";

$result_completion = $conn->query($sql_completion);
?>
