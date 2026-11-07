<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
function amountInWords($amount) {
	// First strip any formatting
	$amount = (0+str_replace(",","",$amount));

	// Check if a number?
	if (!is_numeric($amount)){
		return false;
	}

	$trillion = 1000000000000;
	$billion 	= 1000000000;
	$million 	= 1000000;
	$thousand = 1000;

	// Now filter it
	if ($amount >= $trillion){
		return round(($amount/$trillion),2)."T";
	}	elseif ($amount >= $billion){
		return round(($amount/$billion),2)."B";
	}	elseif ($amount >= $million){
		return round(($amount/$million),2)."M";
	} elseif($amount >= $thousand){
		return round(($amount/$thousand),2)."K";
	} else {
		return number_format($amount);
	}
}

function truncateString($string,$length){
	$str 			= preg_replace("/<[^<]+?>/","",$string);
	$str_len	= strlen($str);
	if($str_len < $length) {
		$strip_str = $str;
	} else {
		$pos = strpos($str," ",$length);
		$strip_str = rtrim(substr($str,0,$pos),",")."...";
	}
	return $strip_str;
}

function sanitizeData($data){
	$data	= trim($data);
	$data = stripslashes($data);
	$data	= htmlspecialchars($data);
	$data	= str_replace("'","&#39;",$data);
	//$data	= mysqli_real_escape_string($data);
	return $data;
}

function encodeData($data){
	$data	= trim($data);
	$data = addslashes($data);
	$data	= htmlspecialchars($data);
	$array_char 	= array("'");
	$replace_char = array("&#39;");
	$data	= str_replace($array_char,$replace_char,$data);
	return $data;
}

function decodeData($data){
	$data	= trim($data);
	$data = stripslashes($data);
	$data = html_entity_decode($data);
	$array_char 	= array("&#39;");
	$replace_char = array("'");
	$data	= str_replace($array_char,$replace_char,$data);
	return $data;
}

function trimData($data){
	$data	= trim($data);
	return $data;
}

function cleanString($string) {
	$string = trim($string);
  $string = str_replace(' ', '-', $string); 								// Replaces all spaces with hyphens.
  $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); 	// Removes special chars.
  $string = preg_replace('/-+/', '-', $string); 						// Replaces multiple hyphens with single one.
	return strtolower(rtrim($string,"-")); 										// Convert the string to lowecase.
}

function dataString($string) {
	$string = trim($string);
  $string = preg_replace('/[^A-Za-z0-9\-.@+ ]/', '', $string); 	// Removes special chars.
	return $string; 																							// Convert the string to lowecase.
}

function numberToWords($number){
	$ones 	= array("Zero", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine");
	$teens 	= array("Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eighteen", "Nineteen");
	$tens 	= array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", "Seventy", "Eighty", "Ninety");
	$sets		= array("", "Thousand", "Million", "Billion", "Trillion");

	if($number==0)
	return "Zero";

	$numbers = array_reverse(str_split($number));
	$x = array_chunk($numbers,3);
	$words = array();

	for($i=count($x)-1; $i>=0; $i--){
		// HUNDREDS
		if(($x[$i][2]>0)&&($x[$i][2]<=9))
		array_push($words,$ones[$x[$i][2]] . " Hundred");

		// TENS
		if(($x[$i][1]>1)&&($x[$i][1]<=9))
		array_push($words,$tens[$x[$i][1]]);

		// TEENS
		if($x[$i][1]==1)
		array_push($words,$teens[$x[$i][0]]);
		else
		// ONES
		if($x[$i][0]>0)
		array_push($words,$ones[$x[$i][0]]);

		// SETS
		if(($i>0)&&($x[$i][2]+$x[$i][1]+$x[$i][0]!=0))
		array_push($words,$sets[$i]);
	}
	return implode(" ", $words);
}
// Bitly URL Shortener Starts
// function get_short_url($long_url,$api_key) {
// 	$url 	= 'https://api-ssl.bitly.com/v4/bitlinks';
// 	$ch 	= curl_init($url);
// 	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['long_url' => $long_url]));
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, [
//     "Authorization: Bearer ".$api_key,
//     "Content-Type: application/json"
// 	]);
//
// 	$arr_result = json_decode(curl_exec($ch));
// 	curl_close($ch);
// 	return $arr_result->link;
// }

// Short.io URL Shortener Starts
function get_short_url($long_url,$api_key) {
	$url 	= 'https://api.short.io/links';
	$ch 	= curl_init($url);
	curl_setopt_array($ch, array(
		CURLOPT_URL 						=> $url,
		CURLOPT_RETURNTRANSFER 	=> true,
		CURLOPT_ENCODING 				=> "",
		CURLOPT_MAXREDIRS 			=> 10,
		CURLOPT_TIMEOUT 				=> 30,
		CURLOPT_HTTP_VERSION 		=> CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST 	=> "POST",
		CURLOPT_POSTFIELDS 			=> json_encode(array(
			'originalURL' 				=> $long_url,
			'domain' 							=> 'bitlx.xyz'
			//'title' 							=> 'My Title'
		)),
		CURLOPT_HTTPHEADER => array(
			"authorization: ".$api_key,
			"content-type: application/json"
		),
	));

	$arr_result = json_decode(curl_exec($ch));
	curl_close($ch);
	return $arr_result->shortURL;
}
function date_quarter($date) {
	$month = date('n',strtotime($date));
	if($month <= 3) {
		return 1;
	} elseif($month <= 6) {
		return 2;
	} elseif($month <= 9) {
		return 3;
	} else {
		return 4;
	}
}
?>
