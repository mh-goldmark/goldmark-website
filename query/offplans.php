<?php
// Featured Off-Plan
$sql_off_plan = "SELECT tbl_projects.project_id, ";
$sql_off_plan.= "tbl_projects.city, ";
$sql_off_plan.= "tbl_projects.location, ";
$sql_off_plan.= "tbl_projects.sub_location, ";
$sql_off_plan.= "tbl_projects.project, ";
$sql_off_plan.= "tbl_projects.category, ";
$sql_off_plan.= "tbl_projects.title, ";
$sql_off_plan.= "tbl_projects.price, ";
$sql_off_plan.= "tbl_projects.permit_number, ";
$sql_off_plan.= "tbl_projects.project_url, ";
$sql_off_plan.= "tbl_projects.chk_url, ";
$sql_off_plan.= "tbl_projects.image ";
$sql_off_plan.= "FROM tbl_projects ";
$sql_off_plan.= "WHERE tbl_projects.deleted = false ";
$sql_off_plan.= "AND tbl_projects.published = true ";
//$sql_off_plan.= "AND tbl_projects.image != '' ";
//$sql_off_plan.= "AND tbl_projects.permit_number != '' ";
//$sql_off_plan.= "AND tbl_projects.permit_expiry >= '".date('Y-m-d')."' ";
//$sql_off_plan.= "AND tbl_projects.featured = true ";
if(!empty($row_project['project_id'])) {
  $sql_off_plan.= "AND tbl_projects.project_id != '".$row_project['project_id']."' ";
}
$sql_off_plan.= "ORDER by RAND() ";
$sql_off_plan.= "LIMIT 6";

$result_off_plan = $conn->query($sql_off_plan);
?>
