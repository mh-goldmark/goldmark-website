<!--Handy buttons starts-->
<div class="handy-buttons gray-bdrt1">
  <div class="d-flex">
    <div class="handy-btn-call col-4">
      <a class="click-to-track" href="tel:<?php echo str_replace($string_replace_mobile,"",decodeData($row_team['mobile'])); ?>" data-phone="<?php echo decodeData($row_team['mobile']); ?>" title="Call Now" data-track="Call">
        <i class="fa fa-volume-control-phone"></i>
        Call Now
      </a>
    </div>
    <div class="handy-btn-whatsapp col-4">
      <a class="click-to-track" href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$company_mobile); ?>&text=Hello <?php echo decodeData($row_team['user_name']); ?>, I would like to learn more about your real estate listings, services, and investment opportunities. I look forward to your response. Thank you!" target="Whatsapp" title="Send Whatsapp" data-track="Whatsapp">
        <i class="fa fa-whatsapp"></i>
        WhatsApp
      </a>
    </div>
    <div class="handy-btn-email col-4">
      <a class="click-to-track" href="mailto:<?php echo strtolower(decodeData($row_team['email'])); ?>?subject=Website Inquiry&body=Hello <?php echo decodeData($row_team['user_name']); ?>, I would like to learn more about your real estate listings, services, and investment opportunities. I look forward to your response. Thank you!" title="Send Email" data-track="Email">
        <i class="fa fa-envelope-o"></i>
        Email Me
      </a>
    </div>
  </div>
</div>
<!--Handy buttons ends-->
