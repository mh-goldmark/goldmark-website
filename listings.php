<?php
/********************************************************
Copyright © 2024 Engr. Dom Sahagun. All rights reserved.
********************************************************/
include_once("includes/constants.php");
require_once(absolutedir."config/connect.php");
include_once(absolutedir."includes/function.class.php");
require_once(absolutedir."config/settings.php");
require_once(absolutedir."query/listings.php");
?>
<?php if($result_listings->num_rows >= 1) { ?>
<div class="row">
<?php while($row_listings = $result_listings->fetch_assoc()) {
  if(!empty($row_listings['images'])) {
    $img_listing_explode 	= explode(",",$row_listings['images']);
    $count_listing_images = count($img_listing_explode);
  } else {
    $count_listing_images = 0;
  }

  $sql_listing_image = $conn->query("SELECT image_name, image_caption, watermark FROM tbl_images WHERE reference = '".$row_listings['listing_id']."' AND image_order = 1 LIMIT 1");
  $row_listing_image = $sql_listing_image->fetch_assoc();

  //$sql_listing_image = $conn->query("SELECT image_name, image_caption, watermark, image_order FROM tbl_images WHERE reference = '".$row_listings['listing_id']."' AND chk_default = true ORDER by image_order ASC");

  if(!empty($row_listings['page_title'])) {
    $page_title = $row_listings['page_title'];
  } else {
    $page_title = $row_listings['title'];
  }

  if($row_listings['category'] == 'Commercial') {
    $url_category = 'commercials';
  } else {
    $url_category = 'residentials';
  }
	if(in_array($row_listings['property_type'],$property_type_apartment)) {
    $url_type = 'apartments';
	} elseif(in_array($row_listings['property_type'],$property_type_villa)) {
		$url_type = 'villas';
	} elseif(in_array($row_listings['property_type'],$property_type_office)) {
		$url_type = 'offices';
  } elseif($row_listings['property_type'] == "Retail") {
    $url_type = 'shops';
	} elseif($row_listings['property_type'] == "Building") {
    $url_type = 'buildings';
	} elseif($row_listings['property_type'] == "Land") {
    $url_type = 'plots';
  } else {
		$url_type = 'apartments';
	}

  if(!empty($row_listings['building_name'])) {
    $listing_url = $url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($row_listings['building_name'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
    $listing_caption = decodeData($row_listings['building_name']);
  } elseif(!empty($row_listings['property'])) {
    $listing_url = $url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($row_listings['property'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
    $listing_caption = decodeData($row_listings['property']);
  } elseif(!empty($row_listings['sub_location'])) {
    $listing_url = $url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($row_listings['sub_location'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
    $listing_caption = decodeData($row_listings['sub_location']);
  } else {
    $listing_url = $url_category."/".$url_type."-for-".cleanString($row_listings['listing_type'])."/".cleanString($row_listings['location'])."/".cleanString($page_title)."-".$row_listings['listing_id'].".html";
    $listing_caption = decodeData($row_listings['location']);
  }
  if(!empty($row_listing_image['image_caption'])) {
    $image_caption = $listing_caption.' - '.decodeData($row_listing_image['image_caption']);
  } else {
    $image_caption = $listing_caption;
  }

  $listing_description = explode("\n", $row_listings['description']);
  ?>
  <div class="col-12 col-sm-6 col-lg-4 items-listings">
    <div class="listing-style1 mb30">
      <div class="list-thumb">
        <a href="<?php echo $listing_url; ?>" tilte="<?php echo $page_title; ?>">
          <?php //if($row_listing_image['watermark'] == true) { ?>
            <!--
            <img src="<?php //echo localhost.'images/watermark/listing?filename='.$row_listing_image['image_name'].'&id='.$row_listings['listing_id']; ?>" alt="<?php //echo $image_caption; ?>" class="w-100">
            !-->
          <?php //} else { ?>
            <img src="<?php echo localhost.'images/listings/'.$row_listings['listing_id'].'/'.$row_listing_image['image_name']; ?>" alt="<?php echo $image_caption; ?>" class="w-100">
          <?php //} ?>
        </a>
        <div class="list-tag d-flex">
          <div class="list-class">
            <?php echo decodeData($row_listings['listing_type']); ?>
          </div>
          <div class="listing-price"<?php if($row_listings['verified'] == true) { echo ' data-bs-toggle="tooltip" data-bs-placement="right" title="This indicates that the listing is verified by Propertyfinder"'; } ?>>
            AED <?php echo number_format($row_listings['list_price'],0); ?>
            <?php if($row_listings['verified'] == true) { ?>
            <img class="verification-icon" src="images/icon/verified-icon.svg" alt="Verified Listing"/>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="list-content">
        <h2 class="list-title">
          <a href="<?php echo $listing_url; ?>" title="<?php echo $page_title; ?>">
            <?php echo decodeData($row_listings['title']); ?>
          </a>
        </h2>
        <h3 class="list-location">
          <span class="icon flaticon-maps-1"></span>
          <?php
          if(!empty($row_listings['building_name'])) {
            echo decodeData($row_listings['building_name']).', '.decodeData($row_listings['sub_location']);
          } elseif(!empty($row_listings['property'])) {
            echo decodeData($row_listings['property']).', '.decodeData($row_listings['sub_location']);
          } else {
            echo decodeData($row_listings['sub_location']).', '.decodeData($row_listings['location']);
          }
          ?>
        </h3>
        <div class="list-meta d-flex align-items-center">
          <?php if($row_listings['category'] == 'Residential') { ?>
          <div class="list-details mr10">
            <span class="flaticon-bed mr5"></span>
            <?php
            if(empty($row_listings['bedrooms'])) {
              echo "studio";
            } else {
              echo $row_listings['bedrooms'].' bed';
            }
            ?>
          </div>
          <div class="list-details mr10">
            <span class="flaticon-shower mr5"></span>
            <?php
            if(empty($row_listings['bathrooms'])) {
              echo "-";
            } else {
              echo $row_listings['bathrooms'].' bath';
            }
            ?>
          </div>
          <?php } else { ?>
          <?php
          if(in_array($row_listings['property_type'],$property_type_land)) {
          if($row_listings['plot_size'] != '0.00') {
          ?>
          <div class="list-details mr10">
            AED <?php echo number_format(($row_listings['list_price']/$row_listings['plot_size']),0).' per '.$row_listings['plot_measurement']; ?>
          </div>
          <?php } ?>
          <?php } else { ?>
          <?php if($row_listings['unit_size'] != '0.00') { ?>
          <div class="list-details mr10">
            AED <?php echo number_format(($row_listings['list_price']/$row_listings['unit_size']),0).' per '.$row_listings['size_measurement']; ?>
          </div>
          <?php } ?>
          <?php } ?>
          <?php } ?>
          <div class="list-details">
            <span class="flaticon-expand mr5"></span>
            <?php
            if(in_array($row_listings['property_type'],$property_type_land)) {
              if($row_listings['plot_size'] != '0.00') {
                echo number_format($row_listings['plot_size'],0).' '.$row_listings['plot_measurement'];
              } else {
                echo '-';
              }
            } else {
              if($row_listings['unit_size'] != '0.00') {
                echo number_format($row_listings['unit_size'],0).' '.$row_listings['size_measurement'];
              } else {
                echo '-';
              }
            }
            ?>
          </div>
        </div>
        <hr class="mt-2 mb-3">
        <div class="list-meta2">
          <div class="icons d-flex justify-content-between align-items-center">
            <a href="tel:<?php echo str_replace($string_replace_mobile,"",$row_listings['mobile']); ?>" title="Call Me">
              <span class="flaticon-call"></span>
              Call
            </a>
            <a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$company_mobile); ?>&text=Hello%20<?php echo decodeData($row_listings['user_name']); ?>, I found this property <?php echo decodeData($row_listings['title']); ?> [Ref <?php if($row_listings['chk_reapit'] == true) { echo decodeData($row_listings['refno']); } else { echo $refno_code.decodeData($row_listings['listing_id']); } ?>] on Gold Mark Real Estate website and I'm interested in learning more. Please contact me at your earliest convenience. Thank you!" title="Whatsapp Me" target="_blank">
              <span class="flaticon-whatsapp"></span>
              Whatsapp
            </a>
            <a class="email-agent" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Agent Listing" data-subsource="Email Lead" data-user="<?php echo decodeData($row_listings['user_id']); ?>" data-refno="<?php if($row_listings['chk_reapit'] == true) { echo decodeData($row_listings['refno']); } else { echo $refno_code.decodeData($row_listings['listing_id']); } ?>" data-agent="<?php echo decodeData($row_listings['full_name']); ?>" data-title="<?php echo decodeData($row_listings['title']); ?>" title="Send Email">
              <span class="flaticon-email"></span>
              Email
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php unset($sql_listing_image,$row_listing_image,$image_caption,$img_listing_explode,$count_listing_images,$listing_url,$page_title,$url_category,$listing_description); ?>
  <?php } ?>
</div>
<?php } else { ?>
  <div class="row no_result text-center">
    <p><?php echo $search_result_text; ?></p>
  </div>
<?php } ?>

<div class="clearfix"></div>

<?php if($page != $chk_count) { ?>
<div class="infinite-paging">
  <a class="jscroll-next button" href="listings.php?page=<?php echo ($page + 1); ?><?php echo $param; ?>">
    <span class="flaticon-new-tab"></span>
    Load More
  </a>
</div>
<?php } ?>

<?php $conn->close(); ?>
