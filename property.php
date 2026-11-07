<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Property';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/listing.php");
require_once(absolutedir."query/other.interest.php");
if($result_listing->num_rows <= 0) {
  header('Location: '.domainhost.'404'); // Redirect to 404
  exit;
}
if(!empty($row_listing['page_title'])) {
  $page_title = $row_listing['page_title'];
} else {
  $page_title = $row_listing['title'];
}

if($row_listing['category'] == 'Commercial') {
  $url_category = 'commercials';
} else {
  $url_category = 'residentials';
}
if(in_array($row_listings['property_type'],$property_type_apartment)) {
  $url_type = 'apartments';
} elseif(in_array($row_listings['property_type'],$property_type_villa)) {
  $url_type = 'villas';
} elseif(in_array($row_listings['property_type'],$property_type_office)) {
  $url_type = 'offices';
} elseif($row_listings['property_type'] == "Retail") {
  $url_type = 'shops';
} elseif($row_listings['property_type'] == "Building") {
  $url_type = 'buildings';
} elseif($row_listings['property_type'] == "Land") {
  $url_type = 'plots';
} else {
  $url_type = 'apartments';
}

if(!empty($row_listing['building_name'])) {
  $project_name = decodeData($row_listing['building_name']).', '.decodeData($row_listing['location']);
  $listing_url = $url_category."/".$url_type."-for-".cleanString($row_listing['listing_type'])."/".cleanString($row_listing['location'])."/".cleanString($row_listing['building_name'])."/".cleanString($page_title)."-".$row_listing['listing_id'].".html";
  $listing_caption = decodeData($row_listing['building_name']);
} elseif(!empty($row_listing['property'])) {
  $project_name = decodeData($row_listing['property']).', '.decodeData($row_listing['location']);
  $listing_url = $url_category."/".$url_type."-for-".cleanString($row_listing['listing_type'])."/".cleanString($row_listing['location'])."/".cleanString($row_listing['property'])."/".cleanString($page_title)."-".$row_listing['listing_id'].".html";
    $listing_caption = decodeData($row_listing['property']);
} else if(!empty($row_listing['sub_location'])) {
  $project_name = decodeData($row_listing['sub_location']).', '.decodeData($row_listing['location']);
  $listing_url = $url_category."/".$url_type."-for-".cleanString($row_listing['listing_type'])."/".cleanString($row_listing['location'])."/".cleanString($row_listing['sub_location'])."/".cleanString($page_title)."-".$row_listing['listing_id'].".html";
    $listing_caption = decodeData($row_listing['sub_location']);
} else {
  $project_name = decodeData($row_listing['location']);
  $listing_url = $url_category."/".$url_type."-for-".cleanString($row_listing['listing_type'])."/".cleanString($row_listing['location'])."/".cleanString($page_title)."-".$row_listing['listing_id'].".html";
  $listing_caption = decodeData($row_listing['location']);
}
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <?php
  $meta_description = explode("\n", $row_listing['description']);
  ?>
	<meta charset="utf-8"/>
	<meta http-equiv="x-ua-compatible" content="ie=edge"/>
	<link rel="canonical" href="<?php echo domainhost.$listing_url; ?>"/>
	<title><?php echo decodeData($page_title); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="robots" content="index, follow"/>
  <?php if(!empty($row_listing['tags'])) { ?>
    <meta name="keywords" content="<?php echo strtolower(decodeData($row_listing['tags'])); ?>"/>
  <?php } else { ?>
  <?php if($row_listing['listing_type'] == 'Sale') { ?>
    <meta name="keywords" content="<?php echo strtolower(decodeData($row_listing['property_type'])); ?> for <?php echo strtolower(decodeData($row_listing['listing_type'])); ?> in <?php echo strtolower(decodeData($row_listing['location'])); ?>, <?php if(empty($row_listing['property'])) { if(!empty($row_listing['sub_location'])) { echo strtolower(decodeData($row_listing['property_type'])).' for '.strtolower(decodeData($row_listing['listing_type'])).' in '.strtolower(decodeData($row_listing['sub_location'])); } else { echo ''; } } else { echo strtolower(decodeData($row_listing['property_type'])).' for '.strtolower(decodeData($row_listing['listing_type'])).' in '.strtolower(decodeData($row_listing['property'])).', '; } ?>apartment for sale in dubai, villas for sale in dubai, office space for sale in dubai"/>
  <?php } else { ?>
    <meta name="keywords" content="<?php echo strtolower(decodeData($row_listing['property_type'])); ?> for <?php echo strtolower(decodeData($row_listing['listing_type'])); ?> in <?php echo strtolower(decodeData($row_listing['location'])); ?>, <?php if(empty($row_listing['property'])) { if(!empty($row_listing['sub_location'])) { echo strtolower(decodeData($row_listing['property_type'])).' for '.strtolower(decodeData($row_listing['listing_type'])).' in '.strtolower(decodeData($row_listing['sub_location'])); } else { echo ''; } } else { echo strtolower(decodeData($row_listing['property_type'])).' for '.strtolower(decodeData($row_listing['listing_type'])).' in '.strtolower(decodeData($row_listing['property'])).', '; } ?>apartment for rent in dubai, villas for rent in dubai, office space for rent in dubai"/>
  <?php } ?>
  <?php } ?>
	<meta name="title" content="<?php echo decodeData($page_title); ?>"/>
	<meta name="description" content="<?php echo decodeData(strip_tags($meta_description[0])); ?>"/>

  <meta property="og:title" content="<?php echo decodeData($page_title); ?>"/>
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="<?php echo $company_name; ?>"/>
  <meta property="og:url" content="<?php echo domainhost.$listing_url; ?>" />
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
	<?php if(!empty($row_listing['image_name'])) { ?>
  <?php
  $imgsize   = getimagesize(localhost."images/listings/".$row_listing['listing_id']."/".$row_listing['image_name']);
  $imgwidth  = $imgsize[0];
  $imgheight = $imgsize[1];
  $imgmime 	 = $imgsize['mime'];
  ?>
	<meta property="og:image" content="<?php echo localhost; ?>images/listings/<?php echo $row_listing['listing_id']; ?>/<?php echo $row_listing['image_name']; ?>" />
	<meta property="og:image:secure_url" content="<?php echo localhost; ?>images/listings/<?php echo $row_listing['listing_id']; ?>/<?php echo $row_listing['image_name']; ?>" />
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

</head>
<body>
  <?php include_once(absolutedir."includes/header.php"); ?>
  <div class="wrapper ovh">
    <?php include_once(absolutedir."includes/menu.php"); ?>

    <div class="body_content">
      <!-- Breadcumb Sections -->
      <section class="breadcumb-section listing-details bg-white pb20 pt110 pb0-md pt80-md">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="breadcumb-style1 d-md-flex align-items-start w-100">
                <div class="col-12 col-lg-8 col-md-7 bread-crumb">
                  <span class="arrow-left"></span>
                  <a href="<?php echo $url_type."-for-".cleanString($row_listing['listing_type']); ?>.html" title="Back to Listings">
                    Back to listings
                  </a>
                  <h3 class="d-inline">
                    <?php echo $project_name; ?>
                  </h3>
                </div>
                <div class="col-12 col-lg-4 col-md-5 mt15-md sharing">
        					<a href="#" class="sharer-btn">
                    <span class="flaticon-share-1 mr10"></span>
                    Share this property
                  </a>
                  <div class="sharing-option-buttons">
                    <div class="row justify-content-between align-items-center">
                      <div class="facebook-share">
                        <a href="https://www.facebook.com/sharer.php?u=<?php echo domainhost.$listing_url; ?>" class="share-icon" title="Share to Facebook" target="_blank">
                          <i class="fa fa-facebook"></i>
                        </a>
                      </div>
                      <div class="twitter-share">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo domainhost.$listing_url; ?>" class="share-icon" title="Share to Twitter" target="_blank">
                          <i class="fab fa-twitter"></i>
                        </a>
                      </div>
                      <div class="linkedin-share">
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo domainhost.$listing_url; ?>" class="share-icon" title="Share to Linkedin" target="_blank">
                          <i class="fab fa-linkedin"></i>
                        </a>
                      </div>
                      <div class="whatsapp-share">
                        <a href="https://api.whatsapp.com/send?text=<?php echo domainhost.$listing_url; ?>" class="share-icon" title="Share via WhatsApp" target="_blank">
                          <i class="fab fa-whatsapp"></i>
                        </a>
                      </div>
                      <div class="copy-share">
                        <a href="<?php echo domainhost.$listing_url; ?>" class="share-icon copy-link" title="Copy Link">
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

      <!-- Property Images -->
      <section class="pt0 pb0 mt-30 listing-details bgc-white">
        <div class="container">
          <div class="row mt30 wow fadeInUp" data-wow-delay="300ms">
            <div class="col-md-8">
              <div class="sp-img-content at-sp-v2 mb15-md">
                <?php if($watermark_array_defaults[0] == true) { ?>
                <a class="venobox preview-img-1 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/watermark/listing?filename='.$images_array_defaults[0].'&id='.$row_listing['listing_id']; ?>');" href="<?php echo localhost.'images/watermark/listing?filename='.$images_array_defaults[0].'&id='.$row_listing['listing_id']; ?>" title="<?php if(!empty($caption_array_defaults[0])) { echo decodeData($caption_array_defaults[0]); } else { echo $listing_caption; } ?>">
                </a>
                <?php } else { ?>
                <a class="venobox preview-img-1 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/listings/'.$row_listing['listing_id'].'/'.$images_array_defaults[0]; ?>');" href="<?php echo localhost.'images/listings/'.$row_listing['listing_id'].'/'.$images_array_defaults[0]; ?>" title="<?php if(!empty($caption_array_defaults[0])) { echo decodeData($caption_array_defaults[0]); } else { echo $listing_caption; } ?>">
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
                    <a class="venobox preview-img-3 sp-img mb10" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/watermark/listing?filename='.$images_array_defaults[1].'&id='.$row_listing['listing_id']; ?>');" href="<?php echo localhost.'images/watermark/listing?filename='.$images_array_defaults[1].'&id='.$row_listing['listing_id']; ?>" title="<?php if(!empty($caption_array_defaults[1])) { echo decodeData($caption_array_defaults[1]); } else { echo $listing_caption; } ?>">
                    </a>
                    <?php } else { ?>
                    <a class="venobox preview-img-3 sp-img mb10" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/listings/'.$row_listing['listing_id'].'/'.$images_array_defaults[1]; ?>');" href="<?php echo localhost.'images/listings/'.$row_listing['listing_id'].'/'.$images_array_defaults[1]; ?>" title="<?php if(!empty($caption_array_defaults[1])) { echo decodeData($caption_array_defaults[1]); } else { echo $listing_caption; } ?>">
                    </a>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-sm-12 ps-lg-0">
                  <div class="sp-img-content at-sp-v2">
                    <?php if($watermark_array_defaults[2] == true) { ?>
                    <a class="venobox preview-img-5 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/watermark/listing?filename='.$images_array_defaults[2].'&id='.$row_listing['listing_id']; ?>');" href="<?php echo localhost.'images/watermark/listing?filename='.$images_array_defaults[2].'&id='.$row_listing['listing_id']; ?>" title="<?php if(!empty($caption_array_defaults[2])) { echo decodeData($caption_array_defaults[2]); } else { echo $listing_caption; } ?>">
                    </a>
                    <?php } else { ?>
                    <a class="venobox preview-img-5 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/listings/'.$row_listing['listing_id'].'/'.$images_array_defaults[2]; ?>');" href="<?php echo localhost.'images/listings/'.$row_listing['listing_id'].'/'.$images_array_defaults[2]; ?>" title="<?php if(!empty($caption_array_defaults[2])) { echo decodeData($caption_array_defaults[2]); } else { echo $listing_caption; } ?>">
                    </a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <?php while($row_images = $result_images->fetch_assoc()) { ?>
            <?php if($row_images['watermark'] == true) { ?>
            <a class="venobox" data-gall="listing-gallery" href="<?php echo localhost.'images/watermark/listing?filename='.$row_images['image_name'].'&id='.$row_listing['listing_id']; ?>" title="<?php if(!empty($row_images['image_caption'])) { echo decodeData($row_images['image_caption']); } else { echo $listing_caption; } ?>"></a>
            <?php } else { ?>
            <a class="venobox" data-gall="listing-gallery" href="<?php echo localhost.'images/listings/'.$row_listing['listing_id'].'/'.$row_images['image_name']; ?>" title="<?php if(!empty($row_images['image_caption'])) { echo decodeData($row_images['image_caption']); } else { echo $listing_caption; } ?>"></a>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
      </section>
      <!-- Property Images -->

      <section class="listing-details pt30 pt10-md pb80">
        <div class="container">
          <div class="row wrap wow fadeInUp" data-wow-delay="500ms">
            <div class="col-lg-8">
              <div class="ps-widget bgc-white bdrs0 mb30 overflow-hidden position-relative">
                <h4 class="price-list mb5">
                  AED <?php echo number_format($row_listing['list_price'],0); ?>
                  <?php if($row_listing['verified'] == true) { ?>
                  <img class="verification-details-icon" src="images/icon/verified-icon.svg" alt="Verified Listing"<?php if($row_listing['verified'] == true) { echo ' data-bs-toggle="tooltip" data-bs-placement="right" title="This indicates that the listing is verified by Propertyfinder"'; } ?>/>
                  <?php } ?>
                </h4>
                <h1 class="title mb5">
                  <?php echo decodeData($page_title); ?>
                </h1>
                <?php
                if(!empty($row_listing['floor_plans'])) {
                  $floor_plans = explode(",",$row_listing['floor_plans']);
                ?>
                <?php $i = 1; ?>
                <?php foreach($floor_plans as $floor_plan) { ?>
                <?php $n = $i++; ?>
                <?php
                  $floor_plan_array = explode(".", trim($floor_plan));
                  $floor_plan_extn  = end($floor_plan_array);
                ?>
                <?php if(strtolower($floor_plan_extn) == 'jpg' || strtolower($floor_plan_extn) == 'jpeg' || strtolower($floor_plan_extn == 'png')) { ?>
                <?php if($n == 1) { ?>
                <a href="<?php echo localhost.'layouts/listings/'.$row_listing['listing_id'].'/'.trim($floor_plan); ?>" class="floor venobox" data-gall="Floor-Plans" title="Floor Plans">
                  Click here to check the floor plan
                </a>
                <?php } else { ?>
                <a href="<?php echo localhost.'layouts/listings/'.$row_listing['listing_id'].'/'.trim($floor_plan); ?>" class="venobox" data-gall="Floor-Plans" title="Floor Plans"></a>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <?php } ?>
                <div class="list-meta mt20 mb30 d-flex align-items-center">
                  <?php if($row_listing['category'] == 'Residential') { ?>
                  <span class="flaticon-bed"></span>
                  <?php
                  if(empty($row_listing['bedrooms'])) {
                    echo "Studio";
                  } elseif($row_listing['bedrooms'] == 1) {
                    echo $row_listing['bedrooms'].' Bed';
                  } else {
                    echo $row_listing['bedrooms'].' Beds';
                  }
                  ?>
                  <span class="flaticon-shower"></span>
                  <?php
                  if(empty($row_listing['bathrooms'])) {
                    echo "-";
                  } elseif($row_listing['bathrooms'] == 1) {
                    echo $row_listing['bathrooms'].' Bath';
                  } else {
                    echo $row_listing['bathrooms'].' Baths';
                  }
                  ?>
                  <?php } else { ?>
                  <?php
                  if(in_array($row_listing['property_type'],$property_type_land)) {
                  if($row_listing['plot_size'] != '0.00') {
                  ?>
                  <span></span>
                  AED <?php echo number_format(($row_listing['list_price']/$row_listing['plot_size']),0).' per '.$row_listing['plot_measurement']; ?>
                  <?php } ?>
                  <?php } else { ?>
                  <?php if($row_listing['unit_size'] != '0.00') { ?>
                  <span></span>
                  AED <?php echo number_format(($row_listing['list_price']/$row_listing['unit_size']),0).' per '.$row_listing['size_measurement']; ?>
                  <?php } ?>
                  <?php } ?>
                  <?php } ?>
                  <span class="flaticon-expand"></span>
                  <?php
                  if(in_array($row_listing['property_type'],$property_type_land)) {
                    if($row_listing['plot_size'] != '0.00') {
                      echo number_format($row_listing['plot_size'],0).' '.$row_listing['plot_measurement'];
                    } else {
                      echo '-';
                    }
                  } else {
                    if($row_listing['unit_size'] != '0.00') {
                      echo number_format($row_listing['unit_size'],0).' '.$row_listing['size_measurement'];
                    } else {
                      echo '-';
                    }
                  }
                  ?>
                </div>
                <p class="text mb0">
                  <?php echo decodeData($row_listing['description']); ?>
                </p>
                <p class="text mb30"></p>
                <hr/>
                <h4 class="title mb30 mt30">
                  Key Details
                </h4>
                <div class="row">
                  <div class="col-md-3 col-6">
                    <div class="pd-list">
                      <span class="key-details-head">
                        Property ID
                      </span>
                      <h6 class="key-details">
                        <?php
                        if(!empty($row_listing['refno'])) {
                          echo $row_listing['refno'];
                        } else {
                          echo $refno_code.$row_listing['listing_id'];
                        }
                        ?>
                      </h6>
                    </div>
                  </div>
                  <div class="col-md-3 col-6">
                    <div class="pd-list">
                      <span class="key-details-head">
                        Category
                      </span>
                      <h6 class="key-details">
                        <?php echo decodeData($row_listing['category']); ?>
                      </h6>
                    </div>
                  </div>
                  <div class="col-md-3 col-6">
                    <div class="pd-list">
                      <span class="key-details-head">
                        Property Type
                      </span>
                      <h6 class="key-details">
                        <?php echo decodeData($row_listing['property_type']); ?>
                      </h6>
                    </div>
                  </div>
                  <div class="col-md-3 col-6">
                    <div class="pd-list">
                      <span class="key-details-head">
                        Listing Type
                      </span>
                      <h6 class="key-details">
                        <?php echo decodeData($row_listing['listing_type']); ?>
                      </h6>
                    </div>
                  </div>
                </div>
              </div>
              <hr/>
              <?php if(!empty($row_listing['amenities'])) { ?>
              <div class="ps-widget bgc-white mt40 mb30 overflow-hidden position-relative">
                <h4 class="title mb20">
                  Features & Amenities
                </h4>
                <div class="row features-amenities">
                  <?php if(!empty($row_listing['amenities'])) {
                    $amenities = explode(',',$row_listing['amenities']);
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
              <hr/>
              <?php } ?>
              <?php if(!empty($row_listing['coordinates'])) { ?>
              <div class="ps-widget bgc-white mt30 overflow-hidden position-relative">
                <h4 class="title mb0">
                  Property address
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
              <?php } ?>
            </div>
            <div class="col-lg-4">
              <div class="column">
                <div class="mb30-md mt20-md position-relative">
                  <div class="agent-profile-details">
                    <div class="agent-single d-flex align-items-end p15 mb0">
                      <div class="single-img">
                        <?php if(!empty($row_listing['user_photo']) && !empty($row_listing['rera_number'])) { ?>
                          <img src="<?php echo localhost.'images/users/'.$row_listing['user_photo']; ?>" alt="<?php echo decodeData($row_listing['full_name']); ?>" class="w90"/>
                        <?php } else { ?>
                          <img src="images/<?php echo $user_400x400; ?>" alt="<?php echo decodeData($company_name); ?>" class="w90"/>
                        <?php } ?>
                      </div>
                      <div class="single-contant ml20">
                        <h4 class="agent-designation">
                          <?php
                            if(!empty($row_listing['rera_number'])) {
                              echo decodeData($row_listing['designation']);
                            } else {
                              echo 'Listing Administrator';
                            }
                          ?>
                        </h4>
                        <h3 class="agent-name">
                          <?php
                            if(!empty($row_listing['rera_number'])) {
                              echo decodeData($row_listing['full_name']);
                            } else {
                              echo decodeData($company_name);
                            }
                          ?>
                        </h3>
                        <p class="agent-brn">
                          <?php if(!empty($row_listing['rera_number'])) { ?>
                          BRN <?php echo decodeData($row_listing['rera_number']); ?>
                          <?php } else { ?>
                          ORN <?php echo decodeData($company_rera); ?>
                          <?php } ?>
                        </p>
                      </div>
                    </div>
                    <div class="list-meta2 pt10 mb20 pl15 pr15 pb15">
                      <div class="agent-contacts d-flex justify-content-start align-items-center">
                        <a href="tel:<?php echo str_replace($string_replace_mobile,"",$row_listing['mobile']); ?>" title="Call Me">
                          <span class="flaticon-call"></span>
                          Call
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$company_mobile); ?>&text=Hello <?php echo decodeData($row_listing['user_name']); ?>, I found this property <?php echo decodeData($row_listing['title']); ?> [Ref <?php echo $refno_code.$row_listing['listing_id']; ?>] on Gold Mark Real Estate website and I'm interested in learning more. Please contact me at your earliest convenience. Thank you!" title="Whatsapp Me" target="_blank">
                          <span class="flaticon-whatsapp"></span>
                          Whatsapp
                        </a>
                        <a class="email-agent" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Agent Listing" data-subsource="Email Lead" data-user="<?php echo decodeData($row_listing['user_id']); ?>" data-refno="<?php echo $refno_code.decodeData($row_listing['listing_id']); ?>" data-agent="<?php echo decodeData($row_listing['full_name']); ?>" data-title="<?php echo decodeData($page_title); ?>" title="Send Email">
                          <span class="flaticon-email"></span>
                          Email
                        </a>
                      </div>
                    </div>
                  </div>
                  <form name="requestCallBack" class="form-style1 call-back p15 pb25 mb20" action="process/process.callback.php" method="POST">
                    <h6 class="title mt5 mb15">
                      Call-back request
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
                            Send Request
                            <i class="fal fa-arrow-right-long"></i>
                          </button>
                          <input type="hidden" name="recaptcha_response" class="recaptchaResponse" readonly/>
                          <input type="hidden" name="email_group" value="Inquiry" readonly/>
                          <input type="hidden" name="source" value="Agent Listing" readonly/>
                          <input type="hidden" name="sub_source" value="Call Back" readonly/>
                          <input type="hidden" name="refno" value="<?php echo decodeData($row_listing['listing_id']); ?>" readonly/>
                        </div>
                      </div>
                    </div>
                  </form>
                  <?php if(!empty($row_listing['permit_number'])) { ?>
                  <div class="rera-qr-code d-flex align-items-end p15 mb0">
                    <div class="single-img">
                      <?php if(!empty($row_listing['qrcode_permit'])) { ?>
                      <img src="<?php echo localhost.'images/qrcodes/listings/'.$row_listing['listing_id'].'/'.$row_listing['qrcode_permit']; ?>" alt="RERA Permit QR Code"/>
                      <?php } else { ?>
                      <img src="images/dubai-land-department-permit.jpg" alt="RERA Permit"/>
                      <?php } ?>
                    </div>
                    <div class="single-content ml20">
                      <h4 class="rera-permit">
                        RERA Permit
                      </h4>
                      <h3 class="rera-permit-number">
                        <?php echo decodeData($row_listing['permit_number']); ?>
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

      <?php if($result_similar_listings->num_rows >= 4) { ?>
      <?php include_once(absolutedir."includes/similar.properties.php"); ?>
      <?php } ?>
      <?php include_once(absolutedir."includes/footer.php"); ?>

    </div>
  </div>

  <?php include_once(absolutedir."includes/handy.buttons.agent.listing.php"); ?>
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
        center                : new google.maps.LatLng(<?php echo decodeData($row_listing['coordinates']); ?>)
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
                          <h3>\
                          <?php if($row_listing['category'] == 'Residential') {
                            if(!empty($row_listing['bedrooms'])) {
                              echo $row_listing['bedrooms'].' Bed '.decodeData($row_listing['property_type']);
                            } else {
                              echo 'Studio '.decodeData($row_listing['property_type']);
                            }
                          } else {
                            echo decodeData($row_listing['property_type']);
                          }
                          ?></h3>\
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
