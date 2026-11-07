<?php
// Prepare the video medias
$sql_media_videos = "SELECT title, ";
$sql_media_videos.= "image, ";
$sql_media_videos.= "url, ";
$sql_media_videos.= "inserted_date ";
$sql_media_videos.= "FROM tbl_media ";
$sql_media_videos.= "WHERE status = true ";
$sql_media_videos.= "AND section = 'Video' ";
$sql_media_videos.= "ORDER by inserted_date DESC ";

$result_media_videos = $conn->query($sql_media_videos);
?>
