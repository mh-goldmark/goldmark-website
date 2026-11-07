<?php
/********************************************************
Copyright © 2023 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("../includes/constants.php");				// Page constants
require_once(absolutedir."config/connect.php");					// Connect to the database and table
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");

// Prepare property types
$sql_property_types = "SELECT property_type ";
$sql_property_types.= "FROM tbl_listings_portals ";
$sql_property_types.= "WHERE listing_status = 'Available' ";
if($_POST['category'] == 'Off-Plan') {
  $sql_property_types.= "AND building_status = 'Off-Plan' ";
} else {
  $sql_property_types.= "AND category LIKE '%".encodeData($_POST['category'])."%' ";
  $sql_property_types.= "AND building_status != 'Off-Plan' ";
}
$sql_property_types.= "AND permit_number != '' ";
$sql_property_types.= "AND permit_expiry >= '".date('Y-m-d')."' ";
$sql_property_types.= "AND deleted = false ";
$sql_property_types.= "AND published = true ";
$sql_property_types.= "AND images != '' ";
$sql_property_types.= "GROUP by property_type ";
$sql_property_types.= "ORDER by property_type ASC";

$result_property_types = $conn->query($sql_property_types);
?>
<div class="form-style2 input-group">
  <select name="type" class="selectpicker proptype" data-live-search="true" data-width="100%">
    <option value="" selected>All Types</option>
    <?php while($row_property_types = $result_property_types->fetch_assoc()) { ?>
    <option value="<?php echo decodeData($row_property_types['property_type']); ?>" data-tokens="<?php echo decodeData($row_property_types['property_type']); ?>"><?php echo decodeData($row_property_types['property_type']); ?></option>
    <?php } ?>
  </select>
</div>
<?php
// Close database connection
$conn->close();
?>
