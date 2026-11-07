<?php
// Prepare similar listings
$sql_similar_listings = "SELECT tbl_listings_portals.listing_id, ";
$sql_similar_listings.= "tbl_listings_portals.refno, ";
$sql_similar_listings.= "tbl_listings_portals.user_id, ";
$sql_similar_listings.= "tbl_listings_portals.title, ";
$sql_similar_listings.= "tbl_listings_portals.page_title, ";
$sql_similar_listings.= "tbl_listings_portals.location, ";
$sql_similar_listings.= "tbl_listings_portals.sub_location, ";
$sql_similar_listings.= "tbl_listings_portals.property, ";
$sql_similar_listings.= "tbl_listings_portals.category, ";
$sql_similar_listings.= "tbl_listings_portals.listing_type, ";
$sql_similar_listings.= "tbl_listings_portals.property_type, ";
$sql_similar_listings.= "tbl_listings_portals.bedrooms, ";
$sql_similar_listings.= "tbl_listings_portals.bathrooms, ";
$sql_similar_listings.= "tbl_listings_portals.parking, ";
$sql_similar_listings.= "tbl_listings_portals.list_price, ";
$sql_similar_listings.= "tbl_listings_portals.price_on_request, ";
$sql_similar_listings.= "tbl_listings_portals.rental_type, ";
$sql_similar_listings.= "tbl_listings_portals.unit_size, ";
$sql_similar_listings.= "tbl_listings_portals.size_measurement, ";
$sql_similar_listings.= "tbl_listings_portals.plot_size, ";
$sql_similar_listings.= "tbl_listings_portals.plot_measurement, ";
$sql_similar_listings.= "tbl_listings_portals.permit_number, ";
$sql_similar_listings.= "tbl_listings_portals.images, ";
$sql_similar_listings.= "tbl_listings_portals.verified, ";
$sql_similar_listings.= "tbl_listings_portals.short_url, ";
$sql_similar_listings.= "tbl_listings_portals.chk_reapit, ";
$sql_similar_listings.= "tbl_members.full_name, ";
$sql_similar_listings.= "tbl_members.user_name, ";
$sql_similar_listings.= "tbl_members.email, ";
$sql_similar_listings.= "tbl_members.mobile, ";
$sql_similar_listings.= "tbl_members.designation, ";
$sql_similar_listings.= "tbl_members.user_photo ";
$sql_similar_listings.= "FROM tbl_listings_portals ";
$sql_similar_listings.= "LEFT JOIN tbl_members ";
$sql_similar_listings.= "ON tbl_listings_portals.user_id = tbl_members.user_id ";
$sql_similar_listings.= "WHERE tbl_listings_portals.listing_status = 'Available' ";
$sql_similar_listings.= "AND tbl_listings_portals.permit_number != '' ";
$sql_similar_listings.= "AND tbl_listings_portals.permit_expiry >= '".date('Y-m-d')."' ";
$sql_similar_listings.= "AND tbl_listings_portals.deleted = false ";
$sql_similar_listings.= "AND tbl_listings_portals.published = true ";
//$sql_similar_listings.= "AND tbl_listings_portals.chk_reapit = true ";
$sql_similar_listings.= "AND tbl_members.user_status = true ";
$sql_similar_listings.= "AND tbl_members.blocked = false ";
$sql_similar_listings.= "AND tbl_listings_portals.images != '' ";
if(!empty($row_listing['listing_id'])) {
  $sql_similar_listings.= "AND tbl_listings_portals.category LIKE '%".$row_listing['category']."%' ";
  $sql_similar_listings.= "AND tbl_listings_portals.property_type LIKE '%".$row_listing['property_type']."%' ";
  $sql_similar_listings.= "AND tbl_listings_portals.listing_type LIKE '%".$row_listing['listing_type']."%' ";
  $sql_similar_listings.= "AND tbl_listings_portals.bedrooms LIKE '%".$row_listing['bedrooms']."%' ";
  $sql_similar_listings.= "AND tbl_listings_portals.listing_id != '".$row_listing['listing_id']."' ";
}
$sql_similar_listings.= "ORDER by RAND() ";
$sql_similar_listings.= "LIMIT 9";

$result_similar_listings = $conn->query($sql_similar_listings);
?>
