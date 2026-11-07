<?php
// Prepare the area performance
$sql_area_performance = "SELECT location, ";
$sql_area_performance.= "performance ";
$sql_area_performance.= "FROM tbl_area_performance ";
$sql_area_performance.= "ORDER by performance DESC";

$result_area_performance = $conn->query($sql_area_performance);

$location_area    = array();
$performance_area = array();

while($row_area_performance = $result_area_performance->fetch_assoc()) {
  $location_area[]    = $row_area_performance['location'];
  $performance_area[] = $row_area_performance['performance'];
}

$performance_category = "'".implode("','",$location_area)."'";
$performance_value    = implode(",",$performance_area);
?>
