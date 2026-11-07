<?php
// Prepare the manager
// $sql_manager = "SELECT user_id, ";
// $sql_manager.= "user_name, ";
// $sql_manager.= "full_name, ";
// $sql_manager.= "email, ";
// $sql_manager.= "mobile, ";
// $sql_manager.= "designation, ";
// $sql_manager.= "department, ";
// $sql_manager.= "rera_number, ";
// $sql_manager.= "user_photo, ";
// $sql_manager.= "other_photo, ";
// $sql_manager.= "website ";
// $sql_manager.= "FROM tbl_members ";
// $sql_manager.= "WHERE user_name = 'Wissam' ";
// $sql_manager.= "LIMIT 1";
//
// $result_manager = $conn->query($sql_manager);
// $row_manager = $result_manager->fetch_assoc();

// Prepare the team
$sql_our_team = "SELECT user_id, ";
$sql_our_team.= "user_name, ";
$sql_our_team.= "full_name, ";
$sql_our_team.= "email, ";
$sql_our_team.= "mobile, ";
$sql_our_team.= "designation, ";
$sql_our_team.= "department, ";
$sql_our_team.= "rera_number, ";
$sql_our_team.= "user_photo, ";
$sql_our_team.= "other_photo, ";
$sql_our_team.= "website ";
$sql_our_team.= "FROM tbl_members ";
$sql_our_team.= "WHERE user_status = true ";
$sql_our_team.= "AND publish = true ";
//$sql_our_team.= "AND blocked = false ";
$sql_our_team.= "AND ((user_role = 'Agent' ";
$sql_our_team.= "AND priviledge = 'Manager') ";
$sql_our_team.= "OR user_name = 'Wissam') ";
$sql_our_team.= "AND user_name != 'Keith' ";
$sql_our_team.= "AND user_name != 'Saleem' ";
$sql_our_team.= "ORDER by (user_name = 'Wissam') DESC, (chk_general = true) DESC, (department = 'Sales') DESC, (department = 'Leasing') DESC, (department = 'Off Plan') DESC";

$result_our_team = $conn->query($sql_our_team);
?>
