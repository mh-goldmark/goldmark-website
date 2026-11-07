<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Team';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/team.php");
require_once(absolutedir."query/vacancies.php");
if($result_team->num_rows <= 0) {
  header('Location: '.domainhost.'404'); // Redirect to 404
  exit;
}
if(!empty($row_team['title'])) {
	$page_title = $row_team['title'];
} else {
	$page_title = $row_team['full_name'].' | '.$row_team['designation'];
}
if(!empty($row_team['details'])) {
	$meta_description = explode("\n", $row_team['details']);
	$page_description = $meta_description[0];
} else {
	$page_description = $row_seo['description'];
}
$team_url = 'the-expert/'.cleanString($row_team['designation']).'/'.cleanString($row_team['full_name']).'-'.$row_team['user_id'].'.html';
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="x-ua-compatible" content="ie=edge"/>
	<link rel="canonical" href="<?php echo domainhost.$team_url; ?>"/>
	<title><?php echo decodeData($page_title); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="robots" content="index, follow"/>
	<meta name="keywords" content="<?php if(!empty($row_team['tags'])) { echo decodeData($row_team['tags']); } else { echo decodeData($row_seo['keywords']); } ?>"/>
	<meta name="title" content="<?php echo decodeData($page_title); ?>"/>
	<meta name="description" content="<?php echo decodeData($page_descriotion); ?>"/>

  <meta property="og:title" content="<?php echo decodeData($page_title); ?>"/>
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="<?php echo $company_name; ?>"/>
  <meta property="og:url" content="<?php echo domainhost.$team_url; ?>" />
  <div itemscope itemtype="https://schema.org/Organization">
    <meta itemprop="telephone" content="<?php echo str_replace(" ","-",str_replace("+","",$company_phone)); ?>" />
    <meta itemprop="name" content="<?php echo $company_name; ?>" />
    <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
    	<meta itemprop="streetAddress" content="<?php if(!empty($company_address)) { echo $company_address.', '; } ?><?php if(!empty($company_office)) { echo 'Office '.$company_office.', '; } ?><?php if(!empty($company_pobox)) { echo 'P.O. Box '.$company_pobox; } ?>"/>
    	<meta itemprop="addressLocality" content="<?php echo $company_city; ?>" />
    	<meta itemprop="addressCountry" content="<?php echo $company_country; ?>" />
		</div>
  </div>

  <meta property="og:description" content="<?php echo decodeData($page_descriotion); ?>" />
	<?php if(!empty($row_team['other_photo'])) { ?>
	<?php
  $imgsize   = getimagesize(localhost."images/users/website/".$row_team['other_photo']);
  $imgwidth  = $imgsize[0];
  $imgheight = $imgsize[1];
  $imgmime 	 = $imgsize['mime'];
  ?>
	<meta property="og:image" content="<?php echo localhost; ?>images/users/website/<?php echo $row_team['other_photo']; ?>" />
	<meta property="og:image:secure_url" content="<?php echo localhost; ?>images/users/website/<?php echo $row_team['other_photo']; ?>" />
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
                  <?php if(!empty($breadcrum_level)) { ?>
                  <a href="gold-mark-real-estate-team.html" title="<?php echo $breadcrum_level; ?>">
                    <?php echo $breadcrum_level; ?>
                  </a>
									<span class="arrow"></span>
                  <?php } ?>
                  <h3 class="d-inline">
                    <?php echo decodeData($row_team['full_name']); ?>
                  </h3>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

			<!-- Member -->
	    <section class="manager-story team-details pb40 pt0">
	      <div class="container">
	        <div class="row justify-content-between align-items-start">
	          <div class="col-lg-4 col-md-6 col-12 wow fadeInLeft" data-wow-delay="300ms">
	            <div class="manager-img">
								<?php if(!empty($row_team['other_photo'])) { ?>
								<img src="<?php echo localhost.'images/users/website/'.$row_team['other_photo']; ?>" alt="<?php echo decodeData($row_team['full_name']); ?>"/>
								<?php } else { ?>
								<img src="images/gold-mark-user.jpg" alt="<?php echo decodeData($row_team['full_name']); ?>"/>
								<?php } ?>
	            </div>
	          </div>
	          <div class="col-lg-8 col-md-6 col-12 wow fadeInRight" data-wow-delay="300ms">
	            <div class="story-content mt0 mt30-md">
	              <h3 class="headline mb10">
									<?php echo decodeData($row_team['designation']); ?>
								</h3>
	              <h1 class="title mb20">
									<?php echo decodeData($row_team['full_name']); ?>
								</h1>
	              <p class="text mb30">
									<?php echo decodeData($row_team['details']); ?>
								</p>
								<div class="agent-contacts mt0 mt60-md d-flex justify-content-center justify-content-md-start align-items-center">
									<a href="tel:<?php echo str_replace($string_replace_mobile,"",$row_team['mobile']); ?>" title="Call Now">
										<span class="flaticon-call"></span>
										Call
									</a>
									<a class="email-agent" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Agent Profile" data-subsource="Email Lead" data-user="<?php echo decodeData($row_team['user_id']); ?>" data-refno="" data-agent="<?php echo decodeData($row_team['full_name']); ?>" data-title="" title="Send Email">
										<span class="flaticon-email"></span>
										Email
									</a>
									<a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$row_team['mobile']); ?>&text=Hello%20<?php echo decodeData($row_team['user_name']); ?>, I would like to inquire on your products and your services you are offering. Please contact me. Thank you." title="Send Whatsapp" target="Whatsapp">
										<span class="flaticon-whatsapp"></span>
										Whatsapp
									</a>
				        </div>
	            </div>
	          </div>
	        </div>
	      </div>
	    </section>
			<!-- Member -->

			<?php if($row_team['user_role'] == 'Agent' || $row_team['user_id'] == 101) { ?>
			<hr/>
      <!--
			<section class="pt50 pb50 pb20-md general-widget contact-details">
				<div class="container">
					<div class="col-7 col-md-10 offset-3 offset-md-1">
						<div class="row justify-content-between align-items-center">
							<div class="col-12 col-md-4 mb30-md d-flex justify-content-center align-items-center flex-start">
								<div class="contact-icon text-gray">
									<img class="widget-icon" src="images/widgets/sales-icon.svg" alt="For sale"/>
								</div>
								<div class="contact-label">
									<span>
										<?php //echo countListings($row_team['user_id'],'Sale'); ?>
									</span>
									<p class="text-gray">
										For sale
									</p>
								</div>
							</div>
							<div class="col-12 col-md-4 mb30-md d-flex justify-content-center align-items-center flex-start">
								<div class="contact-icon text-gray">
									<img class="widget-icon" src="images/widgets/rental-icon.svg" alt="For rent"/>
								</div>
								<div class="contact-label">
									<span>
										<?php //echo countListings($row_team['user_id'],'Rent'); ?>
									</span>
									<p class="text-gray">
										For rent
									</p>
								</div>
							</div>
							<div class="col-12 col-md-4 mb30-md d-flex justify-content-center align-items-center flex-start">
								<div class="contact-icon text-gray">
									<img class="widget-icon" src="images/widgets/deals-icon.svg" alt="Closed deals"/>
								</div>
								<div class="contact-label">
									<span>
										<?php //echo countDeals($row_team['user_id']); ?>
									</span>
									<p class="text-gray">
										Concluded
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<hr/>
      !-->
			<!-- Property All Lists -->
			<section class="pt50 pb90 bg-white bgc-f7">
				<div class="container">
					<div class="row align-items-center wow fadeInUp" data-wow-delay="00ms">
						<div class="col-12">
							<div class="main-title2">
								<h2 class="title text-center">
									My Listings
								</h2>
								<div class="dark-light-navtab style2 text-center mt20">
									<ul class="nav nav-pills nav-exclusive justify-content-center justify-content-center">
										<li class="nav-item" data-type="Sale">
											<a href="#" class="active" title="For Sale">
												For Sale
											</a>
										</li>
										<li class="nav-item" data-type="Rent">
											<a href="#" title="For Rent">
												For Rent
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="row pl15 pr15">
						<div class="col-lg-12">
							<!-- Property start -->
							<div class="row property-list-content"></div>
						</div>
					</div>
				</div>
			</section>
			<?php } ?>

			<?php include_once(absolutedir."includes/career.php"); ?>
      <?php include_once(absolutedir."includes/footer.php"); ?>

    </div>
  </div>

  <?php include_once(absolutedir."includes/handy.buttons.agent.team.php"); ?>
	<?php include_once(absolutedir."includes/property.search.php"); ?>
  <?php include_once(absolutedir."includes/scripts.php"); ?>

	<script>
  //  Fixed sidebar Custom Script For That
  $(function(){
    'use strict'

		$(document).on("click", ".nav-exclusive .nav-item", function(event) {
			event.preventDefault();
			var $type 	= $(this).data("type");
			var $item 	= $(this);
			$(".nav-exclusive .nav-item").each(function() {
				if($(this) != $item) {
					$(this).find("a").removeClass("active");
				}
			});
			if(!$item.find("a").hasClass("active")) {
				$(this).find("a").addClass("active");
			}
			$(".property-list-content").html('<div class="col-12 text-center justify-content-center pt50 pb100"><i class="fa fa-spinner fa-spin fa-4x fa-fw"></i><span class="spinner-text">Determining properties for '+$type.toLowerCase()+'...</span></div>');
			$.ajax({
				type	      : "POST",
				dataType    : "html",
				url         : "ajax/agent.listings.php",
				data        :   {
					type : $type,
					agent: '<?php echo $row_team['user_id']; ?>'
				},
				success:function(html){
					$(".property-list-content").html(html);
          var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  				var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
  						return new bootstrap.Tooltip(tooltipTriggerEl)
  				});
				}
			});
		});

		$(".property-list-content").html('<div class="col-12 text-center justify-content-center pt50 pb100"><i class="fa fa-spinner fa-spin fa-4x fa-fw"></i><span class="spinner-text">Determining properties for sale...</span></div>');
		$.ajax({
			type	      : "POST",
			dataType    : "html",
			url         : "ajax/agent.listings.php",
			data        :   {
				type : 'Sale',
				agent: '<?php echo $row_team['user_id']; ?>'
			},
			success:function(html){
				$(".property-list-content").html(html);
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
				var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
						return new bootstrap.Tooltip(tooltipTriggerEl)
				});
			}
		});
  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
