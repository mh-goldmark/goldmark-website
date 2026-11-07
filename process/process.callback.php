<?php
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && $_POST['source'] == 'Agent Listing' && $_POST['sub_source'] == 'Call Back') {

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

		//Prepare the listing and agent information
		$select = "SELECT tbl_listings.listing_id, ";
		$select.= "tbl_listings.user_id, ";
		$select.= "tbl_listings.category, ";
		$select.= "tbl_listings.listing_type, ";
		$select.= "tbl_listings.location, ";
		$select.= "tbl_listings.sub_location, ";
		$select.= "tbl_listings.property, ";
		$select.= "tbl_listings.building_name, ";
		$select.= "tbl_listings.property_type, ";
		$select.= "tbl_listings.bedrooms, ";
		$select.= "tbl_listings.list_price, ";
		$select.= "tbl_listings.building_status, ";
		$select.= "tbl_members.full_name, ";
		$select.= "tbl_members.user_name, ";
		$select.= "tbl_members.mobile, ";
		$select.= "tbl_members.email ";
		$select.= "FROM tbl_listings ";
		$select.= "LEFT JOIN tbl_members ";
		$select.= "ON tbl_listings.user_id = tbl_members.user_id ";
		$select.= "WHERE tbl_listings.listing_id = '".$_POST['refno']."' ";
		$select.= "LIMIT 1";

		$result = $conn->query($select);
		$row = $result->fetch_assoc();

		if($row['listing_type'] == 'Sale') {
			$category = 'Buyer';
		} else {
			$category = 'Tenant';
		}

		if(!empty($row['building_name'])) {
			$project = $row['building_name'].', '.$row['location'];
		} elseif(!empty($row['property'])) {
			$project = $row['property'].', '.$row['location'];
		} else {
			$project = $row['sub_location'].', '.$row['location'];
		}

		if($row['building_status'] == 'Off Plan') {
			$section = "Off Plan";
		} else {
			$section = "General";
		}

		$client_inquiry = 'Requesting to be called back.';

		//Check the leads existence
		$check = $conn->query("SELECT tbl_contacts.contact_id FROM tbl_contacts LEFT JOIN tbl_inquiries ON tbl_contacts.contact_id = tbl_inquiries.contact_id WHERE tbl_contacts.contact_name LIKE '%".encodeData($_POST['name'])."%' AND REPLACE(REPLACE(REPLACE(tbl_contacts.mobile,'+',''),' ',''),'-','') LIKE '%".encodeData(substr(str_replace(" ","",str_replace("-","",str_replace("+","",$_POST['phone']))), -9))."%' AND tbl_contacts.email = '".encodeData($_POST['email'])."' AND tbl_contacts.source = '".encodeData($_POST['source'])."' AND tbl_contacts.sub_source = '".encodeData($_POST['sub_source'])."' AND tbl_contacts.user_id = '".$row['user_id']."' AND tbl_inquiries.refno = '".$row['listing_id']."'");

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
			$insert.= "'".addslashes(sanitizeData($category))."', ";
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
			$insert_inquiry.= "agent, ";
			$insert_inquiry.= "section, ";
			$insert_inquiry.= "location, ";
			$insert_inquiry.= "property_type, ";
			$insert_inquiry.= "preference, ";
			$insert_inquiry.= "bedrooms, ";
			$insert_inquiry.= "budget, ";
			$insert_inquiry.= "inquiry, ";
			$insert_inquiry.= "inserted_by, ";
			$insert_inquiry.= "inserted_date, ";
			$insert_inquiry.= "updated_by, ";
			$insert_inquiry.= "updated_date)";
			$insert_inquiry.= "VALUES (";
			$insert_inquiry.= "'".$contact_id."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($row['listing_id']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($row['user_name']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($section))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($project))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($row['property_type']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($row['listing_type']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($row['bedrooms']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($row['list_price']))."', ";
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
			$insert_activity.= "'Requested a call back on ".date("M j, Y")."', ";
			$insert_activity.= "'".addslashes(sanitizeData($client_name[0]))."', ";
			$insert_activity.= "NOW())";

			$conn->query($insert_activity);
		}

		$body = file_get_contents("html/notification.callback.html");
		$body = preg_replace("/[\\\]/","",$body);

		$reply_body = file_get_contents("html/autoreply.callback.html");
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
		$inquiry_details.= "<div style='padding: 7px 10px; background: #D5D5D5; color: #868ba1; font-weight: bold;'>PROPERTY</div>";
		$inquiry_details.= "<br/>";
		$inquiry_details.= "<table cellpadding='0' cellspacing='0'>";
		if(!empty($row['listing_id'])){
			$inquiry_details.= "<tr>";
			$inquiry_details.= "<td style='padding: 3px 0px;'><strong>Listing Ref</strong></td>";
			$inquiry_details.= "<td style='padding: 3px 10px;'>: ".decodeData($refno_code.$row['listing_id'])."</td>";
			$inquiry_details.= "</tr>";
		}
		if(!empty($project)){
			$inquiry_details.= "<tr>";
			$inquiry_details.= "<td style='padding: 3px 0px;'><strong>Location</strong></td>";
			$inquiry_details.= "<td style='padding: 3px 10px;'>: ".decodeData($project)."</td>";
			$inquiry_details.= "</tr>";
		}
		if(!empty($row['property_type'])){
			$inquiry_details.= "<tr>";
			$inquiry_details.= "<td style='padding: 3px 0px;'><strong>Property Type</strong></td>";
			$inquiry_details.= "<td style='padding: 3px 10px;'>: ".decodeData($row['property_type'])."</td>";
			$inquiry_details.= "</tr>";
		}
		if(!empty($row['listing_type'])){
			$inquiry_details.= "<tr>";
			$inquiry_details.= "<td style='padding: 3px 0px;'><strong>Preference</strong></td>";
			$inquiry_details.= "<td style='padding: 3px 10px;'>: ".decodeData($row['listing_type'])."</td>";
			$inquiry_details.= "</tr>";
		}
		if($row['bedrooms'] != ''){
			if($row['bedrooms'] == 0) {
				$inquiry_details.= "<tr>";
				$inquiry_details.= "<td style='padding: 3px 0px;'><strong>Bedrooms</strong></td>";
				$inquiry_details.= "<td style='padding: 3px 10px;'>: Studio</td>";
				$inquiry_details.= "</tr>";
			} else {
				$inquiry_details.= "<tr>";
				$inquiry_details.= "<td style='padding: 3px 0px;'><strong>Bedrooms</strong></td>";
				$inquiry_details.= "<td style='padding: 3px 10px;'>: ".decodeData($row['bedrooms'])." Bed</td>";
				$inquiry_details.= "</tr>";
			}
		}
		if($row['list_price'] != '0.00'){
			$inquiry_details.= "<tr>";
			$inquiry_details.= "<td style='padding: 3px 0px;'><strong>Price</strong></td>";
			$inquiry_details.= "<td style='padding: 3px 10px;'>: AED".str_replace('.00','',number_format($row['list_price']))."</td>";
			$inquiry_details.= "</tr>";
		}
		$inquiry_details.= "</table>";
		$inquiry_details.= "<br/>";

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
			$client_inquiry,
			trimData($_POST['name']),
			$category,
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

		$mail->Subject = 'A client is requesting to be called back.';

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
			$whatsapp_message = '*Requesting Call Back*'."\n\n";
			if(!empty($row['listing_id'])){
				$whatsapp_message.= $refno_code.$row['listing_id']."\n";
			}
			if(!empty($project)){
				$whatsapp_message.= sanitizeData($project)."\n";
			}
			if(!empty($row['property_type'])){
				$whatsapp_message.= sanitizeData($row['property_type'])."\n";
			}
			if(!empty($row['listing_type'])){
				$whatsapp_message.= sanitizeData($row['listing_type'])."\n";
			}
			if(!empty($row['bedrooms'])){
				if($row['bedrooms'] == 0) {
					$whatsapp_message.= "Studio\n";
				} else {
					$whatsapp_message.= sanitizeData($row['bedrooms'])." Bed\n";
				}
			}
			if($row['list_price'] != '0.00'){
				$whatsapp_message.= "AED".str_replace(".00","",number_format($row['list_price'],2))."\n\n";
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
