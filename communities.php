<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Communities';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/sliders.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/communities.php");
require_once(absolutedir."query/offplans.php");
}
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
                    Popular Communities
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Page Banner -->
			<?php if($result_sliders->num_rows >= 1) { ?>
      <section class="page-banner pb20 pt-0">
        <div class="container position-relative">
          <div class="row">
            <div class="col-lg-12">
							<div class="sliders-wrapper" style="background-image: url('<?php echo localhost.'images/banners/'.$row_sliders['image']; ?>') !important;">
							</div>
            </div>
          </div>
					<div class="news-room-taglines">
						<h3 class="title">
							<?php echo decodeData(headLine('Communities','title')); ?>
						</h3>
						<h1 class="tagline">
							<?php echo decodeData(headLine('Communities','tagline')); ?>
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
									<?php echo decodeData(headLine('Communities','title')); ?>
								</h3>
								<h1 class="sub-title fz16 fw400 mb20 mb0-md">
									<?php echo decodeData(headLine('Communities','tagline')); ?>
								</h1>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php } ?>

			<!-- Blog Section Area -->
	    <section class="our-blog pt20 pb80">
	      <div class="container">
					<div class="row communities-items">
						<div class="col-12 infinite-scroll">
							<div class="infinite-paging">
								<a class="jscroll-next button" href="areas.php?page=1">
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
	    </section>

			<?php include_once(absolutedir."includes/offplans.php"); ?>
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

		$('.infinite-scroll').jscroll({
      autoTrigger   : false,
      loadingHtml   : '<div class="scroll-loading"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div>',
      nextSelector  : 'a.jscroll-next:last',
      callback      : function() {
        var $rowsCount = $(".jscroll-inner").find(".items-listings").length;
        $(".rows-counter span span").text($rowsCount);
				$(document).find(".jscroll-added").each(function() {
					if(!$(this).hasClass("row")) {
						$(this).addClass("row");
					}
				});
        if($rowsCount < 1) {
          $(".infinite-paging").hide();
          $(".rows-counter").hide();
        } else {
          $(".infinite-paging").show();
          $(".rows-counter").show();
        }
      }
    });
    $('.infinite-paging a.jscroll-next').trigger('click');
  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
