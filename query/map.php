<?php
// Prepare the listings
$sql_listings = "SELECT tbl_listings_portals.listing_id, ";
$sql_listings.= "tbl_listings_portals.refno, ";
$sql_listings.= "tbl_listings_portals.user_id, ";
$sql_listings.= "tbl_listings_portals.title, ";
$sql_listings.= "tbl_listings_portals.page_title, ";
$sql_listings.= "tbl_listings_portals.description, ";
$sql_listings.= "tbl_listings_portals.location, ";
$sql_listings.= "tbl_listings_portals.sub_location, ";
$sql_listings.= "tbl_listings_portals.property, ";
$sql_listings.= "tbl_listings_portals.category, ";
$sql_listings.= "tbl_listings_portals.listing_type, ";
$sql_listings.= "tbl_listings_portals.property_type, ";
$sql_listings.= "tbl_listings_portals.bedrooms, ";
$sql_listings.= "tbl_listings_portals.bathrooms, ";
$sql_listings.= "tbl_listings_portals.parking, ";
$sql_listings.= "tbl_listings_portals.list_price, ";
$sql_listings.= "tbl_listings_portals.price_on_request, ";
$sql_listings.= "tbl_listings_portals.rental_type, ";
$sql_listings.= "tbl_listings_portals.unit_size, ";
$sql_listings.= "tbl_listings_portals.plot_size, ";
$sql_listings.= "tbl_listings_portals.size_measurement, ";
$sql_listings.= "tbl_listings_portals.plot_measurement, ";
$sql_listings.= "tbl_listings_portals.permit_number, ";
$sql_listings.= "tbl_listings_portals.images, ";
$sql_listings.= "tbl_listings_portals.verified, ";
$sql_listings.= "tbl_listings_portals.short_url, ";
$sql_listings.= "tbl_listings_portals.chk_reapit, ";
$sql_listings.= "tbl_listings_portals.coordinates, ";
$sql_listings.= "tbl_listings_portals.featured, ";
$sql_listings.= "tbl_members.full_name, ";
$sql_listings.= "tbl_members.user_name, ";
$sql_listings.= "tbl_members.email, ";
$sql_listings.= "tbl_members.designation, ";
$sql_listings.= "tbl_members.mobile, ";
$sql_listings.= "tbl_members.rera_number, ";
$sql_listings.= "tbl_members.user_photo ";
$sql_listings.= "FROM tbl_listings_portals ";
$sql_listings.= "LEFT JOIN tbl_members ";
$sql_listings.= "ON tbl_listings_portals.user_id = tbl_members.user_id ";
$sql_listings.= "WHERE tbl_listings_portals.listing_status = 'Available' ";
$sql_listings.= "AND tbl_listings_portals.permit_number != '' ";
$sql_listings.= "AND tbl_listings_portals.permit_expiry >= '".date('Y-m-d')."' ";
$sql_listings.= "AND tbl_listings_portals.deleted = false ";
$sql_listings.= "AND tbl_listings_portals.published = true ";
if(!empty($_GET['location'])) {
	$sql_listings.= "AND (tbl_listings_portals.location LIKE '%".$_GET['location']."%' ";
	$sql_listings.= "OR tbl_listings_portals.sub_location LIKE '%".$_GET['location']."%' ";
	$sql_listings.= "OR tbl_listings_portals.property LIKE '%".$_GET['location']."%') ";
}
if(!empty($_GET['category']) && $_GET['category'] != 'Off Plan') {
	$sql_listings.= "AND tbl_listings_portals.category = '".$_GET['category']."' ";
}
if($_GET['category'] == 'Residential') {
	if($_GET['minbed'] == '7+' || $_GET['maxbed'] == '7+') {
		$sql_listings.= "AND tbl_listings_portals.bedrooms >= 7 ";
	} else {
		if($_GET['minbed'] != '' && $_GET['maxbed'] != '' && $_GET['minbed'] == $_GET['maxbed']) {
			$sql_listings.= "AND tbl_listings_portals.bedrooms = '".$_GET['minbed']."' ";
		} else {
			if($_GET['minbed'] != '') {
				$sql_listings.= "AND tbl_listings_portals.bedrooms >= '".$_GET['minbed']."' ";
			} elseif($_GET['maxbed'] != '') {
				$sql_listings.= "AND tbl_listings_portals.bedrooms <= '".$_GET['maxbed']."' ";
			}
		}
	}
	if($_GET['minsize'] != '') {
		$sql_listings.= "AND tbl_listings_portals.unit_size >= '".str_replace(",","",$_GET['minsize'])."' ";
	} elseif($_GET['maxsize'] != '') {
		$sql_listings.= "AND tbl_listings_portals.unit_size <= '".str_replace(",","",$_GET['maxsize'])."' ";
	}
	$sql_listings.= "AND tbl_listings_portals.building_status = 'Completed' ";
} elseif($_GET['category'] == 'Commercial') {
	if($_GET['minsize'] != '' && $_GET['maxsize'] != '' && $_GET['minsize'] == $_GET['maxsize']) {
		$sql_listings.= "AND tbl_listings_portals.unit_size >= '".$_GET['minsize']."' ";
	} else {
		if($_GET['minsize'] != '') {
			$sql_listings.= "AND tbl_listings_portals.unit_size >= '".$_GET['minsize']."' ";
		} elseif($_GET['maxsize'] != '') {
			$sql_listings.= "AND tbl_listings_portals.unit_size <= '".$_GET['maxsize']."' ";
		}
	}
	$sql_listings.= "AND tbl_listings_portals.building_status = 'Completed' ";
} elseif($_GET['category'] == 'Off Plan') {
	$sql_listings.= "AND tbl_listings_portals.building_status = 'Off Plan' ";
}
if($_GET['minprice'] != '') {
	$sql_listings.= "AND tbl_listings_portals.list_price >= '".str_replace(",","",$_GET['minprice'])."' ";
} elseif($_GET['maxprice'] != '') {
	$sql_listings.= "AND tbl_listings_portals.list_price <= '".str_replace(",","",$_GET['maxprice'])."' ";
}
if(!empty($_GET['class']) && $_GET['class'] != 'All') {
	$sql_listings.= "AND tbl_listings_portals.listing_type = '".$_GET['class']."' ";
}
if(!empty($_GET['type'])) {
	$sql_listings.= "AND tbl_listings_portals.property_type = '".$_GET['type']."' ";
}
$sql_listings.= "AND tbl_members.user_status = true ";
$sql_listings.= "AND tbl_members.blocked = false ";
$sql_listings.= "AND tbl_listings_portals.images != '' ";
$sql_listings.= "GROUP by tbl_listings_portals.coordinates ";

if(empty($_GET['sort']) || $_GET['sort'] == 'default') {
	$sql_listings.= "ORDER by (tbl_listings_portals.verified = true) DESC, (tbl_listings_portals.sw_premium = true) DESC, (tbl_listings_portals.featured = true) DESC, tbl_listings_portals.inserted_date DESC ";
} elseif($_GET['sort'] == 'verified') {
	$sql_listings.= "ORDER by tbl_listings_portals.verified DESC, tbl_listings_portals.inserted_date DESC ";
} elseif($_GET['sort'] == 'premium') {
	$sql_listings.= "ORDER by tbl_listings_portals.sw_premium DESC, tbl_listings_portals.inserted_date DESC ";
} elseif($_GET['sort'] == 'featured') {
	$sql_listings.= "ORDER by tbl_listings_portals.featured DESC, tbl_listings_portals.inserted_date DESC ";
} elseif($_GET['sort'] == 'hprice') {
	$sql_listings.= "ORDER by tbl_listings_portals.list_price DESC ";
} elseif($_GET['sort'] == 'lprice') {
	$sql_listings.= "ORDER by tbl_listings_portals.list_price ASC ";
} elseif($_GET['sort'] == 'hsize') {
	$sql_listings.= "ORDER by tbl_listings_portals.unit_size DESC ";
} elseif($_GET['sort'] == 'lsize') {
	$sql_listings.= "ORDER by tbl_listings_portals.unit_size ASC ";
} elseif($_GET['sort'] == 'lbed') {
	$sql_listings.= "ORDER by tbl_listings_portals.bedrooms ASC ";
} elseif($_GET['sort'] == 'mbed') {
	$sql_listings.= "ORDER by tbl_listings_portals.bedrooms DESC ";
}

$result_listings = $conn->query($sql_listings);
$result_listings_center = $conn->query($sql_listings);

$array_coordinates = array();
while($row_listings_center = $result_listings_center->fetch_assoc()) {
	$array_coordinates[] = $row_listings_center['coordinates'];
}
if($result_listings_center->num_rows >= 1) {
	$geocoordinates = explode(",",$array_coordinates[0]);
	$geolatitude  = $geocoordinates[0];
	$geolongitude = $geocoordinates[1];
} else {
	$geolatitude  = '25.276987';
	$geolongitude = '55.296249';
}
?>
