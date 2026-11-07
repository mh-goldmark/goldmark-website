<?php if($result_blogs->num_rows >= 4) { ?>
<!-- Blog Articles -->
<section class="pt40 pb80 bg-light">
	<div class="container-fluid">
		<div class="row mt30 wow fadeInUp blogs-articles" data-wow-delay="700ms">
			<?php if(!empty($row_article['id'])) { ?>
			<div class="col-lg-9">
				<div class="main-title2 mb40">
					<h3 class="title">
						Topics you may be interested...
					</h3>
				</div>
			</div>
			<?php } else { ?>
			<div class="col-12">
				<div class="main-title text-center mb40">
					<h4 class="paragraph">
						<?php echo decodeData(headLine('Recent Topics','headline')); ?>
					</h4>
					<h3 class="title">
						<?php echo decodeData(headLine('Recent Topics','title')); ?>
					</h3>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="row wow fadeInUp blogs-articles" data-wow-delay="900ms">
			<div class="col-lg-12">
				<div class="property-city-slider navi_pagi_bottom_center slider-dib-sm slider-4-grid owl-theme owl-carousel">
					<?php while($row_blogs = $result_blogs->fetch_assoc()) { ?>
					<div class="item">
						<div class="listing-style1">
							<div class="list-thumb">
								<a href="media-room/<?php echo cleanString($row_blogs['title'])."-".$row_blogs['id']; ?>.html" tilte="<?php echo decodeData($row_blogs['title']); ?>">
									<img src="<?php echo localhost.'images/news/'.$row_blogs['id'].'/'.$row_blogs['images']; ?>" alt="<?php echo decodeData($row_blogs['title']); ?>" class="w-100">
								</a>
							</div>
							<div class="list-content">
								<h2 class="list-title">
									<a href="media-room/<?php echo cleanString($row_blogs['title'])."-".$row_blogs['id']; ?>.html" title="<?php echo decodeData($row_blogs['title']); ?>">
										<?php echo decodeData($row_blogs['title']); ?>
									</a>
								</h2>
								<h3 class="list-location">
									<span class="icon flaticon-clock"></span>
									<?php echo decodeData(date("M j, Y",strtotime($row_blogs['published_date']))); ?>
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
<!-- Blog Articles -->
