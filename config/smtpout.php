<?php
// Prepare smtp connection for sending the mails
$sql_smtp = "SELECT id, ";
$sql_smtp.= "user_name, ";
$sql_smtp.= "user_password, ";
$sql_smtp.= "host_name, ";
$sql_smtp.= "smtp_port, ";
$sql_smtp.= "smtp_connection ";
$sql_smtp.= "FROM tbl_smtp_setup ";
$sql_smtp.= "WHERE smtp_status = true ";
$sql_smtp.= "LIMIT 1";

$result_smtp = $conn->query($sql_smtp);
$row_smtp = $result_smtp->fetch_assoc();

$smtp_id	      = $row_smtp['id'];
$smtp_user	    = stripslashes($row_smtp['user_name']);
$smtp_password  = $row_smtp["user_password"];
$smtp_host		  = $row_smtp["host_name"];
$smtp_port		  = $row_smtp["smtp_port"];
$smtp_connection= $row_smtp["smtp_connection"];
?>
