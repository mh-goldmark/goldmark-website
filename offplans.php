<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
require_once(absolutedir."query/projects.php");
?>

<?php if($result_projects->num_rows >= 1) { ?>
<?php while($row_projects = $result_projects->fetch_assoc()) {

  // $sql_project_image = $conn->query("SELECT COUNT(image_name) as images FROM tbl_projects_images WHERE reference = '".$row_projects['project_id']."'");
  // $count_project_images = $row_project_image['images'];

  $sql_project_image = $conn->query("SELECT image_name FROM tbl_projects_images WHERE reference = '".$row_projects['project_id']."' ORDER by image_order ASC LIMIT 1");
  $row_project_image = $sql_project_image->fetch_assoc();

  $page_title = $row_projects['title'];

  if(!empty($row_projects['project'])) {
    $project_url = "new-developments/".cleanString($row_projects['location'])."/".cleanString($row_projects['project'])."/".cleanString($page_title)."-".$row_projects['project_id'].".html";
    $project_caption = decodeData($row_projects['project']);
  } elseif(!empty($row_listings['sub_location'])) {
    $project_url = "new-developments/".cleanString($row_projects['location'])."/".cleanString($row_projects['sub_location'])."/".cleanString($page_title)."-".$row_projects['project_id'].".html";
    $project_caption = decodeData($row_project['sub_location']);
  } else {
    $project_url = "new-developments/".cleanString($row_projects['location'])."/".cleanString($page_title)."-".$row_projects['project_id'].".html";
    $project_caption = decodeData($row_projects['location']);
  }

  $project_description = explode("\n", $row_projects['description']);
  ?>
  <div class="row listing-style1 off-plans listing-type items-listings">
    <div class="col-12 col-md-5 list-thumb flex-shrink-0">
      <a href="<?php echo $project_url; ?>" title="<?php echo decodeData($page_title); ?>" class="listing-image-item" style="background-image: url('<?php if(!empty($row_projects['image'])) { echo localhost.'images/developments/thumbnails/'.$row_projects['project_id'].'/'.$row_projects['image']; } else { echo localhost.'images/developments/'.$row_projects['project_id'].'/'.$row_project_image['image_name']; } ?>')">
      </a>
      <!--
      <div class="image-counter">
        <span class="flaticon-images"></span>
        <?php //echo $count_project_images; ?>
        Photos
      </div>
      !-->
    </div>
    <div class="col-12 col-md-7 list-content flex-shrink-1">
      <h2 class="list-title">
        <a href="<?php echo $project_url; ?>" title="<?php echo decodeData($page_title); ?>">
          <?php
          if(!empty($row_projects['project'])) {
            echo decodeData($row_projects['project']);
          } elseif(!empty($row_projects['sub_location'])) {
            echo decodeData($row_projects['sub_location']);
          } else {
            echo decodeData($row_projects['location']);
          }
          ?>
        </a>
      </h2>
      <h3 class="list-text">
        <span class="icon flaticon-maps-1"></span>
        <?php
        if(!empty($row_projects['location'])) {
          echo decodeData($row_projects['location']).', '.decodeData($row_projects['city']);
        } else {
          echo decodeData($row_projects['city']).', UAE';
        }
        ?>
      </h3>
      <div class="middle-content row mt20 mb20">
        <div class="col-md-6 col-12">
          <div class="developer">
            <div class="mid-label">
              <span class="flaticon-corporation"></span>
              Developer
            </div>
            <h4 class="mid-text">
              <?php echo decodeData($row_projects['developer']); ?>
            </h4>
          </div>
        </div>
        <div class="col-md-6 col-12 mt20-md">
          <div class="completion">
            <div class="mid-label">
              <span class="flaticon-clock"></span>
              Completion
            </div>
            <h4 class="mid-text">
              <?php if($row_projects['completion'] != '0000-00-00') { ?>
                Q<?php echo date_quarter($row_projects['completion']); ?>, <?php echo date("Y", strtotime($row_projects['completion'])); ?>
              <?php } else { ?>
                -
              <?php } ?>
            </h4>
          </div>
        </div>
        <div class="col-12 mt20">
          <div class="dev-type">
            <div class="mid-label">
              <span class="flaticon-expand"></span>
              Development Type
            </div>
            <h4 class="mid-text">
              <?php echo decodeData($row_projects['sub_type']); ?>
            </h4>
          </div>
        </div>
      </div>
      <p class="list-text2 line-wrapper two-lines">
        <?php echo decodeData($project_description[0]); ?>
      </p>
      <div class="list-meta2 mt30 d-md-flex justify-content-between align-items-end">
        <div class="col-md-8 col-12 agent-contacts mt30-sm d-flex justify-content-center align-items-center">
          <a href="tel:<?php echo str_replace($string_replace_mobile,"",$company_phone); ?>" title="Call Me">
            <span class="flaticon-call"></span>
            Call
          </a>
          <a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$company_mobile); ?>&text=Hello Gold Mark, I found this project <?php echo decodeData($row_projects['title']); ?> on Gold Mark Real Estate website and I'm interested in learning more. Please contact me at your earliest convenience. Thank you!" title="Whatsapp Me" target="_blank">
            <span class="flaticon-whatsapp"></span>
            Whatsapp
          </a>
          <a class="email-agent" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Off-Plan" data-subsource="Email Lead" data-user="104" data-refno="" data-agent="<?php echo decodeData($company_name); ?>" data-title="<?php echo decodeData($page_title); ?>" title="Send Email">
            <span class="flaticon-email"></span>
            Email
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php unset($project_url,$page_title,$project_description); ?>
  <?php } ?>
<?php } else { ?>
  <div class="row no_result text-center">
    <p><?php echo $search_result_text; ?></p>
  </div>
<?php } ?>

<div class="clearfix"></div>

<?php if($page != $chk_count) { ?>
<div class="infinite-paging">
  <a class="jscroll-next button" href="offplans.php?page=<?php echo ($page + 1); ?><?php echo $param; ?>">
    <span class="flaticon-new-tab"></span>
    Load More
  </a>
</div>
<?php } ?>
<?php $conn->close(); ?>
