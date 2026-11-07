<!-- side menu -->
<div class="side-search left">
  <div class="inner-wrapper">
    <span class="btn-close" id="btn_sideSearchClose">
      <i></i>
      <i></i>
    </span>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-12">
          <h2 class="pt60 pt40-sm mb40 text-white text-center">
            Find A Property
          </h2>
          <form name="advSearch" method="GET" action="properties">
            <div class="col-12 search-category mb35">
              <div class="form-style2 input-group">
                <select name="category" class="selectpicker" data-live-search="true" data-width="100%">
                  <option value="Residential" <?php if(empty($_GET['category']) || $_GET['category'] == 'Residential') { echo 'selected'; } ?>>Residential Properties</option>
                  <option value="Commercial" <?php if($_GET['category'] == 'Commercial') { echo 'selected'; } ?>>Commercial Properties</option>
                  <option value="Off-Plan" <?php if($_GET['category'] == 'Off-Plan') { echo 'selected'; } ?>>Off-plan Properties</option>
                </select>
              </div>
            </div>
            <div class="col-12 search-category mb35">
              <div class="form-style2 input-group">
                <select name="class" class="selectpicker" data-live-search="true" data-width="100%">
                  <option value="All" <?php if(empty($_GET['class']) || $_GET['class'] == 'All') { echo 'selected'; } ?>>All Offers</option>
                  <option value="Sale" <?php if($_GET['class'] == 'Sale') { echo 'selected'; } ?>>Buy</option>
                  <option value="Rent" <?php if($_GET['class'] == 'Rent') { echo 'selected'; } ?>>Rent</option>
                </select>
              </div>
            </div>
            <div class="col-12 mb35">
              <input name="location" class="form-control" autocomplete="off" value="<?php echo $_GET['location']; ?>" placeholder="Location or project name here..."/>
            </div>
            <div class="col-12 search-property-type mb35">
              <div class="form-style2 input-group">
                <select name="type" class="selectpicker proptype" data-live-search="true" data-width="100%">
                  <option value="" <?php if(empty($_GET['type'])) { echo 'selected'; } ?>>All Types</option>
                  <?php while($row_search_property_types = $property_types_search->fetch_assoc()) { ?>
                  <?php if($_GET['type'] == $row_search_property_types['property_type']) { ?>
                  <option value="<?php echo decodeData($row_search_property_types['property_type']); ?>" data-tokens="<?php echo decodeData($row_search_property_types['property_type']); ?>" selected><?php echo decodeData($row_search_property_types['property_type']); ?></option>
                  <?php } else { ?>
                  <option value="<?php echo decodeData($row_search_property_types['property_type']); ?>" data-tokens="<?php echo decodeData($row_search_property_types['property_type']); ?>"><?php echo decodeData($row_search_property_types['property_type']); ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-md-12 search-bedroom mb35">
                <div class="form-style2 input-group">
                  <select name="minbed" class="selectpicker bedroom" data-live-search="true" data-width="100%">
                    <option value="" <?php if($_GET['minbed'] == '') { echo 'selected'; } ?>>Min Bed</option>
                    <option value="0" <?php if($_GET['minbed'] == '0') { echo 'selected'; } ?>>Studio</option>
                    <option value="1" <?php if($_GET['minbed'] == '1') { echo 'selected'; } ?>>1 Bedroom</option>
                    <option value="2" <?php if($_GET['minbed'] == '2') { echo 'selected'; } ?>>2 Bedroom</option>
                    <option value="3" <?php if($_GET['minbed'] == '3') { echo 'selected'; } ?>>3 Bedroom</option>
                    <option value="4" <?php if($_GET['minbed'] == '4') { echo 'selected'; } ?>>4 Bedroom</option>
                    <option value="5" <?php if($_GET['minbed'] == '5') { echo 'selected'; } ?>>5 Bedroom</option>
                    <option value="6" <?php if($_GET['minbed'] == '6') { echo 'selected'; } ?>>6 Bedroom</option>
                    <option value="7+" <?php if($_GET['minbed'] == '7+') { echo 'selected'; } ?>>7+ Bedroom</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 search-bedroom mb35">
                <div class="form-style2 input-group">
                  <select name="maxbed" class="selectpicker bedroom" data-live-search="true" data-width="100%">
                    <option value="" <?php if($_GET['maxbed'] == '') { echo 'selected'; } ?>>Max Bed</option>
                    <option value="0" <?php if($_GET['maxbed'] == '0') { echo 'selected'; } ?>>Studio</option>
                    <option value="1" <?php if($_GET['maxbed'] == '1') { echo 'selected'; } ?>>1 Bedroom</option>
                    <option value="2" <?php if($_GET['maxbed'] == '2') { echo 'selected'; } ?>>2 Bedroom</option>
                    <option value="3" <?php if($_GET['maxbed'] == '3') { echo 'selected'; } ?>>3 Bedroom</option>
                    <option value="4" <?php if($_GET['maxbed'] == '4') { echo 'selected'; } ?>>4 Bedroom</option>
                    <option value="5" <?php if($_GET['maxbed'] == '5') { echo 'selected'; } ?>>5 Bedroom</option>
                    <option value="6" <?php if($_GET['maxbed'] == '6') { echo 'selected'; } ?>>6 Bedroom</option>
                    <option value="7+" <?php if($_GET['maxbed'] == '7+') { echo 'selected'; } ?>>7+ Bedroom</option>
                  </select>
                </div>
              </div>
              <div class="col-lg-6 col-md-12 search-size mb35 form-group">
                <input name="minsize" class="form-control number-comma min-max" autocomplete="off" placeholder="Min size" value="<?php echo $_GET['minsize']; ?>" data-type="Size" data-range="Min"/>
                <div class="inline-label">
                  sqft
                </div>
              </div>
              <div class="col-lg-6 col-md-12 search-size mb35 form-group">
                <input name="maxsize" class="form-control number-comma min-max" autocomplete="off" placeholder="Max size" value="<?php echo $_GET['maxsize']; ?>" data-type="Size" data-range="Max"/>
                <div class="inline-label">
                  sqft
                </div>
              </div>
              <div class="col-lg-6 col-md-12 search-price mb35 form-group">
                <input name="minprice" class="form-control number-comma min-max" autocomplete="off" placeholder="Min price" value="<?php echo $_GET['minprice']; ?>" data-type="Price" data-range="Min"/>
                <div class="inline-label">
                  AED
                </div>
              </div>
              <div class="col-lg-6 col-md-12 search-price mb35 form-group">
                <input name="maxprice" class="form-control number-comma min-max" autocomplete="off" placeholder="Max price" value="<?php echo $_GET['maxprice']; ?>" data-type="Price" data-range="Max"/>
                <div class="inline-label">
                  AED
                </div>
              </div>
            </div>
            <div class="col-12 text-center">
              <button type="submit" class="button btnsecondary mt20">
                <span class="flaticon-search-1"></span>
                Find A Property
              </button>
              <input type="hidden" name="sort" autocomplete="off" value="<?php if(!empty($_GET['sort'])) { echo $_GET['sort']; } else { echo 'recent'; } ?>" readonly/>
            </div>
          </form>
        </div>
      </div>
    </div>

    <ul class="social-icons-simple text-white mt50 mb20 w-100 text-center">
      <li>
        <a href="<?php echo $company_facebook; ?>" title="Facebook" target="_blank">
          <i class="fab fa-facebook-f list-inline-item"></i>
        </a>
      </li>
      <li>
        <a href="<?php echo $company_linkedin; ?>" title="Instagram" target="_blank">
          <i class="fab fa-linkedin-in list-inline-item"></i>
        </a>
      </li>
      <li>
        <a href="<?php echo $company_instagram; ?>" title="Linkedin" target="_blank">
          <i class="fab fa-instagram list-inline-item"></i>
        </a>
      </li>
      <li>
        <a href="<?php echo $company_tiktok; ?>" title="TikTok" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z" fill="#C0A06F"/></svg>
        </a>
      </li>
    </ul>
    <p class="text-white text-center">
      Copyright &copy; <?php echo date("Y"); ?> <?php echo $company_name; ?>. All rights reserved. Powered by www.goldmark.app
    </p>
  </div>
</div>
<!-- End side menu -->
