<?php
// Prepare the vacancy
$sql_vacancy = "SELECT tbl_vacancy.id, ";
$sql_vacancy.= "tbl_vacancy.vacancy, ";
$sql_vacancy.= "tbl_vacancy.category, ";
$sql_vacancy.= "tbl_vacancy.details, ";
$sql_vacancy.= "tbl_vacancy.image ";
$sql_vacancy.= "FROM tbl_vacancy ";
$sql_vacancy.= "WHERE tbl_vacancy.id = '".$_GET['id']."' ";
$sql_vacancy.= "LIMIT 1";

$result_vacancy = $conn->query($sql_vacancy);
$row_vacancy = $result_vacancy->fetch_assoc();
