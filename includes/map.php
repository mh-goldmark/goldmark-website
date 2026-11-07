<script type="text/javascript">
var nooGmapL10n = {
  "latitude"                : "<?php echo $geolatitude; ?>",
  "longitude"               : "<?php echo $geolongitude; ?>",
  "maxZoom_MarkerClusterer" : "10",
  "zoom"                    : "12",
  "default_label"           : "",
  "fullscreen_label"        : "",
  "no_geolocation_pos"      : "The browser couldn't detect your position!",
  "no_geolocation_msg"      : "Geolocation is not supported by this browser.",
  "markers": [
    <?php $i = 1; ?>
    <?php while($row_listings = $result_listings->fetch_assoc())	{

      if(!empty($row_listings['coordinates'])) {
        $coordinates = explode(',',$row_listings['coordinates']);
      }

      $sql_listing_image = $conn->query("SELECT image_name, image_caption, watermark, image_order FROM tbl_images WHERE reference = '".$row_listings['listing_id']."' AND chk_default = true AND image_order = 1 LIMIT 1");
      $row_listing_image = $sql_listing_image->fetch_assoc();

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

      //if($row_listing_image['watermark'] == true) {
      //  $image = localhost.'images/watermark/?filename='.$row_listing_image['image_name'].'&id='.$row_listings['listing_id'];
      //} else {
        $image = localhost.'images/listings/'.$row_listings['listing_id'].'/'.$row_listing_image['image_name'];
      //}

      if($row_listings['price_on_request'] == true) {
        $price = 'Price on request';
      } else {
        $price = 'AED '.number_format($row_listings['list_price'],0);
      }

      if(!empty($row_listings['property'])) {
        $location = decodeData($row_listings['property']).', '.decodeData($row_listings['location']);
      } else {
        $location = decodeData($row_listings['sub_location']).', '.decodeData($row_listings['location']);
      }

      if($row_listings['category'] == 'Residential') {
        if(empty($row_listings['bedrooms'])) {
          $bedroom = "Studio";
        } elseif($row_listings['bedrooms'] == 1) {
          $bedroom = $row_listings['bedrooms'].' Bed';
        } else {
          $bedroom = $row_listings['bedrooms'].' Beds';
        }
      } else {
        $bedroom = 'N/a';
      }

      if($row_listings['category'] == 'Residential') {
        if(empty($row_listings['bathrooms'])) {
          $bathroom = "-";
        } elseif($row_listings['bathrooms'] == 1) {
          $bathroom = $row_listings['bathrooms'].' Bath';
        } else {
          $bathroom = $row_listings['bathrooms'].' Baths';
        }
      }

      if(in_array($row_listings['property_type'],$property_type_land)) {
        if($row_listings['plot_size'] != '0.00') {
          $size = number_format($row_listings['plot_size'],0).' '.$row_listings['plot_measurement'];
        } else {
          $size = '-';
        }
      } else {
        if($row_listings['unit_size'] != '0.00') {
          $size = number_format($row_listings['unit_size'],0).' '.$row_listings['size_measurement'];
        } else {
          $size = '-';
        }
      }

      if(in_array($row_listings['property_type'],$property_type_land)) {
        if($row_listings['plot_size'] != '0.00') {
        $size_price = 'AED '.number_format(($row_listings['list_price']/$row_listings['plot_size']),0).' per '.$row_listings['plot_measurement'];
        }
      } else {
        if($row_listings['unit_size'] != '0.00') {
          $size_price = 'AED '.number_format(($row_listings['list_price']/$row_listings['unit_size']),0).' per '.$row_listings['size_measurement'];
        }
      }

      $icon = webhost."images/icons/marker-icon.png";

      ?>
      {
        "latitude"   : "<?php echo $coordinates[0]; ?>",
        "longitude"  : "<?php echo $coordinates[1]; ?>",
        "image"      : "<?php echo $image; ?>",
        "caption"    : "<?php echo $image_caption; ?>",
        "price"      : "<?php echo $price; ?>",
        "size_price" : "<?php echo $size_price; ?>",
        "location"   : "<?php echo $location; ?>",
        "category"   : "<?php echo decodeData($row_listings['category']); ?>",
        "developer"  : "<?php echo decodeData($row_listings['developer']); ?>",
        "completion" : "",
        "title"      : "<?php echo $page_title; ?>",
        "refno"      : "<?php echo $refno_code.$row_listings['listing_id']; ?>",
        "class"      : "<?php echo 'For '.decodeData($row_listings['listing_type']); ?>",
        "type"       : "<?php echo decodeData($row_listings['property_type']); ?>",
        "bedroom"    : "<?php echo $bedroom; ?>",
        "bathroom"   : "<?php echo $bathroom; ?>",
        "size"       : "<?php echo $size; ?>",
        "url"        : "<?php echo $listing_url; ?>",
        "icon"       : "<?php echo $icon; ?>"
      }<?php if($i++ < $result_listings->num_rows) { echo ','; } ?>
        <?php unset($coordinates,$listing_url,$image_caption,$image,$price,$location,$bedroom,$bathroom,$size,$size_price,$icon); ?>
        <?php } ?>
        ],
        "ajax_finishedMsg"  : "All posts displayed"
      };
</script>
