<!-- Testimonials -->
<?php if($result_testimonials->num_rows >= 3) { ?>
<section class="pt80 pb50-md testimonials">
	<div class="container maxw1600">
		<div class="row">
			<div class="col-lg-8 mx-auto wow fadeInUp" data-wow-delay="300ms">
				<div class="main-title text-center">
					<!--
					<p class="paragraph">
						<?php //echo decodeData(headLine('Testimonials','headline')); ?>
					</p>
					!-->
					<img class="mb20 google-review-img" src="images/google-reviews.png" alt="Google reviews"/>
					<h2 class="title">
						<?php echo decodeData(headLine('Testimonials','title')); ?>
					</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="navi_pagi_bottom_center slider-dib-sm slider-3-grid owl-carousel owl-theme wow fadeInUp" data-wow-delay="300ms">
					<?php while($row_testimonials = $result_testimonials->fetch_assoc()) { ?>
					<div class="item">
						<div class="testimonial-style3 mt-1 mx-1 position-relative mb30">
							<div class="testimonial-content">
								<span class="icon fas fa-quote-left"></span>
								<div class="thumb mb20 text-center">
									<!--
									<div class="d-block">
										<img src="<?php //if(empty($row_testimonials['photo'])) { echo localhost."images/testimonials/image.png"; } else { echo localhost."images/testimonials/".$row_testimonials['photo']; } ?>" alt="<?php //echo decodeData($row_testimonials['full_name']); ?>">
									</div>
									!-->
									<div class="d-block">
										<h6 class="mb-0 mt20">
											<?php echo decodeData($row_testimonials['full_name']); ?>
										</h6>
									</div>
								</div>
								<p class="text text-center mb-0 line-wrapper ten-lines">
									<?php echo decodeData($row_testimonials['testimonial']); ?>
								</p>
								<div class="row justify-content-center align-items-center mt30">
									<div class="testimonial-review-stars">
										<span class="me-1">
											<i class="fas fa-star"></i>
										</span>
										<span class="me-1">
											<i class="fas fa-star"></i>
										</span>
										<span class="me-1">
											<i class="fas fa-star"></i>
										</span>
										<span class="me-1">
											<i class="fas fa-star"></i>
										</span>
										<span>
											<i class="fas fa-star"></i>
										</span>
									</div>
								</div>
								<div class="row justify-content-center mt10">
									<a class="google-link" href="https://www.google.com/search?q=gold+mark+real+estate+broker+l.l.c&rlz=1C1GCEU_enAE1035AE1035&oq=gold+mark+rea&gs_lcrp=EgZjaHJvbWUqDggAEEUYJxg7GIAEGIoFMg4IABBFGCcYOxiABBiKBTIVCAEQLhgnGK8BGMcBGMkDGIAEGIoFMgYIAhBFGDkyDQgDEC4YrwEYxwEYgAQyDAgEEAAYFBiHAhiABDIGCAUQRRg8MgYIBhBFGDwyBggHEEUYPNIBCDgzMzBqMGo3qAIAsAIA&sourceid=chrome&ie=UTF-8#lrd=0x3e5f6e714d604251:0xf1db84b36c21e2df,1" title="Google reviews" target="_blank">
										See it on Google
									</a>
								</div>
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
