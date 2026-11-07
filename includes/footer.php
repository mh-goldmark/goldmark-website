<!-- Our Footer -->
<section class="footer-style1 bg-black at-home4 pt60 pb-0">
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-6 col-12">
        <div class="footer-widget mb-4 mb-lg-5 ps-0 ps-lg-5">
          <div class="link-style1 light-style mb30">
            <h3 class="mb25">
              Contact info
            </h3>
            <ul class="ps-0 footer-address">
              <li>
                <span>
                  <i class="icon flaticon-corporation"></i>
                </span>
                <?php echo $company_address; ?>
              </li>
              <li>
                <span>
                  <i class="icon flaticon-maps-1"></i>
                </span>
                <?php if(!empty($company_office)) { echo 'Office '.$company_office.', '; } ?><?php if(!empty($company_pobox)) { echo 'P.O. Box '.$company_pobox; } ?>
              </li>
              <li>
                <span>
                  <i class="fa fa-envelope-o"></i>
                </span>
                <script language=javascript>
                  var email = "info"
                  var emailHost = "goldmark.ae"
                  document.write(email + "@" + emailHost)
                </script>
              </li>
              <li>
                <span>
                  <i class="fa fa-volume-control-phone"></i>
                </span>
                <a href="tel:<?php echo str_replace(' ','',$company_phone); ?>" title="<?php echo str_replace(' ','',$company_phone); ?>">
                  <?php echo $company_phone; ?>
                </a>
              </li>
              <li>
                <span>
                  <i class="icon flaticon-smartphone"></i>
                </span>
                <a href="tel:<?php echo str_replace(' ','',$company_mobile); ?>" title="<?php echo str_replace(' ','',$company_mobile); ?>">
                  <?php echo $company_mobile; ?>
                </a>
              </li>
            </ul>
          </div>
          <div class="social-widget text-start">
            <div class="social-style1 light-style">
              <a href="<?php echo $company_facebook; ?>" title="Facebook" target="_blank">
                <i class="fab fa-facebook-f list-inline-item"></i>
              </a>
              <a href="<?php echo $company_instagram; ?>" title="Instagram" target="_blank">
                <i class="fab fa-instagram list-inline-item"></i>
              </a>
              <a href="<?php echo $company_linkedin; ?>" title="Linkedin" target="_blank">
                <i class="fab fa-linkedin-in list-inline-item"></i>
              </a>
              <a class="tiktok" href="<?php echo $company_tiktok; ?>" title="TikTok" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" fill="#C0A06F"/></svg>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 col-12">
        <div class="footer-widget mb-4 mb-lg-5 ps-0 ps-lg-5">
          <div class="link-style1 light-style mb-3">
            <h3 class="mb25">
              Quick links
            </h3>
            <ul class="ps-0">
              <li>
                <a href="<?php echo webhost; ?>developments.html" title="New developments">
                  New Developments
                </a>
              </li>
              <li>
                <a href="<?php echo webhost; ?>communities.html" title="Popular communities">
                  Popular Communities
                </a>
              </li>
              <li>
                <a href="<?php echo webhost; ?>gold-mark-real-estate-career.html" title="Career opportunity">
                  Career Opportunity
                </a>
              </li>
              <li>
                <a href="<?php echo webhost; ?>gold-mark-real-estate-media.html" title="Media room">
                  Media Room
                </a>
              </li>
              <li>
                <a href="<?php echo webhost; ?>contact-gold-mark-real-estate.html" title="Contact us">
                  Contact Us
                </a>
              </li>
              <!--
              <li>
                <a href="<?php //echo webhost; ?>gold-mark-real-estate-faq.html" title="Frequently asked questions" target="_blank">
                  FAQs
                </a>
              </li>
              !-->
              <li>
                <a href="<?php echo webhost; ?>website-cookies.html" title="Website cookies" target="_blank">
                  Website Cookies
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="footer-widget mb-4 mb-lg-5">
          <div class="mailchimp-widget mb30">
            <h4 class="title mb30">
              Stay connected!
            </h4>
            <div class="mailchimp-style1 at-home7 white-version">
              <form name="registerForm" class="white-borders" action="process/process.registration.php" method="POST">
                <input type="text" name="phone" class="form-control required" placeholder="Enter your mobile number" value="<?php echo $_COOKIE['phone']; ?>" autocomplete="off">
                <input type="email" name="email" class="form-control required" placeholder="Enter your email address" value="<?php echo $_COOKIE['email']; ?>" autocomplete="off">
                <p>
                  By submitting the form, you have read and agree to our <a href="<?php echo webhost; ?>terms-and-conditions.html" title="Terms & Conditions" target="Terms">Terms & Conditions</a> and <a href="<?php echo webhost; ?>privacy-policy.html" title="Privacy Policy" target="Policy">Privacy Policy</a>.
                </p>
                <button class="btn" type="submit">
                  Subscribe now
                  <i class="far fa-arrow-right-long"></i>
                </button>
                <input type="hidden" name="recaptcha_response" class="recaptchaResponse" readonly/>
                <input type="hidden" name="email_group" value="Registration" readonly/>
                <input type="hidden" name="source" value="Website" readonly/>
                <input type="hidden" name="sub_source" value="Registration" readonly/>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="footer-style1 at-home4 pt-0 pb-0">
  <div class="container gray-bdrt1 py-3 pb80-md">
    <div class="row">
      <div class="col-sm-12">
        <div class="text-center">
          <p class="copyright-text ff-heading mb-0">
            Copyright &copy; <?php echo date("Y"); ?> <?php echo $company_name; ?>. Powered by www.goldmark.app
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<a class="scrollToHome" href="#">
  <i class="fas fa-angle-up"></i>
</a>

<div class="ft-wapp-btn">
  <a class="click-to-track" href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$company_mobile); ?>&text=Hello Gold Mark, I would like to learn more about your real estate listings, services, and investment opportunities. I look forward to your response. Thank you!" target="Whatsapp" title="Send us WhatsApp" data-track="Whatsapp">
    <i class="fa fa-whatsapp"></i>
    <span>Chat with us</span>
  </a>
</div>

<!-- Email Agent -->
<div class="signup-modal contact-agent">
  <div class="modal fade" id="contactAgentToggle" aria-hidden="true" aria-labelledby="contactAgentToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="contactAgentToggleLabel">
            <span class="flaticon-email"></span>
            Contact Agent
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body mt20">
          <div class="log-reg-form">
            <form name="contactAgent" class="gray-borders" action="process/process.inquiry.php" method="POST">
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
                <div class="mb5">
                  <textarea class="required" name="message" placeholder="Message*" rows="4"></textarea>
                </div>
                <p>
									By submitting the form, you agree to our <a href="<?php echo webhost; ?>terms-and-conditions.html" title="Terms & Conditions" target="Terms">Terms & Conditions</a> and <a href="<?php echo webhost; ?>privacy-policy.html" title="Privacy Policy" target="Policy">Privacy Policy</a>.
								</p>
                <div class="d-grid mb20">
                  <button class="btn-dark-default" type="submit">
                    Inquire Now
                    <i class="fal fa-arrow-right-long"></i>
                  </button>
                  <input type="hidden" name="recaptcha_response" class="recaptchaResponse" readonly/>
                  <input type="hidden" name="email_group" value="Inquiry" readonly/>
                  <input type="hidden" name="refno" readonly/>
                  <input type="hidden" name="user" readonly/>
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
