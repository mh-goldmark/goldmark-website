<?php
if(!empty($_GET["page"])) {
	$page = $_GET["page"];
} else {
	$page = 1;
}
$limit 		  = $page_views;
$startpoint = ($page * $limit) - $limit;

// Prepare the communities
$sql_communities = "SELECT tbl_communities.community_id, ";
$sql_communities.= "tbl_communities.title, ";
$sql_communities.= "tbl_communities.headline, ";
$sql_communities.= "tbl_communities.location, ";
$sql_communities.= "tbl_communities.community_name, ";
$sql_communities.= "tbl_communities.developer, ";
$sql_communities.= "tbl_communities.description, ";
$sql_communities.= "tbl_communities.image ";
$sql_communities.= "FROM tbl_communities ";
$sql_communities.= "WHERE tbl_communities.published = true ";
$sql_communities.= "AND tbl_communities.deleted = false ";
$sql_communities.= "AND tbl_communities.image != '' ";
$sql_communities.= "ORDER by tbl_communities.location ASC ";
$sql_communities.= "LIMIT ".$startpoint.", ".$limit;

$result_communities = $conn->query($sql_communities);

// Count the total communities
$sql_count_communities = "SELECT COUNT(*) as total ";
$sql_count_communities.= "FROM tbl_communities ";
$sql_count_communities.= "WHERE tbl_communities.published = true ";
$sql_count_communities.= "AND tbl_communities.deleted = false ";
$sql_count_communities.= "AND tbl_communities.image != '' ";

$count      = $conn->query($sql_count_communities);
$total 	    = $count->fetch_assoc();
$chk_count 	= ceil($total['total']/$limit);
?>
