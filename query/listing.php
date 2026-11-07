<?php
// Prepare the listings
$sql_listing = "SELECT tbl_listings_portals.listing_id, ";
$sql_listing.= "tbl_listings_portals.refno, ";
$sql_listing.= "tbl_listings_portals.user_id, ";
$sql_listing.= "tbl_listings_portals.title, ";
$sql_listing.= "tbl_listings_portals.page_title, ";
$sql_listing.= "tbl_listings_portals.location, ";
$sql_listing.= "tbl_listings_portals.sub_location, ";
$sql_listing.= "tbl_listings_portals.property, ";
$sql_listing.= "tbl_listings_portals.category, ";
$sql_listing.= "tbl_listings_portals.listing_type, ";
$sql_listing.= "tbl_listings_portals.property_type, ";
$sql_listing.= "tbl_listings_portals.bedrooms, ";
$sql_listing.= "tbl_listings_portals.bathrooms, ";
$sql_listing.= "tbl_listings_portals.parking, ";
$sql_listing.= "tbl_listings_portals.list_price, ";
$sql_listing.= "tbl_listings_portals.price_on_request, ";
$sql_listing.= "tbl_listings_portals.unit_size, ";
$sql_listing.= "tbl_listings_portals.plot_size, ";
$sql_listing.= "tbl_listings_portals.size_measurement, ";
$sql_listing.= "tbl_listings_portals.plot_measurement, ";
$sql_listing.= "tbl_listings_portals.rental_type, ";
$sql_listing.= "tbl_listings_portals.permit_number, ";
$sql_listing.= "tbl_listings_portals.qrcode_permit, ";
$sql_listing.= "tbl_listings_portals.description, ";
$sql_listing.= "tbl_listings_portals.features, ";
$sql_listing.= "tbl_listings_portals.amenities, ";
$sql_listing.= "tbl_listings_portals.exclusive, ";
$sql_listing.= "tbl_listings_portals.price_on_request, ";
$sql_listing.= "tbl_listings_portals.coordinates, ";
$sql_listing.= "tbl_listings_portals.referal, ";
$sql_listing.= "tbl_listings_portals.floor_plans, ";
$sql_listing.= "tbl_listings_portals.youtube_url, ";
$sql_listing.= "tbl_listings_portals.short_url, ";
$sql_listing.= "tbl_listings_portals.tags, ";
$sql_listing.= "tbl_listings_portals.verified, ";
$sql_listing.= "tbl_listings_portals.keywords, ";
$sql_listing.= "tbl_listings_portals.building_status, ";
$sql_listing.= "tbl_images.image_name, ";
$sql_listing.= "tbl_images.watermark, ";
$sql_listing.= "tbl_members.full_name, ";
$sql_listing.= "tbl_members.user_name, ";
$sql_listing.= "tbl_members.email, ";
$sql_listing.= "tbl_members.mobile, ";
$sql_listing.= "tbl_members.designation, ";
$sql_listing.= "tbl_members.rera_number, ";
$sql_listing.= "tbl_members.user_photo, ";
$sql_listing.= "tbl_members.other_photo, ";
$sql_listing.= "tbl_members.details ";
$sql_listing.= "FROM tbl_listings_portals ";
$sql_listing.= "LEFT JOIN tbl_members ";
$sql_listing.= "ON tbl_listings_portals.user_id = tbl_members.user_id ";
$sql_listing.= "LEFT JOIN tbl_images ";
$sql_listing.= "ON tbl_listings_portals.listing_id = tbl_images.reference ";
$sql_listing.= "WHERE tbl_listings_portals.listing_status = 'Available' ";
$sql_listing.= "AND tbl_listings_portals.permit_number != '' ";
$sql_listing.= "AND tbl_listings_portals.permit_expiry >= '".date('Y-m-d')."' ";
$sql_listing.= "AND tbl_listings_portals.deleted = false ";
$sql_listing.= "AND tbl_listings_portals.published = true ";
$sql_listing.= "AND tbl_listings_portals.listing_id = '".$_GET['id']."' ";
$sql_listing.= "AND tbl_images.image_order = 1 ";
$sql_listing.= "LIMIT 1";

$result_listing = $conn->query($sql_listing);
$row_listing = $result_listing->fetch_assoc();

if(!empty($row_listing['floor_plans'])) {
  $floor_plans = explode(",",$row_listing['floor_plans']);
}

$sql_images_defaults = "SELECT image_name, ";
$sql_images_defaults.= "image_caption, ";
$sql_images_defaults.= "watermark ";
$sql_images_defaults.= "FROM tbl_images ";
$sql_images_defaults.= "WHERE reference = '".$row_listing['listing_id']."' ";
$sql_images_defaults.= "AND chk_default = true ";
$sql_images_defaults.= "ORDER by image_order ASC ";
$sql_images_defaults.= "LIMIT 0,3";

$result_images_defaults = $conn->query($sql_images_defaults);

$images_array_defaults    = array();
$caption_array_defaults   = array();
$watermark_array_defaults = array();

while($row_images_defaults = $result_images_defaults->fetch_assoc()) {
  $images_array_defaults[]    = $row_images_defaults['image_name'];
  $caption_array_defaults[]   = decodeData($row_images_defaults['image_caption']);
  $watermark_array_defaults[] = $row_images_defaults['watermark'];
}

$sql_images = "SELECT image_name, ";
$sql_images.= "image_caption, ";
$sql_images.= "watermark ";
$sql_images.= "FROM tbl_images ";
$sql_images.= "WHERE reference = '".$row_listing['listing_id']."' ";
$sql_images.= "AND chk_default = true ";
$sql_images.= "ORDER by image_order ASC ";
$sql_images.= "LIMIT 3,50";

$result_images = $conn->query($sql_images);

$count_images = $conn->query("SELECT COUNT(reference) AS counted FROM tbl_images WHERE reference = '".$row_listing['listing_id']."' AND chk_default = true");
$row_images_counted = $count_images->fetch_assoc();
?>
