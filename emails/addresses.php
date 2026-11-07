<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/

// Prepare email addresses to send
$sql_email_addresses = "SELECT email, ";
$sql_email_addresses.= "full_name, ";
$sql_email_addresses.= "email_type ";
$sql_email_addresses.= "FROM tbl_email_addresses ";
$sql_email_addresses.= "WHERE email_group = 'All' ";
if(!empty($_POST['email_group'])){
  $sql_email_addresses.= "OR email_group = '".$_POST['email_group']."' ";
} elseif(!empty($custom_group)){
  $sql_email_addresses.= "OR email_group = '".$custom_group."' ";
}
$sql_email_addresses.= "ORDER by email_type ASC";

$result_email_addresses = $conn->query($sql_email_addresses);

while($row_email_addresses = $result_email_addresses->fetch_assoc()){
  $email_type = trim($row_email_addresses['email_type']);
  $mail->$email_type(stripslashes(strtolower(trim($row_email_addresses['email']))),stripslashes(trim($row_email_addresses['full_name'])));
  unset($email_type);
}
?>
