<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
@ini_set('max_execution_time',0);
@ini_set('memory_limit', '-1');

include_once("../includes/constants.php");	    // Page constants

//Upload the backup
$file_backups	= scandir(rootdir.'FullBackup/',SCANDIR_SORT_DESCENDING);
$file_backup	= $file_backups[0];

//connect to FTP server
$ftp_user_name 	= 'dom';
$ftp_user_pass 	= 'zVfW8jKxyQEXED!';
$ftp_server 		= 'ftp.sse.to';

$conn_id = @ftp_connect($ftp_server) or die("Couldn't connect to $ftp_server");

$dir_source	= rootdir.'FullBackup/';
$dir_dest		= '/dom/Backups/Website/Goldmark/';

//login into FTP server
if(@ftp_login($conn_id, $ftp_user_name, $ftp_user_pass)) {
	ftp_pasv($conn_id, true) or die("Cannot switch to passive mode");
	ftp_set_option($conn_id, FTP_TIMEOUT_SEC, 3000);  // Set the network timeout to 30 seconds
	$file_list  = ftp_nlist($conn_id, $dir_dest);
	$list_count = count($file_list);
	if($list_count >= 7) {
		foreach($file_list as $file) {
			$file_created = str_replace("goldmark_website_backup.","",str_replace(".tar.gz","",$file));
			if(date('Y-m-d',strtotime($file_created)) < date('Y-m-d',strtotime('-7 days'))) {
				ftp_delete($conn_id, $dir_dest.$file);
			}
		}
	}
	if(ftp_put($conn_id, $dir_dest.$file_backup, $dir_source.$file_backup, FTP_ASCII)) {
		echo 'File uploaded successfully!';
	}
} else {
	echo 'Connection is not successful!';
}
// Close ftp_connect
@ftp_close($conn_id);
?>
