<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
if($_GET['category'] == 'Projects') {
$current_page = 'Projects';
} else {
$current_page = 'Properties';
}
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/sliders.php");
require_once(absolutedir."query/headlines.php");
if($_GET['category'] == 'Projects') {
require_once(absolutedir."query/maps.php");
if(strpos($_SERVER['REQUEST_URI'],'.html') !== false) {
	$request 		= parse_url($_SERVER['REQUEST_URI']);
	$path 	 		= $request["path"];
	$uri     		= ltrim($path,'/');
	$page_title = decodeData($row_seo['title']);
	$robot_index= 'index, follow';
} else {
	$uri     		= ltrim($_SERVER['REQUEST_URI'],'/');
	$page_title = decodeData($row_seo['title']);
	$robot_index= 'noindex, nofollow';
}
} else {
require_once(absolutedir."query/map.php");
if(strpos($_SERVER['REQUEST_URI'],'.html') !== false) {
	$request 			= parse_url($_SERVER['REQUEST_URI']);
	$path 	 			= $request["path"];
	$uri     			= ltrim($path,'/');
	$robot_index	= 'index, follow';
	$page_title 	= ucfirst(str_replace("-"," ",str_replace(".html","",$uri))).' | '.$company_name;
	$search_title = ucfirst(str_replace("-"," ",str_replace(".html","",$uri)));
} else {
	$uri     			= ltrim($_SERVER['REQUEST_URI'],'/');
	$robot_index	= 'noindex, nofollow';
	if($_GET['category'] == 'Commecrial') {
		$page_category = 'Commercials';
	} elseif($_GET['category'] == 'Off-Plan') {
		$page_category = 'Off-plans';
	} else {
		$page_category = 'Residentials';
	}
	if($_GET['class'] == 'Rent') {
		$page_class = 'Rent';
	} else {
		$page_class = 'Sale';
	}
	if(!empty($_GET['type'])) {
		if(in_array($_GET['type'],$property_type_apartment)) {
	    $page_type = 'Apartments';
		} elseif($_GET['type'] == "Villa") {
			$page_type = 'Villas';
		} elseif($_GET['type'] == "Townhouse") {
			$page_type = 'Townhouses';
		} elseif(in_array($_GET['type'],$property_type_office)) {
			$page_type = 'Offices';
	  } elseif($_GET['type'] == "Retail") {
	    $page_type = 'Shops';
		} elseif($_GET['type'] == "Building") {
	    $page_type = 'Buildings';
		} elseif($_GET['type'] == "Land") {
	    $page_type = 'Plots';
	  } else {
			$page_type = 'Apartments';
		}
		$page_title 	= $page_type.' for '.$page_class.' | '.$company_name;
		$search_title = $page_type.' for '.$page_class;
	}	else {
		$page_title 	= $page_category.' for '.$page_class.' | '.$company_name;
		$search_title = $page_category.' for '.$page_class;
	}
}
}
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="x-ua-compatible" content="ie=edge"/>
	<link rel="canonical" href="<?php echo domainhost.$uri; ?>"/>
	<title><?php echo $page_title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="robots" content="<?php echo $robot_index; ?>"/>
	<meta name="keywords" content="<?php echo decodeData($row_seo['keywords']); ?>"/>
	<meta name="title" content="<?php echo $page_title; ?>"/>
	<meta name="description" content="<?php echo decodeData($row_seo['description']); ?>"/>

  <meta property="og:title" content="<?php echo $page_title; ?>"/>
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="<?php echo $company_name; ?>"/>
  <meta property="og:url" content="<?php echo domainhost.$uri; ?>" />
  <div itemscope itemtype="https://schema.org/Organization">
    <meta itemprop="telephone" content="<?php echo str_replace(" ","-",str_replace("+","",$company_phone)); ?>" />
    <meta itemprop="name" content="<?php echo $company_name; ?>" />
		<div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
    	<meta itemprop="streetAddress" content="<?php if(!empty($company_address)) { echo $company_address.', '; } ?><?php if(!empty($company_office)) { echo 'Office '.$company_office.', '; } ?><?php if(!empty($company_pobox)) { echo 'P.O. Box '.$company_pobox; } ?>"/>
    	<meta itemprop="addressLocality" content="<?php echo $company_city; ?>" />
    	<meta itemprop="addressCountry" content="<?php echo $company_country; ?>" />
		</div>
  </div>

  <meta property="og:description" content="<?php echo decodeData($row_seo['description']); ?>" />

	<?php if(!empty($row_sliders['image'])) { ?>
  <?php
  $imgsize   = getimagesize(localhost."images/banners/".$row_sliders['image']);
  $imgwidth  = $imgsize[0];
  $imgheight = $imgsize[1];
  $imgmime 	 = $imgsize['mime'];
  ?>
	<meta property="og:image" content="<?php echo localhost; ?>images/banners/<?php echo $row_sliders['image']; ?>" />
	<meta property="og:image:secure_url" content="<?php echo localhost; ?>images/banners/<?php echo $row_sliders['image']; ?>" />
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

			<section id="search_map_horizontal" class="noo_advanced_search_property horizontal p0 m0">
			  <div class="noo-map">
			    <div id="gmap"></div>
					<div class="gmap-search">
						<input placeholder="Search your map" type="text" autocomplete="off" id="gmap_search_input">
					</div>
					<div class="gmap-view-all">
						<div class="d-flex">
							<a class="exit-map" href="javascript:history.go(-1)" title="Exit map view">
								Exit map
							</a>
							<?php if($_GET['category'] == 'Projects') { ?>
							<a class="ud-btn2" href="projects/map.html" title="View all projects">
								View all projects
								<i class="fal fa-arrow-right-long"></i>
							</a>
							<?php } else { ?>
							<a class="ud-btn2" href="map.html" title="View all listings">
								View all listings
								<i class="fal fa-arrow-right-long"></i>
							</a>
							<?php } ?>
						</div>
					</div>
			    <div class="gmap-control">
			      <a class="gmap-mylocation" href="#" title="My Location">
			        <i class="fa fa-map-marker"></i>
			        <span>
								My Location
							</span>
			      </a>
			      <a class="gmap-full" href="#" title="Expand">
			        <i class="fa fa-expand"></i>
			      </a>
			      <a class="gmap-prev" href="#" title="Previous">
			        <i class="fa fa-angle-left"></i>
			      </a>
			      <a class="gmap-next" href="#" title="Next">
			        <i class="fa fa-angle-right"></i>
			      </a>
			    </div>
			    <div class="gmap-zoom">
			      <a href="#" class="zoom-in" title="Zoom In">
			        <i class="fa fa-plus"></i>
			      </a>
			      <a href="#" class="zoom-out" title="Zoom Out">
			        <i class="fa fa-minus"></i>
			      </a>
			    </div>
			    <div class="gmap-loading">
			      Loading Maps
			      <div class="gmap-loader">
			        <div class="rect1"></div>
			        <div class="rect2"></div>
			        <div class="rect3"></div>
			        <div class="rect4"></div>
			        <div class="rect5"></div>
			      </div>
			    </div>
			  </div>
			</section>

			<div class="clearfix"></div>

      <?php include_once(absolutedir."includes/footer.php"); ?>

    </div>
  </div>

	<?php include_once(absolutedir."includes/handy.buttons.php"); ?>
  <?php include_once(absolutedir."includes/property.search.php"); ?>
	<?php include_once(absolutedir."includes/scripts.php"); ?>

	<script src="<?php echo path; ?>js/map.js"></script>
	<?php
	if($_GET['category'] == 'Projects') {
		include_once(absolutedir."includes/maps.php");
	} else {
		include_once(absolutedir."includes/map.php");
	}
	?>

  <script>
  $(function(){
    'use strict'

  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
