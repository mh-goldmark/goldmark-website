<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'General';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/headlines.php");
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
	<meta name="robots" content="noindex, nofollow"/>
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

	<?php
  $imgsize   = getimagesize(domainhost."images/".$page_og_image);
  $imgwidth  = $imgsize[0];
  $imgheight = $imgsize[1];
  $imgmime   = $imgsize['mime'];
  ?>
	<meta property="og:image" content="<?php echo domainhost."images/".$page_og_image; ?>" />
  <meta property="og:image:secure_url" content="<?php echo domainhost."images/".$page_og_image; ?>" />

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
      <!-- Error/404 Section Area -->
      <section class="our-error pt110 pt100-md">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-xl-6 wow fadeInRight d-md-block d-none" data-wow-delay="300ms">
              <div class="text-center text-xl-start">
                <img class="w-100 gray-scale" src="images/icon/gold-mark-real-estate-lost-lion.png" alt="<?php echo decodeData($company_name); ?>">
              </div>
            </div>
            <div class="col-xl-5 offset-xl-1 wow fadeInLeft" data-wow-delay="300ms">
              <div class="error_page_content mt10 mb80 mt50-lg text-center text-xl-start">
                <div class="erro_code">
                  <span class="text-thm">40</span>4
                </div>
                <h1 class="h2 error_title">
                  <?php echo decodeData(headLine('404 Error','title')); ?>
                </h1>
                <p class="text fz15 mb20">
                  <?php echo decodeData(headLine('404 Error','tagline')); ?>
                </p>
                <a href="<?php echo webhost; ?>" class="btn-dark-default" title="<?php echo decodeData($company_name); ?>">
									<i class="fal fa-arrow-right-long"></i>
                  Go Back To Home
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <?php include_once(absolutedir."includes/footer.php"); ?>

    </div>
  </div>
	<?php include_once(absolutedir."includes/handy.buttons.php"); ?>
	<?php include_once(absolutedir."includes/property.search.php"); ?>
  <?php include_once(absolutedir."includes/scripts.php"); ?>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
