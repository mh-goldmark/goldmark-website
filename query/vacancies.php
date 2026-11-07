<?php
// Prepare vacancies
$sql_vacancies = "SELECT id, ";
$sql_vacancies.= "vacancy, ";
$sql_vacancies.= "address, ";
$sql_vacancies.= "image, ";
$sql_vacancies.= "details, ";
$sql_vacancies.= "status ";
$sql_vacancies.= "FROM tbl_vacancy ";
$sql_vacancies.= "WHERE status = true ";
$sql_vacancies.= "ORDER by id ASC";

$result_vacancies   = $conn->query($sql_vacancies);
$result_application = $conn->query($sql_vacancies);
?>
