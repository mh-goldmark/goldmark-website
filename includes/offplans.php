<!-- Off Plan Projects -->
<section class="bgc-thm-light pt80 pb30-md pb60">
	<div class="container-fluid">
		<div class="row align-items-center wow fadeInUp" data-wow-delay="400ms">
			<div class="col-lg-12">
				<div class="main-title2 text-center">
					<h3 class="paragraph mb15">
						<?php echo decodeData(headLine('Featured Off-Plan','headline')); ?>
					</h3>
					<h2 class="title">
						<?php echo decodeData(headLine('Featured Off-Plan','title')); ?>
					</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 wow fadeInUp" data-wow-delay="400ms">
				<div class="property-city-slider navi_pagi_bottom_center slider-dib-sm slider-4-grid2 owl-theme owl-carousel">
					<?php while($row_off_plan = $result_off_plan->fetch_assoc()) { ?>
					<?php
					$sql_off_plan_image = $conn->query("SELECT image_name FROM tbl_projects_images WHERE reference = '".$row_off_plan['project_id']."' ORDER by image_order ASC LIMIT 1");
				  $row_off_plan_image = $sql_off_plan_image->fetch_assoc();

					if(!empty($row_off_plan['project'])) {
						$off_plan_url = "new-developments/".cleanString($row_off_plan['location'])."/".cleanString($row_off_plan['project'])."/".cleanString($row_off_plan['title'])."-".$row_off_plan['project_id'].".html";
						$off_plan_caption = decodeData($row_off_plan['project']);
					} elseif(!empty($row_off_plan['sub_location'])) {
						$off_plan_url = "new-developments/".cleanString($row_off_plan['location'])."/".cleanString($row_off_plan['sub_location'])."/".cleanString($row_off_plan['title'])."-".$row_off_plan['project_id'].".html";
						$off_plan_caption = decodeData($row_off_plan['sub_location']);
					} else {
						$off_plan_url = "new-developments/".cleanString($row_off_plan['location'])."/".cleanString($row_off_plan['title'])."-".$row_off_plan['project_id'].".html";
						$off_plan_caption = decodeData($row_off_plan['location']);
					}
					$off_plan_image_caption = $off_plan_caption;
					?>
					<div class="item">
						<a href="<?php echo $off_plan_url; ?>" title="<?php echo decodeData($off_plan_caption); ?>">
						<div class="feature-style1 mb50">
							<div class="feature-img" style="background-image: url('<?php if(!empty($row_off_plan['image'])) { echo localhost.'images/developments/thumbnails/'.$row_off_plan['project_id'].'/'.$row_off_plan['image']; } else { echo localhost.'images/developments/'.$row_off_plan['project_id'].'/'.$row_off_plan_image['image_name']; } ?>')"></div>
							<div class="feature-content">
								<div class="top-area">
									<h3 class="title mb5">
										<?php
										if(!empty($row_off_plan['project'])) {
											echo decodeData($row_off_plan['project']);
										} elseif(!empty($row_off_plan['sub_location'])) {
											echo decodeData($row_off_plan['sub_location']);
										} else {
											echo decodeData($row_off_plan['location']);
										}
										?>
									</h3>
									<p class="text">
										<?php
						        if(!empty($row_off_plan['location'])) {
						          echo decodeData($row_off_plan['location']).', '.decodeData($row_off_plan['city']);
						        } else {
						          echo decodeData($row_off_plan['city']).', UAE';
						        }
						        ?>
									</p>
								</div>
							</div>
						</div>
						</a>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Off Plan Projects -->
