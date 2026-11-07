<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
$current_page = 'Media';
if(!empty($current_page)) {
require_once(absolutedir."query/seo.php");
require_once(absolutedir."query/sliders.php");
require_once(absolutedir."query/headlines.php");
require_once(absolutedir."query/media.php");
require_once(absolutedir."query/video.php");
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
                    Media room
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
							<?php echo decodeData(headLine('Media','title')); ?>
						</h3>
						<h1 class="tagline">
							<?php echo decodeData(headLine('Media','tagline')); ?>
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
									<?php echo decodeData(headLine('Media','title')); ?>
								</h3>
								<h1 class="sub-title fz16 fw400 mb20 mb0-md">
									<?php echo decodeData(headLine('Media','tagline')); ?>
								</h1>
							</div>
						</div>
					</div>
				</div>
			</section>
			<?php } ?>

			<hr class="mt15"/>

			<section class="blogs-topics pt5 pb0">
				<div class="container">
					<div class="row">
						<div class="col-8 topic-list">
							<div class="row justify-content-between align-items-center">
								<div class="col-2 text-center">
									<a href="#" class="active news-topics" title="All" data-topic="All">
										All
									</a>
								</div>
								<div class="col-2 text-center">
									<a href="#" class="news-topics" title="News" data-topic="News">
										News
									</a>
								</div>
								<div class="col-2 text-center">
									<a href="#" class="news-topics" title="Market" data-topic="Market">
										Market
									</a>
								</div>
								<div class="col-2 text-center">
									<a href="#" class="news-topics" title="Blogs" data-topic="Blogs">
										Blogs
									</a>
								</div>
								<div class="col-2 text-center">
									<a href="#" class="news-topics" title="Off-plan" data-topic="Off-plan">
										Off-plan
									</a>
								</div>
								<div class="col-2 text-center">
									<a href="#" class="news-topics" title="Tips" data-topic="Tips">
										Tips
									</a>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-4 topic-selection">
							<form name="formTopic" method="GET" action="news">
								<select name="topic" class="selectpicker" data-live-search="true" data-width="100%">
									<option value="All">All Topics</option>
									<?php
									$array_topics = array();
									while($row_topics = $result_topics->fetch_assoc()) {
										$array_topics[]	= $row_topics['category'];
									}
									?>
									<?php $array_topics_implode = implode(",",$array_topics); ?>
									<?php $array_topics_explode = explode(",",$array_topics_implode); ?>
									<?php $array_topics_unique  = array_unique($array_topics_explode); ?>
									<?php foreach($array_topics_unique as $array_topic) { ?>
									<option value="<?php echo decodeData($array_topic); ?>"><?php echo decodeData($array_topic); ?></option>
									<?php } ?>
								</select>
							</form>
						</div>
					</div>
				</div>
			</section>

			<hr class="mt10"></hr>

			<!-- Blog Section Area -->
	    <section class="our-blog media-room pt20 pb80">
	      <div class="container">
					<div class="row wow fadeInUp news-articles" data-wow-delay="300ms">
						<div class="col-12 infinite-scroll">
							<div class="infinite-paging">
								<a class="jscroll-next button" href="articles.php?page=1">
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

			<?php include_once(absolutedir."includes/video.php"); ?>
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

		$(document).on("click", ".news-topics", function(event) {
			event.preventDefault();
			var $topic 	= $(this).data("topic");
			var $item 	= $(this);
			$(".news-topics").each(function() {
				if($(this) != $item) {
					$(this).removeClass("active");
				}
			});
			if(!$item.hasClass("active")) {
				$(this).addClass("active");
			}
			$(".news-articles").html('<div class="col-12 text-center justify-content-center pt50 pb100"><i class="fa fa-spinner fa-spin fa-4x fa-fw"></i><span class="spinner-text">Determining topics to display...</span></div>');
			$.ajax({
				type	      : "POST",
				dataType    : "html",
				url         : "ajax/topics.php",
				data        :   {
					topic : $topic
				},
				success:function(html){
					$(".news-articles").html(html);
				}
			});
		});

		$(document).on("change", "select[name=topic]", function(event) {
			event.preventDefault();
			var $topic 	= $(this).val();
			var $item 	= $(this);
			$(".news-topics").each(function() {
				$(this).removeClass("active");
			});
			if($topic == 'All') {
				$("a[data-topic=All]").addClass("active");
			} else if($topic == 'News') {
				$("a[data-topic=News]").addClass("active");
			} else if($topic == 'Market') {
				$("a[data-topic=Market]").addClass("active");
			} else if($topic == 'Blogs') {
				$("a[data-topic=Blogs]").addClass("active");
			} else if($topic == 'Off-plan') {
				$("a[data-topic=Off-plan]").addClass("active");
			} else if($topic == 'Tips') {
				$("a[data-topic=Tips]").addClass("active");
			}
			$(".news-articles").html('<div class="col-12 text-center justify-content-center pt50 pb100"><i class="fa fa-spinner fa-spin fa-4x fa-fw"></i><span class="spinner-text">Determining Topics to display...</span></div>');
			$.ajax({
				type	      : "POST",
				dataType    : "html",
				url         : "ajax/topics.php",
				data        :   {
					topic : $topic
				},
				success:function(html){
					$(".news-articles").html(html);
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
