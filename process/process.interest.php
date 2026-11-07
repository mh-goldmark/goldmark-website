<?php
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && $_POST['source'] == 'Off-Plan' && $_POST['sub_source'] == 'Register') {

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

		//Prepare the project
		$select = "SELECT tbl_projects.project_id, ";
		$select.= "tbl_projects.permitted_use, ";
		$select.= "tbl_projects.project_type, ";
		$select.= "tbl_projects.location, ";
		$select.= "tbl_projects.sub_location, ";
		$select.= "tbl_projects.project, ";
		$select.= "tbl_projects.category, ";
		$select.= "tbl_projects.price ";
		$select.= "FROM tbl_projects ";
		$select.= "WHERE tbl_projects.project_id = '".$_POST['refno']."' ";
		$select.= "LIMIT 1";

		$result = $conn->query($select);
		$row = $result->fetch_assoc();

		if(!empty($row['project'])) {
			$project = $row['project'];
		} else {
			$project = $row['sub_location'];
		}

		$client_inquiry = 'Registration Interest.';

		//Check the leads existence
		$check = $conn->query("SELECT contact_id FROM tbl_contacts WHERE contact_name LIKE '%".encodeData($_POST['name'])."%' AND REPLACE(REPLACE(REPLACE(mobile,'+',''),' ',''),'-','') LIKE '%".encodeData(substr(str_replace(" ","",str_replace("-","",str_replace("+","",$_POST['phone']))), -9))."%' AND email = '".encodeData($_POST['email'])."' AND source = '".encodeData($_POST['source'])."' AND sub_source = '".encodeData($_POST['sub_source'])."' AND user_id = '104'");

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
			$insert.= "'104', ";
			$insert.= "true, ";
			$insert.= "'Buyer', ";
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
			$insert_inquiry.= "refno, ";
			$insert_inquiry.= "section, ";
			$insert_inquiry.= "location, ";
			$insert_inquiry.= "property_type, ";
			$insert_inquiry.= "preference, ";
			$insert_inquiry.= "budget, ";
			$insert_inquiry.= "inquiry, ";
			$insert_inquiry.= "inserted_by, ";
			$insert_inquiry.= "inserted_date, ";
			$insert_inquiry.= "updated_by, ";
			$insert_inquiry.= "updated_date)";
			$insert_inquiry.= "VALUES (";
			$insert_inquiry.= "'".$contact_id."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($row['project_id']))."', ";
			$insert_inquiry.= "'Off Plan', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($project))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($row['category']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($row['project_type']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($row['price']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($client_inquiry))."', ";
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
			$insert_notification.= "'104', ";
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
			$insert_activity.= "'Sent interest from company website on ".date("M j, Y")."', ";
			$insert_activity.= "'".addslashes(sanitizeData($client_name[0]))."', ";
			$insert_activity.= "NOW())";

			$conn->query($insert_activity);
		}

		$body = file_get_contents("html/notification.interest.html");
		$body = preg_replace("/[\\\]/","",$body);

		$reply_body = file_get_contents("html/autoreply.interest.html");
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

		$inquiry_details = "";
		$inquiry_details.= "<div style='padding: 7px 10px; background: #D5D5D5; color: #868ba1; font-weight: bold;'>PROJECT</div>";
		$inquiry_details.= "<br/>";
		$inquiry_details.= "<table cellpadding='0' cellspacing='0'>";
		if(!empty($project)){
			$inquiry_details.= "<tr>";
			$inquiry_details.= "<td style='padding: 3px 0px;'><strong>Location</strong></td>";
			$inquiry_details.= "<td style='padding: 3px 10px;'>: ".decodeData($project)."</td>";
			$inquiry_details.= "</tr>";
		}
		if(!empty($row['category'])){
			$inquiry_details.= "<tr>";
			$inquiry_details.= "<td style='padding: 3px 0px;'><strong>Category</strong></td>";
			$inquiry_details.= "<td style='padding: 3px 10px;'>: ".decodeData($row['category'])."</td>";
			$inquiry_details.= "</tr>";
		}
		if($row['price'] != '0.00'){
			$inquiry_details.= "<tr>";
			$inquiry_details.= "<td style='padding: 3px 0px;'><strong>Starting Price</strong></td>";
			$inquiry_details.= "<td style='padding: 3px 10px;'>: AED".str_replace('.00','',number_format($row['price']))."</td>";
			$inquiry_details.= "</tr>";
		}
		$inquiry_details.= "</table>";
		$inquiry_details.= "<br/>";

		// Setup variables to be replaced
		$vars = array(
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
			trimData($_POST['source']).' - '.trimData($_POST['sub_source']),
			$client_inquiry,
			trimData($_POST['name']),
			'Buyer',
			$other_details,
			$inquiry_details,
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
			strtoupper(decodeData($company_name)),
			decodeData($company_phone),
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

		$mail->AddAddress(decodeData($company_email), decodeData($company_name)); // Include only this line if no email group defined from

		$mail->Subject = 'A client registered interest.';

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

			$whatsapp_phone = str_replace($string_replace_mobile,"",$company_mobile);

			//Whatsapp Notifications
			$whatsapp_message = '*Registration Interest*'."\n\n";
			if(!empty($project)){
				$whatsapp_message.= sanitizeData($project)."\n";
			}
			if(!empty($row['category'])){
				$whatsapp_message.= sanitizeData($row['category'])."\n";
			}
			if($row['price'] != '0.00'){
				$whatsapp_message.= "AED".str_replace(".00","",number_format($row['price'],2))."\n\n";
			}
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
	} else {
		$results = 2;
	}

	echo $results;
	// Close database connection
	$conn->close();
}
?>
