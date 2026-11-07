<!-- CTA 1 -->
<section class="our-cta pt0 pb0">
	<div class="cta-banner bgc-f7 mx-auto maxw1600 pt120 pb120 pt60-md pb60-md position-relative">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-7 col-xl-6 wow fadeInLeft">
					<div class="cta-style1">
						<h2 class="cta-title">
							<?php echo decodeData(headLine('Call-to-Action','title')); ?>
						</h2>
						<p class="cta-text mb-0">
							<?php echo decodeData(headLine('Call-to-Action','tagline')); ?>
						</p>
					</div>
				</div>
				<div class="col-lg-5 col-xl-6 wow fadeInRight" data-wow-delay="300ms">
					<div class="cta-btns-style1 d-flex align-items-center justify-content-center justify-content-md-end">
						<a href="contact-alliance-properties.html" class="btn-light-default mr30 mr0-xs" title="<?php echo decodeData($company_name); ?>">
							Talk To Us
							<i class="fal fa-arrow-right-long"></i>
						</a>
						<a href="tel:<?php echo str_replace($replace_mobile_array,"",$company_phone); ?>" class="btn-dark-default" title="Talk to Us">
							<span class="flaticon-call vam pe-2"></span>
							<?php echo $company_phone; ?>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
