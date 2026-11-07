<!-- CTA Banner -->
<section id="career" class="<?php if($current_page != 'Career') { echo 'bgc-thm-light '; } ?>cta-goldmark pt80 pb80">
	<div class="container">
		<div class="row justify-content-center align-items-start">
			<div class="col-md-6 col-12 cta-details-text wow fadeInLeft" data-wow-delay="400ms">
				<h4>
					<?php echo decodeData(headLine('Career Application','title')); ?>
				</h4>
				<h2 class="title">
					<?php echo decodeData(headLine('Career Application','headline')); ?>
				</h2>
				<div class="general-details">
					<p>
						<?php echo decodeData(nl2br(headLine('Career Application','tagline'))); ?>
					</p>
				</div>
			</div>
			<div class="col-md-6 col-12 cta-form wow mt30-md fadeInRight" data-wow-delay="400ms">
				<form name="careerForm" class="transparent-borders" action="process/process.application.php" method="POST">
					<input type="text" name="name" class="form-control required" placeholder="Full name*" value="<?php echo $_COOKIE['name']; ?>" autocomplete="off">
					<input type="email" name="email" class="form-control required" placeholder="Email address*" value="<?php echo $_COOKIE['email']; ?>" autocomplete="off">
					<input type="text" name="phone" class="form-control required" placeholder="Phone number*" value="<?php echo $_COOKIE['phone']; ?>" autocomplete="off">
					<div class="form-style2 input-group">
						<select name="vacancy" class="selectpicker required" data-live-search="true" data-width="100%">
							<option value="" selected>Vacancy*</option>
							<?php while($row_application = $result_application->fetch_assoc()) { ?>
							<option value="<?php echo decodeData($row_application['vacancy']); ?>"><?php echo decodeData($row_application['vacancy']); ?></option>
							<?php } ?>
						</select>
					</div>
					<input type="file" class="input-field input-field-file required" name="attachment" label="Upload your CV" accept=".pdf,.doc">
					<p>
						By submitting the form, you agree to our <a href="<?php echo webhost; ?>terms-and-conditions.html" title="Terms & Conditions" target="Terms">Terms & Conditions</a> and <a href="<?php echo webhost; ?>privacy-policy.html" title="Privacy Policy" target="Policy">Privacy Policy</a>.
					</p>
					<button class="btn btn-dark-default" type="submit">
						Submit Application
						<i class="fal fa-arrow-right-long"></i>
					</button>
					<input type="hidden" name="recaptcha_response" class="recaptchaResponse" readonly/>
					<input type="hidden" name="email_group" value="Career" readonly/>
					<input type="hidden" name="source" value="Website" readonly/>
					<input type="hidden" name="sub_source" value="Application" readonly/>
				</form>
			</div>
		</div>
	</div>
</section>
<!-- CTA Banner -->
