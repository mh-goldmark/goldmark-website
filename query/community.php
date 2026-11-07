<?php
// Prepare the community
$sql_community = "SELECT tbl_communities.community_id, ";
$sql_community.= "tbl_communities.title, ";
$sql_community.= "tbl_communities.headline, ";
$sql_community.= "tbl_communities.location, ";
$sql_community.= "tbl_communities.developer, ";
$sql_community.= "tbl_communities.description, ";
$sql_community.= "tbl_communities.amenities, ";
$sql_community.= "tbl_communities.coordinates, ";
$sql_community.= "tbl_communities.image, ";
$sql_community.= "tbl_communities.short_url, ";
$sql_community.= "tbl_communities.tags, ";
$sql_community.= "tbl_communities.image ";
$sql_community.= "FROM tbl_communities ";
$sql_community.= "WHERE tbl_communities.published = true ";
$sql_community.= "AND tbl_communities.deleted = false ";
$sql_community.= "AND tbl_communities.community_id = '".$_GET['id']."' ";
$sql_community.= "AND tbl_communities.image != '' ";
$sql_community.= "LIMIT 1";

$result_community = $conn->query($sql_community);
$row_community = $result_community->fetch_assoc();

$sql_images_defaults = "SELECT image_name, ";
$sql_images_defaults.= "caption, ";
$sql_images_defaults.= "watermark ";
$sql_images_defaults.= "FROM tbl_communities_images ";
$sql_images_defaults.= "WHERE reference = '".$row_community['community_id']."' ";
$sql_images_defaults.= "ORDER by image_order ASC ";
$sql_images_defaults.= "LIMIT 0,3";

$result_images_defaults = $conn->query($sql_images_defaults);

$images_array_defaults    = array();
$caption_array_defaults   = array();
$watermark_array_defaults = array();

while($row_images_defaults = $result_images_defaults->fetch_assoc()) {
  $images_array_defaults[]    = $row_images_defaults['image_name'];
  $caption_array_defaults[]   = decodeData($row_images_defaults['caption']);
  $watermark_array_defaults[] = $row_images_defaults['watermark'];
}

$sql_images = "SELECT image_name, ";
$sql_images.= "caption, ";
$sql_images.= "watermark ";
$sql_images.= "FROM tbl_communities_images ";
$sql_images.= "WHERE reference = '".$row_community['community_id']."' ";
$sql_images.= "ORDER by image_order ASC ";
$sql_images.= "LIMIT 3,50";

$result_images = $conn->query($sql_images);

$count_images = $conn->query("SELECT COUNT(reference) AS counted FROM tbl_communities_images WHERE reference = '".$row_community['community_id']."'");
$row_images_counted = $count_images->fetch_assoc();

// Prepare community features
$sql_community_features = "SELECT details, ";
$sql_community_features.= "description ";
$sql_community_features.= "FROM tbl_communities_features ";
$sql_community_features.= "WHERE reference = '".$row_community['community_id']."' ";
$sql_community_features.= "ORDER by id ASC";

$result_community_features = $conn->query($sql_community_features);
?>
