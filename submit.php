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

	<div class="body_content bgc-thm-light">
		<section class="inner-content cta-goldmark">
			<div class="container">
				<div class="row justify-content-center align-items-start">
					<div class="col-md-6 col-12 cta-form">
						<div class="text-center">
							<img class="goldmark-logo" src="images/logos/gold-mark-real-estate-logo-dark.svg" alt="<?php echo decodeData($company_name); ?>"/>
						</div>
						<form name="requestForm" class="transparent-borders" action="process/process.request.php" method="POST">
							<input type="text" name="name" class="form-control required" placeholder="Full name*" value="<?php echo $_COOKIE['name']; ?>" autocomplete="off">
							<input type="email" name="email" class="form-control required" placeholder="Email address*" value="<?php echo $_COOKIE['email']; ?>" autocomplete="off">
							<input type="text" name="phone" class="form-control required" placeholder="Phone number*" value="<?php echo $_COOKIE['phone']; ?>" autocomplete="off">
							<textarea class="required" name="message" placeholder="Message*" rows="4"></textarea>
							<p>
								By submitting the form, you agree to our <a href="<?php echo webhost; ?>terms-and-conditions.html" title="Terms & Conditions" target="Terms">Terms & Conditions</a> and <a href="<?php echo webhost; ?>privacy-policy.html" title="Privacy Policy" target="Policy">Privacy Policy</a>.
							</p>
							<button class="btn btn-dark-default" type="submit" <?php if(empty($_GET['source']) || empty($_GET['project'])) { echo 'disabled'; } ?>>
								Submit Inquiry
								<i class="fal fa-arrow-right-long"></i>
							</button>
							<input type="hidden" name="recaptcha_response" class="recaptchaResponse" readonly/>
							<input type="hidden" name="email_group" value="Inquiry" readonly/>
							<input type="hidden" name="source" value="<?php echo $_GET['source']; ?>" readonly/>
							<input type="hidden" name="sub_source" value="<?php echo $_GET['project']; ?>" readonly/>
						</form>
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
