<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");	// Page constants
require_once(absolutedir."config/connect.php");					// Connect to the database and table
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'FAQ';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/medias.php");
require_once(absolutedir."query/faq.php");
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
	<meta property="og:image" content="<?php echo domainhost; ?>images/gold-mark-real-estate-1080x1080.jpg" />
  <meta property="og:image:secure_url" content="<?php echo domainhost; ?>images/gold-mark-real-estate-1080x1080.jpg" />
	<meta property="og:image:type" content="image/jpeg" />
	<meta property="og:image:width" content="1080"/>
	<meta property="og:image:height" content="1080"/>

	<?php include_once(absolutedir."includes/head.php"); ?>
</head>
<body>
  <?php include_once(absolutedir."includes/header.php"); ?>
  <div class="wrapper ovh">
    <?php include_once(absolutedir."includes/menu.php"); ?>

    <div class="body_content">
      <!-- UI Elements Sections -->
      <section class="breadcumb-section pt130 pb20 pt100-md">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="breadcumb-style1">
                <h2 class="title text-center">
                  Frequently Asked Questions
                </h2>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- FAQ Section Area -->
      <section class="our-faq pb90 pt-0">
        <div class="container">
          <div class="row wow fadeInUp" data-wow-delay="300ms">
            <div class="col-lg-12">
              <div class="ui-content faq">
								<?php while($row_faq = $result_faq->fetch_assoc()) { ?>
								<h3>
									<?php echo decodeData($row_faq['page']); ?>
								</h3>
	              <p>
	                <?php echo decodeData($row_faq['description']); ?>
	              </p>
								<?php } ?>
              </div>
            </div>
          </div>
        </div>
      </section>

			<?php include_once(absolutedir."includes/media.php"); ?>
      <?php include_once(absolutedir."includes/footer.php"); ?>

    </div>
  </div>

	<?php include_once(absolutedir."includes/handy.buttons.php"); ?>
	<?php include_once(absolutedir."includes/property.search.php"); ?>
  <?php include_once(absolutedir."includes/scripts.php"); ?>

	<script>
  $(function(){
    'use strict'

		$('.venobox').venobox({
      numeratio     : true,
      htmlClose     : "",
      titleattr     : 'title',
      titlePosition : 'bottom',
      overlayClose  : false
    });
	});
	</script>

</body>
</html>
<?php
// Close database connection
$conn->close();
?>
