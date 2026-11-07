<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Community';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/community.php");
require_once(absolutedir."query/blogs.php");
if($result_community->num_rows <= 0) {
  header('Location: '.domainhost.'404'); // Redirect to 404
  exit;
}
if(!empty($row_community['headline'])) {
  $page_title = $row_community['headline'];
} else {
  $page_title = decodeData($row_community['location']). ' | Community Guide';
}
$community_caption = decodeData($row_community['location']);
$community_url = 'community-guides/'.cleanString($row_community['location']).'/'.cleanString($page_title).'-'.$row_community['community_id'].'.html';
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <?php
  $meta_description = explode("\n", $row_community['description']);
  ?>
	<meta charset="utf-8"/>
	<meta http-equiv="x-ua-compatible" content="ie=edge"/>
	<link rel="canonical" href="<?php echo domainhost.$community_url; ?>"/>
	<title><?php echo decodeData($page_title); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="robots" content="index, follow"/>
  <?php if(!empty($row_community['tags'])) { ?>
  <meta name="keywords" content="<?php echo strtolower(decodeData($row_community['tags'])); ?>"/>
  <?php } else { ?>
  <meta name="keywords" content="<?php echo strtolower(decodeData($row_seo['keywords'])); ?>"/>
  <?php } ?>
	<meta name="title" content="<?php echo decodeData($page_title); ?>"/>
	<meta name="description" content="<?php echo decodeData(strip_tags($meta_description[0])); ?>"/>

  <meta property="og:title" content="<?php echo decodeData($page_title); ?>"/>
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="<?php echo $company_name; ?>"/>
  <meta property="og:url" content="<?php echo domainhost.$community_url; ?>" />
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
	<?php if(!empty($row_community['image'])) { ?>
  <?php
  $imgsize   = getimagesize(localhost."images/communities/default/".$row_community['community_id']."/".$row_community['image']);
  $imgwidth  = $imgsize[0];
  $imgheight = $imgsize[1];
  $imgmime 	 = $imgsize['mime'];
  ?>
	<meta property="og:image" content="<?php echo localhost; ?>images/communities/default/<?php echo $row_community['community_id']; ?>/<?php echo $row_community['image']; ?>" />
	<meta property="og:image:secure_url" content="<?php echo localhost; ?>images/communities/default/<?php echo $row_community['community_id']; ?>/<?php echo $row_community['image']; ?>" />
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
                url("<?php echo localhost.'images/communities/default/'.$row_community['community_id'].'/'.$row_community['image']; ?>") no-repeat;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    /* height: calc(100vh - 130px); */
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
    /* .project-default-img {
    	height: calc(100vh);
    } */
    .listing-details .breadcumb-style1 .sharing a.sharer-btn {
      top: -60px;
    }
    .listing-details .breadcumb-style1 .sharing .sharing-option-buttons {
      top: -25px;
    }
  }
  </style>

</head>
<body class="community-body">
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
                    <h1 class="title">
                      <?php echo decodeData($row_community['location']); ?>
                    </h1>
                    <h4 class="developer">
                      <a href="#findmap" class="pagescroll" title="Find on Google Map">
                        Click to find on the map
                      </a>
                    </h4>
                  </div>
                  <div class="col-12 col-lg-3 col-md-5">
                    <a class="download-brochure" href="gold-mark-real-estate-team.html" title="Find an expert">
                      <span class="flaticon-user"></span>
                      Find an expert
                    </a>
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
                  <a href="ommunities.html" title="Back to communities">
                    Back to Popular commuinities
                  </a>
                  <h3 class="d-inline">
                    <?php echo decodeData($row_community['location']); ?>
                  </h3>
                </div>
                <div class="col-12 col-lg-4 col-md-5 mt15-sm sharing">
        					<a href="#" class="sharer-btn">
                    <span class="flaticon-share-1 mr10"></span>
                    Share this community
                  </a>
                  <div class="sharing-option-buttons">
                    <div class="row justify-content-between align-items-center">
                      <div class="facebook-share">
                        <a href="https://www.facebook.com/sharer.php?u=<?php echo domainhost.$community_url; ?>" class="share-icon" title="Share to Facebook" target="_blank">
                          <i class="fa fa-facebook"></i>
                        </a>
                      </div>
                      <div class="twitter-share">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo domainhost.$community_url; ?>" class="share-icon" title="Share to Twitter" target="_blank">
                          <i class="fab fa-twitter"></i>
                        </a>
                      </div>
                      <div class="linkedin-share">
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo domainhost.$community_url; ?>" class="share-icon" title="Share to Linkedin" target="_blank">
                          <i class="fab fa-linkedin"></i>
                        </a>
                      </div>
                      <div class="whatsapp-share">
                        <a href="https://api.whatsapp.com/send?text=<?php echo domainhost.$community_url; ?>" class="share-icon" title="Share via WhatsApp" target="_blank">
                          <i class="fab fa-whatsapp"></i>
                        </a>
                      </div>
                      <div class="copy-share">
                        <a href="<?php echo domainhost.$community_url; ?>" class="share-icon copy-link" title="Copy Link">
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

      <section class="community-items-details pt30 pb20">
        <div class="container">
          <div class="row justify-content-between align-items-start">
            <?php while($row_community_features = $result_community_features->fetch_assoc()) { ?>
            <div class="col-6 col-lg-2 col-md-4 feature-item mb30">
              <h4>
                <?php echo decodeData($row_community_features['details']); ?>
              </h4>
              <h6>
                <?php echo decodeData($row_community_features['description']); ?>
              </h6>
            </div>
            <?php } ?>
          </div>
        </div>
      </section>

      <!-- Property Images -->
      <section class="pt0 pb0 mt-30 listing-details bgc-white">
        <div class="container">
          <div class="row mt30 wow fadeInUp" data-wow-delay="300ms">
            <div class="col-12">
              <div class="ps-widget bgc-white bdrs0 mb50 overflow-hidden position-relative">
                <h4 class="title mb20">
                  About <?php echo decodeData($row_community['location']); ?>
                </h4>
                <p class="text">
                  <?php echo decodeData($row_community['description']); ?>
                </p>
              </div>
            </div>
            <div class="col-md-8">
              <div class="sp-img-content at-sp-v2 mb15-md">
                <?php if($watermark_array_defaults[0] == true) { ?>
                <a class="venobox preview-img-1 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/watermark/community?filename='.$images_array_defaults[0].'&id='.$row_community['community_id']; ?>');" href="<?php echo localhost.'images/watermark/community?filename='.$images_array_defaults[0].'&id='.$row_community['community_id']; ?>" title="<?php if(!empty($caption_array_defaults[0])) { echo decodeData($caption_array_defaults[0]); } else { echo $community_caption; } ?>">
                </a>
                <?php } else { ?>
                <a class="venobox preview-img-1 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/communities/'.$row_community['community_id'].'/'.$images_array_defaults[0]; ?>');" href="<?php echo localhost.'images/communities/'.$row_community['community_id'].'/'.$images_array_defaults[0]; ?>" title="<?php if(!empty($caption_array_defaults[0])) { echo decodeData($caption_array_defaults[0]); } else { echo $community_caption; } ?>">
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
                    <a class="venobox preview-img-3 sp-img mb10" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/watermark/community?filename='.$images_array_defaults[1].'&id='.$row_community['community_id']; ?>');" href="<?php echo localhost.'images/watermark/community?filename='.$images_array_defaults[1].'&id='.$row_community['community_id']; ?>" title="<?php if(!empty($caption_array_defaults[1])) { echo decodeData($caption_array_defaults[1]); } else { echo $community_caption; } ?>">
                    </a>
                    <?php } else { ?>
                    <a class="venobox preview-img-3 sp-img mb10" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/communities/'.$row_community['community_id'].'/'.$images_array_defaults[1]; ?>');" href="<?php echo localhost.'images/communities/'.$row_community['community_id'].'/'.$images_array_defaults[1]; ?>" title="<?php if(!empty($caption_array_defaults[1])) { echo decodeData($caption_array_defaults[1]); } else { echo $community_caption; } ?>">
                    </a>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-sm-12 ps-lg-0">
                  <div class="sp-img-content at-sp-v2">
                    <?php if($watermark_array_defaults[2] == true) { ?>
                    <a class="venobox preview-img-5 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/watermark/community?filename='.$images_array_defaults[2].'&id='.$row_community['community_id']; ?>');" href="<?php echo localhost.'images/watermark/community?filename='.$images_array_defaults[2].'&id='.$row_community['community_id']; ?>" title="<?php if(!empty($caption_array_defaults[2])) { echo decodeData($caption_array_defaults[2]); } else { echo $community_caption; } ?>">
                    </a>
                    <?php } else { ?>
                    <a class="venobox preview-img-5 sp-img" data-gall="listing-gallery" style="background-image: url('<?php echo localhost.'images/communities/'.$row_community['community_id'].'/'.$images_array_defaults[2]; ?>');" href="<?php echo localhost.'images/communities/'.$row_community['community_id'].'/'.$images_array_defaults[2]; ?>" title="<?php if(!empty($caption_array_defaults[2])) { echo decodeData($caption_array_defaults[2]); } else { echo $community_caption; } ?>">
                    </a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
            <?php while($row_images = $result_images->fetch_assoc()) { ?>
            <?php if($row_images['watermark'] == true) { ?>
            <a class="venobox img-primary" data-gall="listing-gallery" href="<?php echo localhost.'images/watermark/community?filename='.$row_images['image_name'].'&id='.$row_community['community_id']; ?>" title="<?php if(!empty($row_images['image_caption'])) { echo decodeData($row_images['caption']); } else { echo $community_caption; } ?>"></a>
            <?php } else { ?>
            <a class="venobox" data-gall="listing-gallery" href="<?php echo localhost.'images/communities/'.$row_community['community_id'].'/'.$row_images['image_name']; ?>" title="<?php if(!empty($row_images['caption'])) { echo decodeData($row_images['image_caption']); } else { echo $community_caption; } ?>"></a>
            <?php } ?>
            <?php } ?>
          </div>
        </div>
      </section>
      <!-- Property Images -->

      <section class="listing-details pt0 pb60">
        <div class="container">
          <div class="row wrap wow fadeInUp" data-wow-delay="500ms">
            <div class="col-lg-12">
              <?php if(!empty($row_community['amenities'])) { ?>
              <div class="ps-widget bgc-white mt40 mb30 overflow-hidden position-relative">
                <h4 class="title mb20">
                  Amenities
                </h4>
                <div class="row features-amenities">
                  <?php if(!empty($row_community['amenities'])) {
                    $amenities = explode(',',$row_community['amenities']);
                    foreach($amenities as $amenity) {
                  ?>
                  <div class="col-md-4 col-sm-6">
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

              <div id="findmap" class="ps-widget bgc-white mt80 overflow-hidden position-relative">
                <h4 class="title mb0">
                  Community address
                </h4>
                <h6 class="location mb20">
                  <?php echo decodeData($row_community['location']); ?>
                </h6>
                <div class="row">
                  <div class="col-lg-12">
                    <div id="listing-map"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <?php include_once(absolutedir."includes/blogs.php"); ?>
      <?php include_once(absolutedir."includes/footer.php"); ?>

    </div>
  </div>

  <?php include_once(absolutedir."includes/handy.buttons.php"); ?>
  <?php include_once(absolutedir."includes/property.search.php"); ?>
  <?php include_once(absolutedir."includes/scripts.php"); ?>

  <script>
  //  Fixed sidebar Custom Script For That
  $(function(){
    'use strict'

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
        center                : new google.maps.LatLng(<?php echo decodeData($row_community['coordinates']); ?>)
      };

      var map = new google.maps.Map(document.getElementById('listing-map'),mapOptions);

      //add a marker1
      var marker = new google.maps.Marker({
        position  : map.getCenter(),
        map       : map,
        icon      : 'images/icons/marker-icon.png'
      });

      //show info box for marker1
      var contentString = "<div class='info-box'>\
                          <h3><?php echo decodeData($row_community['location']); ?></h3>\
                          <span><?php echo decodeData($page_title); ?></span>\
                          </div>";

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
