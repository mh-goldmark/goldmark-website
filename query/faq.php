<?php
// Prepare the faq
$sql_faq = "SELECT page, ";
$sql_faq.= "description, ";
$sql_faq.= "keywords ";
$sql_faq.= "FROM tbl_faq ";
$sql_faq.= "ORDER by page ASC";

$result_faq  = $conn->query($sql_faq);
?>
