<?php
// Prepare the communities
$sql_interest_communities = "SELECT tbl_communities.community_id, ";
$sql_interest_communities.= "tbl_communities.title, ";
$sql_interest_communities.= "tbl_communities.headline, ";
$sql_interest_communities.= "tbl_communities.location, ";
$sql_interest_communities.= "tbl_communities.community_name, ";
$sql_interest_communities.= "tbl_communities.developer, ";
$sql_interest_communities.= "tbl_communities.image ";
$sql_interest_communities.= "FROM tbl_communities ";
$sql_interest_communities.= "WHERE tbl_communities.published = true ";
$sql_interest_communities.= "AND tbl_communities.deleted = false ";
$sql_interest_communities.= "AND tbl_communities.image != '' ";
$sql_interest_communities.= "ORDER by RAND() ";
$sql_interest_communities.= "LIMIT 9";

$result_interest_communities = $conn->query($sql_interest_communities);
?>
