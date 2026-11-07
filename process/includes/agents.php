<?php
//Prepare the listing and agent information
$select = "SELECT tbl_members.user_id, ";
$select.= "tbl_members.full_name, ";
$select.= "tbl_members.user_name, ";
$select.= "tbl_members.mobile, ";
$select.= "tbl_members.email ";
$select.= "FROM tbl_members ";
$select.= "WHERE tbl_members.user_id = '".$_POST['user']."' ";
$select.= "LIMIT 1";

$result = $conn->query($select);
$row = $result->fetch_assoc();

//Check the leads existence
$check = $conn->query("SELECT contact_id FROM tbl_contacts WHERE contact_name LIKE '%".encodeData($_POST['name'])."%' AND REPLACE(REPLACE(REPLACE(mobile,'+',''),' ',''),'-','') LIKE '%".encodeData(substr(str_replace(" ","",str_replace("-","",str_replace("+","",$_POST['phone']))), -9))."%' AND email = '".encodeData($_POST['email'])."' AND source = '".encodeData($_POST['source'])."' AND sub_source = '".encodeData($_POST['sub_source'])."' AND user_id = '".$row['user_id']."'");

if($check->num_rows <= 0) {

  $client_name = explode(" ",$_POST['name']);

  // Insert the contact (tbl_contacts)
  $insert = "INSERT INTO tbl_contacts (";
  $insert.= "user_id, ";
  $insert.= "individual, ";
  $insert.= "contact_type, ";
  $insert.= "contact_name, ";
  $insert.= "email, ";
  $insert.= "mobile, ";
  $insert.= "origin, ";
  $insert.= "source, ";
  $insert.= "sub_source, ";
  $insert.= "posted, ";
  $insert.= "progress, ";
  $insert.= "subscribed, ";
  $insert.= "deleted, ";
  $insert.= "inserted_by, ";
  $insert.= "inserted_date, ";
  $insert.= "updated_by, ";
  $insert.= "updated_date)";
  $insert.= "VALUES (";
  $insert.= "'".addslashes(sanitizeData($row['user_id']))."', ";
  $insert.= "true, ";
  $insert.= "'Unknown', ";
  $insert.= "'".addslashes(sanitizeData($_POST['name']))."', ";
  $insert.= "'".addslashes(sanitizeData($_POST['email']))."', ";
  $insert.= "'".addslashes(sanitizeData($_POST['phone']))."', ";
  $insert.= "'Inquiry', ";
  $insert.= "'".addslashes(sanitizeData($_POST['source']))."', ";
  $insert.= "'".addslashes(sanitizeData($_POST['sub_source']))."', ";
  $insert.= "false, ";
  $insert.= "true, ";
  $insert.= "true, ";
  $insert.= "false, ";
  $insert.= "'".addslashes(sanitizeData($client_name[0]))."', ";
  $insert.= "NOW(), ";
  $insert.= "'".addslashes(sanitizeData($client_name[0]))."', ";
  $insert.= "NOW())";

  $conn->query($insert);
  $contact_id = $conn->insert_id;

  // Insert the inquiry (tbl_inquiries)
  $insert_inquiry = "INSERT INTO tbl_inquiries (";
  $insert_inquiry.= "contact_id, ";
  $insert_inquiry.= "agent, ";
  $insert_inquiry.= "inquiry, ";
  $insert_inquiry.= "section, ";
  $insert_inquiry.= "inserted_by, ";
  $insert_inquiry.= "inserted_date, ";
  $insert_inquiry.= "updated_by, ";
  $insert_inquiry.= "updated_date)";
  $insert_inquiry.= "VALUES (";
  $insert_inquiry.= "'".$contact_id."', ";
  $insert_inquiry.= "'".addslashes(sanitizeData($row['user_name']))."', ";
  $insert_inquiry.= "'".addslashes(sanitizeData($_POST['message']))."', ";
  $insert_inquiry.= "'General', ";
  $insert_inquiry.= "'".addslashes(sanitizeData($client_name[0]))."', ";
  $insert_inquiry.= "NOW(), ";
  $insert_inquiry.= "'".addslashes(sanitizeData($client_name[0]))."', ";
  $insert_inquiry.= "NOW())";

  $conn->query($insert_inquiry);
  $inquiry_id = $conn->insert_id;

  $insert_notification = "INSERT INTO tbl_notifications (";
  $insert_notification.= "reference, ";
  $insert_notification.= "agent, ";
  $insert_notification.= "notification, ";
  $insert_notification.= "details, ";
  $insert_notification.= "viewed, ";
  $insert_notification.= "inserted_date)";
  $insert_notification.= "VALUES (";
  $insert_notification.= "'".addslashes(sanitizeData($inquiry_id))."', ";
  $insert_notification.= "'".addslashes(sanitizeData($row['user_id']))."', ";
  $insert_notification.= "'Leads', ";
  $insert_notification.= "'".addslashes(sanitizeData($_POST['name']))." | ".addslashes(sanitizeData($_POST['phone']))."', ";
  $insert_notification.= "false, ";
  $insert_notification.= "NOW())";

  $conn->query($insert_notification);

  $insert_activity = "INSERT INTO tbl_activity_logs (";
  $insert_activity.= "reference, ";
  $insert_activity.= "source, ";
  $insert_activity.= "activity, ";
  $insert_activity.= "inserted_by, ";
  $insert_activity.= "inserted_date)";
  $insert_activity.= "VALUES (";
  $insert_activity.= "'".$inquiry_id."', ";
  $insert_activity.= "'Leads', ";
  $insert_activity.= "'Sent inquiry from company website on ".date("M j, Y")."', ";
  $insert_activity.= "'".addslashes(sanitizeData($client_name[0]))."', ";
  $insert_activity.= "NOW())";

  $conn->query($insert_activity);
}

$body = file_get_contents("html/notification.inquiry.html");
$body = preg_replace("/[\\\]/","",$body);

$reply_body = file_get_contents("html/autoreply.inquiry.html");
$reply_body = preg_replace("/[\\\]/","",$reply_body);

$other_details = "";
if(!empty($_POST['phone'])){
  $other_details.= "<tr>";
  $other_details.= "<td style='padding: 3px 0px;'><strong>Phone</strong></td>";
  $other_details.= "<td style='padding: 3px 10px;'>: ".trimData($_POST['phone'])."</td>";
  $other_details.= "</tr>";
}
if(!empty($_POST['email'])){
  $other_details.= "<tr>";
  $other_details.= "<td style='padding: 3px 0px;'><strong>Email</strong></td>";
  $other_details.= "<td style='padding: 3px 10px;'>: ".trimData($_POST['email'])."</td>";
  $other_details.= "</tr>";
}

// Setup variables to be replaced
$vars = array(
  "{agent}",
  "{source}",
  "{inquiry}",
  "{name}",
  "{type}",
  "{details}",
  "{inquiry_details}",
  "{logo}",
  "{company_name}"
);
$vals = array(
  decodeData($row['full_name']),
  trimData($_POST['source']).' - '.trimData($_POST['sub_source']),
  nl2br(trimData($_POST['message'])),
  trimData($_POST['name']),
  'Unknown',
  $other_details,
  '',
  "cid:".$company_logo_name, // Call back the embbeded logo
  strtoupper($company_name)
);

$reply_vars = array(
  "{client}",
  "{agent}",
  "{contact}",
  "{timings}",
  "{weekdays}",
  "{logo}",
  "{company_name}"
);
$reply_vals = array(
  trimData($_POST['name']),
  strtoupper(decodeData($row['full_name'])),
  decodeData($row['mobile']),
  decodeData($office_timings),
  decodeData($office_weekdays),
  "cid:".$company_logo_name,
  strtoupper($company_name)
);

// Now replace the variables
$body 			= str_replace($vars,$vals,$body);
$reply_body = str_replace($reply_vars,$reply_vals,$reply_body);

// Create Phpmailer instance
$mail = new PHPMailer;
$mail->CharSet 				= 'UTF-8';
$mail->isSMTP();
$mail->Host 					= $smtp_host;
$mail->SMTPAuth 			= true;
$mail->Port 					= $smtp_port;
$mail->SMTPSecure 		= $smtp_connection;
$mail->SMTPKeepAlive	= true;

$mail->Username 			= $smtp_user;
$mail->Password 			= $smtp_password;

// Prepare the emails headers
$mail->addCustomHeader("X-Priority: 1");
$mail->AddEmbeddedImage(absolutedir."images/logos/".$company_logo, $company_logo_name, $company_logo);

$mail->From 		= $setting_account_email;
$mail->FromName = trimData($_POST['name']);

$mail->AddAddress(decodeData($row["email"]), decodeData($row["full_name"])); // Include only this line if no email group defined from

$mail->Subject = trimData($_POST['name'])." for ".decodeData(ucwords($row['user_name']))." - Added in the system";

// Include the emails to send from the setting
include_once(absolutedir."emails/addresses.php");

$mail->AltBody = "Please switch to HTML format to view this email correctly";
$mail->msgHTML($body);

$mail->send();
$mail->ClearAddresses();
$mail->ClearCCs();
$mail->ClearBCCs();
$mail->ClearAllRecipients();
//sleep(10);

if(!empty($row['mobile']) && !empty($whatsapp_api_token) && !empty($whatsapp_api_url)) {

  $whatsapp_phone = str_replace($string_replace_mobile,"",$row['mobile']);

  //Whatsapp Notifications
  $whatsapp_message = '*Inquiry from '.trimData($_POST['source']).' - '.trimData($_POST['sub_source']).'*'."\n\n";
  $whatsapp_message.= nl2br(trimData($_POST['message']))."\n\n";
  $whatsapp_message.= trimData($_POST['name'])."\n";
  if(!empty($_POST['phone'])){
    $whatsapp_message.= trimData($_POST['phone'])."\n";
  }
  if(!empty($_POST['email'])){
    $whatsapp_message.= trimData($_POST['email'])."\n";
  }

  $data = [
     'phone'   => $whatsapp_phone,
     'message' => $whatsapp_message
  ];

  $curl     = curl_init();
  curl_setopt($curl, CURLOPT_HTTPHEADER,
    array(
      "Authorization: ".trim($whatsapp_api_token),
    )
  );
  curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($curl, CURLOPT_URL, $whatsapp_api_url."/api/send-message");
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  $result = curl_exec($curl);
  curl_close($curl);
}

$mail->From 		= $setting_account_email;
$mail->FromName = $company_name;

// Send autoreply
$mail->AddAddress(trimData($_POST['email']), trimData($_POST['name']));
$mail->AddBcc("dom@sahagun.net", "IT Support");

$mail->Subject = "Thank you for contacting ".$company_name;

$mail->AltBody = "Please switch to HTML format to view this email correctly";
$mail->msgHTML($reply_body);

$mail->send();
$mail->ClearAddresses();
$mail->ClearCCs();
$mail->ClearBCCs();
$mail->ClearAllRecipients();

$mail->SmtpClose(); // Close phpmailer

$results = 1;
?>
