<?php
// Prepare the search engine optimizer
$sql_seo = "SELECT title, ";
$sql_seo.= "description, ";
$sql_seo.= "keywords ";
$sql_seo.= "FROM tbl_seo ";
$sql_seo.= "WHERE page = '".$current_page."'";

$result_seo = $conn->query($sql_seo);
$row_seo = $result_seo->fetch_assoc();
?>
