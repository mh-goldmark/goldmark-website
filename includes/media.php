<?php if($result_media_images->num_rows >= 4) { ?>
<!-- Media -->
<section class="pt40 pb80 media bg-light">
	<div class="container-fluid">
		<div class="row mt30 wow fadeInUp blogs-articles" data-wow-delay="700ms">
			<div class="col-12">
				<div class="cta-style4 position-relative text-center">
					<h3 class="cta-title fw400 mb30">
						<?php echo decodeData(headLine('Media - Images','title')); ?>
					</h3>
					<h4 class="sub-title fz16 fw400 mb50">
						<?php echo decodeData(headLine('Media - Images','tagline')); ?>
					</h4>
				</div>
			</div>
		</div>
		<div class="row wow fadeInUp blogs-articles" data-wow-delay="900ms">
			<div class="col-lg-12">
				<div class="property-city-slider navi_pagi_bottom_center slider-dib-sm slider-4-grid owl-theme owl-carousel">
					<?php while($row_media_images = $result_media_images->fetch_assoc()) { ?>
					<div class="item">
						<div class="listing-style1">
							<div class="list-thumb">
								<a class="venobox" data-gall="media-gallery" href="<?php echo localhost.'images/media/'.$row_media_images['image']; ?>" title="<?php if(!empty($row_media_images['title'])) { echo decodeData($row_media_images['title']); } else { echo 'Media photos'; } ?>">
									<img src="<?php echo localhost.'images/media/'.$row_media_images['image']; ?>" alt="<?php if(!empty($row_media_images['title'])) { echo decodeData($row_media_images['title']); } else { echo 'Media photos'; } ?>" class="w-100">
								</a>
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
