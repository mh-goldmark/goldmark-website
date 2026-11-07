<?php
// Prepare the agent
$sql_agent = "SELECT tbl_members.user_id, ";
$sql_agent.= "tbl_members.full_name, ";
$sql_agent.= "tbl_members.user_name, ";
$sql_agent.= "tbl_members.email, ";
$sql_agent.= "tbl_members.mobile, ";
$sql_agent.= "tbl_members.designation, ";
$sql_agent.= "tbl_members.rera_number, ";
$sql_agent.= "tbl_members.user_photo, ";
$sql_agent.= "tbl_members.other_photo ";
$sql_agent.= "FROM tbl_members ";
$sql_agent.= "WHERE tbl_members.user_status = true ";
$sql_agent.= "AND tbl_members.publish = true ";
$sql_agent.= "AND tbl_members.blocked = false ";
$sql_agent.= "AND tbl_members.user_role = 'Agent' ";
$sql_agent.= "AND tbl_members.rera_number != '' ";
$sql_agent.= "AND tbl_members.rera_expiry >= '".date('Y-m-d')."' ";
$sql_agent.= "ORDER by RAND() ";
$sql_agent.= "LIMIT 1";

$result_agent = $conn->query($sql_agent);
$row_agent = $result_agent->fetch_assoc();
?>
