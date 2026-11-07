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
		if(!empty($_POST['user'])) {
			include_once(absolutedir."process/includes/agents.php");
		} else {
			include_once(absolutedir."process/includes/listings.php");
		}
	} else {
		$results = 2;
	}

	echo $results;
	// Close database connection
	$conn->close();
}
?>
