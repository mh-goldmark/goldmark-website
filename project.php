<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Project';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/project.php");
require_once(absolutedir."query/areas.php");
if($result_project->num_rows <= 0) {
  header('Location: '.domainhost.'404'); // Redirect to 404
  exit;
}

$page_title = $row_project['title'];

if(!empty($row_project['project'])) {
  $project_name = decodeData($row_project['project']).', '.decodeData($row_project['location']);
  $project_url = "new-developments/".cleanString($row_project['location'])."/".cleanString($row_project['project'])."/".cleanString($page_title)."-".$row_project['project_id'].".html";
  $project_caption = decodeData($row_project['project']);
} else if(!empty($row_project['sub_location'])) {
  $project_name = decodeData($row_project['sub_location']).', '.decodeData($row_project['location']);
  $project_url = "new-developments/".cleanString($row_project['location'])."/".cleanString($row_project['sub_location'])."/".cleanString($page_title)."-".$row_project['project_id'].".html";
  $project_caption = decodeData($row_project['sub_location']);
} else {
  $project_name = decodeData($row_project['location']);
  $project_url = "new-developments/".cleanString($row_project['location'])."/".cleanString($page_title)."-".$row_project['project_id'].".html";
  $project_caption = decodeData($row_project['location']);
}
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <?php
  $meta_description = explode("\n", $row_project['description']);
  ?>
	<meta charset="utf-8"/>
	<meta http-equiv="x-ua-compatible" content="ie=edge"/>
	<link rel="canonical" href="<?php echo domainhost.$project_url; ?>"/>
	<title><?php echo decodeData($page_title); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="robots" content="index, follow"/>
  <?php if(!empty($row_project['tags'])) { ?>
    <meta name="keywords" content="<?php echo strtolower(decodeData($row_project['tags'])); ?>"/>
  <?php } else { ?>
  <?php if($row_project['project_type'] == 'Sale') { ?>
    <meta name="keywords" content="<?php echo strtolower(decodeData($row_project['category'])); ?> for <?php echo strtolower(decodeData($row_project['project_type'])); ?> in <?php echo strtolower(decodeData($row_project['location'])); ?>, <?php if(empty($row_project['project'])) { if(!empty($row_project['sub_location'])) { echo strtolower(decodeData($row_project['category'])).' for '.strtolower(decodeData($row_project['project_type'])).' in '.strtolower(decodeData($row_project['sub_location'])); } else { echo ''; } } else { echo strtolower(decodeData($row_project['category'])).' for '.strtolower(decodeData($row_project['project_type'])).' in '.strtolower(decodeData($row_project['project'])).', '; } ?>apartment for sale in dubai, villas for sale in dubai, office space for sale in dubai"/>
  <?php } else { ?>
    <meta name="keywords" content="<?php echo strtolower(decodeData($row_project['category'])); ?> for <?php echo strtolower(decodeData($row_project['project_type'])); ?> in <?php echo strtolower(decodeData($row_project['location'])); ?>, <?php if(empty($row_project['project'])) { if(!empty($row_project['sub_location'])) { echo strtolower(decodeData($row_project['category'])).' for '.strtolower(decodeData($row_project['project_type'])).' in '.strtolower(decodeData($row_project['sub_location'])); } else { echo ''; } } else { echo strtolower(decodeData($row_project['category'])).' for '.strtolower(decodeData($row_project['project_type'])).' in '.strtolower(decodeData($row_project['project'])).', '; } ?>apartment for rent in dubai, villas for rent in dubai, office space for rent in dubai"/>
  <?php } ?>
  <?php } ?>
	<meta name="title" content="<?php echo decodeData($page_title); ?>"/>
	<meta name="description" content="<?php echo decodeData(strip_tags($meta_description[0])); ?>"/>

  <meta property="og:title" content="<?php echo decodeData($page_title); ?>"/>
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="<?php echo $company_name; ?>"/>
  <meta property="og:url" content="<?php echo domainhost.$project_url; ?>" />
  <div itemscope itemtype="https://schema.org/Organization">
    <meta itemprop="telephone" content="<?php echo str_replace(" ","-",str_replace("+","",$company_phone)); ?>" />
    <meta itemprop="name" content="<?php echo $company_name; ?>" />
    <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
    	<meta itemprop="streetAddress" content="<?php if(!empty($company_address)) { echo $company_address.', '; } ?><?php if(!empty($company_office)) { echo 'Office '.$company_office.', '; } ?><?php if(!empty($company_pobox)) { echo 'P.O. Box '.$company_pobox; } ?>"/>
    	<meta itemprop="addressLocality" content="<?php echo $company_city; ?>" />
    	<meta itemprop="addressCountry" content="<?php echo $company_country; ?>" />
		</div>
  </div>

  <meta property="og:description" content="<?php echo decodeData(strip_tags($meta_description[0])); ?>" />
	<?php if(!empty($row_project['image'])) { ?>
  <?php
  $imgsize   = getimagesize(localhost."images/developments/default/".$row_project['project_id']."/".$row_project['image']);
  $imgwidth  = $imgsize[0];
  $imgheight = $imgsize[1];
  $imgmime 	 = $imgsize['mime'];
  ?>
	<meta property="og:image" content="<?php echo localhost; ?>images/developments/default/<?php echo $row_project['project_id']; ?>/<?php echo $row_project['image']; ?>" />
	<meta property="og:image:secure_url" content="<?php echo localhost; ?>images/developments/default/<?php echo $row_project['project_id']; ?>/<?php echo $row_project['image']; ?>" />
	<?php } else { ?>
  <?php
  $imgsize   = getimagesize(domainhost."images/".$page_og_image);
  $imgwidth  = $imgsize[0];
  $imgheight = $imgsize[1];
  $imgmime   = $imgsize['mime'];
  ?>
  <meta property="og:image" content="<?php echo domainhost."images/".$page_og_image; ?>" />
  <meta property="og:image:secure_url" content="<?php echo domainhost."images/".$page_og_image; ?>" />
  <?php } ?>

  <meta property="og:image:type" content="<?php echo $imgmime; ?>" />
  <meta property="og:image:width" content="<?php echo $imgwidth; ?>"/>
  <meta property="og:image:height" content="<?php echo $imgheight; ?>"/>

	<base href="<?php echo domainhost; ?>"/>

	<?php include_once(absolutedir."includes/head.php"); ?>

  <style>
  .project-default-img {
    background: linear-gradient(rgba(0, 0, 0, 0.20),
                rgba(0, 0, 0, 0.35)),
                url("<?php if(!empty($row_project['image'])) { echo localhost.'images/developments/default/'.$row_project['project_id'].'/'.$row_project['image']; } else { echo localhost.'images/developments/'.$row_project['project_id'].'/'.$row_project['image_name']; } ?>") no-repeat;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
  	height: 100vh;
  	position: relative;
  }
  .project-default-img:before {
    content: "";
    top: 0;
    position: absolute;
    height: 100%;
    width: 100%;
    z-index: 0;
    /* background: linear-gradient(to bottom,rgb(0 0 0 / 95%) 0%,rgb(0 0 0 / 30%) 35%,rgba(0, 0, 0, 0) 60%,rgba(0,0,0,0) 100%); */
    background: linear-gradient(to bottom,rgb(44 43 65 / 95%) 0%,rgb(44 43 65 / 30%) 35%,rgba(44, 43, 65, 0) 60%,rgba(44, 43, 65,0) 100%);
    border-radius: 0;
    opacity: 1;
  }
  header.nav-homepage-style.menu-home4 {
		background-color: transparent;
		border-bottom: none;
	}
  @media only screen and (max-width: 767px) {
    .listing-details .breadcumb-style1 .sharing a.sharer-btn {
      top: -60px;
    }
    .listing-details .breadcumb-style1 .sharing .sharing-option-buttons {
      top: -25px;
    }
  }
  </style>

</head>
<body class="project-body">
  <?php include_once(absolutedir."includes/header.php"); ?>
  <div class="wrapper ovh">
    <?php include_once(absolutedir."includes/menu.php"); ?>

    <div class="body_content">
      <section class="project-default-img pt0 pb0">
        <div class="container">
          <div class="row">
            <div class="banner-wrapper">
              <div class="banner-details">
                <div class="row align-items-end">
                  <div class="col-12 col-lg-9 col-md-7">
                    <h2 class="title">
                      <?php echo decodeData($project_caption); ?>
                    </h2>
                    <h4 class="developer">
                      by <?php echo decodeData($row_project['developer']); ?>
                    </h4>
                  </div>
                  <div class="col-12 col-lg-3 col-md-5">
                    <?php if(!empty($row_project['brochure'])) { ?>
                    <a class="download-brochure" data-bs-toggle="modal" href="#downloadToggle" role="button" data-source="Project" data-subsource="Registration" title="Download Brochure" data-refno="<?php echo $row_project['project_id']; ?>">
                      <span class="flaticon-printer"></span>
                      Download Brochure
                    </a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Breadcumb Sections -->
      <section class="breadcumb-section listing-details bg-white pb20 pt20 pb0-sm pb10-md pt15-md">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="breadcumb-style1 d-md-flex align-items-start w-100">
                <div class="col-12 col-lg-8 col-md-7 bread-crumb">
                  <span class="arrow-left"></span>
                  <a href="developments.html" title="Back to off plan projects">
                    Back to off plan projects
                  </a>
                  <h3 class="d-inline">
                    <?php echo decodeData($project_name); ?>
                  </h3>
                </div>
                <div class="col-12 col-lg-4 col-md-5 mt15-sm sharing">
        					<a href="#" class="sharer-btn">
                    <span class="flaticon-share-1 mr10"></span>
                    Share this project
                  </a>
                  <div class="sharing-option-buttons">
                    <div class="row justify-content-between align-items-center">
                      <div class="facebook-share">
                        <a href="https://www.facebook.com/sharer.php?u=<?php echo domainhost.$project_url; ?>" class="share-icon" title="Share to Facebook" target="_blank">
                          <i class="fa fa-facebook"></i>
                        </a>
                      </div>
                      <div class="twitter-share">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo domainhost.$project_url; ?>" class="share-icon" title="Share to Twitter" target="_blank">
                          <i class="fab fa-twitter"></i>
                        </a>
                      </div>
                      <div class="linkedin-share">
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo domainhost.$project_url; ?>" class="share-icon" title="Share to Linkedin" target="_blank">
                          <i class="fab fa-linkedin"></i>
                        </a>
                      </div>
                      <div class="whatsapp-share">
                        <a href="https://api.whatsapp.com/send?text=<?php echo domainhost.$project_url; ?>" class="share-icon" title="Share via WhatsApp" target="_blank">
                          <i class="fab fa-whatsapp"></i>
                        </a>
                      </div>
                      <div class="copy-share">
                        <a href="<?php echo domainhost.$project_url; ?>" class="share-icon copy-link" title="Copy Link">
                          <i class="fas fa-clipboard"></i>
                        </a>
                      </div>
                    </div>
                  </div>
        				</div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <hr class="mt0"></hr>
      <section class="project-items-details pt30 pb20">
        <div class="container">
          <div class="row justify-content-between align-items-start">
            <div class="col-6 col-lg-2 col-md-4 text-center mb30">
              <span class="flaticon-expand"></span>
              <h4>
                Development Type
              </h4>
              <h6>
                <?php echo decodeData($row_project['sub_type']); ?>
              </h6>
            </div>
            <div class="col-6 col-lg-2 col-md-4 text-center mb30">
              <span class="flaticon-investment"></span>
              <h4>
                Starting Price
              </h4>
              <h6>
                <?php if($row_project['price'] != '0.00') { ?>
                  AED <?php echo amountInWords($row_project['price']); ?>
                <?php } else { ?>
                  Price on request
                <?php } ?>
              </h6>
            </div>
            <div class="col-6 col-lg-2 col-md-4 text-center mb30">
              <span class="flaticon-corporation"></span>
              <h4>
                Developer
              </h4>
              <h6>
                <?php echo decodeData($row_project['developer']); ?>
              </h6>
            </div>
            <div class="col-6 col-lg-2 col-md-4 text-center mb30">
              <span class="flaticon-maps-1"></span>
              <h4>
                Location
              </h4>
              <h6>
                <?php echo decodeData($row_project['location']); ?>
              </h6>
            </div>
            <div class="col-6 col-lg-2 col-md-4 text-center mb30">
              <span class="flaticon-clock"></span>
              <h4>
                Completion Date
              </h4>
              <h6>
                <?php if($row_project['completion'] != '0000-00-00') { ?>
                  Q<?php echo date_quarter($row_project['completion']); ?>, <?php echo date("Y", strtotime($row_project['completion'])); ?>
                <?php } else { ?>
                  -
                <?php } ?>
              </h6>
            </div>
          </div>
        </div>
      </section>

      <!-- Property Images -->
      <section class="pt0 pb0 mt-30 listing-details bgc-white">
        <div class="container">
          <div class="row mt30 wow fadeInUp" data-wow-delay="300ms">
            <div class="col-md-8">
              <div class="sp-img-content at-sp-v2 mb15-md">
                <?php if($watermark_array_defaults[0] == true) { ?>
                <a class="venobox preview-img-1 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/watermark/development?filename='.$images_array_defaults[0].'&id='.$row_project['project_id']; ?>');" href="<?php echo localhost.'images/watermark/development?filename='.$images_array_defaults[0].'&id='.$row_project['project_id']; ?>" title="<?php if(!empty($caption_array_defaults[0])) { echo decodeData($caption_array_defaults[0]); } else { echo $project_caption; } ?>">
                </a>
                <?php } else { ?>
                <a class="venobox preview-img-1 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/developments/'.$row_project['project_id'].'/'.$images_array_defaults[0]; ?>');" href="<?php echo localhost.'images/developments/'.$row_project['project_id'].'/'.$images_array_defaults[0]; ?>" title="<?php if(!empty($caption_array_defaults[0])) { echo decodeData($caption_array_defaults[0]); } else { echo $project_caption; } ?>">
                </a>
                <?php } ?>
                <div class="listing-img-count">
                  <span class="flaticon-images"></span>
                  <?php echo $row_images_counted['counted']; ?>
                  Photos
                </div>
              </div>
            </div>
            <div class="col-md-4 desktop-view">
              <div class="row">
                <div class="col-sm-12 ps-lg-0">
                  <div class="sp-img-content">
                    <?php if($watermark_array_defaults[1] == true) { ?>
                    <a class="venobox preview-img-3 sp-img mb10" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/watermark/development?filename='.$images_array_defaults[1].'&id='.$row_project['project_id']; ?>');" href="<?php echo localhost.'images/watermark/development?filename='.$images_array_defaults[1].'&id='.$row_project['project_id']; ?>" title="<?php if(!empty($caption_array_defaults[1])) { echo decodeData($caption_array_defaults[1]); } else { echo $project_caption; } ?>">
                    </a>
                    <?php } else { ?>
                    <a class="venobox preview-img-3 sp-img mb10" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/developments/'.$row_project['project_id'].'/'.$images_array_defaults[1]; ?>');" href="<?php echo localhost.'images/developments/'.$row_project['project_id'].'/'.$images_array_defaults[1]; ?>" title="<?php if(!empty($caption_array_defaults[1])) { echo decodeData($caption_array_defaults[1]); } else { echo $project_caption; } ?>">
                    </a>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-sm-12 ps-lg-0">
                  <div class="sp-img-content at-sp-v2">
                    <?php if($watermark_array_defaults[2] == true) { ?>
                    <a class="venobox preview-img-5 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/watermark/development?filename='.$images_array_defaults[2].'&id='.$row_project['project_id']; ?>');" href="<?php echo localhost.'images/watermark/development?filename='.$images_array_defaults[2].'&id='.$row_project['project_id']; ?>" title="<?php if(!empty($caption_array_defaults[2])) { echo decodeData($caption_array_defaults[2]); } else { echo $project_caption; } ?>">
                    </a>
                    <?php } else { ?>
                    <a class="venobox preview-img-5 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/developments/'.$row_project['project_id'].'/'.$images_array_defaults[2]; ?>');" href="<?php echo localhost.'images/developments/'.$row_project['project_id'].'/'.$images_array_defaults[2]; ?>" title="<?php if(!empty($caption_array_defaults[2])) { echo decodeData($caption_array_defaults[2]); } else { echo $project_caption; } ?>">
                    </a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <?php while($row_images = $result_images->fetch_assoc()) { ?>
            <?php if($row_images['watermark'] == true) { ?>
            <a class="venobox" data-gall="listing-gallery" href="<?php echo localhost.'images/watermark/development?filename='.$row_images['image_name'].'&id='.$row_project['project_id']; ?>" title="<?php if(!empty($row_images['image_caption'])) { echo decodeData($row_images['caption']); } else { echo $project_caption; } ?>"></a>
            <?php } else { ?>
            <a class="venobox" data-gall="listing-gallery" href="<?php echo localhost.'images/developments/'.$row_project['project_id'].'/'.$row_images['image_name']; ?>" title="<?php if(!empty($row_images['caption'])) { echo decodeData($row_images['image_caption']); } else { echo $project_caption; } ?>"></a>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
      </section>
      <!-- Property Images -->

      <section class="listing-details pt30 pt10-md pb90">
        <div class="container">
          <div class="row wrap wow fadeInUp" data-wow-delay="500ms">
            <div class="col-lg-8">
              <div class="ps-widget bgc-white bdrs0 mb30 overflow-hidden position-relative">
                <h1 class="title mb5">
                  <?php echo decodeData($page_title); ?>
                </h1>
                <?php $i = 1; ?>
                <?php while($row_projects_layouts = $result_projects_layouts->fetch_assoc()) { ?>
                <?php $n = $i++; ?>
                <?php
                  $floor_plan_array = explode(".", trim($row_projects_layouts['floor_plans']));
                  $floor_plan_extn  = end($floor_plan_array);
                ?>
                <?php if(strtolower($floor_plan_extn) == 'jpg' || strtolower($floor_plan_extn) == 'jpeg' || strtolower($floor_plan_extn == 'png')) { ?>
                <?php if($n == 1) { ?>
                <a href="<?php echo localhost.'layouts/developments/'.$row_project['project_id'].'/'.trim($row_projects_layouts['floor_plans']); ?>" class="floor venobox" data-gall="Floor-Plans" title="<?php echo decodeData($row_projects_layouts['floor_type']); ?>">
                  Click here to check the floor plan
                </a>
                <?php } else { ?>
                <a href="<?php echo localhost.'layouts/developments/'.$row_project['project_id'].'/'.trim($row_projects_layouts['floor_plans']); ?>" class="venobox" data-gall="Floor-Plans" title="<?php echo decodeData($row_projects_layouts['floor_type']); ?>"></a>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <p class="text mt40">
                  <?php echo decodeData($row_project['description']); ?>
                </p>
              </div>

              <?php if(!empty($row_project['features']) || !empty($row_project['amenities'])) { ?>
              <hr/>
              <div class="ps-widget bgc-white mt40 mb30 overflow-hidden position-relative">
                <h4 class="title mb20">
                  Features & Amenities
                </h4>
                <div class="row features-amenities">
                  <?php
                  if(!empty($row_project['features'])) {
                    $features = explode(',',$row_project['features']);
                    foreach($features as $feature) {
                  ?>
                  <div class="col-sm-6 col-md-4">
                    <div class="pd-list mb10-sm fz16">
                      <i class="fas fa-long-arrow-right fz14 align-middle pe-2"></i>
                      <?php echo decodeData($feature); ?>
                    </div>
                  </div>
                  <?php }
                  }
                  ?>
                  <?php if(!empty($row_project['amenities'])) {
                    $amenities = explode(',',$row_project['amenities']);
                    foreach($amenities as $amenity) {
                  ?>
                  <div class="col-sm-6 col-md-4">
                    <div class="pd-list mb10-sm fz16">
                      <i class="fas fa-long-arrow-right fz14 align-middle pe-2"></i>
                      <?php echo decodeData($amenity); ?>
                    </div>
                  </div>
                  <?php }
                  }
                  ?>
                </div>
              </div>
              <?php } ?>

              <?php if($result_projects_units->num_rows >= 1) { ?>
              <hr/>
              <div class="ps-widget payment-plan mt40 mb30 overflow-hidden position-relative">
                <h4 class="title mb0 <?php if($row_availability['availability'] >= 1) { echo 'mb0'; } else { echo 'mb30'; } ?>">
                  Availability
                </h4>
                <?php if($row_availability['availability'] >= 1) { ?>
                <p class="mb30">
                  <a class="position-relative" href="#" title="Unit availability">
                    Click here to check the availability
                  </a>
                </p>
                <?php } ?>
                <div class="row justify-content-start align-items-start">
                  <?php while($row_projects_units = $result_projects_units->fetch_assoc()) { ?>
                  <div class="col-md-4 col-sm-6 col-12 text-center mb20">
                    <div class="payment-plan-content">
                      <?php if(!empty($row_projects_units['number_of_units'])) { ?>
                      <h4 class="unit-title">
                        <?php
                        if($row_projects_units['number_of_units'] == 1) {
                          echo decodeData($row_projects_units['number_of_units']).' Unit';
                        } else {
                          echo decodeData($row_projects_units['number_of_units']).' Units';
                        }
                        ?>
                      </h4>
                      <?php } ?>
                      <?php if(!empty($row_projects_units['number_of_units'])) { ?>
                      <h6>
                        <?php
                        if(!empty($row_projects_units['unit'])) {
                          echo decodeData($row_projects_units['unit']);
                        }
                        ?>
                      </h6>
                      <?php  } else { ?>
                      <?php if(!empty($row_projects_units['unit'])) { ?>
                      <h4 class="unit-title">
                        <?php echo decodeData($row_projects_units['unit']); ?>
                      </h4>
                      <?php } ?>
                      <?php } ?>
                      <p class="mb0">
                        <?php
                        if($row_projects_units['unit_size'] != '0.00') {
                          echo 'Size from '.str_replace(".00","",number_format($row_projects_units['unit_size'],2)).' sqft';
                        } else {
                          echo 'Size not available';
                        }
                        ?>
                      </p>
                      <span>
                        <?php if($row_projects_units['price'] != '0.00') { ?>
                          Starting price
                        <?php } else { ?>
                          <a class="request-price position-relative" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Off-Plan" data-subsource="Email Lead" data-user="" data-refno="" data-agent="<?php echo decodeData($company_name); ?>" data-title="<?php echo decodeData($page_title); ?>" title="Request the price">
                            Price on request
                          </a>
                        <?php } ?>
                      </span>
                      <h4 class="availability-price">
                        <?php
                        if($row_projects_units['price'] != '0.00') {
                          echo 'AED '.amountInWords($row_projects_units['price']);
                        }
                        ?>
                      </h4>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>

              <?php if($result_payment_plans->num_rows >= 1) { ?>
              <hr/>
              <div class="ps-widget payment-plan mt40 mb30 overflow-hidden position-relative">
                <h4 class="title mb0">
                  Payment Plan
                </h4>
                <p class="mb30">
                  <a class="email-agent position-relative" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Off-Plan" data-subsource="Email Lead" data-user="" data-refno="" data-agent="<?php echo decodeData($company_name); ?>" data-title="<?php echo decodeData($page_title); ?>" title="Contact us now">
                    Contact us to know more about payment plans
                  </a>
                </p>
                <div class="row justify-content-start align-items-start">
                  <?php while($row_payment_plans = $result_payment_plans->fetch_assoc()) { ?>
                  <div class="col-md-4 col-sm-6 col-12 text-center mb20">
                    <div class="payment-plan-content">
                      <h4 class="unit-title">
                        <?php echo decodeData($row_payment_plans['percentage']); ?>%
                      </h4>
                      <h6>
                        <?php echo decodeData($row_payment_plans['details']); ?>
                      </h6>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <?php } ?>
              <hr/>
              <div class="ps-widget bgc-white mt30 overflow-hidden position-relative">
                <h4 class="title mb0">
                  Project address
                </h4>
                <h6 class="location mb20">
                  <?php echo $project_name; ?>
                </h6>
                <div class="row">
                  <div class="col-lg-12">
                    <div id="listing-map"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="column">
                <div class="mb30-md mt20-md position-relative">
                  <form name="registerInterest" class="form-style1 call-back p15 pb25 mb20" action="process/process.interest.php" method="POST">
                    <h6 class="title mt5 mb15">
                      Register your interest
                    </h6>
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="mb15">
                          <input type="text" name="name" class="form-control required" placeholder="Name*" value="<?php echo $_COOKIE['name']; ?>" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-md-12">
                        <div class="mb15">
                          <input type="email" name="email" class="form-control required" placeholder="Email*" value="<?php echo $_COOKIE['email']; ?>" autocomplete="off">
                        </div>
                      </div>
                      <div class="col-lg-12">
                        <div class="mb15">
                          <input type="text" name="phone" class="form-control required" placeholder="Phone*" value="<?php echo $_COOKIE['phone']; ?>" autocomplete="off">
                        </div>
                      </div>
                      <p>
      									By submitting the form, you have read and agree to our <a href="<?php echo webhost; ?>terms-and-conditions.html" title="Terms & Conditions" target="Terms">Terms & Conditions</a> and <a href="<?php echo webhost; ?>privacy-policy.html" title="Privacy Policy" target="Policy">Privacy Policy</a>.
      								</p>
                      <div class="col-md-12">
                        <div class="d-grid">
                          <button class="btn btn-dark-default w-100 bdrs0" type="submit">
                            Register Now
                            <i class="fal fa-arrow-right-long"></i>
                          </button>
                          <input type="hidden" name="recaptcha_response" class="recaptchaResponse" readonly/>
                          <input type="hidden" name="email_group" value="Inquiry" readonly/>
                          <input type="hidden" name="source" value="Off-Plan" readonly/>
                          <input type="hidden" name="sub_source" value="Register" readonly/>
                          <input type="hidden" name="refno" value="<?php echo decodeData($row_project['project_id']); ?>" readonly/>
                        </div>
                      </div>
                    </div>
                  </form>
                  <?php if(!empty($row_project['qrcode_permit'])) { ?>
                  <div class="rera-qr-code d-flex align-items-end p15 mb0">
                    <div class="single-img">
                      <img src="<?php echo localhost.'images/qrcodes/projects/'.$row_project['project_id'].'/'.$row_project['qrcode_permit']; ?>" alt="RERA Permit QR Code"/>
                    </div>
                    <div class="single-content ml20">
                      <h4 class="rera-permit">
                        RERA Permit
                      </h4>
                      <h3 class="rera-permit-number">
                        <?php echo decodeData($row_project['permit_number']); ?>
                      </h3>
                      <p class="rera-permit-details">
                        Issued to RERA registered company as a confirmation of our right to advertise the property.
                      </p>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <?php include_once(absolutedir."includes/area.interest.php"); ?>
      <?php include_once(absolutedir."includes/footer.php"); ?>

      <!-- Download Brichure -->
      <div class="signup-modal contact-agent">
        <div class="modal fade" id="downloadToggle" aria-hidden="true" aria-labelledby="downloadToggleLabel" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="downloadToggleLabel">
                  <span class="flaticon-printer"></span>
                  Download Brochure
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body mt20">
                <div class="log-reg-form">
                  <form name="downloadBrochure" class="gray-borders" action="process/process.brochure.php" method="POST">
                    <div class="form-style1">
                      <div class="mb15">
                        <input type="text" name="name" class="form-control required" placeholder="Name*" value="<?php echo $_COOKIE['name']; ?>" autocomplete="off">
                      </div>
                      <div class="mb15">
                        <input type="email" name="email" class="form-control required" placeholder="Email*" value="<?php echo $_COOKIE['email']; ?>" autocomplete="off">
                      </div>
                      <div class="mb15">
                        <input type="text" name="phone" class="form-control required" placeholder="Phone*" value="<?php echo $_COOKIE['phone']; ?>" autocomplete="off">
                      </div>
                      <p>
      									Please ensure your email address and phone number are correct. You'll get the brochure in your email inbox assuming the process and request is successful.
      								</p>
                      <div class="d-grid mb20">
                        <button class="btn-dark-default" type="submit">
                          Send Request
                          <i class="fal fa-arrow-right-long"></i>
                        </button>
                        <input type="hidden" name="recaptcha_response" class="recaptchaResponse" readonly/>
                        <input type="hidden" name="email_group" value="Inquiry" readonly/>
                        <input type="hidden" name="refno" readonly/>
                        <input type="hidden" name="source" readonly/>
                        <input type="hidden" name="sub_source" readonly/>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <?php include_once(absolutedir."includes/handy.buttons.php"); ?>
  <?php include_once(absolutedir."includes/property.search.php"); ?>
  <?php include_once(absolutedir."includes/scripts.php"); ?>

  <script>
  //  Fixed sidebar Custom Script For That
  $(function(){
    'use strict'

    var cols = $('.wrap .column');
    var enabled = true;
    var scrollbalance = new ScrollBalance(cols, {
      minwidth: 0
    });
    // bind to scroll and resize events
    scrollbalance.bind();

    $('.venobox').venobox({
      numeratio     : true,
      htmlClose     : "",
      titleattr     : 'title',
      titlePosition : 'bottom',
      overlayClose  : false
    });
    //intialize the map
    function initialize() {
      var mapOptions = {
        zoom                  : 13,
      	scrollwheel           : false,
    	  draggable             : true,
      	disableDoubleClickZoom: true,
        center                : new google.maps.LatLng(<?php echo decodeData($row_project['coordinates']); ?>)
      };

      var map = new google.maps.Map(document.getElementById('listing-map'),mapOptions);

      //add a marker1
      var marker = new google.maps.Marker({
        position  : map.getCenter(),
        map       : map,
        icon      : 'images/icons/marker-icon.png'
      });

      //show info box for marker1
      var contentString = '<div class="info-box">\
                          <h3><?php echo decodeData($project_caption); ?></h3>\
                          <span><?php echo decodeData($page_title); ?></span>\
                          </div>';

      var infowindow = new google.maps.InfoWindow({
        content: contentString
      });

      google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map,marker);
      });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
