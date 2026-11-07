<?php
// Prepare videos
$sql_videos = "SELECT video, ";
$sql_videos.= "title, ";
$sql_videos.= "sub_title ";
$sql_videos.= "FROM tbl_videos ";
$sql_videos.= "WHERE section = '".$current_page."' ";
$sql_videos.= "AND status = true ";
$sql_videos.= "ORDER by sort_order ASC ";
$sql_videos.= "LIMIT 1";

$result_videos = $conn->query($sql_videos);
$row_videos = $result_videos->fetch_assoc();
?>
