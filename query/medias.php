<?php
// Prepare the media images
$sql_media_images = "SELECT title, ";
$sql_media_images.= "image, ";
$sql_media_images.= "url, ";
$sql_media_images.= "inserted_date ";
$sql_media_images.= "FROM tbl_media ";
$sql_media_images.= "WHERE status = true ";
$sql_media_images.= "AND section = 'Image' ";
$sql_media_images.= "ORDER by inserted_date DESC ";

$result_media_images = $conn->query($sql_media_images);
?>
