<?php
// Prepare the invest widgets
$sql_invest_widgets = "SELECT id, ";
$sql_invest_widgets.= "category, ";
$sql_invest_widgets.= "icon, ";
$sql_invest_widgets.= "details, ";
$sql_invest_widgets.= "label, ";
$sql_invest_widgets.= "sort_order ";
$sql_invest_widgets.= "FROM tbl_widgets ";
$sql_invest_widgets.= "WHERE category = 'Why Invest' ";
$sql_invest_widgets.= "ORDER by sort_order ASC";

$result_invest_widgets = $conn->query($sql_invest_widgets);
$result_invest_list    = $conn->query($sql_invest_widgets);
?>
