<!-- Similar Properties -->
<section class="pt40 pb80 bg-light">
	<div class="container-fluid">
		<div class="row wow fadeInUp similar-properties" data-wow-delay="700ms">
			<div class="col-lg-9">
				<div class="main-title2 mb40">
					<h3 class="title">
						Similar properties you may be interested...
					</h3>
				</div>
			</div>
		</div>
		<div class="row wow fadeInUp similar-properties" data-wow-delay="900ms">
			<div class="col-lg-12">
				<div class="property-city-slider navi_pagi_bottom_center slider-dib-sm slider-4-grid owl-theme owl-carousel">
					<?php while($row_similar_listings = $result_similar_listings->fetch_assoc()) { ?>
					<?php
					if(!empty($row_similar_listings['images'])) {
						$img_listing_similar_explode 	= explode(",",$row_similar_listings['images']);
						$count_listing_similar_images = count($img_listing_similar_explode);
					} else {
						$count_listing_similar_images = 0;
					}

					$sql_listing_similar_image = $conn->query("SELECT image_name, image_caption, watermark FROM tbl_images WHERE reference = '".$row_similar_listings['listing_id']."' AND image_order = 1 LIMIT 1");
					$row_listing_similar_image = $sql_listing_similar_image->fetch_assoc();

					if(!empty($row_similar_listings['page_title'])) {
						$page_similar_title = $row_similar_listings['page_title'];
					} else {
						$page_similar_title = $row_similar_listings['title'];
					}
					if($row_similar_listings['category'] == 'Commercial') {
						$url_category_similar_listings = 'commercials';
					} else {
						$url_category_similar_listings = 'residentials';
					}
					if(in_array($row_similar_listings['property_type'],$property_type_apartment)) {
						$url_type_similar_listings = 'apartments';
					} elseif(in_array($row_similar_listings['property_type'],$property_type_villa)) {
						$url_type_similar_listings = 'villas';
					} elseif(in_array($row_similar_listings['property_type'],$property_type_office)) {
						$url_type_similar_listings = 'offices';
					} elseif($row_similar_listings['property_type'] == "Retail") {
						$url_type_similar_listings = 'shops';
					} elseif($row_similar_listings['property_type'] == "Building") {
						$url_type_similar_listings = 'buildings';
					} elseif($row_similar_listings['property_type'] == "Land") {
						$url_type_similar_listings = 'plots';
					} else {
						$url_type_similar_listings = 'apartments';
					}

					if(!empty($row_similar_listings['building_name'])) {
						$listing_similar_url = $url_category_similar_listings."/".$url_type_similar_listings."-for-".cleanString($row_similar_listings['listing_type'])."/".cleanString($row_similar_listings['location'])."/".cleanString($row_similar_listings['building_name'])."/".cleanString($page_similar_title)."-".$row_similar_listings['listing_id'].".html";
						$listing_similar_caption = decodeData($row_similar_listings['building_name']);
					} elseif(!empty($row_similar_listings['property'])) {
						$listing_similar_url = $url_category_similar_listings."/".$url_type_similar_listings."-for-".cleanString($row_similar_listings['listing_type'])."/".cleanString($row_similar_listings['location'])."/".cleanString($row_similar_listings['property'])."/".cleanString($page_similar_title)."-".$row_similar_listings['listing_id'].".html";
						$listing_similar_caption = decodeData($row_similar_listings['property']);
					} elseif(!empty($row_similar_listings['sub_location'])) {
						$listing_similar_url = $url_category_similar_listings."/".$url_type_similar_listings."-for-".cleanString($row_similar_listings['listing_type'])."/".cleanString($row_similar_listings['location'])."/".cleanString($row_similar_listings['sub_location'])."/".cleanString($page_similar_title)."-".$row_similar_listings['listing_id'].".html";
						$listing_similar_caption = decodeData($row_similar_listings['sub_location']);
					} else {
						$listing_similar_url = $url_category_similar_listings."/".$url_type_similar_listings."-for-".cleanString($row_similar_listings['listing_type'])."/".cleanString($row_similar_listings['location'])."/".cleanString($page_similar_title)."-".$row_similar_listings['listing_id'].".html";
						$listing_similar_caption = decodeData($row_similar_listings['location']);
					}
					if(!empty($row_listing_similar_image['image_caption'])) {
						$image_similar_caption = $listing_similar_caption.' - '.decodeData($row_listing_similar_image['image_caption']);
					} else {
						$image_similar_caption = $listing_similar_caption;
					}
					?>
					<div class="item">
						<div class="listing-style1">
							<div class="list-thumb">
								<a href="<?php echo $listing_similar_url; ?>" tilte="<?php echo $page_similar_title; ?>">
									<?php //if($row_listing_similar_image['watermark'] == true) { ?>
										<!--
										<img src="<?php //echo localhost.'images/watermark/listing?filename='.$row_listing_similar_image['image_name'].'&id='.$row_similar_listings['listing_id']; ?>" alt="<?php //echo $image_similar_caption; ?>" class="w-100">
										!-->
									<?php //} else { ?>
										<img src="<?php echo localhost.'images/listings/'.$row_similar_listings['listing_id'].'/'.$row_listing_similar_image['image_name']; ?>" alt="<?php echo $image_similar_caption; ?>" class="w-100">
									<?php //} ?>
								</a>
								<div class="list-tag d-flex">
									<div class="list-class">
										<?php echo decodeData($row_similar_listings['listing_type']); ?>
									</div>
									<div class="listing-price"<?php if($row_similar_listings['verified'] == true) { echo ' data-bs-toggle="tooltip" data-bs-placement="bottom" title="This indicates that the listing is verified by Propertyfinder"'; } ?>>
										AED <?php echo number_format($row_similar_listings['list_price'],0); ?>
										<?php if($row_similar_listings['verified'] == true) { ?>
										<img class="verification-icon" src="images/icon/verified-icon.svg" alt="Verified Listing"/>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="list-content">
								<h2 class="list-title">
									<a href="<?php echo $listing_similar_url; ?>" title="<?php echo $page_similar_title; ?>">
										<?php echo decodeData($row_similar_listings['title']); ?>
									</a>
								</h2>
								<h3 class="list-location">
									<span class="icon flaticon-maps-1"></span>
									<?php
									if(!empty($row_similar_listings['building_name'])) {
										echo decodeData($row_similar_listings['building_name']).', '.decodeData($row_similar_listings['sub_location']);
									} elseif(!empty($row_similar_listings['property'])) {
										echo decodeData($row_similar_listings['property']).', '.decodeData($row_similar_listings['sub_location']);
									} else {
										echo decodeData($row_similar_listings['sub_location']).', '.decodeData($row_similar_listings['location']);
									}
									?>
								</h3>
								<div class="list-meta d-flex align-items-center">
									<?php if($row_similar_listings['category'] == 'Residential') { ?>
									<div class="list-details mr10">
										<span class="flaticon-bed mr5"></span>
										<?php
										if(empty($row_similar_listings['bedrooms'])) {
											echo "studio";
										} else {
											echo $row_similar_listings['bedrooms'].' bed';
										}
										?>
									</div>
									<div class="list-details mr10">
										<span class="flaticon-shower mr5"></span>
										<?php
										if(empty($row_similar_listings['bathrooms'])) {
											echo "-";
										} else {
											echo $row_similar_listings['bathrooms'].' bath';
										}
										?>
									</div>
									<?php } else { ?>
									<?php
									if(in_array($row_similar_listings['property_type'],$property_type_land)) {
									if($row_similar_listings['plot_size'] != '0.00') {
									?>
									<div class="list-details mr10">
										AED <?php echo number_format(($row_similar_listings['list_price']/$row_similar_listings['plot_size']),0).' per '.$row_listings['plot_measurement']; ?>
									</div>
									<?php } ?>
									<?php } else { ?>
									<?php if($row_similar_listings['unit_size'] != '0.00') { ?>
									<div class="list-details mr10">
										AED <?php echo number_format(($row_similar_listings['list_price']/$row_similar_listings['unit_size']),0).' per '.$row_similar_listings['size_measurement']; ?>
									</div>
									<?php } ?>
									<?php } ?>
									<?php } ?>
									<div class="list-details">
										<span class="flaticon-expand mr5"></span>
										<?php
										if(in_array($row_similar_listings['property_type'],$property_type_land)) {
											if($row_similar_listings['plot_size'] != '0.00') {
												echo number_format($row_similar_listings['plot_size'],0).' '.$row_similar_listings['plot_measurement'];
											} else {
												echo '-';
											}
										} else {
											if($row_similar_listings['unit_size'] != '0.00') {
												echo number_format($row_similar_listings['unit_size'],0).' '.$row_similar_listings['size_measurement'];
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
										<a href="tel:<?php echo str_replace($string_replace_mobile,"",$row_similar_listings['mobile']); ?>" title="Call Me">
											<span class="flaticon-call"></span>
											Call
										</a>
										<a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$row_similar_listings['mobile']); ?>&text=Hello%20<?php echo decodeData($row_similar_listings['user_name']); ?>, I found this property <?php echo decodeData($row_similar_listings['title']); ?> with Ref <?php if($row_similar_listings['chk_reapit'] == true) { echo decodeData($row_similar_listings['refno']); } else { echo $refno_code.decodeData($row_similar_listings['listing_id']); } ?> on your website. Please contact me. Thank you." title="Whatsapp Me" target="_blank">
											<span class="flaticon-whatsapp"></span>
											Whatsapp
										</a>
										<a class="email-agent" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Agent Listing" data-subsource="Email Lead" data-user="<?php echo decodeData($row_similar_listings['user_id']); ?>" data-refno="<?php if($row_similar_listings['chk_reapit'] == true) { echo decodeData($row_similar_listings['refno']); } else { echo $refno_code.decodeData($row_similar_listings['listing_id']); } ?>" data-agent="<?php echo decodeData($row_similar_listings['full_name']); ?>" data-title="<?php echo decodeData($row_similar_listings['title']); ?>" title="Send Email">
											<span class="flaticon-email"></span>
											Email
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Similar Properties -->
