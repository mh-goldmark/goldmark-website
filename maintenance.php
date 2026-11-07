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
  <div itemscope itemtype="https://schema.org/">
    <meta itemprop="telephone" content="<?php echo str_replace(" ","-",str_replace("+","",$company_phone)); ?>" />
    <meta itemprop="name" content="<?php echo $company_name; ?>" />
    <meta itemprop="streetAddress" content="<?php if(!empty($company_address)) { echo $company_address.', '; } ?><?php if(!empty($company_office)) { echo 'Office '.$company_office.', '; } ?><?php if(!empty($company_pobox)) { echo 'P.O. Box '.$company_pobox; } ?>"/>
    <meta itemprop="addressLocality" content="<?php echo $company_city; ?>" />
    <meta itemprop="addressCountry" content="<?php echo $company_country; ?>" />
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

	<style>
	.body_content .under-maintenance {
		background-position: top right;
	  background-repeat: no-repeat;
	  background-size: cover;
	  position: relative;
		background-color: #000;
	  background-image: url('../images/background/lion-bg-light.svg');
		width: 100%;
		height: 100vh;
	}
	.body_content .under-maintenance .fa-cog {
		color: #d88d2a;
		font-size: 380px;
		background: -webkit-linear-gradient(#f0bc1b, #d88d2a);
	  -webkit-background-clip: text;
	  -webkit-text-fill-color: transparent;
	}
	@media only screen and (max-width: 991px) {
		.body_content .under-maintenance .fa-cog {
			font-size: 200px;
		}
	}
	@media only screen and (max-width: 767px) {
		.body_content .under-maintenance .fa-cog {
			font-size: 140px;
		}
	}
	</style>
</head>
<body>
	<div class="body_content">
		<section class="under-maintenance">
			<div class="container">
				<div class="row justify-content-center align-items-center">
					<div class="col-5">
						<i class="fa fa-cog fa-spin fa-fw"></i>
					</div>
				</div>
				<div class="row justify-content-center align-items-center">
					<div class="col-12 col-md-8">
						<h1 class="text-white text-center">
							The system is undergoing maintenance...
						</h1>
					</div>
				</div>
			</div>
		</section>
	</div>
  <?php include_once(absolutedir."includes/scripts.php"); ?>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
