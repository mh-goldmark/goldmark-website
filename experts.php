<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Experts';
$widgets_page = 'General';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/sliders.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/our.team.php");
require_once(absolutedir."query/widgets.php");
require_once(absolutedir."query/vacancies.php");
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
                    The Experts
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
							<?php echo decodeData(headLine('The Expert','title')); ?>
						</h3>
						<h1 class="tagline">
							<?php echo decodeData(nl2br(headLine('The Expert','tagline'))); ?>
						</h1>
					</div>
        </div>
      </section>
			<?php include_once(absolutedir."includes/widgets.php"); ?>
			<hr/>
			<?php } else { ?>
			<hr class="mt0"/>
			<section class="pt20 pt0-md pb20 pb0-md media">
				<div class="container-fluid">
					<div class="row mt30 wow fadeInUp blogs-articles" data-wow-delay="700ms">
						<div class="col-12">
							<div class="cta-style4 position-relative text-center">
								<h3 class="cta-title fw400 mb30">
									<?php echo decodeData(headLine('The Expert','title')); ?>
								</h3>
								<h1 class="sub-title fz16 fw400 mb20 mb0-md">
									<?php echo decodeData(nl2br(headLine('The Expert','tagline'))); ?>
								</h1>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php } ?>

			<!-- Agent Section Area -->
	    <section class="our-agents <?php if($result_sliders->num_rows >= 1) { echo 'pt40'; } else { echo 'pt0'; } ?> pt40-md pb50">
	      <div class="container">
					<div class="row">
						<div class="col-xl-8 col-12 mx-auto wow fadeInUp" data-wow-delay="300ms">
							<div class="main-title2 mb0 position-relative text-center">
								<?php if($result_sliders->num_rows >= 1) { ?>
								<h3 class="paragraph text-center mb15">
									<?php echo decodeData(headLine('The Team','headline')); ?>
								</h3>
								<h2 class="title text-center">
									<?php echo decodeData(headLine('The Team','title')); ?>
								</h2>
								<?php } ?>
								<div class="dark-light-navtab style2 text-center <?php if($result_sliders->num_rows >= 1) { echo 'mt30'; } else { echo 'mt0'; } ?> mb40">
									<ul class="nav nav-pills nav-exclusive justify-content-center justify-content-center">
										<li class="nav-item" data-team="Managers">
											<a href="#" class="active" title="Directors & Managers">
												Directors & Managers
											</a>
										</li>
										<li class="nav-item" data-team="Leasing">
											<a href="#" title="Leasing Associates">
												Leasing Associates
											</a>
										</li>
										<li class="nav-item" data-team="Sales">
											<a href="#" title="Sales Associates">
												Sales Associates
											</a>
										</li>
										<li class="nav-item" data-team="Marketing">
											<a href="#" title="Creatives & Marketings">
												Creatives & Marketing
											</a>
										</li>
										<li class="nav-item" data-team="HR">
											<a href="#" title="HR">
												HR
											</a>
										</li>
										<li class="nav-item" data-team="Administration">
											<a href="#" title="Administration">
												Administration
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<div id="theTeam" class="row">
						<?php while($row_our_team = $result_our_team->fetch_assoc()) { ?>
							<div class="col-md-3 col-sm-4 col-6 feature-style2 mb30 wow fadeInUp" data-wow-delay="400ms">
								<div class="the-team-grid">
								<a href="the-expert/<?php echo cleanString($row_our_team['designation']); ?>/<?php echo cleanString($row_our_team['full_name']); ?>-<?php echo $row_our_team['user_id']; ?>.html" class="feature-img" title="<?php echo decodeData($row_our_team['full_name']); ?>">
									<?php if(!empty($row_our_team['other_photo'])) { ?>
									<img src="<?php echo localhost.'images/users/website/'.$row_our_team['other_photo']; ?>" alt="<?php echo decodeData($row_our_team['full_name']); ?>"/>
									<?php } else { ?>
									<img src="images/<?php echo $user_400x400; ?>" alt="<?php echo decodeData($row_our_team['full_name']); ?>"/>
									<?php } ?>
								</a>
								<div class="feature-content pt15 pr10 pl10 pb15">
									<a href="the-expert/<?php echo cleanString($row_our_team['designation']); ?>/<?php echo cleanString($row_our_team['full_name']); ?>-<?php echo $row_our_team['user_id']; ?>.html" class="title mb5" title="<?php echo decodeData($row_our_team['full_name']); ?>">
										<?php echo decodeData($row_our_team['full_name']); ?>
									</a>
									<p class="text mb0">
										<?php echo decodeData($row_our_team['designation']); ?>
									</p>
								</div>
								<div class="row justify-content-center align-items-center contact-buttons pt0 pb10">
									<a href="tel:<?php echo str_replace($string_replace_mobile,"",$row_our_team['mobile']); ?>" title="Call Now">
										<span class="flaticon-call"></span>
									</a>
									<a class="email-agent" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Website" data-subsource="Email Lead" data-user="<?php echo decodeData($row_our_team['user_id']); ?>" data-refno="" data-agent="<?php echo decodeData($row_our_team['full_name']); ?>" data-title="" title="Send Email">
										<span class="flaticon-email"></span>
									</a>
									<a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$row_our_team['mobile']); ?>&text=Hello%20<?php echo decodeData($row_our_team['user_name']); ?>, I would like to inquire on your products and your services you are offering. Please contact me. Thank you." title="Send Whatsapp" target="Whatsapp">
										<span class="flaticon-whatsapp"></span>
									</a>
								</div>
								</div>
							</div>
						<?php } ?>
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

		$(document).on("click", ".nav-exclusive .nav-item", function(event) {
			event.preventDefault();
			var $team 	= $(this).data("team");
			var $text 	= $(this).find("a").attr("title");
			var $item 	= $(this);
			$(".nav-exclusive .nav-item").each(function() {
				if($(this) != $item) {
					$(this).find("a").removeClass("active");
				}
			});
			if(!$item.find("a").hasClass("active")) {
				$(this).find("a").addClass("active");
			}
			$("#theTeam").html('<div class="col-12 text-center justify-content-center pt50 pb100"><i class="fa fa-spinner fa-spin fa-4x fa-fw"></i><span class="spinner-text">Determining the '+$text+'...</span></div>');

			$.ajax({
				type	      : "POST",
				dataType    : "html",
				url         : "ajax/the.team.php",
				data        :   {
					team : $team
				},
				success:function(html){
					$("#theTeam").html(html);
				}
			});
		});

  });
  </script>
</body>
</html>
<?php
// Close database connection
$conn->close();
?>
