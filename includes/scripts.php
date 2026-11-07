<script src="<?php echo path; ?>js/jquery-3.6.4.min.js"></script>
<script src="<?php echo path; ?>js/jquery-migrate-3.0.0.min.js"></script>
<script src="<?php echo path; ?>js/popper.min.js"></script>
<script src="<?php echo path; ?>js/bootstrap.min.js"></script>
<script src="<?php echo path; ?>js/bootstrap-select.min.js"></script>
<script src="<?php echo path; ?>js/jquery.mmenu.all.js"></script>
<script src="<?php echo path; ?>js/ace-responsive-menu.js"></script>
<script src="<?php echo path; ?>js/jquery-scrolltofixed-min.js"></script>
<script src="<?php echo path; ?>js/jquery.counterup.js"></script>
<script src="<?php echo path; ?>js/wow.min.js"></script>
<script src="<?php echo path; ?>js/owl.js"></script>
<script src="<?php echo path; ?>js/swiper.js"></script>
<!--<script src="<?php //echo path; ?>js/pricing-slider.js"></script>!-->
<script src="<?php echo path; ?>js/isotop.js"></script>
<script src="<?php echo path; ?>js/scrollbalance.js"></script>

<!-- Custom script for all pages -->
<script src="<?php echo path; ?>js/script.js"></script>

<script type="text/javascript" src="<?php echo path; ?>assets/sweetalert2/6.6.10/sweetalert2.js"></script>
<script type="text/javascript" src="<?php echo path; ?>assets/venobox/venobox.js"></script>
<script type="text/javascript" src="<?php echo path; ?>js/jquery.clearsearch.js"></script>
<script type="text/javascript" src="<?php echo path; ?>js/custom.file.input.js"></script>
<script type="text/javascript" src="<?php echo path; ?>js/jquery.jscroll.min.js"></script>
<script type="text/javascript" src="<?php echo path; ?>js/jquery.jscroll.js"></script>

<!--Google Map API-->
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_api_key; ?>&sensor=false&libraries=places"></script>

<script src="https://apis.google.com/js/platform.js" async defer></script>

<script src="<?php echo path; ?>js/infobox.js"></script>
<script src="<?php echo path; ?>js/markerclusterer.js"></script>

<!-- Custom javascript -->
<script src="<?php echo path; ?>js/custom.js"></script>

<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptcha_key; ?>"></script>

<script>
function execute_captcha() {
	grecaptcha.execute('<?php echo $recaptcha_key; ?>', { action: 'goldmark' }).then(function (token) {
    $(".recaptchaResponse").val(token);
	});
}

if($(".recaptchaResponse").length) {
  grecaptcha.ready(function() {
	   execute_captcha();
   });
}
</script>
