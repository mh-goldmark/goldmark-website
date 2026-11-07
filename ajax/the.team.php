<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("../includes/constants.php");	// Page constants
require_once(absolutedir."config/connect.php");					// Connect to the database and table
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");

//Prepare the team
$sql_our_team = "SELECT user_id, ";
$sql_our_team.= "user_name, ";
$sql_our_team.= "full_name, ";
$sql_our_team.= "email, ";
$sql_our_team.= "mobile, ";
$sql_our_team.= "designation, ";
$sql_our_team.= "department, ";
$sql_our_team.= "nationality, ";
$sql_our_team.= "rera_number, ";
$sql_our_team.= "user_photo, ";
$sql_our_team.= "other_photo, ";
$sql_our_team.= "website ";
$sql_our_team.= "FROM tbl_members ";
$sql_our_team.= "WHERE user_status = true ";
$sql_our_team.= "AND publish = true ";
//$sql_our_team.= "AND blocked = false ";
if($_POST['team'] == 'Managers') {
  $sql_our_team.= "AND ((user_role = 'Agent' ";
  $sql_our_team.= "AND priviledge = 'Manager') ";
  $sql_our_team.= "OR user_name = 'Wissam') ";
  $sql_our_team.= "AND user_name != 'Keith' ";
  $sql_our_team.= "AND user_name != 'Saleem' ";
  $sql_our_team.= "ORDER by (user_name = 'Wissam') DESC, (chk_general = true) DESC, (department = 'Sales') DESC, (department = 'Leasing') DESC, (department = 'Off Plan') DESC";
} elseif($_POST['team'] == 'Leasing') {
  $sql_our_team.= "AND user_role = 'Agent' ";
  $sql_our_team.= "AND priviledge != 'Manager' ";
  $sql_our_team.= "AND department = 'Leasing' ";
  $sql_our_team.= "ORDER by (designation = 'Associate Director') DESC, (designation = 'Senior Client Manager') DESC, (designation = 'Client Manager') DESC, (nationality = 'United Kingdom') DESC, (nationality = 'Ireland') DESC";
} elseif($_POST['team'] == 'Sales') {
  $sql_our_team.= "AND ((user_role = 'Agent' ";
  $sql_our_team.= "AND priviledge != 'Manager' ";
  $sql_our_team.= "AND (department = 'Sales' ";
  $sql_our_team.= "OR department = 'Off Plan')) ";
  $sql_our_team.= "OR user_name = 'Keith' ";
  $sql_our_team.= "OR user_name = 'Saleem') ";
  $sql_our_team.= "ORDER by (designation = 'Associate Director') DESC, (designation = 'Senior Client Manager') DESC, (designation = 'Client Manager') DESC, (nationality = 'United Kingdom') DESC, (nationality = 'Ireland') DESC";
} elseif($_POST['team'] == 'Marketing') {
  // $sql_our_team.= "AND (department = 'Marketing' ";
  // $sql_our_team.= "OR user_name = 'Khmer') ";
  $sql_our_team.= "AND department = 'Marketing' ";
  $sql_our_team.= "ORDER by (priviledge = 'Manager') DESC";
} elseif($_POST['team'] == 'HR') {
  $sql_our_team.= "AND department = 'Human Resource' ";
  $sql_our_team.= "ORDER by (priviledge = 'Manager') DESC";
} elseif($_POST['team'] == 'Administration') {
  $sql_our_team.= "AND (department = 'Administration' ";
  $sql_our_team.= "OR department = 'Accounting' ";
  $sql_our_team.= "OR department = 'Office Support' ";
  $sql_our_team.= "OR designation LIKE 'Telesales%') ";
  $sql_our_team.= "ORDER by (priviledge = 'Manager') DESC, (department = 'Accounting') DESC, (department = 'Administration') DESC, (department = 'Office Support') DESC";
}

$result_our_team = $conn->query($sql_our_team);
?>
<?php while($row_our_team = $result_our_team->fetch_assoc()) { ?>
  <div class="col-md-3 col-sm-4 col-6 feature-style2 mb30 wow fadeInUp" data-wow-delay="400ms">
    <div class="the-team-grid">
    <a href="the-expert/<?php echo cleanString($row_our_team['designation']); ?>/<?php echo cleanString($row_our_team['full_name']); ?>-<?php echo $row_our_team['user_id']; ?>.html" class="feature-img" title="<?php echo decodeData($row_our_team['full_name']); ?>">
      <?php if(!empty($row_our_team['other_photo'])) { ?>
      <img src="<?php echo localhost.'images/users/website/'.$row_our_team['other_photo']; ?>" alt="<?php echo decodeData($row_our_team['full_name']); ?>"/>
      <?php } else { ?>
      <img src="images/gold-mark-user.jpg" alt="<?php echo decodeData($row_our_team['full_name']); ?>"/>
      <?php } ?>
    </a>
    <div class="feature-content pt15 pr10 pl10 pb15">
      <a href="the-expert/<?php echo cleanString($row_our_team['designation']); ?>/<?php echo cleanString($row_our_team['full_name']); ?>-<?php echo $row_our_team['user_id']; ?>.html" class="title mb5" title="<?php echo decodeData($row_our_team['full_name']); ?>">
        <?php echo decodeData($row_our_team['full_name']); ?>
      </a>
      <p class="text mb0">
        <?php echo decodeData($row_our_team['designation']); ?>
      </p>
    </div>
    <div class="row justify-content-center align-items-center contact-buttons pt0 pb10">
      <a href="tel:<?php echo str_replace($string_replace_mobile,"",$row_our_team['mobile']); ?>" title="Call Now">
        <span class="flaticon-call"></span>
      </a>
      <a class="email-agent" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Website" data-subsource="Email Lead" data-user="<?php echo decodeData($row_our_team['user_id']); ?>" data-refno="" data-agent="<?php echo decodeData($row_our_team['full_name']); ?>" data-title="" title="Send Email">
        <span class="flaticon-email"></span>
      </a>
      <a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$company_mobile); ?>&text=Hello <?php echo decodeData($row_our_team['user_name']); ?>, I would like to learn more about your real estate listings, services, and investment opportunities. I look forward to your response. Thank you!" title="Send Whatsapp" target="Whatsapp">
        <span class="flaticon-whatsapp"></span>
      </a>
    </div>
    </div>
  </div>
<?php } ?>
<?php
// Close database connection
$conn->close();
?>
