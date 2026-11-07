<!-- Similar Properties -->
<section class="pt40 pb80 bg-light">
	<div class="container-fluid">
		<div class="row wow fadeInUp similar-properties" data-wow-delay="700ms">
			<div class="col-lg-9">
				<div class="main-title2 mb40">
					<h3 class="title">
						Off-plan properties you may be interested...
					</h3>
				</div>
			</div>
		</div>
		<div class="row wow fadeInUp similar-properties" data-wow-delay="900ms">
			<div class="col-lg-12">
				<div class="property-city-slider navi_pagi_bottom_center slider-dib-sm slider-4-grid owl-theme owl-carousel">
					<?php while($row_off_plans = $result_off_plans->fetch_assoc()) { ?>
					<?php
					if(!empty($row_off_plans['images'])) {
						$img_off_plans_explode 	= explode(",",$row_off_plans['images']);
						$count_off_plans_images = count($img_off_plans_explode);
					} else {
						$count_off_plans_images = 0;
					}

					$sql_off_plans_image = $conn->query("SELECT image_name, image_caption, watermark FROM tbl_images WHERE reference = '".$row_off_plans['listing_id']."' ORDER by image_order ASC LIMIT 1");
					$row_off_plans_image = $sql_off_plans_image->fetch_assoc();

					if(!empty($row_off_plans['page_title'])) {
						$page_off_plans_title = $row_off_plans['page_title'];
					} else {
						$page_off_plans_title = $row_off_plans['title'];
					}
					if($row_off_plans['category'] == 'Commercial') {
						$url_category_off_plans = 'commercials';
					} else {
						$url_category_off_plans = 'residentials';
					}
					if(in_array($row_off_plans['property_type'],$property_type_apartment)) {
						$url_type_off_plans = 'apartments';
					} elseif(in_array($row_off_plans['property_type'],$property_type_villa)) {
						$url_type_off_plans = 'villas';
					} elseif(in_array($row_off_plans['property_type'],$property_type_office)) {
						$url_type_off_plans = 'offices';
					} elseif($row_off_plans['property_type'] == "Retail") {
						$url_type_off_plans = 'shops';
					} elseif($row_off_plans['property_type'] == "Building") {
						$url_type_off_plans = 'buildings';
					} elseif($row_off_plans['property_type'] == "Land") {
						$url_type_off_plans = 'plots';
					} else {
						$url_type_off_plans = 'apartments';
					}

					if(!empty($row_off_plans['building_name'])) {
				    $off_plans_url = $url_category_off_plans."/".$url_type_off_plans."-for-".cleanString($row_off_plans['listing_type'])."/".cleanString($row_off_plans['location'])."/".cleanString($row_off_plans['building_name'])."/".cleanString($page_title)."-".$row_off_plans['listing_id'].".html";
				    $off_plans_caption = decodeData($row_off_plans['building_name']);
					} elseif(!empty($row_off_plans['property'])) {
						$off_plans_url = $url_category_off_plans."/".$url_type_off_plans."-for-".cleanString($row_off_plans['listing_type'])."/".cleanString($row_off_plans['location'])."/".cleanString($row_off_plans['property'])."/".cleanString($page_off_plans_title)."-".$row_off_plans['listing_id'].".html";
						$off_plans_caption = decodeData($row_off_plans['property']);
					} elseif(!empty($row_off_plans['sub_location'])) {
						$off_plans_url = $url_category_off_plans."/".$url_type_off_plans."-for-".cleanString($row_off_plans['listing_type'])."/".cleanString($row_off_plans['location'])."/".cleanString($row_off_plans['sub_location'])."/".cleanString($page_off_plans_title)."-".$row_off_plans['listing_id'].".html";
						$off_plans_caption = decodeData($row_off_plans['sub_location']);
					} else {
						$off_plans_url = $url_category_off_plans."/".$url_type_off_plans."-for-".cleanString($row_off_plans['listing_type'])."/".cleanString($row_off_plans['location'])."/".cleanString($page_off_plans_title)."-".$row_off_plans['listing_id'].".html";
						$off_plans_caption = decodeData($row_off_plans['location']);
					}
					if(!empty($row_off_plans_image['image_caption'])) {
						$image_off_plans_caption = $off_plans_caption.' - '.decodeData($row_off_plans_image['image_caption']);
					} else {
						$image_off_plans_caption = $off_plans_caption;
					}
					?>
					<div class="item">
						<div class="listing-style1">
							<div class="list-thumb">
								<a href="<?php echo $off_plans_url; ?>" tilte="<?php echo $page_off_plans_title; ?>">
									<?php //if($row_off_plans_image['watermark'] == true) { ?>
										<!--
										<img src="<?php //echo localhost.'images/watermark/listing?filename='.$row_off_plans_image['image_name'].'&id='.$row_off_plans['listing_id']; ?>" alt="<?php //echo $image_off_plans_caption; ?>" class="w-100">
										!-->
									<?php //} else { ?>
										<img src="<?php echo localhost.'images/listings/'.$row_off_plans['listing_id'].'/'.$row_off_plans_image['image_name']; ?>" alt="<?php echo $off_plans_caption; ?>" class="w-100">
									<?php //} ?>
								</a>
								<div class="list-tag d-flex">
									<div class="list-class">
										<?php echo decodeData($row_off_plans['listing_type']); ?>
									</div>
									<div class="listing-price"<?php if($row_off_plans['verified'] == true) { echo ' data-bs-toggle="tooltip" data-bs-placement="bottom" title="This indicates that the listing is verified by Propertyfinder"'; } ?>>
										AED <?php echo number_format($row_off_plans['list_price'],0); ?>
										<?php if($row_off_plans['verified'] == true) { ?>
										<img class="verification-icon" src="images/icon/verified-icon.svg" alt="Verified Listing"/>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="list-content">
								<h2 class="list-title">
									<a href="<?php echo $off_plans_url; ?>" title="<?php echo $page_off_plans_title; ?>">
										<?php echo decodeData($row_off_plans['title']); ?>
									</a>
								</h2>
								<h3 class="list-location">
									<span class="icon flaticon-maps-1"></span>
									<?php
									if(!empty($row_off_plans['property']) && !empty($row_off_plans['sub_location'])) {
										echo decodeData($row_off_plans['property']).', '.decodeData($row_off_plans['sub_location']);
									} elseif(!empty($row_off_plans['sub_location'])) {
										echo decodeData($row_off_plans['sub_location']).', '.decodeData($row_off_plans['location']);
									} else {
										echo decodeData($row_off_plans['location']);
									}
									?>
								</h3>
								<div class="list-meta d-flex align-items-center">
									<?php if($row_off_plans['category'] == 'Residential') { ?>
									<div class="list-details mr10">
										<span class="flaticon-bed mr5"></span>
										<?php
										if(empty($row_off_plans['bedrooms'])) {
											echo "studio";
										} else {
											echo $row_off_plans['bedrooms'].' bed';
										}
										?>
									</div>
									<div class="list-details mr10">
										<span class="flaticon-shower mr5"></span>
										<?php
										if(empty($row_off_plans['bathrooms'])) {
											echo "-";
										} else {
											echo $row_off_plans['bathrooms'].' bath';
										}
										?>
									</div>
									<?php } else { ?>
									<?php
									if(in_array($row_off_plans['property_type'],$property_type_land)) {
									if($row_off_plans['plot_size'] != '0.00') {
									?>
									<div class="list-details mr10">
										AED <?php echo number_format(($row_off_plans['list_price']/$row_off_plans['plot_size']),0).' per '.$row_off_plans['plot_measurement']; ?>
									</div>
									<?php } ?>
									<?php } else { ?>
									<?php if($row_off_plans['unit_size'] != '0.00') { ?>
									<div class="list-details mr10">
										AED <?php echo number_format(($row_off_plans['list_price']/$row_off_plans['unit_size']),0).' per '.$row_off_plans['size_measurement']; ?>
									</div>
									<?php } ?>
									<?php } ?>
									<?php } ?>
									<div class="list-details">
										<span class="flaticon-expand mr5"></span>
										<?php
										if(in_array($row_off_plans['property_type'],$property_type_land)) {
											if($row_off_plans['plot_size'] != '0.00') {
												echo number_format($row_off_plans['plot_size'],0).' '.$row_off_plans['plot_measurement'];
											} else {
												echo '-';
											}
										} else {
											if($row_off_plans['unit_size'] != '0.00') {
												echo number_format($row_off_plans['unit_size'],0).' '.$row_off_plans['size_measurement'];
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
										<a href="tel:<?php echo str_replace($string_replace_mobile,"",$row_off_plans['mobile']); ?>" title="Call Me">
											<span class="flaticon-call"></span>
											Call
										</a>
										<a href="https://api.whatsapp.com/send?phone=<?php echo str_replace($string_replace_mobile,"",$row_off_plans['mobile']); ?>&text=Hello%20<?php echo decodeData($row_off_plans['user_name']); ?>, I found this property <?php echo decodeData($row_off_plans['title']); ?> with Ref <?php if($row_off_plans['chk_reapit'] == true) { echo decodeData($row_off_plans['refno']); } else { echo $refno_code.decodeData($row_off_plans['listing_id']); } ?> on your website. Please contact me. Thank you." title="Whatsapp Me" target="_blank">
											<span class="flaticon-whatsapp"></span>
											Whatsapp
										</a>
										<a class="email-agent" data-bs-toggle="modal" href="#contactAgentToggle" role="button" data-source="Agent Listing" data-subsource="Email Lead" data-user="104" data-refno="<?php if($row_off_plans['chk_reapit'] == true) { echo decodeData($row_off_plans['refno']); } else { echo $refno_code.decodeData($row_off_plans['listing_id']); } ?>" data-agent="<?php echo decodeData($row_off_plans['full_name']); ?>" data-title="<?php echo decodeData($row_off_plans['title']); ?>" title="Send Email">
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
