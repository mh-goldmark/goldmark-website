<?php
/********************************************************
Copyright © 2025 Engr. Dom Sahagun. All rights reserved.
********************************************************/
$temp_folders = scandir('/home/u647025890/domains/goldmark.ae/public_html/temp/images/');
foreach($temp_folders as $temp_folder) {
	if($temp_folder != '.' && $temp_folder != '..') {
		$folder_created = date("F d Y H:i:s", filectime('/home/u647025890/domains/goldmark.ae/public_html/temp/images/'.$temp_folder));
		if(strtotime($folder_created) <= strtotime("-1 hour")) {
			system('/bin/rm -rf '.escapeshellarg('/home/u647025890/domains/goldmark.ae/public_html/temp/images/'.$temp_folder.'/'));
		}
		unset($folder_created);
	}
}
?>
