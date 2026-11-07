<?php
$email_address = explode("@",$company_email);
?>
<div class="preloader"></div>
<!-- Main Header Nav -->
<header class="header-nav nav-homepage-style menu-home4 stricky main-menu">
  <!-- Ace Responsive Menu -->
  <nav class="posr">
    <div class="container maxw1600 posr menu_bdrt1">
      <div class="row align-items-center justify-content-center">
        <div class="col-menu-left">
          <!-- Responsive Menu Structure-->
          <ul class="ace-responsive-menu menu-list" data-menu-style="horizontal">
            <li class="visible_list">
              <a class="list-item" href="<?php echo webhost; ?>gold-mark-real-estate-list-property.html" title="List a property">
                <span class="title">
                  List a property
                </span>
              </a>
            </li>
            <li class="visible_list">
              <a class="list-item" href="<?php echo webhost; ?>developments.html" title="New developments">
                <span class="title">
                  Off-plan
                </span>
              </a>
            </li>
            <li class="visible_list">
              <a class="list-item" href="<?php echo webhost; ?>gold-mark-real-estate-career.html" title="Join the team">
                <span class="title">
                  Join the team
                </span>
              </a>
            </li>
          </ul>
        </div>
        <div class="col-menu-middle">
          <a class="header-logo logo1" href="<?php echo webhost; ?>" title="<?php echo decodeData($company_name); ?>">
            <img src="images/logos/gold-mark-real-estate-logo-light.svg" alt="<?php echo decodeData($company_name); ?>"/>
          </a>
          <a class="header-logo logo2" href="<?php echo webhost; ?>" title="<?php echo decodeData($company_name); ?>">
            <img src="images/logos/gold-mark-real-estate-logo-dark.svg" alt="<?php echo decodeData($company_name); ?>"/>
          </a>
        </div>
        <div class="col-menu-right">
          <ul id="respMenu" class="ace-responsive-menu menu-list">
            <li class="visible_list">
              <a class="list-item" href="<?php echo webhost; ?>about-gold-mark-real-estate.html" title="About us">
                <span class="title">
                  Who we are
                </span>
              </a>
            </li>
            <li class="visible_list">
              <a class="list-item" href="<?php echo webhost; ?>gold-mark-real-estate-team.html" title="Meet the team">
                <span class="title">
                  The Experts
                </span>
              </a>
            </li>
            <li class="visible_list">
              <a class="list-item" href="<?php echo webhost; ?>contact-gold-mark-real-estate.html" title="Connect with us">
                <span class="title">
                  Connect with us
                </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>

<!-- Mobile Nav  -->
<div id="page" class="mobilie_header_nav stricky stylehome1">
  <div class="mobile-menu">
    <div class="header innerpage-style">
      <div class="menu_and_widgets">
        <div class="mobile_menu_bar d-flex justify-content-between align-items-center">
          <a class="menubar menubar1" href="#menu">
            <img src="images/mobile-light-nav-icon.svg" alt="Menu">
          </a>
          <a class="menubar menubar2" href="#menu">
            <img src="images/mobile-dark-nav-icon.svg" alt="Menu">
          </a>
          <a class="mobile_logo logo1" href="<?php echo webhost; ?>" title="<?php echo decodeData($company_name); ?>">
            <img src="images/logos/gold-mark-real-estate-logo-light.svg" alt="<?php echo decodeData($company_name); ?>">
          </a>
          <a class="mobile_logo logo2" href="<?php echo webhost; ?>" title="<?php echo decodeData($company_name); ?>">
            <img src="images/logos/gold-mark-real-estate-logo-dark.svg" alt="<?php echo decodeData($company_name); ?>">
          </a>
          <a href="#" class="slider-search">
            <span class="flaticon-search"></span>
          </a>
        </div>
      </div>
    </div>
  </div>
  <!-- /.mobile-menu -->
  <nav id="menu" class="menu-mobile">
    <ul>
      <li>
        <a href="<?php echo webhost; ?>about-gold-mark-real-estate.html" title="About us">
          <i class="fal fa-arrow-right-long"></i>
          <span>
            Who we are
          </span>
        </a>
      </li>
      <li>
        <a href="<?php echo webhost; ?>gold-mark-real-estate-team.html" title="Meet the team">
          <i class="fal fa-arrow-right-long"></i>
          <span>
            The experts
          </span>
        </a>
      </li>
      <li>
        <a href="<?php echo webhost; ?>gold-mark-real-estate-list-property.html" title="List a property">
          <i class="fal fa-arrow-right-long"></i>
          <span>
            List a property
          </span>
        </a>
      </li>
      <li>
        <a href="<?php echo webhost; ?>developments.html" title="New developments">
          <i class="fal fa-arrow-right-long"></i>
          <span>
            Off-plan projects
          </span>
        </a>
      </li>
      <li>
        <a href="<?php echo webhost; ?>communities.html" title="Popular communities">
          <i class="fal fa-arrow-right-long"></i>
          <span>
            Popular communities
          </span>
        </a>
      </li>
      <li>
        <a href="<?php echo webhost; ?>gold-mark-real-estate-career.html" title="Join the team">
          <i class="fal fa-arrow-right-long"></i>
          <span>
            Join the team
          </span>
        </a>
      </li>
      <li>
        <a href="<?php echo webhost; ?>gold-mark-real-estate-media.html" title="Media room">
          <i class="fal fa-arrow-right-long"></i>
          <span>
            Media room
          </span>
        </a>
      </li>
      <li>
        <a href="<?php echo webhost; ?>contact-gold-mark-real-estate.html" title="Connect with us">
          <i class="fal fa-arrow-right-long"></i>
          <span>
            Connect with us
          </span>
        </a>
      </li>
      <!-- Only for Mobile View -->
    </ul>
  </nav>
</div>
