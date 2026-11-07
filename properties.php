<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
require_once(absolutedir."query/listings.php");
$current_page = 'Properties';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/sliders.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/offplans.php");
}
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

	<?php include_once(absolutedir."includes/head.php"); ?>
</head>
<body>
  <?php include_once(absolutedir."includes/header.php"); ?>

  <div class="wrapper ovh">
    <?php include_once(absolutedir."includes/menu.php"); ?>

    <div class="body_content">

      <!-- Search Form -->
      <section class="search-form pt110 pb20 pt85-md">
        <div class="container-fluid">
          <form name="searchForm" method="GET" action="properties">
            <div class="row justify-content-between align-items-center basic-search">
              <div class="col-lg-4 col-md-12 col-12 mb15-md">
                <div class="advance-search-field position-relative text-start">
                  <div class="box-search">
                    <span class="icon flaticon-search"></span>
                    <input class="form-control bgc-f7 bdrs12" type="text" name="location" placeholder="Location, Building or Tower Name." autocomplete="off"/>
										<input type="hidden" name="category" autocomplete="off" readonly value="<?php echo $_GET['category']; ?>"/>
                  </div>
                </div>
              </div>
              <div class="col-lg-1 col-md-3 col-sm-6 col-12 br-light mb15-md">
                <div class="form-style2 input-group">
                  <select name="class" class="selectpicker" data-live-search="true" data-width="100%">
										<option value="All" data-tokens="All" <?php if(empty($_GET['class']) || $_GET['class'] == 'All') { echo 'selected'; } ?>>All</option>
                    <option value="Sale" data-tokens="Sale" <?php if($_GET['class'] == 'Sale') { echo 'selected'; } ?>>Buy</option>
                    <option value="Rent" data-tokens="Rent" <?php if($_GET['class'] == 'Rent') { echo 'selected'; } ?>>Rent</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-2 col-md-4 col-sm-6 col-12 br-light mb15-md">
                <div class="form-style2 input-group">
                  <select name="type" class="selectpicker" data-live-search="true" data-width="100%">
                    <option value="" <?php if(empty($_GET['type'])) { echo 'selected'; } ?>>All Types</option>
                    <?php while($row_property_types = $result_property_types->fetch_assoc()) { ?>
                    <?php if($_GET['type'] == $row_property_types['property_type']) { ?>
                    <option value="<?php echo decodeData($row_property_types['property_type']); ?>" data-tokens="<?php echo decodeData($row_property_types['property_type']); ?>" selected><?php echo decodeData($row_property_types['property_type']); ?></option>
                    <?php } else { ?>
                    <option value="<?php echo decodeData($row_property_types['property_type']); ?>" data-tokens="<?php echo decodeData($row_property_types['property_type']); ?>"><?php echo decodeData($row_property_types['property_type']); ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-lg-2 col-md-3 col-sm-6 col-12 br-light mb15-md">
                <div class="form-style2 input-group">
									<?php if(empty($_GET['category']) || $_GET['category'] == 'Residential') { ?>
                  <select name="minbed" class="selectpicker" data-live-search="true" data-width="100%">
                    <option value="" <?php if($_GET['minbed'] == '') { echo 'selected'; } ?>>All Bed</option>
                    <option value="0" <?php if($_GET['minbed'] == '0') { echo 'selected'; } ?>>ST</option>
                    <option value="1" <?php if($_GET['minbed'] == '1') { echo 'selected'; } ?>>1 Bed</option>
                    <option value="2" <?php if($_GET['minbed'] == '2') { echo 'selected'; } ?>>2 Bed</option>
                    <option value="3" <?php if($_GET['minbed'] == '3') { echo 'selected'; } ?>>3 Bed</option>
                    <option value="4" <?php if($_GET['minbed'] == '4') { echo 'selected'; } ?>>4 Bed</option>
                    <option value="5" <?php if($_GET['minbed'] == '5') { echo 'selected'; } ?>>5 Bed</option>
                    <option value="6" <?php if($_GET['minbed'] == '6') { echo 'selected'; } ?>>6 Bed</option>
                    <option value="7+" <?php if($_GET['minbed'] == '7+') { echo 'selected'; } ?>>7+ Bed</option>
                  </select>
									<?php } else { ?>
									<select name="minsize" class="selectpicker" data-live-search="true" data-width="100%">
	                  <option value="" <?php if($_GET['minsize'] == '') { echo 'selected'; } ?>>Min Size</option>
	                  <option value="500" <?php if($_GET['minsize'] == '500') { echo 'selected'; } ?>>500 sqft</option>
	                  <option value="1000" <?php if($_GET['minsize'] == '1000') { echo 'selected'; } ?>>1 000 sqft</option>
	                  <option value="1500" <?php if($_GET['minsize'] == '1500') { echo 'selected'; } ?>>1 500 sqft</option>
	                  <option value="2000" <?php if($_GET['minsize'] == '2000') { echo 'selected'; } ?>>2 000 sqft</option>
	                  <option value="2500" <?php if($_GET['minsize'] == '2500') { echo 'selected'; } ?>>2 500 sqft</option>
	                  <option value="3000" <?php if($_GET['minsize'] == '3000') { echo 'selected'; } ?>>3 000 sqft</option>
	                  <option value="3500" <?php if($_GET['minsize'] == '3500') { echo 'selected'; } ?>>3 500 sqft</option>
	                  <option value="4000+" <?php if($_GET['minsize'] == '4000+') { echo 'selected'; } ?>>4 000+ sqft</option>
	                </select>
									<?php } ?>
                </div>
              </div>
              <div class="col-lg-1 col-md-6 col-sm-6 col-12">
                <button class="light-btn-search slider-search" type="button">
                  <span class="flaticon-settings"></span>
                  Filters
                </button>
              </div>
              <div class="col-lg-2 col-md-6 col-sm-12 col-12">
                <button class="search-btn-now-light" type="submit">
									<span class="flaticon-search-1"></span>
                  Search Now
                </button>
                <input type="hidden" name="maxbed" autocomplete="off" readonly value="<?php echo $_GET['maxbed']; ?>"/>
								<input type="hidden" name="maxsize" autocomplete="off" readonly value="<?php echo $_GET['maxsize']; ?>"/>
                <input type="hidden" name="sort" autocomplete="off" value="<?php if(!empty($_GET['sort'])) { echo $_GET['sort']; } else { echo 'recent'; } ?>" readonly/>
              </div>
            </div>
          </form>
        </div>
      </section>

      <!-- Breadcumb Sections -->
      <section class="breadcumb-section bg-white pb20 pt80-sm">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <div class="breadcumb-style1 d-md-flex align-items-start w-100">
                <div class="col-12 col-lg-8 col-md-6 indicator-results">
                  <h1 class="title">
                    <?php echo $search_title; ?>
                  </h1>
                  <h4 class="results-counted mb0">
                    <?php if($total['total'] >= 1) { ?>
                      <?php echo number_format($total['total'],0); ?> <?php if($total['total'] == 1) { echo 'record'; } else { echo 'records'; } ?> found
                    <?php } else { ?>
                      No record found
                    <?php } ?>
                  </h4>
                </div>
                <div class="col-12 col-lg-4 col-md-6 mt20-sm">
									<div class="row pr15 justify-content-between align-items-center">
										<div class="col-6 pl15-md pl0">
		        					<form name="mapForm" method="GET" action="map">
		        						<input type="hidden" name="category" autocomplete="off" readonly value="<?php if(!empty($_GET['category'])) { echo $_GET['category']; } else { echo 'Residential'; } ?>"/>
		        						<input type="hidden" name="class" autocomplete="off" readonly value="<?php if(empty($_GET['class']) || $_GET['class'] == 'All') { echo 'All'; } else { echo $_GET['class']; } ?>"/>
		        						<input type="hidden" name="location" autocomplete="off" readonly value="<?php echo $_GET['location']; ?>"/>
		        						<input type="hidden" name="type" autocomplete="off" readonly value="<?php echo $_GET['type']; ?>"/>
		        						<input type="hidden" name="minbed" autocomplete="off" readonly value="<?php echo $_GET['minbed']; ?>"/>
												<input type="hidden" name="maxbed" autocomplete="off" readonly value="<?php echo $_GET['maxbed']; ?>"/>
		        						<input type="hidden" name="minsize" autocomplete="off" readonly value="<?php echo $_GET['minsize']; ?>"/>
		        						<input type="hidden" name="maxsize" autocomplete="off" readonly value="<?php echo $_GET['maxsize']; ?>"/>
		        						<input type="hidden" name="minprice" autocomplete="off" readonly value="<?php echo $_GET['minprice']; ?>"/>
		        						<input type="hidden" name="maxprice" autocomplete="off" readonly value="<?php echo $_GET['maxprice']; ?>"/>
		        						<input type="hidden" name="sort" autocomplete="off" value="<?php if(!empty($_GET['sort'])) { echo $_GET['sort']; } else { echo 'default'; } ?>" readonly/>
												<button type="submit" class="view-map-button">
													<img src="images/map.svg" alt="View on map"/>
													<span class="flaticon-maps"></span>
													View on map
												</button>
		        					</form>
										</div>
										<div class="col-6 sort-order">
											<span class="flaticon-settings"></span>
		        					<form name="sortForm" method="GET" action="properties">
		        						<input type="hidden" name="category" autocomplete="off" readonly value="<?php if(!empty($_GET['category'])) { echo $_GET['category']; } else { echo 'Residential'; } ?>"/>
		        						<input type="hidden" name="class" autocomplete="off" readonly value="<?php if(empty($_GET['class']) || $_GET['class'] == 'All') { echo 'All'; } else { echo $_GET['class']; } ?>"/>
		        						<input type="hidden" name="location" autocomplete="off" readonly value="<?php echo $_GET['location']; ?>"/>
		        						<input type="hidden" name="type" autocomplete="off" readonly value="<?php echo $_GET['type']; ?>"/>
		        						<input type="hidden" name="minbed" autocomplete="off" readonly value="<?php echo $_GET['minbed']; ?>"/>
												<input type="hidden" name="maxbed" autocomplete="off" readonly value="<?php echo $_GET['maxbed']; ?>"/>
		        						<input type="hidden" name="minsize" autocomplete="off" readonly value="<?php echo $_GET['minsize']; ?>"/>
		        						<input type="hidden" name="maxsize" autocomplete="off" readonly value="<?php echo $_GET['maxsize']; ?>"/>
		        						<input type="hidden" name="minprice" autocomplete="off" readonly value="<?php echo $_GET['minprice']; ?>"/>
		        						<input type="hidden" name="maxprice" autocomplete="off" readonly value="<?php echo $_GET['maxprice']; ?>"/>
		        						<select name="sort" class="selectpicker" data-live-search="true" data-width="100%">
		        							<option value="default" <?php if(empty($_GET['sort']) || $_GET['sort'] == 'default') { echo 'selected'; } ?>>Default</option>
													<option value="verified" <?php if($_GET['sort'] == 'verified') { echo 'selected'; } ?>>Verified</option>
													<option value="premium" <?php if($_GET['sort'] == 'premium') { echo 'selected'; } ?>>Premium</option>
		                      <option value="featured" <?php if($_GET['sort'] == 'featured') { echo 'selected'; } ?>>Featured</option>
													<?php if(!empty($_GET['class']) && $_GET['class'] != 'All') { ?>
		        							<option value="hprice" <?php if($_GET['sort'] == 'hprice') { echo 'selected'; } ?>>Highest Price</option>
		        							<option value="lprice" <?php if($_GET['sort'] == 'lprice') { echo 'selected'; } ?>>Lowest Price</option>
													<?php } ?>
		        							<option value="hsize" <?php if($_GET['sort'] == 'hsize') { echo 'selected'; } ?>>Highest Size</option>
		        							<option value="lsize" <?php if($_GET['sort'] == 'lsize') { echo 'selected'; } ?>>Lowest Size</option>
		        							<?php if($_GET['category'] != 'Commercial') { ?>
		        							<option value="mbed" <?php if($_GET['sort'] == 'mbed') { echo 'selected'; } ?>>Most Bedrooms</option>
		        							<option value="lbed" <?php if($_GET['sort'] == 'lbed') { echo 'selected'; } ?>>Least Bedrooms</option>
		        							<?php } ?>
		        						</select>
		        					</form>
										</div>
									</div>
        				</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Property All Lists -->
      <section class="pt0 pb90 bg-white bgc-f7">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">
              <!-- Property start -->
              <div class="property-list-content">
                <div class="infinite-scroll">
                  <div class="infinite-paging">
                    <a class="jscroll-next button" href="listings.php?page=1<?php echo $param; ?>">
											<span class="flaticon-new-tab"></span>
                      Load More
                    </a>
                  </div>
                </div>

                <div class="clearfix"></div>

                <div class="rows-counter">
                  <span>
                    Displaying <span></span> of <?php echo number_format($total['total'],0); ?>
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <?php include_once(absolutedir."includes/offplans.php"); ?>
      <?php include_once(absolutedir."includes/footer.php"); ?>

    </div>
  </div>

	<?php include_once(absolutedir."includes/handy.buttons.php"); ?>
  <?php include_once(absolutedir."includes/property.search.php"); ?>
	<?php include_once(absolutedir."includes/scripts.php"); ?>

  <script>
  $(function(){
    'use strict'
    $('.infinite-scroll').jscroll({
      autoTrigger   : false,
      loadingHtml   : '<div class="scroll-loading"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div>',
      nextSelector  : 'a.jscroll-next:last',
      callback      : function() {
        var $rowsCount = $(".jscroll-inner").find(".items-listings").length;
        $(".rows-counter span span").text($rowsCount);
        if($rowsCount < 1) {
          $(".infinite-paging").hide();
          $(".rows-counter").hide();
        } else {
          $(".infinite-paging").show();
          $(".rows-counter").show();
        }
				var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
				var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
						return new bootstrap.Tooltip(tooltipTriggerEl)
				});
      }
    });

    $('.infinite-paging a.jscroll-next').trigger('click');

    $("body").on("change", "form[name=sortForm] select[name=sort]", function(event) {
	    $('form[name=sortForm]').submit();
		});

    $("body").on("change", "form[name=searchForm] select[name=minbed]", function(event) {
	    $('form[name=searchForm]').find("input[name=maxbed]").val($(this).val());
			setTimeout(function(){
				$('form[name=searchForm]').submit();
			},200);
		});

		$("body").on("change", "form[name=searchForm] select[name=minsize]", function(event) {
	    $('form[name=searchForm]').find("input[name=maxsize]").val($(this).val());
			setTimeout(function(){
				$('form[name=searchForm]').submit();
			},200);
		});

		$("body").on("change", ".basic-search select[name=class], .basic-search select[name=type]", function(event) {
	    $('form[name=searchForm]').submit();
		});

		<?php if($_GET['category'] == 'Commercial') { ?>
		$(".search-bedroom").hide();
    $("form[name=advSearch]").find("select[name=minbed]").attr("disabled","disabled");
    $("form[name=advSearch]").find("select[name=maxbed]").attr("disabled","disabled");
    $("form[name=advSearch]").find(".selectpicker.bedroom").selectpicker();
		<?php } ?>
  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
