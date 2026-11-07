<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Vacancy';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/vacancy.php");
require_once(absolutedir."query/vacancies.php");
if($result_vacancy->num_rows <= 0) {
  header('Location: '.domainhost.'404'); // Redirect to 404
  exit;
}
$vacancy_url = "vacancies/".cleanString($row_vacancy['vacancy'])."-".$row_vacancy['id'].".html";
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
  <?php
  $meta_description = explode("\n", $row_vacancy['details']);
  ?>
	<meta charset="utf-8"/>
	<meta http-equiv="x-ua-compatible" content="ie=edge"/>
	<link rel="canonical" href="<?php echo domainhost.$vacancy_url; ?>"/>
	<title><?php echo decodeData($row_vacancy['vacancy']); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="robots" content="index, follow"/>
  <meta name="keywords" content="<?php echo decodeData($row_seo['keywords']); ?>"/>
	<meta name="title" content="<?php echo decodeData($row_vacancy['vacancy']); ?>"/>
	<meta name="description" content="<?php echo decodeData(strip_tags($meta_description[0])); ?>"/>

  <meta property="og:title" content="<?php echo decodeData($row_vacancy['vacancy']); ?>"/>
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="<?php echo $company_name; ?>"/>
  <meta property="og:url" content="<?php echo domainhost.$vacancy_url; ?>" />
  <div itemscope itemtype="https://schema.org/Organization">
    <meta itemprop="telephone" content="<?php echo str_replace(" ","-",str_replace("+","",$company_phone)); ?>" />
    <meta itemprop="name" content="<?php echo $company_name; ?>" />
    <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
    	<meta itemprop="streetAddress" content="<?php if(!empty($company_address)) { echo $company_address.', '; } ?><?php if(!empty($company_office)) { echo 'Office '.$company_office.', '; } ?><?php if(!empty($company_pobox)) { echo 'P.O. Box '.$company_pobox; } ?>"/>
    	<meta itemprop="addressLocality" content="<?php echo $company_city; ?>" />
    	<meta itemprop="addressCountry" content="<?php echo $company_country; ?>" />
		</div>
  </div>

  <meta property="og:description" content="<?php echo decodeData(strip_tags($meta_description[0])); ?>" />
	<?php if(!empty($row_vacancy['image'])) { ?>
  <?php
  $imgsize   = getimagesize(localhost."images/vacancies/".$row_vacancy['id']."/".$row_vacancy['image']);
  $imgwidth  = $imgsize[0];
  $imgheight = $imgsize[1];
  $imgmime 	 = $imgsize['mime'];
  ?>
	<meta property="og:image" content="<?php echo localhost; ?>images/vacancies/<?php echo $row_vacancy['id']; ?>/<?php echo $row_vacancy['image']; ?>" />
	<meta property="og:image:secure_url" content="<?php echo localhost; ?>images/vacancies/<?php echo $row_vacancy['id']; ?>/<?php echo $row_vacancy['image']; ?>" />
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

  <style>
	.page-banner .title {
    color: #fff;
	}
	</style>

</head>
<body>
  <?php include_once(absolutedir."includes/header.php"); ?>
  <div class="wrapper ovh">
    <?php include_once(absolutedir."includes/menu.php"); ?>

    <div class="body_content">
      <!-- Breadcumb Sections -->
      <section class="breadcumb-section listing-details bg-white pb20 pt110 pb0-md pt80-md">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="breadcumb-style1 d-md-flex align-items-start w-100">
                <div class="col-12 col-lg-8 col-md-7 bread-crumb">
                  <span class="arrow-left"></span>
                  <a href="gold-mark-real-estate-career.html" title="Back to career">
                    Back to Career
                  </a>
                  <h3 class="d-inline">
                    <?php echo decodeData($row_vacancy['vacancy']); ?>
                  </h3>
                </div>
                <div class="col-12 col-lg-4 col-md-5 mt15-md sharing">
        					<a href="#" class="sharer-btn">
                    <span class="flaticon-share-1 mr10"></span>
                    Share this vacancy
                  </a>
                  <div class="sharing-option-buttons">
                    <div class="row justify-content-between align-items-center">
                      <div class="facebook-share">
                        <a href="https://www.facebook.com/sharer.php?u=<?php echo domainhost.$vacancy_url; ?>" class="share-icon" title="Share to Facebook" target="_blank">
                          <i class="fa fa-facebook"></i>
                        </a>
                      </div>
                      <div class="twitter-share">
                        <a href="https://twitter.com/intent/tweet?url=<?php echo domainhost.$vacancy_url; ?>" class="share-icon" title="Share to Twitter" target="_blank">
                          <i class="fab fa-twitter"></i>
                        </a>
                      </div>
                      <div class="linkedin-share">
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo domainhost.$vacancy_url; ?>" class="share-icon" title="Share to Linkedin" target="_blank">
                          <i class="fab fa-linkedin"></i>
                        </a>
                      </div>
                      <div class="whatsapp-share">
                        <a href="https://api.whatsapp.com/send?text=<?php echo domainhost.$vacancy_url; ?>" class="share-icon" title="Share via WhatsApp" target="_blank">
                          <i class="fab fa-whatsapp"></i>
                        </a>
                      </div>
                      <div class="copy-share">
                        <a href="<?php echo domainhost.$vacancy_url; ?>" class="share-icon copy-link" title="Copy Link">
                          <i class="fas fa-clipboard"></i>
                        </a>
                      </div>
                    </div>
                  </div>
        				</div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Article Image -->
      <section class="pt0 pb0 mt-30 page-banner bgc-white">
        <div class="container position-relative">
          <div class="row mt30 wow fadeInUp" data-wow-delay="300ms">
            <div class="col-lg-12">
              <div class="sliders-wrapper" style="background-image: url('<?php echo localhost.'images/vacancies/'.$row_vacancy['id'].'/'.$row_vacancy['image']; ?>') !important;">
              </div>
            </div>
            <div class="news-room-taglines">
  						<h1 class="title">
  							<?php echo decodeData($row_vacancy['vacancy']); ?>
  						</h1>
              <p class="tagline">
                <a class="apply-now pagescroll" href="#career" title="Apply now">
                  Apply now for this vacancy
  							</a>
  						</p>
  					</div>
          </div>
        </div>
      </section>
      <!-- Article Image -->

      <section class="article-details pt30 pt10-md pb50">
        <div class="container">
          <div class="row wrap wow fadeInUp" data-wow-delay="500ms">
            <div class="col-lg-12">
              <div class="ps-widget bgc-white bdrs0 mb30 overflow-hidden position-relative">
                <p class="text mb0">
                  <?php echo decodeData($row_vacancy['details']); ?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </section>

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
  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
