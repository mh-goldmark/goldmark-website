<!-- Service Popups -->
<div class="signup-modal contact-agent">
  <div class="modal fade" id="scheduleCallToggle" aria-hidden="true" aria-labelledby="scheduleCallToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="scheduleCallToggleLabel">
            <span class="flaticon-review"></span>
            Request a call back
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body mt20">
          <div class="log-reg-form">
            <form name="scheduleCall" class="gray-borders" action="process/process.callschedule.php" method="POST">
              <div class="form-style1">
                <div class="mb15">
                  <input type="text" name="name" class="form-control required" placeholder="Name*" value="<?php echo $_COOKIE['name']; ?>" autocomplete="off">
                </div>
                <div class="mb15">
                  <input type="email" name="email" class="form-control required" placeholder="Email*" value="<?php echo $_COOKIE['email']; ?>" autocomplete="off">
                </div>
                <div class="mb15">
                  <input type="text" name="phone" class="form-control required" placeholder="Phone*" value="<?php echo $_COOKIE['phone']; ?>" autocomplete="off">
                </div>
                <p>
									By submitting the form, you agree to our <a href="<?php echo webhost; ?>terms-and-conditions.html" title="Terms & Conditions" target="Terms">Terms & Conditions</a> and <a href="<?php echo webhost; ?>privacy-policy.html" title="Privacy Policy" target="Policy">Privacy Policy</a>.
								</p>
                <div class="d-grid mb20">
                  <button class="btn-dark-default" type="submit">
                    Send Request
                    <i class="fal fa-arrow-right-long"></i>
                  </button>
                  <input type="hidden" name="recaptcha_response" class="recaptchaResponse" readonly/>
                  <input type="hidden" name="email_group" value="Inquiry" readonly/>
                  <input type="hidden" name="subject" readonly/>
                  <input type="hidden" name="source" readonly/>
                  <input type="hidden" name="sub_source" readonly/>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
