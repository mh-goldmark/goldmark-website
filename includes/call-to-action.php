<!-- CTA 2 -->
<section class="cta-banner-dark d-flex align-items-center pt60 pb80">
	<div class="container">
		<div class="row">
			<div class="col-xl-9 col-12 mx-auto wow fadeInUp" data-wow-delay="400ms">
				<div class="cta-style4 position-relative text-center">
					<h3 class="cta-title fw400 text-white mb30">
						<?php echo decodeData(headLine('Call to Action','title')); ?>
					</h3>
					<h4 class="sub-title text-white mb50">
						<?php echo decodeData(headLine('Call to Action','tagline')); ?>
					</h4>
					<div class="d-lg-flex justify-content-between align-items-center">
						<?php while($row_widgets = $result_widgets->fetch_assoc()) { ?>
						<div class="col-12 col-lg-4 mb30-md wow fadeInUp" data-wow-delay="400ms">
							<div class="home-widget d-flex justify-content-start align-items-center">
								<div class="contact-icon text-gray">
									<img class="widget-icon" src="<?php echo localhost.'images/widgets/'.cleanString($row_widgets['category']).'/'.$row_widgets['icon']; ?>" alt="<?php echo decodeData($row_widgets['label']); ?>"/>
								</div>
								<div class="contact-label text-white text-uppercase">
									<?php echo trim(wordwrap(decodeData($row_widgets['label']),15,"<br/>",true)); ?>
								</div>
							</div>
						</div>
						<?php } ?>
					</div>
					<p class="text-white text-uppercase mt30 fz19">
						<?php echo decodeData(headLine('Call to Action','headline')); ?>
					</p>
					<div class="d-block justify-content-center btn-cta">
						<a class="btn-white-default text-uppercase service-call" data-bs-toggle="modal" href="#scheduleCallToggle" role="button" data-source="Company Services" data-subsource="Call Schedule" data-title="Requesting a call back for free valuation" title="Book your free valuations">
							<span class="icon flaticon-investment"></span>
							Free Valuation
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
