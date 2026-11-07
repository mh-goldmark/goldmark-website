<?php
// Order images if unorder
// $k = 1;
// $order_images = $conn->query("SELECT id FROM tbl_projects_images WHERE reference = '".$_GET['id']."' ORDER by image_order ASC");
// while($row_images_order = $order_images->fetch_assoc()) {
//   $v = $k++;
//   $conn->query("UPDATE tbl_projects_images SET image_order = '".$v."' WHERE reference = '".$_GET['id']."' AND id = '".$row_images_order['id']."' AND image_order != '".$v."'");
// }
// Prepare the projects
$sql_project = "SELECT tbl_projects.project_id, ";
$sql_project.= "tbl_projects.title, ";
$sql_project.= "tbl_projects.headline, ";
$sql_project.= "tbl_projects.location, ";
$sql_project.= "tbl_projects.sub_location, ";
$sql_project.= "tbl_projects.project, ";
$sql_project.= "tbl_projects.developer, ";
$sql_project.= "tbl_projects.permitted_use, ";
$sql_project.= "tbl_projects.category, ";
$sql_project.= "tbl_projects.project_type, ";
$sql_project.= "tbl_projects.sub_type, ";
$sql_project.= "tbl_projects.number_of_floors, ";
$sql_project.= "tbl_projects.price, ";
$sql_project.= "tbl_projects.permit_number, ";
$sql_project.= "tbl_projects.qrcode_permit, ";
$sql_project.= "tbl_projects.description, ";
$sql_project.= "tbl_projects.features, ";
$sql_project.= "tbl_projects.amenities, ";
$sql_project.= "tbl_projects.coordinates, ";
$sql_project.= "tbl_projects.completion, ";
$sql_project.= "tbl_projects.project_no, ";
$sql_project.= "tbl_projects.brochure, ";
$sql_project.= "tbl_projects.video_url, ";
$sql_project.= "tbl_projects.project_url, ";
$sql_project.= "tbl_projects.chk_url, ";
$sql_project.= "tbl_projects.short_url, ";
$sql_project.= "tbl_projects.tags, ";
$sql_project.= "tbl_projects.image, ";
$sql_project.= "tbl_projects_images.image_name ";
$sql_project.= "FROM tbl_projects ";
$sql_project.= "LEFT JOIN tbl_projects_images ";
$sql_project.= "ON tbl_projects.project_id = tbl_projects_images.reference ";
$sql_project.= "WHERE tbl_projects.published = true ";
//$sql_project.= "AND tbl_projects.permit_number != '' ";
//$sql_project.= "AND tbl_projects.permit_expiry >= '".date('Y-m-d')."' ";
$sql_project.= "AND tbl_projects.deleted = false ";
$sql_project.= "AND tbl_projects.project_id = '".$_GET['id']."' ";
//$sql_project.= "AND tbl_projects.image != '' ";
$sql_project.= "AND tbl_projects_images.image_order = 1 ";
$sql_project.= "LIMIT 1";

$result_project = $conn->query($sql_project);
$row_project = $result_project->fetch_assoc();

$sql_images_defaults = "SELECT image_name, ";
$sql_images_defaults.= "caption, ";
$sql_images_defaults.= "watermark ";
$sql_images_defaults.= "FROM tbl_projects_images ";
$sql_images_defaults.= "WHERE reference = '".$row_project['project_id']."' ";
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
$sql_images.= "FROM tbl_projects_images ";
$sql_images.= "WHERE reference = '".$row_project['project_id']."' ";
$sql_images.= "ORDER by image_order ASC ";
$sql_images.= "LIMIT 3,20";

$result_images = $conn->query($sql_images);

$count_images = $conn->query("SELECT COUNT(reference) AS counted FROM tbl_projects_images WHERE reference = '".$row_project['project_id']."'");
$row_images_counted = $count_images->fetch_assoc();

// Prepare floor plans
$sql_projects_layouts = "SELECT floor_type, ";
$sql_projects_layouts.= "floor_plans ";
$sql_projects_layouts.= "FROM tbl_projects_layouts ";
$sql_projects_layouts.= "WHERE reference = '".$row_project['project_id']."' ";
$sql_projects_layouts.= "ORDER by id ASC";

$result_projects_layouts = $conn->query($sql_projects_layouts);

// Prepare payment plans
$sql_payment_plans = "SELECT details, ";
$sql_payment_plans.= "percentage, ";
$sql_payment_plans.= "amount ";
$sql_payment_plans.= "FROM tbl_payment_plans ";
$sql_payment_plans.= "WHERE reference = '".$row_project['project_id']."' ";
$sql_payment_plans.= "ORDER by id ASC";

$result_payment_plans = $conn->query($sql_payment_plans);

// Prepare available units
$sql_projects_units = "SELECT unit, ";
$sql_projects_units.= "number_of_units, ";
$sql_projects_units.= "unit_size, ";
$sql_projects_units.= "price ";
$sql_projects_units.= "FROM tbl_projects_units ";
$sql_projects_units.= "WHERE reference = '".$row_project['project_id']."' ";
$sql_projects_units.= "ORDER by id ASC";

$result_projects_units = $conn->query($sql_projects_units);

// Count availability
$sql_availability = "SELECT COUNT(unit_no) as availability ";
$sql_availability.= "FROM tbl_projects_availability ";
$sql_availability.= "WHERE project_id = '".$row_project['project_id']."' ";

$result_availability = $conn->query($sql_availability);
$row_availability = $result_availability->fetch_assoc();
?>
