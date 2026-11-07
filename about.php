<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'About';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/sliders.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/widgets.php");
require_once(absolutedir."query/testimonials.php");
}
$request = parse_url($_SERVER['REQUEST_URI']);
$path 	 = $request["path"];
$uri     = ltrim($path,'/');
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="x-ua-compatible" content="ie=edge"/>
	<link rel="canonical" href="<?php echo domainhost.$uri; ?>"/>
	<title><?php echo decodeData($row_seo['title']); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="robots" content="index, follow"/>
	<meta name="keywords" content="<?php echo decodeData($row_seo['keywords']); ?>"/>
	<meta name="title" content="<?php echo decodeData($row_seo['title']); ?>"/>
	<meta name="description" content="<?php echo decodeData($row_seo['description']); ?>"/>

  <meta property="og:title" content="<?php echo decodeData($row_seo['title']); ?>"/>
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
			<!-- Breadcumb Sections -->
      <section class="breadcumb-section general-page bg-white pb20 pt110 pb5-md pt70-md">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="breadcumb-style1 d-md-flex align-items-start w-100">
                <div class="col-12 bread-crumb">
                  <a href="<?php echo domainhost; ?>" title="Back to Home">
                    Home
                  </a>
									<span class="arrow"></span>
                  <h3 class="d-inline">
                    About us
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

			<!-- Manager -->
	    <section class="manager-story about-us pb40 pt0">
	      <div class="container">
	        <div class="row wrap">
	          <div class="col-lg-5 col-md-6 col-12 wow fadeInLeft" data-wow-delay="300ms">
							<div class="column">
								<div class="manager-img">
									<!--<img src="images/gold-mark-real-estate-1080x1080.svg" alt="<?php //echo decodeData($company_name); ?>"/>!-->
									<img src="<?php echo localhost.'images/about/'.$company_about_image; ?>" alt="<?php echo decodeData($company_name); ?>"/>
		            </div>
							</div>
	          </div>
	          <div class="col-lg-7 col-md-6 col-12 wow fadeInRight" data-wow-delay="300ms">
	            <div class="story-content mt0 mt30-md">
	              <h3 class="headline mb10">
									<?php echo decodeData(headLine('About','headline')); ?>
								</h3>
	              <h1 class="title mb20">
									<?php echo decodeData(headLine('About','title')); ?>
								</h1>
								<?php
								//$about_details = explode("\n", $company_about);
								?>
	              <p class="text">
									<?php echo decodeData($company_about); ?>
									<!--
									<?php //echo decodeData($about_details[0]); ?>
									<br/>
									<?php //echo decodeData($about_details[2]); ?>
									<br/>
									<?php //echo decodeData($about_details[4]); ?>
									!-->
								</p>
	            </div>
	          </div>
						<!--
						<div class="col-12 wow fadeInLeft" data-wow-delay="300ms">
							<div class="story-content mt30 mt15-md pl0">
								<p class="text">
									<?php //echo decodeData($about_details[6]); ?>
									<br/>
									<?php //echo decodeData($about_details[8]); ?>
									<br/>
									<?php //echo decodeData($about_details[10]); ?>
								</p>
							</div>
						</div>
						!-->
	        </div>
	      </div>
	    </section>
			<!-- Manager -->

			<section class="pt80 pb120 about-widget bg-light">
				<div class="container">
					<div class="row">
						<div class="col-xl-8 col-12 mx-auto wow fadeInUp" data-wow-delay="300ms">
							<div class="cta-style4 position-relative text-center">
								<h3 class="cta-title mb60">
									Why choose us?
								</h3>
							</div>
						</div>
					</div>
					<div class="row choose-us-wrapper">
						<div class="choose-us d-lg-flex justify-content-center align-items-start pt20 pb20 wow fadeInUp" data-wow-delay="300ms">
							<?php while($row_widgets = $result_widgets->fetch_assoc()) { ?>
							<div class="col-6 col-md-4 col-lg-2 mb30-lg text-center widget-item">
								<div class="contact-icon text-gray">
									<img class="widget-icon" src="<?php echo localhost.'images/widgets/'.cleanString($row_widgets['category']).'/'.$row_widgets['icon']; ?>" alt="<?php echo decodeData($row_widgets['label']); ?>"/>
								</div>
								<div class="contact-label">
									<?php echo decodeData(wordwrap($row_widgets['label'],15, "<br/>",true)); ?>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</section>

			<!-- Mission & Vision Section Area -->
	    <section class="mission-vision cta-banner-dark pt80 pb80">
	      <div class="container">
					<div class="row">
						<div class="col-xl-8 col-12 mx-auto wow fadeInUp" data-wow-delay="300ms">
							<div class="cta-style4 position-relative text-center">
								<h3 class="cta-title text-white mb60">
									Mission & Vision
								</h3>
							</div>
						</div>
					</div>
					<div class="row wow fadeInUp" data-wow-delay="300ms">
						<p class="text-white fz19 mb40">
							<?php echo nl2br(decodeData($company_mission)); ?>
						</p>
						<p class="text-white fz19">
							<?php echo nl2br(decodeData($company_vision)); ?>
						</p>
					</div>
				</div>
			</section>

			<?php include_once(absolutedir."includes/testimonials.php"); ?>
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

		var cols = $('.wrap .column');
    var enabled = true;
    var scrollbalance = new ScrollBalance(cols, {
      minwidth: 0
    });
    // bind to scroll and resize events
    scrollbalance.bind();

		$(".testimonials").find(".owl-stage").addClass("row");

  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
