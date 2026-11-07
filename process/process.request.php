<?php
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['source']) && !empty($_POST['sub_source'])) {

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

		if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone'])) {

			//Check first if contact already inserted
			$check = $conn->query("SELECT contact_id FROM tbl_zapier WHERE contact_name LIKE '%".encodeData($_POST['name'])."%' AND REPLACE(REPLACE(REPLACE(mobile,'+',''),' ',''),'-','') LIKE '%".encodeData(substr(str_replace(" ","",str_replace("-","",str_replace("+","",$_POST['phone']))), -9))."%' AND email = '".encodeData($_POST['email'])."' AND source = '".encodeData($_POST['source'])."' AND sub_source = '".encodeData($_POST['sub_source'])."' AND inserted_date >= '".date('Y-m-d',strtotime('-1 day'))."'");

			if($check->num_rows <= 0) {
				// Insert the leads (tbl_zapier)
				$insert = "INSERT INTO tbl_zapier (";
				$insert.= "individual, ";
				$insert.= "contact_name, ";
				$insert.= "email, ";
				$insert.= "phone, ";
				$insert.= "category, ";
				$insert.= "source, ";
				$insert.= "sub_source, ";
				$insert.= "campaign, ";
				$insert.= "remarks, ";
				$insert.= "inserted, ";
				$insert.= "inserted_by, ";
				$insert.= "inserted_date, ";
				$insert.= "updated_by, ";
				$insert.= "updated_date)";
				$insert.= "VALUES (";
				$insert.= "true, ";
				$insert.= "'".sanitizeData($_POST['name'])."', ";
				$insert.= "'".sanitizeData($_POST['email'])."', ";
				$insert.= "'".sanitizeData($_POST['phone'])."', ";
				$insert.= "'Buyer', ";
				$insert.= "'".sanitizeData($_POST['source'])."', ";
				$insert.= "'".sanitizeData($_POST['sub_source'])."', ";
				$insert.= "'".sanitizeData($_POST['source'].' - '.$_POST['sub_source'])."', ";
				$insert.= "'".sanitizeData($_POST['message'])."', ";
				$insert.= "false, ";
				$insert.= "'PropGuru', ";
				$insert.= "NOW(), ";
				$insert.= "'PropGuru', ";
				$insert.= "NOW())";

				$conn->query($insert);

				$insert_activity = "INSERT INTO tbl_activity_logs (";
				$insert_activity.= "reference, ";
				$insert_activity.= "source, ";
				$insert_activity.= "activity, ";
				$insert_activity.= "inserted_by, ";
				$insert_activity.= "inserted_date)";
				$insert_activity.= "VALUES (";
				$insert_activity.= "'".$inquiry_id."', ";
				$insert_activity.= "'Leads', ";
				$insert_activity.= "'Sent inquiry from PropGuru on ".date("M j, Y")."', ";
				$insert_activity.= "'PropGuru', ";
				$insert_activity.= "NOW())";

				$conn->query($insert_activity);
			}
		}

		$results = 1;
	} else {
		$results = 2;
	}

	echo $results;
	// Close database connection
	$conn->close();
}
?>
