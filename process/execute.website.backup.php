<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
@ini_set('max_execution_time',0);
@ini_set('memory_limit', '-1');

include_once("../includes/constants.php");	    // Page constants

//Clear first the backups
$db_backups 	= scandir(rootdir.'FullBackup/');
$num_files		= count($db_backups)-2;
if($num_files >= 10) {
	foreach($db_backups as $db_backup) {
		if($db_backup != '.' && $db_backup != '..') {
			$backup_created = date("F d Y H:i:s", filemtime(rootdir.'FullBackup/'.$db_backup));
			if(strtotime($backup_created) < strtotime("-10 days")) {
				unlink(rootdir.'FullBackup/'.$db_backup);
			}
			unset($backup_created);
		}
	}
}

$timestamp	  = date("Y-m-d");
$source       = absolutedir;
$destination  = rootdir.'FullBackup/';

exec("tar -czf ".$destination."goldmark_website_backup.".$timestamp.".tar.gz ".$source);

echo "Website backup successfully processed!";
?>
