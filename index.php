<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Home';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/videos.php");
require_once(absolutedir."query/sliders.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/home.php");
require_once(absolutedir."query/offplans.php");
require_once(absolutedir."query/widgets.php");
require_once(absolutedir."query/invest.php");
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="x-ua-compatible" content="ie=edge"/>
	<link rel="canonical" href="<?php echo domainhost; ?>"/>
	<title><?php echo decodeData($row_seo['title']); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="robots" content="index, follow"/>
	<meta name="keywords" content="<?php echo decodeData($row_seo['keywords']); ?>"/>
	<meta name="title" content="<?php echo decodeData($row_seo['title']); ?>"/>
	<meta name="description" content="<?php echo decodeData($row_seo['description']); ?>"/>

  <meta property="og:title" content="<?php echo decodeData($row_seo['title']); ?>"/>
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="<?php echo $company_name; ?>"/>
  <meta property="og:url" content="<?php echo domainhost; ?>" />
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

	<style>
	header.nav-homepage-style.menu-home4 {
		background-color: transparent;
		border-bottom: none;
	}
  /* @media only screen and (min-width: 768px) {
		header.nav-innerpage-style {
			background: transparent;
    	position: absolute;
    	width: 100%;
    	z-index: 1;
		}
  } */
  </style>

</head>
<body class="home-body">
  <?php include_once(absolutedir."includes/header.php"); ?>
  <div class="wrapper ovh">
  	<?php include_once(absolutedir."includes/menu.php"); ?>

    <div class="body_content">
			<!-- Home Banner Style V1 -->
	    <section class="home-banner-style1 p0" style="background-image: url('<?php echo localhost.'videos/'.$row_videos['video']; ?>') !important;">
				<video id="bgvid" loop preload="auto" playsinline autoplay="true" muted poster="<?php echo localhost.'images/banners/'.$row_sliders['image']; ?>">
	        <source src="<?php echo localhost.'videos/'.$row_videos['video']; ?>" type="video/mp4">
	      </video>
	      <div class="home-style1">
	        <div class="container">
	          <div class="row">
	            <div class="col-xl-12 mx-auto">
	              <div class="inner-banner-style1 text-center pt100">
	                <h1 class="hero-title animate-up-2">
										<?php echo decodeData(headLine('Home - Banner','title')); ?>
									</h>
	                <h2 class="hero-text animate-up-3">
										<?php echo decodeData(headLine('Home - Banner','tagline')); ?>
									</h2>
	                <div class="advance-search-tab mt30 mt20-md mx-auto animate-up-3">
	                  <div class="tab-content">
	                    <div class="tab-pane fade show active">
												<form action="properties" method="GET" class="form-search position-relative" accept-charset="utf-8">
													<div class="advance-content-style1">
														<div class="row">
															<div class="col-md-3 col-12 listing-types">
																<div class="form-style2 input-group">
																	<select name="classification" class="selectpicker" data-live-search="true" data-width="100%">
																		<option value="Residential for Sale" data-tokens="Residential for Sale" selected>Residential for Sale</option>
																		<option value="Residential for Rent" data-tokens="Residential for Rent">Residential for Rent</option>
																		<option value="Commercial" data-tokens="Commercial">Commercials</option>
																		<option value="Off Plan" data-tokens="Commercial">Off-plan Properties</option>
																	</select>
																</div>
																<input type="hidden" name="category" value="Residential" readonly/>
																<input type="hidden" name="class" value="Sale" readonly/>
															</div>
															<div class="col-md-6 col-12 pl0 pr0">
																<div class="advance-search-field position-relative text-start">
																	<div class="box-search">
																		<input class="form-control bgc-f7 bdrs12" type="text" name="location" placeholder="Location..." autocomplete="off"/>
																		<span class="icon flaticon-maps-1"></span>
																	</div>
																</div>
															</div>
															<div class="col-md-3 col-12">
																<button class="search-btn-now" type="submit">
																	<span class="flaticon-search-1"></span>
																	Find a property
																</button>
																<input type="hidden" name="sort" value="default" readonly/>
															</div>
														</div>
													</div>
												</form>
	                    </div>
	                  </div>
										<div class="row mt20">
											<div class="col-12">
												<div class="d-flex align-items-center justify-content-start justify-content-center mt-3 mt-md-0">
													<button class="advance-btn-search slider-search" type="button">
														<span class="flaticon-settings"></span>
														More Filters
													</button>
												</div>
											</div>
										</div>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </section>
			<!-- Home Banner Style V1 -->

			<!-- Featured Properties -->
			<section class="pt50 pb60 pb30-md bgc-white">
				<div class="container-fluid">
					<div class="row align-items-center wow fadeInUp" data-wow-delay="400ms">
						<div class="col-12">
							<div class="main-title2">
								<h3 class="paragraph text-center mb15">
									<?php echo decodeData(headLine('Home - Featured','headline')); ?>
								</h3>
								<h2 class="title text-center">
									<?php echo decodeData(headLine('Home - Featured','title')); ?>
								</h2>
								<div class="dark-light-navtab style2 text-center mt20">
									<ul class="nav nav-pills nav-exclusive justify-content-center justify-content-center">
										<li class="nav-item" data-type="Residential for Sale">
											<a href="#" class="active" title="Residential For Sale">
												Residential for Sale
											</a>
										</li>
										<li class="nav-item" data-type="Residential for Rent">
											<a href="#" title="Residential for Rent">
												Residential for Rent
											</a>
										</li>
										<li class="nav-item" data-type="Off-plan Properties">
											<a href="#" title="Off-plan Properties">
												Off-plan Properties
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div id="exclusiveListings" class="col-lg-12 wow fadeInUp" data-wow-delay="400ms">
	            <div class="feature-listing-slider navi_pagi_bottom_center slider-dib-sm slider-3-grid owl-carousel owl-theme">
								<?php while($row_listings = $result_listings->fetch_assoc()) { ?>
								<?php
								if(!empty($row_listings['images'])) {
									$img_listing_explode 	= explode(",",$row_listings['images']);
									$count_listing_images = count($img_listing_explode);
								} else {
									$count_listing_images = 0;
								}

								$sql_listing_image = $conn->query("SELECT image_name, image_caption, watermark FROM tbl_images WHERE reference = '".$row_listings['listing_id']."' AND image_order = 1 LIMIT 1");
								$row_listing_image = $sql_listing_image->fetch_assoc();

								if(!empty($row_listings['page_title'])) {
									$page_title = $row_listings['page_title'];
								} else {
									$page_title = $row_listings['title'];
								}
								if($row_listings['category'] == 'Commercial') {
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

								if(!empty($row_listings['building_name'])) {
									$listing_url = $url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($row_listings['building_name'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
									$listing_caption = decodeData($row_listings['building_name']);
								} elseif(!empty($row_listings['property'])) {
									$listing_url = $url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($row_listings['property'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
									$listing_caption = decodeData($row_listings['property']);
								} elseif(!empty($row_listings['sub_location'])) {
									$listing_url = $url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($row_listings['sub_location'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
									$listing_caption = decodeData($row_listings['sub_location']);
								} else {
									$listing_url = $url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
									$listing_caption = decodeData($row_listings['location']);
								}
								if(!empty($row_listing_image['image_caption'])) {
									$image_caption = $listing_caption.' - '.decodeData($row_listing_image['image_caption']);
								} else {
									$image_caption = $listing_caption;
								}
								?>
	              <div class="item">
	                <div class="listing-style1 mb30">
	                  <div class="list-thumb">
											<a href="<?php echo $listing_url; ?>" tilte="<?php echo $page_title; ?>">
												<?php //if($row_listing_image['watermark'] == true) { ?>
													<!--
													<img src="<?php //echo localhost.'images/watermark/listing?filename='.$row_listing_image['image_name'].'&id='.$row_listings['listing_id']; ?>" alt="<?php //echo $image_caption; ?>" class="w-100">
													!-->
												<?php //} else { ?>
													<img src="<?php echo localhost.'images/listings/'.$row_listings['listing_id'].'/'.$row_listing_image['image_name']; ?>" alt="<?php echo $image_caption; ?>" class="w-100">
												<?php //} ?>
											</a>
	                    <div class="list-tag d-flex">
												<div class="list-class">
													<?php echo decodeData($row_listings['listing_type']); ?>
												</div>
												<div class="listing-price"<?php if($row_listings['verified'] == true) { echo ' data-bs-toggle="tooltip" data-bs-placement="right" title="This indicates that the listing is verified by Propertyfinder"'; } ?>>
													AED <?php echo number_format($row_listings['list_price'],0); ?>
													<?php if($row_listings['verified'] == true) { ?>
													<img class="verification-icon" src="images/icon/verified-icon.svg" alt="Verified Listing"/>
													<?php } ?>
												</div>
											</div>
	                  </div>
	                  <div class="list-content">
	                    <h2 class="list-title">
												<a href="<?php echo $listing_url; ?>" title="<?php echo $page_title; ?>">
													<?php echo decodeData($row_listings['title']); ?>
												</a>
											</h2>
											<h3 class="list-location">
												<span class="icon flaticon-maps-1"></span>
												<?php
												if(!empty($row_listings['building_name'])) {
													echo decodeData($row_listings['building_name']).', '.decodeData($row_listings['sub_location']);
												} elseif(!empty($row_listings['property'])) {
													echo decodeData($row_listings['property']).', '.decodeData($row_listings['sub_location']);
												} else {
													echo decodeData($row_listings['sub_location']).', '.decodeData($row_listings['location']);
												}
												?>
											</h3>
											<div class="list-meta d-flex align-items-center">
												<?php if($row_listings['category'] == 'Residential') { ?>
												<div class="list-details mr10">
													<span class="flaticon-bed mr5"></span>
													<?php
													if(empty($row_listings['bedrooms'])) {
														echo "studio";
													} else {
														echo $row_listings['bedrooms'].' bed';
													}
													?>
												</div>
												<div class="list-details mr10">
													<span class="flaticon-shower mr5"></span>
													<?php
													if(empty($row_listings['bathrooms'])) {
														echo "-";
													} else {
														echo $row_listings['bathrooms'].' bath';
													}
													?>
												</div>
												<?php } else { ?>
												<?php
												if(in_array($row_listings['property_type'],$property_type_land)) {
												if($row_listings['plot_size'] != '0.00') {
												?>
												<div class="list-details mr10">
													AED <?php echo number_format(($row_listings['list_price']/$row_listings['plot_size']),0).' per '.$row_listings['plot_measurement']; ?>
												</div>
												<?php } ?>
												<?php } else { ?>
												<?php if($row_listings['unit_size'] != '0.00') { ?>
												<div class="list-details mr10">
													AED <?php echo number_format(($row_listings['list_price']/$row_listings['unit_size']),0).' per '.$row_listings['size_measurement']; ?>
												</div>
												<?php } ?>
												<?php } ?>
												<?php } ?>
												<div class="list-details">
													<span class="flaticon-expand mr5"></span>
													<?php
													if(in_array($row_listings['property_type'],$property_type_land)) {
														if($row_listings['plot_size'] != '0.00') {
															echo number_format($row_listings['plot_size'],0).' '.$row_listings['plot_measurement'];
														} else {
															echo '-';
														}
													} else {
														if($row_listings['unit_size'] != '0.00') {
															echo number_format($row_listings['unit_size'],0).' '.$row_listings['size_measurement'];
														} else {
															echo '-';
														}
													}
													?>
												</div>
	                    </div>
			                <hr class="mt-2 mb-3">
			                <div class="list-meta2">
			                  <div class="icons d-flex justify-content-between align-items-center">
													<a href="tel:<?php echo str_replace($string_replace_mobile,"",$row_listings['mobile']); ?>" title="Call Me">
		                        <span class="flaticon-call"></span>
		                        Call
		                      </a>
		                      <a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$row_listings['mobile']); ?>&text=Hello <?php echo decodeData($row_listings['user_name']); ?>, I found this property <?php echo decodeData($row_listings['title']); ?> [Ref <?php if($row_listings['chk_reapit'] == true) { echo decodeData($row_listings['refno']); } else { echo $refno_code.decodeData($row_listings['listing_id']); } ?>] on Gold Mark Real Estate website and I'm interested in learning more. Please contact me at your earliest convenience. Thank you!" title="Whatsapp Me" target="_blank">
		                        <span class="flaticon-whatsapp"></span>
		                        Whatsapp
		                      </a>
		                      <a class="email-agent" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Agent Listing" data-subsource="Email Lead" data-user="" data-refno="<?php if($row_listings['chk_reapit'] == true) { echo decodeData($row_listings['refno']); } else { echo $refno_code.decodeData($row_listings['listing_id']); } ?>" data-agent="<?php echo decodeData($row_listings['full_name']); ?>" data-title="<?php echo decodeData($row_listings['title']); ?>" title="Send Email">
		                        <span class="flaticon-email"></span>
		                        Email
		                      </a>
			                  </div>
			                </div>
	                  </div>
	                </div>
	              </div>
								<?php } ?>
	            </div>
	          </div>
					</div>
				</div>
			</section>
			<!-- Featured Properties -->

			<!-- Why Invest -->
      <section class="why-invest bgc-thm-light pt80 pt50-md pb90 pb50-md">
        <div class="container">
          <div class="row align-items-md-center align-items-center">
            <div class="col-lg-7 wow fadeInRight" data-wow-delay="400ms">
              <div class="cta-style6 mb60-sm">
								<h3 class="cta-title mb15">
									<?php echo decodeData(headLine('Why Invest','headline')); ?>
								</h3>
                <h2 class="cta-title mb25">
									<?php echo decodeData(headLine('Why Invest','title')); ?>
								</h2>
                <p class="cta-text fz15 mb30 text-start">
									<?php echo decodeData(nl2br(headLine('Why Invest','tagline'))); ?>
								</p>
								<div class="list-style1 mb50 mb30-md">
                  <ul class="row">
										<?php while($row_invest_list = $result_invest_list->fetch_assoc()) { ?>
                    <li class="col-md-6 col-12">
											<i class="far fa-check text-white bgc-dark fz15"></i>
											<?php echo decodeData($row_invest_list['label']); ?>
										</li>
										<?php } ?>
                  </ul>
                </div>
              </div>
            </div>
						<div class="col-lg-5 col-xl-4 offset-xl-1">
	            <div class="testimonial-slider2 navi_pagi_bottom_center slider-1-grid owl-carousel owl-theme wow fadeInUp" data-wow-delay="300ms">
								<?php while($row_invest_widgets = $result_invest_widgets->fetch_assoc()) { ?>
	              <div class="item">
	                <div class="testimonial-style1 position-relative mb25 mb40-md mb0-xs">
	                  <div class="testimonial-content">
											<img class="widget-icon" src="<?php echo localhost.'images/widgets/'.cleanString($row_invest_widgets['category']).'/'.$row_invest_widgets['icon']; ?>" alt="<?php echo decodeData($row_invest_widgets['label']); ?>"/>
	                    <h5 class="title">
												<?php echo decodeData($row_invest_widgets['label']); ?>
											</h5>
	                    <p class="text">
												<?php echo decodeData($row_invest_widgets['details']); ?>
											</p>
	                  </div>
	                </div>
	              </div>
								<?php } ?>
	            </div>
	          </div>
          </div>
        </div>
      </section>
			<!-- Why Invest -->

			<?php include_once(absolutedir."includes/call-to-action.php"); ?>

			<!-- Market Updates -->
      <section class="pt60 pb90 pb30-md">
        <div class="container">
          <div class="row align-items-center reversible-column">
						<div class="col-md-6 wow fadeInRight" data-wow-delay="400ms">
              <div class="row align-items-center">
                <div class="col-12">
                  <iframe class="frame-graph" src="graphs/market.updates.php" frameBorder="0"></iframe>
                </div>
              </div>
            </div>
            <div class="col-md-6 wow fadeInLeft" data-wow-delay="400ms">
              <div class="cta-style6 mb30-sm">
								<h3 class="cta-title mb15">
									<?php echo decodeData(headLine('Market Updates','headline')); ?>
								</h3>
                <h2 class="cta-title mb25">
									<?php echo decodeData(headLine('Market Updates','title')); ?>
								</h2>
                <p class="cta-text fz15 mb50 text-start">
									<?php echo decodeData(nl2br(headLine('Market Updates','tagline'))); ?>
								</p>
                <a class="btn-dark-default text-uppercase service-call" data-bs-toggle="modal" href="#scheduleCallToggle" role="button" data-source="Company Services" data-subsource="Call Schedule" data-title="Requesting a call back for free consultation" title="Free Consultation">
									<span class="flaticon-chat-1"></span>
									Free Consultation
								</a>
              </div>
            </div>
          </div>
        </div>
      </section>
			<!-- Market Updates -->

			<?php include_once(absolutedir."includes/offplans.php"); ?>
      <?php include_once(absolutedir."includes/footer.php"); ?>

    </div>
  </div>
  <!-- Wrapper End -->

	<?php include_once(absolutedir."includes/handy.buttons.php"); ?>
	<?php include_once(absolutedir."includes/property.search.php"); ?>
	<?php include_once(absolutedir."includes/service.popups.php"); ?>
	<?php include_once(absolutedir."includes/scripts.php"); ?>

	<script>
	$(function(){
    'use strict'

		$(document).on("change", "select[name=classification]", function(event) {
			event.preventDefault();
			var $val = $(this).val();
			if($val == 'Residential for Sale') {
				$("input[name=category]").val('Residential');
				$("input[name=class]").val('Sale');
			} else if($val == 'Residential for Rent') {
				$("input[name=category]").val('Residential');
				$("input[name=class]").val('Rent');
			} else {
				$("input[name=category]").val($val);
				$("input[name=class]").val('All');
			}
		});

		$(document).on("click", ".nav-exclusive .nav-item", function(event) {
			event.preventDefault();
			var $type 	= $(this).data("type");
			var $item 	= $(this);
			$(".nav-exclusive .nav-item").each(function() {
				if($(this) != $item) {
					$(this).find("a").removeClass("active");
				}
			});
			if(!$item.find("a").hasClass("active")) {
				$(this).find("a").addClass("active");
			}
			$("#exclusiveListings").html('<div class="col-12 text-center justify-content-center pt50 pb100"><i class="fa fa-spinner fa-spin fa-4x fa-fw"></i><span class="spinner-text">Determining hand-picked deals and offers for you...</span></div>');
			$.ajax({
				type	      : "POST",
				dataType    : "html",
				url         : "ajax/exclusive.listings.php",
				data        :   {
					type : $type
				},
				success:function(html){
					$("#exclusiveListings").html(html);
					$('.slider-3-grid').owlCarousel({
				    loop:true,
				    margin:30,
				    center:false,
				    dots:true,
				    nav:true,
				    rtl:false,
				    autoplayHoverPause:false,
				    autoplay: false,
				    singleItem: true,
				    smartSpeed: 1200,
				    navText: [
				      '<i class="far fa-arrow-left-long"></i>',
				      '<i class="far fa-arrow-right-long"></i>'
				    ],
				    responsive: {
				      0: {
				        items: 1,
				        center: false
				      },
				      480:{
				        items:1,
				        center: false
				      },
				      600: {
				        items: 1,
				        center: false
				      },
				      768: {
				        items: 2
				      },
				      992: {
				        items: 2
				      },
				      1200: {
				        items: 3
				      }
				    }
				  });
					var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
			    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
			        return new bootstrap.Tooltip(tooltipTriggerEl)
			    });
				}
			});
		});
	});
	</script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
