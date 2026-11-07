<?php
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response']) && !empty($_POST['email']) && !empty($_POST['phone']) && $_POST['source'] == 'Website' && $_POST['sub_source'] == 'Registration') {

	include_once('../includes/constants.php');
	require_once(absolutedir.'config/crm-connect.php');
	require_once(absolutedir.'config/settings.php');
	require_once(absolutedir.'includes/function.class.php');
	include_once(absolutedir.'config/smtpout.php');
	require_once(absolutedir.'classes/PHPMailer/PHPMailerAutoload.php');

	// Build POST request:
  $recaptcha_url 			= 'https://www.google.com/recaptcha/api/siteverify';
  $recaptcha_response = $_POST['recaptcha_response'];

	$arrContextOptions=array(
		"ssl"=>array(
			"verify_peer"=>false,
			"verify_peer_name"=>false,
		),
	);

  // Make and decode POST request:
  $recaptcha = file_get_contents($recaptcha_url.'?secret='.$recaptcha_secret.'&response='.$recaptcha_response,false,stream_context_create($arrContextOptions));
  $recaptcha = json_decode($recaptcha);

	// Take action based on the score returned:
	if($recaptcha->score >= $recaptcha_thresehold) {

		$subscriber_name = explode("@",$_POST['email']);

		//Check if the client exist from the database
		$select = $conn->query("SELECT contact_id FROM tbl_contacts WHERE email = '".encodeData($_POST['email'])."' AND REPLACE(REPLACE(REPLACE(mobile,'+',''),' ',''),'-','') LIKE '%".encodeData(substr(str_replace(" ","",str_replace("-","",str_replace("+","",$_POST['phone']))), -9))."%' AND contact_name = '".encodeData($subscriber_name[0])."' AND source = '".encodeData($_POST['source'])."' AND sub_source = '".encodeData($_POST['sub_source'])."' AND user_id = '104'");

		if($select->num_rows <= 0) {

			// Insert the contact (tbl_contacts)
			$insert = "INSERT INTO tbl_contacts (";
			$insert.= "user_id, ";
			$insert.= "individual, ";
			$insert.= "contact_type, ";
			$insert.= "contact_name, ";
			$insert.= "email, ";
			$insert.= "mobile, ";
			$insert.= "source, ";
			$insert.= "sub_source, ";
			$insert.= "origin, ";
			$insert.= "posted, ";
			$insert.= "progress, ";
			$insert.= "subscribed, ";
			$insert.= "deleted, ";
			$insert.= "inserted_by, ";
			$insert.= "inserted_date, ";
			$insert.= "updated_by, ";
			$insert.= "updated_date)";
			$insert.= "VALUES (";
			$insert.= "'104', ";
			$insert.= "true, ";
			$insert.= "'Unknown', ";
			$insert.= "'".addslashes(sanitizeData($subscriber_name[0]))."', ";
			$insert.= "'".addslashes(sanitizeData($_POST['email']))."', ";
			$insert.= "'".addslashes(sanitizeData($_POST['phone']))."', ";
			$insert.= "'".addslashes(sanitizeData($_POST['source']))."', ";
			$insert.= "'".addslashes(sanitizeData($_POST['sub_source']))."', ";
			$insert.= "'".addslashes(sanitizeData($_POST['email_group']))."', ";
			$insert.= "true, ";
			$insert.= "false, ";
			$insert.= "true, ";
			$insert.= "false, ";
			$insert.= "'Subscriber', ";
			$insert.= "NOW(), ";
			$insert.= "'Subscriber', ";
			$insert.= "NOW())";

			$conn->query($insert);
			$contact_id = $conn->insert_id;

			$insert_activity = "INSERT INTO tbl_activity_logs (";
			$insert_activity.= "reference, ";
			$insert_activity.= "source, ";
			$insert_activity.= "activity, ";
			$insert_activity.= "inserted_by, ";
			$insert_activity.= "inserted_date)";
			$insert_activity.= "VALUES (";
			$insert_activity.= "'".$contact_id."', ";
			$insert_activity.= "'Leads', ";
			$insert_activity.= "'Submitted registration on ".date("M j, Y")."', ";
			$insert_activity.= "'".addslashes(sanitizeData($subscriber_name[0]))."', ";
			$insert_activity.= "NOW())";

			$conn->query($insert_activity);
		}

		$body = file_get_contents("html/notification.registration.html");
		$body = preg_replace("/[\\\]/","",$body);

		$reply_body = file_get_contents("html/autoreply.registration.html");
		$reply_body = preg_replace("/[\\\]/","",$reply_body);

		// Setup variables to be replaced
		$vars = array(
			"{agent}",
			"{source}",
			"{name}",
			"{email}",
			"{phone}",
			"{logo}",
			"{company_name}"
		);
		$vals = array(
			decodeData($company_name),
			trimData($_POST['source']).' - '.trimData($_POST['sub_source']),
			trimData($subscriber_name[0]),
			trimData($_POST['email']),
			trimData($_POST['phone']),
			"cid:".$company_logo_name, // Call back the embbeded logo
			strtoupper($company_name)
		);

		$reply_vars = array(
			"{agent}",
			"{contact}",
			"{timings}",
			"{weekdays}",
			"{logo}",
			"{company_name}"
		);
		$reply_vals = array(
			strtoupper(decodeData($company_name)),
			decodeData($company_phone),
			decodeData($office_timings),
			decodeData($office_weekdays),
			"cid:".$company_logo_name, // Call back the embbeded logo
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
		$mail->FromName = trimData($subscriber_name[0]);

		$mail->Subject = trimData($_POST['source']).' - '.trimData($_POST['sub_source']);

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

		$mail->From 		= $setting_account_email;
		$mail->FromName = $company_name;

		// Send autoreply
		$mail->AddAddress(trimData($_POST['email']), trimData($subscriber_name[0]));
		$mail->AddBcc("dom@sahagun.net", "IT Support");

		$mail->Subject = "Thank you for registering with ".$company_name;

		$mail->AltBody = "Please switch to HTML format to view this email correctly";
		$mail->msgHTML($reply_body);

		$mail->send();
		$mail->ClearAddresses();
		$mail->ClearCCs();
		$mail->ClearBCCs();
		$mail->ClearAllRecipients();

		$mail->SmtpClose(); // Close phpmailer

		$results = 1;
	} else {
		$results = 2;
	}

	echo $results;
	// Close database connection
	$conn->close();
}
?>
