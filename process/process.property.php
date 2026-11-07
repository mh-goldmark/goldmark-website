<?php
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && $_POST['source'] == 'Website' && $_POST['sub_source'] == 'Submit Property') {

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

		$allowed_extension  = array("pdf","PDF","doc","docx","DOC","DOCX");

		// Documents
		if($_FILES['documents']['name'][0] != "") {

			if(count($_FILES['documents']['name']) > 3) { //5 MB (size is also in bytes)
				echo 3;
				return;
			}

			$docs_sizes = 0;

			for($i = 0; $i < count($_FILES['documents']['name']); $i++) {

				$filename 	= $_FILES['documents']['name'][$i];
				$extension 	= pathinfo($filename, PATHINFO_EXTENSION);
				$docs_sizes += $_FILES['documents']['size'][$i];

				if(!in_array($extension, $allowed_extension)) {
					$docs_extensions += 1;
				} else {
					$docs_extensions += 0;
				}
			}

			if($docs_sizes > 10485760) { //5 MB (size is also in bytes)
				echo 4;
				return;
			} elseif($docs_extensions >= 1) {
				echo 5;
				return;
			}
		}

		//Prepare the agent information
		$select = "SELECT tbl_members.user_id, ";
		$select.= "tbl_members.full_name, ";
		$select.= "tbl_members.user_name, ";
		$select.= "tbl_members.mobile, ";
		$select.= "tbl_members.email ";
		$select.= "FROM tbl_members ";
		$select.= "WHERE tbl_members.user_id = '".$_POST['user_id']."' ";
		$select.= "LIMIT 1";

		$result = $conn->query($select);
		$row = $result->fetch_assoc();

		if($_POST['category'] == 'Residential for Sale' || $_POST['category'] == 'Commercial for Sale') {
			$category = 'Seller';
			$class 		= 'Sale';
		} else {
			$category = 'Landlord';
			$class 		= 'Rent';
		}

		$client_inquiry = 'Property submitted to be listed.';

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
			$insert_inquiry.= "'".addslashes(sanitizeData($row['user_name']))."', ";
			$insert_inquiry.= "'General', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($_POST['project']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($_POST['type']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($class))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($_POST['bedroom']))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData(str_replace(",","",$_POST['price'])))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($client_inquiry))."', ";
			$insert_inquiry.= "'".addslashes(sanitizeData($client_name[0]))."', ";
			$insert_inquiry.= "NOW(), ";
			$insert_inquiry.= "'".addslashes(sanitizeData($client_name[0]))."', ";
			$insert_inquiry.= "NOW())";

			$conn->query($insert_inquiry);
			$inquiry_id = $conn->insert_id;

			$insert_activity = "INSERT INTO tbl_activity_logs (";
			$insert_activity.= "reference, ";
			$insert_activity.= "source, ";
			$insert_activity.= "activity, ";
			$insert_activity.= "inserted_by, ";
			$insert_activity.= "inserted_date)";
			$insert_activity.= "VALUES (";
			$insert_activity.= "'".$inquiry_id."', ";
			$insert_activity.= "'Property', ";
			$insert_activity.= "'Submitted property on ".date("M j, Y")."', ";
			$insert_activity.= "'".addslashes(sanitizeData($client_name[0]))."', ";
			$insert_activity.= "NOW())";

			$conn->query($insert_activity);
		}

		$body = file_get_contents("html/notification.listing.html");
		$body = preg_replace("/[\\\]/","",$body);

		$reply_body = file_get_contents("html/autoreply.listing.html");
		$reply_body = preg_replace("/[\\\]/","",$reply_body);

		if(!empty($_POST['email'])){
			$other_details.= "<tr>";
			$other_details.= "<td style='padding: 3px 0px;'><strong>Email</strong></td>";
			$other_details.= "<td style='padding: 3px 10px;'>: ".trimData(strtolower($_POST['email']))."</td>";
			$other_details.= "</tr>";
		}
		if(!empty($_POST['phone'])){
			$other_details.= "<tr>";
			$other_details.= "<td style='padding: 3px 0px;'><strong>Phone</strong></td>";
			$other_details.= "<td style='padding: 3px 10px;'>: ".trimData($_POST['phone'])."</td>";
			$other_details.= "</tr>";
		}

		// Property details
		$property_details = "<tr>";
		$property_details.= "<td style='padding: 3px 0px;' colspan='2'><strong>".trimData($_POST['category'])."</strong></td>";
		$property_details.= "</tr>";
		$property_details.= "<tr>";
		$property_details.= "<td style='padding: 3px 0px;'><strong>Type</strong></td>";
		$property_details.= "<td style='padding: 3px 10px;'>: ".trimData($_POST['type'])."</td>";
		$property_details.= "</tr>";
		$property_details.= "<tr>";
		$property_details.= "<td style='padding: 3px 0px;'><strong>Location</strong></td>";
		$property_details.= "<td style='padding: 3px 10px;'>: ".trimData($_POST['location'])."</td>";
		$property_details.= "</tr>";
		$property_details.= "<tr>";
		$property_details.= "<td style='padding: 3px 0px;'><strong>Project</strong></td>";
		$property_details.= "<td style='padding: 3px 10px;'>: ".trimData($_POST['project'])."</td>";
		$property_details.= "</tr>";
		if(in_array($_POST['type'],$property_type_bedrooms)) {
			if($_POST['bedroom'] != '') {
				if($_POST['bedroom'] == 0) {
					$property_details.= "<tr>";
					$property_details.= "<td style='padding: 3px 0px;'><strong>Bedrooms</strong></td>";
					$property_details.= "<td style='padding: 3px 10px;'>: Studio</td>";
					$property_details.= "</tr>";
				} else {
					$property_details.= "<tr>";
					$property_details.= "<td style='padding: 3px 0px;'><strong>Bedrooms</strong></td>";
					$property_details.= "<td style='padding: 3px 10px;'>: ".trimData($_POST['bedroom'])." Bed</td>";
					$property_details.= "</tr>";
				}
			}
			if(!empty($_POST['bathroom'])) {
				$property_details.= "<tr>";
				$property_details.= "<td style='padding: 3px 0px;'><strong>Bathrooms</strong></td>";
				$property_details.= "<td style='padding: 3px 10px;'>: ".trimData($_POST['bathroom'])." Bath</td>";
				$property_details.= "</tr>";
			}
		}
		$property_details.= "<tr>";
		$property_details.= "<td style='padding: 3px 0px;'><strong>Size</strong></td>";
		$property_details.= "<td style='padding: 3px 10px;'>: ".trimData($_POST['size'])." sqft</td>";
		$property_details.= "</tr>";
		$property_details.= "<tr>";
		$property_details.= "<td style='padding: 3px 0px;'><strong>Price</strong></td>";
		$property_details.= "<td style='padding: 3px 10px;'>: AED".amountInWords(trimData(str_replace(',','',$_POST['price'])))."</td>";
		$property_details.= "</tr>";
		if(!empty($_POST['details'])) {
			$property_details.= "<tr>";
			$property_details.= "<td colspan='2' style='padding: 3px 0px;'><strong>Details</strong></td>";
			$property_details.= "</tr>";
			$property_details.= "<tr>";
			$property_details.= "<td colspan='2' style='padding: 3px 0px;'>".nl2br(trimData($_POST['details']))."</td>";
			$property_details.= "</tr>";
		}

		// Setup variables to be replaced
		$vars = array(
			"{agent}",
			"{source}",
			"{property_details}",
			"{name}",
			"{type}",
			"{details}",
			"{logo}",
			"{company_name}"
		);
		$vals = array(
			decodeData($row['full_name']),
			trimData($_POST['source']).' - '.trimData($_POST['sub_source']),
			$property_details,
			trimData($_POST['name']),
			$category,
			$other_details,
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
		$mail->FromName = trimData($_POST['name']);

		$mail->Subject = trimData($_POST['name']).' requested a property to be listed.';

		$temp_folder = uniqid();

		// Prepare the directory
		$dir_path_folder = absolutedir."temp/".$temp_folder."/";

		// Documents
		if($_FILES['documents']['name'][0] != "") {
			// Check if document directory exist
			if(!file_exists($dir_path_folder)) {
				// Unmask the folder and set permission
				$unmask = umask(0);
		    mkdir(absolutedir."temp/".$temp_folder, 0755);
				umask($unmask);
			}

			$document_file			= 1;
			$document_filename  = 1;
			$document_extension	= 1;
			$target							= 1;

			for($i = 0; $i < count($_FILES['documents']['name']); $i++) {

				$document_file++;
				$document_filename++;
				$document_extension++;
				$target++;

				$document_file 			= explode(".", $_FILES["documents"]["name"][$i]);
				$document_extension = end($document_file);
				$document_filename 	= basename($_FILES['documents']['name'][$i], ".".$document_extension);

				$target = $dir_path_folder.cleanString($document_filename).'.'.$document_extension;
				move_uploaded_file($_FILES["documents"]["tmp_name"][$i], $target);

				$mail->addAttachment($dir_path_folder.cleanString($document_filename).'.'.$document_extension);
			}
		}

		$mail->AddAddress(decodeData($row["email"]), decodeData($row["full_name"])); // Include only this line if no email group defined from

		// Include the emails to send from the setting
		include_once(absolutedir."emails/addresses.php");

		$mail->AltBody = "Please switch to HTML format to view this email correctly";
		$mail->msgHTML($body);

		if($mail->send()) {
			if($_FILES['documents']['name'][0] != "") {
				system('/bin/rm -rf '.escapeshellarg(absolutedir."temp/".$temp_folder."/"));
			}
		}

		$mail->ClearAddresses();
		$mail->ClearCCs();
		$mail->ClearBCCs();
		$mail->ClearAllRecipients();
		$mail->clearAttachments();

		if(!empty($row['mobile']) && !empty($whatsapp_api_token) && !empty($whatsapp_api_url)) {

			$whatsapp_phone = str_replace($string_replace_mobile,"",$row['mobile']);

			//Whatsapp Notifications
			$whatsapp_message = '*Property Listing*'."\n\n";
			if(!empty($_POST['category'])){
				$whatsapp_message.= trimData($_POST['category'])."\n";
			}
			if(!empty($_POST['project'])){
				$whatsapp_message.= trimData($_POST['project'])."\n";
			}
			if(!empty($_POST['type'])){
				$whatsapp_message.= trimData($_POST['type'])."\n";
			}
			if($_POST['category'] == 'Residential for Sale' || $_POST['category'] == 'Residential for Rent'){
				if($_POST['bedroom'] == 0) {
					$whatsapp_message.= "Studio\n";
				} else {
					$whatsapp_message.= trimData($_POST['bedroom'])." Bed\n";
				}
			}
			if(!empty($_POST['price'])){
				$whatsapp_message.= "AED".trimData($_POST['price'])."\n\n";
			}
			$whatsapp_message.= trimData($_POST['name'])."\n";
			if(!empty($_POST['phone'])){
				$whatsapp_message.= trimData($_POST['phone'])."\n";
			}
			if(!empty($_POST['email'])){
				$whatsapp_message.= trimData($_POST['email'])."\n";
			}
			$whatsapp_message.= $category."\n";

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

		$mail->AddEmbeddedImage(absolutedir."images/logos/".$company_logo, $company_logo_name, $company_logo);

		$mail->From 		= $setting_account_email;
		$mail->FromName = $company_name;

		// Send autoreply
		$mail->AddAddress(trimData($_POST['email']), trimData($_POST['name']));
		$mail->AddBcc("dom@sahagun.net", "IT Support");

		$mail->Subject = "Thank you for sharing your property with ".$company_name;

		$mail->AltBody = "Please switch to HTML format to view this email correctly";
		$mail->msgHTML($reply_body);

		$mail->send();
		$mail->ClearAddresses();
		$mail->ClearCCs();
		$mail->ClearBCCs();
		$mail->ClearAllRecipients();
		$mail->clearAttachments();

		$mail->SmtpClose(); // Close phpmailer

		$results 	= 1;
	} else {
		$results 	= 2;
	}

	echo $results;

	// Close database connection
	$conn->close();
}
?>
