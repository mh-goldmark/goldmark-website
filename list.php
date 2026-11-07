<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'List Property';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/sliders.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/agent.php");
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
                    List a property
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

			<?php if($result_sliders->num_rows >= 1) { ?>
			<!-- Page Banner -->
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
							<?php echo decodeData(headLine('List Property','title')); ?>
						</h3>
						<h1 class="tagline">
							<?php echo decodeData(nl2br(headLine('List Property','tagline'))); ?>
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
									<?php echo decodeData(headLine('List Property','title')); ?>
								</h3>
								<h1 class="sub-title fz16 fw400 mb20 mb0-md">
									<?php echo decodeData(nl2br(headLine('List Property','tagline'))); ?>
								</h1>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php } ?>

			<section class="pt40 pb70 pb40-md list-property contact-details">
        <div class="container">
					<div class="col-10 offset-1 wow fadeInUp" data-wow-delay="400ms">
						<div class="row justify-content-center align-items-center">
							<?php while($row_widgets = $result_widgets->fetch_assoc()) { ?>
	            <div class="col-12 col-lg-4 mb30-md d-md-flex">
								<div class="widget-contact d-flex justify-content-start align-items-center">
									<div class="contact-icon text-gray">
										<img class="widget-icon" src="<?php echo localhost.'images/widgets/'.cleanString($row_widgets['category']).'/'.$row_widgets['icon']; ?>" alt="<?php echo decodeData($row_widgets['label']); ?>"/>
									</div>
									<div class="contact-label fw600 text-uppercase">
										<?php echo trim(wordwrap(decodeData($row_widgets['label']),15,"<br/>",true)); ?>
									</div>
								</div>
	            </div>
							<?php } ?>
	          </div>
					</div>
        </div>
      </section>

			<section class="submit-property bg-light pt60 pt40-md pb90">
        <div class="container">
          <div class="row wrap wow fadeInUp" data-wow-delay="500ms">
            <div class="col-lg-8">
              <div class="ps-widget bdrs0 mb30 overflow-hidden position-relative">
								<form name="propertyForm" class="gray-borders" action="process/process.property.php" method="POST">
									<h3 class="mb20">
										<span class="flaticon-corporation"></span>
										Property Details
									</h3>
									<div class="row justify-content-center align-items-center">
										<div class="col-12 col-md-6 mb20">
											<input type="text" name="location" class="form-control required" placeholder="Location or property address*" autocomplete="off">
										</div>
										<div class="col-12 col-md-6 mb20">
											<input type="text" name="project" class="form-control required" placeholder="Project or tower name*" autocomplete="off">
										</div>
										<div class="col-12 col-md-6 mb20">
											<select name="category" class="selectpicker" data-live-search="true" data-width="100%">
												<option value="Residential for Sale">Residential for Sale</option>
			                  <option value="Commercial for Sale">Commercial for Sale</option>
			                  <option value="Residential for Rent">Residential for Rent</option>
			                  <option value="Commercial for Rent">Commercial for Rent</option>
			                </select>
										</div>
										<div class="col-12 col-md-6 mb20">
											<select name="type" class="selectpicker" data-live-search="true" data-width="100%">
												<option value="Apartment">Apartment</option>
			                  <option value="Villa">Villa</option>
			                  <option value="Office Space">Office Space</option>
			                  <option value="Penthouse">Penthouse</option>
												<option value="Townhouse">Townhouse</option>
												<option value="Retail Shop">Retail Shop</option>
												<option value="Others">Others</option>
			                </select>
										</div>
										<!--
										<div class="col-12 col-md-6 mb20">
											<select name="bedroom" class="selectpicker" data-live-search="true" data-width="100%">
		                    <option value="">Bedroom</option>
		                    <option value="0">Studio</option>
		                    <option value="1">1 Bedroom</option>
		                    <option value="2">2 Bedroom</option>
		                    <option value="3">3 Bedroom</option>
		                    <option value="4">4 Bedroom</option>
		                    <option value="5">5 Bedroom</option>
		                    <option value="6">6 Bedroom</option>
		                    <option value="7+">7+ Bedroom</option>
		                  </select>
										</div>
										<div class="col-12 col-md-6 mb20">
											<select name="bathroom" class="selectpicker" data-live-search="true" data-width="100%">
												<option value="">Bathroom</option>
		                    <option value="0">Studio</option>
		                    <option value="1">1 Bathroom</option>
		                    <option value="2">2 Bathroom</option>
		                    <option value="3">3 Bathroom</option>
		                    <option value="4">4 Bathroom</option>
		                    <option value="5">5 Bathroom</option>
		                    <option value="6">6 Bathroom</option>
		                    <option value="7+">7+ Bathroom</option>
		                  </select>
										</div>
										<div class="col-12 col-md-6 mb20">
											<input type="text" name="size" class="form-control required number-comma" placeholder="Size*" autocomplete="off">
										</div>
										<div class="col-12 col-md-6 mb20">
											<input type="text" name="price" class="form-control required number-comma" placeholder="Asking price*" autocomplete="off">
										</div>
										!-->
									</div>
									<!--
									<h3 class="mb20 mt20">
										<span class="flaticon-review"></span>
										Property Description
									</h3>
									<div class="row justify-content-center align-items-center">
										<div class="col-12 mb20">
											<textarea name="details" placeholder="Property description" rows="6"></textarea>
										</div>
									</div>
									!-->
									<h3 class="mb20 mt20">
										<span class="flaticon-user-1"></span>
										Owner Details
									</h3>
									<div class="row justify-content-center align-items-center">
										<div class="col-12 mb20">
											<input type="text" name="name" class="form-control required" placeholder="Full name*" value="<?php echo $_COOKIE['name']; ?>" autocomplete="off">
										</div>
										<div class="col-12 col-md-6 mb20">
											<input type="email" name="email" class="form-control required" placeholder="Email address*" value="<?php echo $_COOKIE['email']; ?>" autocomplete="off">
										</div>
										<div class="col-12 col-md-6 mb20">
											<input type="text" name="phone" class="form-control required" placeholder="Phone number*" value="<?php echo $_COOKIE['phone']; ?>" autocomplete="off">
										</div>
									</div>
									<!--
									<h3 class="mb20 mt20">
										<span class="flaticon-door"></span>
										Documents
									</h3>
									<div class="row justify-content-center align-items-center">
										<div class="col-12 mb20">
											<input type="file" class="input-field input-field-file" name="documents[]" label="Upload Documents" accept=".pdf,.doc" multiple>
										</div>
									</div>
									!-->
									<p class="mt0">
										By submitting the form, you agree to our <a href="<?php echo webhost; ?>terms-and-conditions.html" title="Terms & Conditions" target="Terms">Terms & Conditions</a> and <a href="<?php echo webhost; ?>privacy-policy.html" title="Privacy Policy" target="Policy">Privacy Policy</a>.
									</p>
									<button class="btn btn-dark-default" type="submit">
										Submit Property
										<i class="fal fa-arrow-right-long"></i>
									</button>
									<input type="hidden" name="recaptcha_response" class="recaptchaResponse" readonly/>
									<input type="hidden" name="email_group" value="Listing" readonly/>
									<input type="hidden" name="user_id" value="<?php echo decodeData($row_agent['user_id']); ?>" readonly/>
									<input type="hidden" name="source" value="Website" readonly/>
									<input type="hidden" name="sub_source" value="Submit Property" readonly/>
								</form>
              </div>
            </div>
            <div class="col-lg-4 listing-details">
              <div class="column">
                <div class="mt40-md position-relative">
									<div class="agent-profile-details bgc-white">
										<h6 class="title">
                      Ask the expert!
                    </h6>
										<div class="agent-single d-flex align-items-end p15 mb0">
	                    <div class="single-img">
	                      <?php if(!empty($row_agent['user_photo'])) { ?>
	                        <img src="<?php echo localhost.'images/users/'.$row_agent['user_photo']; ?>" alt="<?php echo decodeData($row_agent['full_name']); ?>" class="w90"/>
	                      <?php } else { ?>
	                        <img src="images/<?php echo $user_400x400; ?>" alt="<?php echo decodeData($row_agent['full_name']); ?>" class="w90"/>
	                      <?php } ?>
	                    </div>
	                    <div class="single-contant ml20">
	                      <h4 class="agent-designation">
	                        <?php echo decodeData($row_agent['designation']); ?>
	                      </h4>
	                      <h3 class="agent-name">
	                        <?php echo decodeData($row_agent['full_name']); ?>
	                      </h3>
	                      <p class="agent-brn">
	                        BRN <?php echo decodeData($row_agent['rera_number']); ?>
	                      </p>
	                    </div>
	                  </div>
	                  <div class="list-meta2 pt10 pl15 pr15 pb15">
	                    <div class="agent-contacts d-flex justify-content-start align-items-center">
	                      <a href="tel:<?php echo str_replace($string_replace_mobile,"",$row_agent['mobile']); ?>" title="Call Now">
	                        <span class="flaticon-call"></span>
	                        Call
	                      </a>
												<a class="email-agent" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Website" data-subsource="Email Lead" data-user="<?php echo decodeData($row_agent['user_id']); ?>" data-refno="" data-agent="<?php echo decodeData($row_agent['full_name']); ?>" data-title="" title="Send Email">
													<span class="flaticon-email"></span>
													Email
												</a>
												<a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$company_mobile); ?>&text=Hello <?php echo decodeData($row_agent['user_name']); ?>, I would like to learn more about your real estate listings, services, and investment opportunities. I look forward to your response. Thank you!" title="Send Whatsapp" target="Whatsapp">
													<span class="flaticon-whatsapp"></span>
													Whatsapp
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

  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
