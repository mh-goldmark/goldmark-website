<?php
// Prepare sliders
$sql_sliders = "SELECT image, ";
$sql_sliders.= "title, ";
$sql_sliders.= "sub_title, ";
$sql_sliders.= "sort_order ";
$sql_sliders.= "FROM tbl_sliders ";
$sql_sliders.= "WHERE section = '".$current_page."' ";
$sql_sliders.= "AND status = true ";
$sql_sliders.= "ORDER by sort_order ASC ";
$sql_sliders.= "LIMIT 1";

$result_sliders = $conn->query($sql_sliders);
$row_sliders = $result_sliders->fetch_assoc();
?>
