<!--Handy buttons starts-->
<div class="handy-buttons gray-bdrt1">
  <div class="d-flex">
    <div class="handy-btn-call col-4">
      <a class="click-to-track" href="tel:<?php echo str_replace($string_replace_mobile,"",decodeData($row_listing['mobile'])); ?>" data-phone="<?php echo decodeData($row_listing['mobile']); ?>" title="Call Now" data-track="Call">
        <i class="fa fa-volume-control-phone"></i>
        Call Now
      </a>
    </div>
    <div class="handy-btn-whatsapp col-4">
      <a class="click-to-track" href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",decodeData($company_mobile)); ?>&text=Hello <?php echo ucwords(decodeData($row_listing['user_name'])); ?>, I found this property <?php echo ucwords(decodeData($row_listing['title'])); ?> [Ref <?php echo $refno_code.$row_listing['listing_id']; ?>] on Gold Mark Real Estate website and I'm interested in learning more. Please contact me at your earliest convenience. Thank you!" target="Whatsapp" title="Send Whatsapp" data-track="Whatsapp">
        <i class="fa fa-whatsapp"></i>
        WhatsApp
      </a>
    </div>
    <div class="handy-btn-email col-4">
      <a class="click-to-track" href="mailto:<?php echo strtolower(decodeData($row_listing['email'])); ?>?subject=Website Inquiry&body=Hello <?php echo ucwords(decodeData($row_listing['user_name'])); ?>, I found this property <?php echo ucwords(decodeData($row_listing['title'])); ?> [Ref <?php echo $refno_code.$row_listing['listing_id']; ?>] on Gold Mark Real Estate website and I'm interested in learning more. Please contact me at your earliest convenience. Thank you!" title="Send Email" data-track="Email">
        <i class="fa fa-envelope-o"></i>
        Email Me
      </a>
    </div>
  </div>
</div>
<!--Handy buttons ends-->
