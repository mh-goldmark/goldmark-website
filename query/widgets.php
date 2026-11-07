<?php
// Prepare the widgets
$sql_widgets = "SELECT id, ";
$sql_widgets.= "category, ";
$sql_widgets.= "icon, ";
$sql_widgets.= "details, ";
$sql_widgets.= "label, ";
$sql_widgets.= "sort_order ";
$sql_widgets.= "FROM tbl_widgets ";
if(!empty($widgets_page)) {
  $sql_widgets.= "WHERE category = 'General' ";
} else {
  $sql_widgets.= "WHERE category = '".$current_page."' ";
}
$sql_widgets.= "ORDER by sort_order ASC";

$result_widgets = $conn->query($sql_widgets);
?>
