<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Contact';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/sliders.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/medias.php");
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
                    Connect with us
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

			<section class="manager-story connect-with-us pb40 pt0">
	      <div class="container">
	        <div class="row justify-content-between align-items-center">
	          <div class="col-lg-5 col-md-6 col-12 wow fadeInLeft" data-wow-delay="300ms">
	            <div class="manager-img">
								<img src="<?php echo decodeData(getImage('Contact',localhost)); ?>" alt="<?php echo decodeData($company_name); ?>"/>
	            </div>
	          </div>
	          <div class="col-lg-6 col-md-6 col-12 wow fadeInRight" data-wow-delay="300ms">
	            <div class="story-content mt0 mt30-md">
								<h3 class="cta-title mb15">
									<?php echo decodeData(headLine('Contact','headline')); ?>
								</h3>
                <h1 class="cta-title mb25">
									<?php echo decodeData(headLine('Contact','title')); ?>
								</h1>
	              <p class="text">
									<?php echo nl2br(decodeData(headLine('Contact','tagline'))); ?>
								</p>
	            </div>
	          </div>
	        </div>
	      </div>
	    </section>

			<hr/>

			<section class="pb100 pt40 pb60-md pt30-md contact-details connect-with-us">
	      <div class="container">
	        <div class="row justify-content-between align-items-center">
	          <div class="col-md-6 col-12 wow fadeInLeft" data-wow-delay="300ms">
							<h2 class="title mb30">
								Talk to us
							</h2>
							<div class="row">
								<div class="talk-to-us-bg mr15 ml15 mr0-md ml0-md">
									<div class="col-12 mb30 d-md-flex">
										<div class="widget-contact d-flex justify-content-start align-items-center">
											<div class="contact-icon text-gray">
												<span class="fa fa-volume-control-phone"></span>
											</div>
											<div class="contact-label">
												<span>
													Phone
												</span>
												<a href="tel:<?php echo str_replace($string_replace_mobile,"",$company_phone); ?>" class="text-gray" title="Call Now">
													<?php echo $company_phone; ?>
												</a>
											</div>
										</div>
			            </div>
									<div class="col-12 mb30 d-md-flex">
										<div class="widget-contact d-flex justify-content-start align-items-center">
											<div class="contact-icon text-gray">
												<span class="icon flaticon-smartphone"></span>
											</div>
											<div class="contact-label">
												<span>
													Mobile
													<a href="tel:<?php echo str_replace($string_replace_mobile,"",$company_mobile); ?>" class="text-gray" title="Call Now">
														<?php echo $company_mobile; ?>
													</a>
											</div>
										</div>
			            </div>
									<div class="col-12 mb30 d-md-flex">
										<div class="widget-contact d-flex justify-content-start align-items-center">
											<div class="contact-icon text-gray">
												<span class="flaticon-whatsapp"></span>
											</div>
											<div class="contact-label">
												<span>
													WhatsApp
												</span>
												<a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$company_mobile); ?>&text=Hello Gold Mark, I would like to learn more about your real estate listings, services, and investment opportunities. I look forward to your response. Thank you!" target="Whatsapp" class="text-gray" title="Send Whatsapp">
													Click to send WhatsApp
												</a>
											</div>
										</div>
			            </div>
									<div class="col-12 d-md-flex">
										<div class="widget-contact d-flex justify-content-start align-items-center">
											<div class="contact-icon text-gray">
												<span class="fa fa-envelope-o"></span>
											</div>
											<div class="contact-label">
												<span>
													Email
												</span>
												<a href="#emailus" class="pagescroll text-gray" title="Email us">
													<?php
													$email_address = explode("@",$company_email);
													?>
													<script language=javascript>
													var $email = "<?php echo $email_address[0]; ?>"
													var $host  = "<?php echo $email_address[1]; ?>"
													document.write($email+"@"+$host)
													</script>
												</a>
											</div>
										</div>
			            </div>
								</div>
		          </div>
						</div>
	          <div class="col-md-6 col-12 wow fadeInRight mt60-sm" data-wow-delay="300ms">
							<h2 class="title mb30">
								Follow us
							</h2>
							<div class="row">
								<div class="talk-to-us-bg bg-light mr15 ml15 mr0-md ml0-md">
									<div class="col-12 mb30 d-md-flex">
										<div class="widget-contact d-flex justify-content-start align-items-center">
											<div class="contact-icon text-gray">
												<span class="fa fa-facebook"></span>
											</div>
											<div class="contact-label">
												<span>
													Facebook
												</span>
												<a href="<?php echo $company_facebook; ?>" target="Social" class="text-gray" title="Follow us on Facebook">
													<?php echo $company_userfacebook; ?>
												</a>
											</div>
										</div>
			            </div>
									<div class="col-12 mb30 d-md-flex">
										<div class="widget-contact d-flex justify-content-start align-items-center">
											<div class="contact-icon text-gray">
												<span class="fa fa-instagram"></span>
											</div>
											<div class="contact-label">
												<span>
													Instagram
												</span>
												<a href="<?php echo $company_instagram; ?>" target="Social" class="text-gray" title="Follow us on Instagram">
													<?php echo $company_userinstagram; ?>
												</a>
											</div>
										</div>
			            </div>
									<div class="col-12 mb30 d-md-flex">
										<div class="widget-contact d-flex justify-content-start align-items-center">
											<div class="contact-icon text-gray">
												<svg xmlns="http://www.w3.org/2000/svg" height="60" width="60" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" fill="#2B2C3F"/></svg>
											</div>
											<div class="contact-label">
												<span>
													TikTok
												</span>
												<a href="<?php echo $company_tiktok; ?>" target="Social" class="text-gray" title="Follow us on TikTok">
													<?php echo $company_usertiktok; ?>
												</a>
											</div>
										</div>
			            </div>
									<div class="col-12 d-md-flex">
										<div class="widget-contact d-flex justify-content-start align-items-center">
											<div class="contact-icon text-gray">
												<span class="fa fa-linkedin"></span>
											</div>
											<div class="contact-label">
												<span>
													Linkedin
												</span>
												<a href="<?php echo $company_linkedin; ?>" target="Social" class="text-gray" title="Follow us on Linkedin">
													<?php echo $company_userlinkedin; ?>
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

			<!-- CTA Banner -->
	    <section id="emailus" class="bgc-thm-light cta-goldmark pt80 pb80">
				<div class="container">
					<div class="row justify-content-center align-items-start">
						<div class="col-md-6 col-12 cta-details-text wow fadeInLeft" data-wow-delay="400ms">
							<h4>
								<?php echo decodeData(headLine('General Inquiry','title')); ?>
							</h4>
							<h2 class="title">
								<?php echo decodeData(headLine('General Inquiry','headline')); ?>
							</h2>
							<div class="general-details">
								<p>
									<?php echo decodeData(nl2br(headLine('General Inquiry','tagline'))); ?>
								</p>
							</div>
						</div>
						<div class="col-md-6 col-12 cta-form wow mt30-md fadeInRight" data-wow-delay="400ms">
							<form name="inquiryForm" class="transparent-borders" action="process/process.contact.php" method="POST">
								<input type="text" name="name" class="form-control required" placeholder="Full name*" value="<?php echo $_COOKIE['name']; ?>" autocomplete="off">
								<input type="email" name="email" class="form-control required" placeholder="Email address*" value="<?php echo $_COOKIE['email']; ?>" autocomplete="off">
								<input type="text" name="phone" class="form-control required" placeholder="Phone number*" value="<?php echo $_COOKIE['phone']; ?>" autocomplete="off">
								<textarea class="required" name="message" placeholder="Message*" rows="4"></textarea>
								<p>
									By submitting the form, you agree to our <a href="<?php echo webhost; ?>terms-and-conditions.html" title="Terms & Conditions" target="Terms">Terms & Conditions</a> and <a href="<?php echo webhost; ?>privacy-policy.html" title="Privacy Policy" target="Policy">Privacy Policy</a>.
								</p>
								<button class="btn btn-dark-default" type="submit">
									Inquire Now
									<i class="fal fa-arrow-right-long"></i>
								</button>
								<input type="hidden" name="recaptcha_response" class="recaptchaResponse" readonly/>
								<input type="hidden" name="email_group" value="Inquiry" readonly/>
								<input type="hidden" name="source" value="Website" readonly/>
								<input type="hidden" name="sub_source" value="General Inquiry" readonly/>
							</form>
						</div>
					</div>
				</div>
	    </section>
			<!-- CTA Banner -->

			<section class="find-us-on-map pt80 pb80">
				<div class="container">
					<div class="row">
						<h6 class="title mb5">
							Our address
						</h6>
						<h4 class="location mb20">
							<?php echo decodeData($company_office).', '.decodeData($company_address).', '.decodeData($company_city); ?>
						</h4>
						<div class="col-lg-12">
							<div id="listing-map"></div>
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
  //  Fixed sidebar Custom Script For That
  $(function(){
    'use strict'

		$('.venobox').venobox({
      numeratio     : true,
      htmlClose     : "",
      titleattr     : 'title',
      titlePosition : 'bottom',
      overlayClose  : false
    });

    //intialize the map
    function initialize() {
      var mapOptions = {
        zoom                  : 13,
      	scrollwheel           : false,
    	  draggable             : true,
      	disableDoubleClickZoom: true,
        center                : new google.maps.LatLng(<?php echo decodeData($company_geolocation); ?>)
      };

      var map = new google.maps.Map(document.getElementById('listing-map'),mapOptions);

      //add a marker1
      var marker = new google.maps.Marker({
        position  : map.getCenter(),
        map       : map,
        icon      : 'images/icons/marker-icon.png'
      });

      //show info box for marker1
      var contentString = '<div class="info-box">\
                          <h3>\
                          <?php echo decodeData($company_name); ?></h3>\
                          <span><?php echo decodeData($company_office).', '.decodeData($company_address).', '.decodeData($company_city); ?></span>\
                          </div>';

      var infowindow = new google.maps.InfoWindow({
        content: contentString
      });

      google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map,marker);
      });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
