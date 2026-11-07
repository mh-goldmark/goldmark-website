<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Career';
$widgets_page = 'General';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/sliders.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/vacancies.php");
require_once(absolutedir."query/widgets.php");
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
                    Join the team
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

			<!-- Page Banner -->
			<?php if($result_sliders->num_rows >= 1) { ?>
      <section class="page-banner pb10 pt-0">
        <div class="container position-relative">
          <div class="row">
            <div class="col-lg-12">
							<div class="sliders-wrapper" style="background-image: url('<?php echo localhost.'images/banners/'.$row_sliders['image']; ?>') !important;">
							</div>
            </div>
          </div>
					<div class="news-room-taglines">
						<h3 class="title">
							<?php echo decodeData(headLine('Career','title')); ?>
						</h3>
						<h1 class="tagline">
							<?php echo decodeData(nl2br(headLine('Career','tagline'))); ?>
						</h1>
					</div>
        </div>
      </section>
			<?php } else { ?>
			<hr class="mt0"/>
			<section class="pt20 pt0-md pb20 pb0-md media">
				<div class="container-fluid">
					<div class="row mt30 wow fadeInUp blogs-articles" data-wow-delay="700ms">
						<div class="col-12">
							<div class="cta-style4 position-relative text-center">
								<h3 class="cta-title fw400 mb30">
									<?php echo decodeData(headLine('Career','title')); ?>
								</h3>
								<h1 class="sub-title fz16 fw400 mb20 mb0-md">
									<?php echo decodeData(nl2br(headLine('Career','tagline'))); ?>
								</h1>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php } ?>

			<?php include_once(absolutedir."includes/widgets.php"); ?>
	    <?php include_once(absolutedir."includes/vacancies.php"); ?>

			<!-- About Us -->
			<!--
      <section class="pt60 pb90 pt0-md pb0-md">
        <div class="container">
          <div class="row align-items-center">
						<div class="col-md-6 col-xl-5 wow fadeInRight" data-wow-delay="300ms">
              <div class="row align-items-center mb0-sm position-relative">
								<img class="about-img" src="images/gold-mark-real-estate-team.webp" alt="Gold Mark Real Estate team"/>
              </div>
            </div>
            <div class="col-md-6 col-xl-6 offset-xl-1 wow fadeInLeft" data-wow-delay="100ms">
              <div class="cta-style6 mt30-md mb60-sm">
								<h3 class="cta-title mb15">
									<?php //echo decodeData(headLine('Join The Team','headline')); ?>
								</h3>
                <h2 class="cta-title mb25">
									<?php //echo decodeData(headLine('Join The Team','title')); ?>
								</h2>
                <p class="cta-text fz15 mb50 text-start">
									<?php //echo decodeData(nl2br(headLine('Join The Team','tagline'))); ?>
								</p>
              </div>
            </div>
          </div>
        </div>
      </section>
			!-->
			<!-- About Us -->

			<?php include_once(absolutedir."includes/career.php"); ?>
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

		$(".apply-now").on("click", function() {
			var $vacancy = $(this).data("vacancy");
			$('select[name=vacancy]').selectpicker('val',$vacancy);
		});

  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
