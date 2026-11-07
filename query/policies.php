<?php
// Prepare the policies
$sql_policies = "SELECT title, ";
$sql_policies.= "description, ";
$sql_policies.= "keywords ";
$sql_policies.= "FROM tbl_policies ";
$sql_policies.= "WHERE page = '".$current_policy."'";

$result_policies = $conn->query($sql_policies);
$row_policies = $result_policies->fetch_assoc();
?>
