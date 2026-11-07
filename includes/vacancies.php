<!-- Our Vacancies -->
<section class="about-services bg-light pt60 pt30-md pb60 pb30-md">
	<div class="container">
		<div class="row align-items-center wow fadeInUp" data-wow-delay="300ms">
			<div class="col-lg-12">
				<div class="main-title2 text-center">
					<h2 class="title">
						<?php echo decodeData(headLine('Vacancies','title')); ?>
					</h2>
					<h4 class="sub-title mb50 mt10">
						<?php echo decodeData(headLine('Vacancies','tagline')); ?>
					</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 wow fadeInUp" data-wow-delay="300ms">
				<div class="property-city-slider navi_pagi_bottom_center slider-dib-sm slider-3-grid owl-theme owl-carousel">
					<?php while($row_vacancies = $result_vacancies->fetch_assoc()) { ?>
					<div class="item">
						<div class="listing-style1 vacancies bdrs0">
							<div class="list-thumb vacancy-thumb" style="background-image: url('<?php echo localhost.'images/vacancies/'.$row_vacancies['id'].'/'.$row_vacancies['image']; ?>');">
								<a class="apply-now pagescroll" href="#career" title="Apply now" data-vacancy="<?php echo decodeData($row_vacancies['vacancy']); ?>">
									Apply Now
								</a>
							</div>
							<div class="vacancy-item-content">
								<h3>
									<a href="vacancies/<?php echo cleanString($row_vacancies['vacancy'])."-".$row_vacancies['id']; ?>.html" title="<?php echo decodeData($row_vacancies['vacancy']); ?>">
										<?php echo decodeData($row_vacancies['vacancy']); ?>
									</a>
								</h3>
								<p class="mb5">
									<span class="flaticon-maps"></span>
									<?php echo decodeData($row_vacancies['address']); ?>
								</p>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Our Vacancies -->
