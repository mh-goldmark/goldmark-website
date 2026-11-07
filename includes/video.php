<?php if($result_media_videos->num_rows >= 4) { ?>
<!-- Media -->
<section class="pt40 pb80 media bg-light">
	<div class="container-fluid">
		<div class="row mt30 wow fadeInUp blogs-articles" data-wow-delay="700ms">
			<div class="col-12">
				<div class="cta-style4 position-relative text-center">
					<h3 class="cta-title fw400 mb30">
						<?php echo decodeData(headLine('Media - Videos','title')); ?>
					</h3>
					<h4 class="sub-title fz16 fw400 mb50">
						<?php echo decodeData(headLine('Media - Videos','tagline')); ?>
					</h4>
				</div>
			</div>
		</div>
		<div class="row wow fadeInUp blogs-articles" data-wow-delay="900ms">
			<div class="col-lg-12">
				<div class="property-city-slider navi_pagi_bottom_center slider-dib-sm slider-4-grid owl-theme owl-carousel">
					<?php while($row_media_videos = $result_media_videos->fetch_assoc()) { ?>
					<div class="item">
						<div class="listing-style1">
							<div class="list-thumb">
								<a href="<?php echo decodeData($row_media_videos['url']); ?>" tilte="<?php echo decodeData($row_media_videos['title']); ?>" target="_blank">
									<img src="<?php echo localhost.'images/media/'.$row_media_videos['image']; ?>" alt="<?php echo decodeData($row_media_videos['title']); ?>" class="w-100">
									<div class="video-play d-flex justify-content-center align-items-center">
										<i class="fa fa-4x text-white fa-play-circle"></i>
									</div>
								</a>
							</div>
							<div class="list-content">
								<h2 class="list-title">
									<a href="<?php echo decodeData($row_media_videos['url']); ?>" title="<?php echo decodeData($row_media_videos['title']); ?>" target="_blank">
										<?php echo decodeData($row_media_videos['title']); ?>
									</a>
								</h2>
								<h3 class="list-location">
									<span class="icon flaticon-clock"></span>
									<?php echo decodeData(date("M j, Y",strtotime($row_media_videos['inserted_date']))); ?>
								</h3>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>
<!-- Media -->
