<?php
// Prepare the team
$sql_team = "SELECT tbl_members.user_id, ";
$sql_team.= "tbl_members.full_name, ";
$sql_team.= "tbl_members.user_name, ";
$sql_team.= "tbl_members.email, ";
$sql_team.= "tbl_members.user_role, ";
$sql_team.= "tbl_members.priviledge, ";
$sql_team.= "tbl_members.mobile, ";
$sql_team.= "tbl_members.designation, ";
$sql_team.= "tbl_members.department, ";
$sql_team.= "tbl_members.rera_number, ";
$sql_team.= "tbl_members.user_photo, ";
$sql_team.= "tbl_members.other_photo, ";
$sql_team.= "tbl_members.tags, ";
$sql_team.= "tbl_members.title, ";
$sql_team.= "tbl_members.details ";
$sql_team.= "FROM tbl_members ";
$sql_team.= "WHERE tbl_members.user_status = true ";
//$sql_team.= "AND tbl_members.blocked = false ";
$sql_team.= "AND tbl_members.publish = true ";
$sql_team.= "AND tbl_members.user_id = '".$_GET['id']."' ";
$sql_team.= "LIMIT 1";

$result_team = $conn->query($sql_team);
$row_team = $result_team->fetch_assoc();

if(($row_team['user_role'] == 'Agent' && $row_team['priviledge'] == 'Manager' && $row_team['user_name'] != 'Keith') || $row_team['user_name'] == 'Wissam') {
	$breadcrum_level = 'Direcotrs & Managers';
} elseif($row_team['user_role'] == 'Agent' && $row_team['priviledge'] != 'Manager' && $row_team['department'] == 'Leasing') {
	$breadcrum_level = 'Leasing Associates';
} elseif(($row_team['user_role'] == 'Agent' && $row_team['priviledge'] != 'Manager' && $row_team['department'] == 'Sales') || $row_team['user_name'] == 'Keith') {
	$breadcrum_level = 'Sales Associates';
} elseif($row_team['department'] == 'Marketing') {
	$breadcrum_level = 'Creatives & Marketing';
} elseif($row_team['department'] == 'Administration' || $row_team['department'] == 'Human Resource') {
	$breadcrum_level = 'HR & Administration';
}

function countListings($user,$type){

	global $conn;

	$sql_count = "SELECT COUNT(listing_id) as count ";
  $sql_count.= "FROM tbl_listings_portals ";
  $sql_count.= "WHERE listing_status = 'Available' ";
  $sql_count.= "AND permit_number != '' ";
  $sql_count.= "AND permit_expiry >= '".date('Y-m-d')."' ";
  $sql_count.= "AND deleted = false ";
  $sql_count.= "AND published = true ";
  $sql_count.= "AND user_id = '".$user."' ";
  $sql_count.= "AND listing_type = '".$type."'";

	$result_count = $conn->query($sql_count);
	$row_count = $result_count->fetch_assoc();

	if($row_count['count'] == 1) {
		return $row_count['count'].' Listing';
	} elseif($row_count['count'] > 1) {
		return str_replace(".00","",number_format($row_count['count'],2)).' Listings';
	} else {
		return 'No availability';
	}
}

function countDeals($user){

	global $conn;

	$sql_deals = "SELECT COUNT(contract_id) as count ";
  $sql_deals.= "FROM tbl_tenancy_contracts ";
  $sql_deals.= "WHERE deleted = false ";
  $sql_deals.= "AND cancelled = false ";
  $sql_deals.= "AND user_id = '".$user."' ";
  $sql_deals.= "UNION SELECT COUNT(sales_id) as count ";
  $sql_deals.= "FROM tbl_sales_agreements ";
  $sql_deals.= "WHERE deleted = false ";
  $sql_deals.= "AND cancelled = false ";
  $sql_deals.= "AND user_id = '".$user."'";

	$result_deals = $conn->query($sql_deals);
	$row_deals = $result_deals->fetch_assoc();

	if($row_deals['count'] >= 1) {
		return str_replace(".00","",number_format(($row_deals['count']+5),2)).' Deals';
	} else {
		return '5 Deals';
	}
}
?>
