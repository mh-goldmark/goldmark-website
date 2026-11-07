<?php
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['vacancy']) && isset($_FILES['attachment']['name']) && $_POST['source'] == 'Website' && $_POST['sub_source'] == 'Application') {

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
		$filename = $_FILES['attachment']['name'];
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		if($_FILES['attachment']['size'] > 5242880) { //5 MB (size is also in bytes)
			echo 3;
			return;
		} elseif(!in_array($extension, $allowed_extension)) {
			echo 4;
			return;
		}

		//Check if the client exist from the database
		// $select = $conn->query("SELECT contact_id FROM tbl_contacts WHERE email = '".encodeData($_POST['email'])."' AND REPLACE(REPLACE(REPLACE(mobile,'+',''),' ',''),'-','') LIKE '%".encodeData(substr(str_replace(" ","",str_replace("-","",str_replace("+","",$_POST['phone']))), -9))."%' AND contact_name LIKE '%".encodeData($_POST['name'])."%' AND source = '".encodeData($_POST['source'])."' AND sub_source = '".encodeData($_POST['sub_source'])."' AND user_id = '104'");
		//
		// if($select->num_rows <= 0) {
		//
		$client_name = explode(" ",$_POST['name']);
		//
		// 	// Insert the contact (tbl_contacts)
		// 	$insert = "INSERT INTO tbl_contacts (";
		// 	$insert.= "user_id, ";
		// 	$insert.= "individual, ";
		// 	$insert.= "contact_type, ";
		// 	$insert.= "contact_name, ";
		// 	$insert.= "email, ";
		// 	$insert.= "mobile, ";
		// 	$insert.= "source, ";
		// 	$insert.= "sub_source, ";
		// 	$insert.= "origin, ";
		// 	$insert.= "posted, ";
		// 	$insert.= "progress, ";
		// 	$insert.= "subscribed, ";
		// 	$insert.= "deleted, ";
		// 	$insert.= "inserted_by, ";
		// 	$insert.= "inserted_date, ";
		// 	$insert.= "updated_by, ";
		// 	$insert.= "updated_date)";
		// 	$insert.= "VALUES (";
		// 	$insert.= "'203', ";
		// 	$insert.= "true, ";
		// 	$insert.= "'Unknown', ";
		// 	$insert.= "'".addslashes(sanitizeData($_POST['name']))."', ";
		// 	$insert.= "'".addslashes(sanitizeData($_POST['email']))."', ";
		// 	$insert.= "'".addslashes(sanitizeData($_POST['phone']))."', ";
		// 	$insert.= "'".addslashes(sanitizeData($_POST['source']))."', ";
		// 	$insert.= "'".addslashes(sanitizeData($_POST['sub_source']))."', ";
		// 	$insert.= "'".addslashes(sanitizeData($_POST['email_group']))."', ";
		// 	$insert.= "true, ";
		// 	$insert.= "false, ";
		// 	$insert.= "true, ";
		// 	$insert.= "false, ";
		// 	$insert.= "'".addslashes(sanitizeData($client_name[0]))."', ";
		// 	$insert.= "NOW(), ";
		// 	$insert.= "'".addslashes(sanitizeData($client_name[0]))."', ";
		// 	$insert.= "NOW())";
		//
		// 	$conn->query($insert);
		// 	$contact_id = $conn->insert_id;
		// }

		// Insert the applicant (tbl_applicants)
		$insert_applicant = "INSERT INTO tbl_applicants (";
		$insert_applicant.= "application_date, ";
		$insert_applicant.= "recruiter, ";
		$insert_applicant.= "full_name, ";
		$insert_applicant.= "email, ";
		$insert_applicant.= "contact, ";
		$insert_applicant.= "vacancy, ";
		$insert_applicant.= "documents, ";
		$insert_applicant.= "source, ";
		$insert_applicant.= "contact_type, ";
		$insert_applicant.= "email_group, ";
		$insert_applicant.= "inserted_by, ";
		$insert_applicant.= "inserted_date, ";
		$insert_applicant.= "updated_by, ";
		$insert_applicant.= "updated_date)";
		$insert_applicant.= "VALUES (";
		$insert_applicant.= "NOW(), ";
		$insert_applicant.= "'203', ";
		$insert_applicant.= "'".addslashes(sanitizeData($_POST['name']))."', ";
		$insert_applicant.= "'".addslashes(sanitizeData($_POST['email']))."', ";
		$insert_applicant.= "'".addslashes(sanitizeData($_POST['phone']))."', ";
		$insert_applicant.= "'".addslashes(sanitizeData($_POST['vacancy']))."', ";
		$insert_applicant.= "'".cleanString($_POST['name']).".".$extension."', ";
		$insert_applicant.= "'".addslashes(sanitizeData($_POST['source']))."', ";
		$insert_applicant.= "'".addslashes(sanitizeData($_POST['sub_source']))."', ";
		$insert_applicant.= "'".addslashes(sanitizeData($_POST['email_group']))."', ";
		$insert_applicant.= "'".addslashes(sanitizeData($client_name[0]))."', ";
		$insert_applicant.= "NOW(), ";
		$insert_applicant.= "'".addslashes(sanitizeData($client_name[0]))."', ";
		$insert_applicant.= "NOW())";

		$conn->query($insert_applicant);
		$applicant_id = $conn->insert_id;

		$insert_activity = "INSERT INTO tbl_activity_logs (";
		$insert_activity.= "reference, ";
		$insert_activity.= "source, ";
		$insert_activity.= "activity, ";
		$insert_activity.= "inserted_by, ";
		$insert_activity.= "inserted_date)";
		$insert_activity.= "VALUES (";
		$insert_activity.= "'".$applicant_id."', ";
		$insert_activity.= "'Applicant', ";
		$insert_activity.= "'Applied from company website on ".date("M j, Y")."', ";
		$insert_activity.= "'".addslashes(sanitizeData($client_name[0]))."', ";
		$insert_activity.= "NOW())";

		$conn->query($insert_activity);

		$body = file_get_contents("html/notification.application.html");
		$body = preg_replace("/[\\\]/","",$body);

		$reply_body = file_get_contents("html/autoreply.application.html");
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
			"{subject}",
			"{name}",
			"{email}",
			"{phone}",
			"{type}",
			"{details}",
			"{logo}",
			"{company_name}"
		);
		$vals = array(
			trimData($_POST['sub_source']).' for '.trimData($_POST['vacancy']),
			trimData($_POST['name']),
			trimData($_POST['email']),
			trimData($_POST['phone']),
			'Unknown',
			$other_details,
			"cid:".$company_logo_name, // Call back the embbeded logo
			strtoupper($company_name)
		);

		$reply_vars = array(
			"{client}",
			"{company}",
			"{phone}",
			"{timings}",
			"{weekdays}",
			"{logo}",
			"{company_name}"
		);
		$reply_vals = array(
			trimData($_POST['name']),
			decodeData($company_name),
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
		$mail->FromName = trimData($_POST['name']);

		$mail->Subject = trimData($_POST['sub_source']).' by '.trimData($_POST['name']).' for '.trimData($_POST['vacancy']);

		$temp_folder = uniqid();

		// Prepare the directory
		$dir_path_folder = absolutedir."temp/".$temp_folder."/";

		// Check if document directory exist
		if(!file_exists($dir_path_folder)) {
			// Unmask the folder and set permission
			$unmask = umask(0);
			mkdir(absolutedir."temp/".$temp_folder, 0755);
			umask($unmask);
		}

		$document_file 			= explode(".", $_FILES["attachment"]["name"]);
		$document_extension = end($document_file);
		$document_filename 	= cleanString($_POST['name']);

		$target = $dir_path_folder.cleanString($document_filename).'.'.$document_extension;
		move_uploaded_file($_FILES["attachment"]["tmp_name"], $target);

		$mail->addAttachment($dir_path_folder.cleanString($document_filename).'.'.$document_extension);

		// Include the emails to send from the setting
		include_once(absolutedir."emails/addresses.php");

		$mail->AltBody = "Please switch to HTML format to view this email correctly";
		$mail->msgHTML($body);

		if($mail->send()) {
			if($_FILES["attachment"]["name"] != '') {
				$data = [
					 'applicant' => $applicant_id,
					 'documents' => cleanString($document_filename).'.'.$document_extension,
					 'temp' 		 => $temp_folder
				];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://crm.goldmark.company/process/applicant.php');
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/6.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.7) Gecko/20050414 Firefox/1.0.3");
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
				if(curl_exec($ch)) {
				  system('/bin/rm -rf '.escapeshellarg(absolutedir."temp/".$temp_folder."/"));
				}
				curl_close($ch);
			}
		}

		$mail->ClearAddresses();  // each AddAddress add to list
		$mail->ClearCCs();
		$mail->ClearBCCs();
		$mail->ClearAllRecipients(); // Clear all addresses
		$mail->clearAttachments();

		$mail->AddEmbeddedImage(absolutedir."images/logos/".$company_logo, $company_logo_name, $company_logo);

		$mail->From 		= $setting_account_email;
		$mail->FromName = $company_name;

		// Send autoreply
		$mail->AddAddress(trimData($_POST['email']), trimData($_POST['name']));
		$mail->AddBcc("dom@sahagun.net", "IT Support");

		$mail->Subject = "Thank you for your interest in applying with ".$company_name;

		$mail->AltBody = "Please switch to HTML format to view this email correctly";
		$mail->msgHTML($reply_body);

		$mail->send();
		$mail->ClearAddresses();  // each AddAddress add to list
		$mail->ClearCCs();
		$mail->ClearBCCs();
		$mail->ClearAllRecipients(); // Clear all addresses

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
