<?php
@ini_set('max_execution_time',0);
@ini_set('memory_limit', '-1');

if(!empty($_GET['db'])) {
	include_once('../includes/constants.php');
	$dir_temp = absolutedir.'temp/';
	file_put_contents($dir_temp.trim($_GET['db']),file_get_contents("https://my.goldmark.ae/temp/".trim($_GET['db'])));
}
?>
