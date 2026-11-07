<?php if($result_interest_communities->num_rows >= 4) { ?>
<!-- Other Communities -->
<section class="bg-light pt30 pb80">
	<div class="container-fluid ">
		<div class="row mt30 wow fadeInUp communities-interest" data-wow-delay="700ms">
			<div class="col-lg-9">
				<div class="main-title2 mb40">
					<h3 class="title">
						Explore the Dubai communities...
					</h3>
				</div>
			</div>
		</div>
		<div class="row wow fadeInUp communities-interest" data-wow-delay="900ms">
			<div class="col-lg-12">
				<div class="property-city-slider navi_pagi_bottom_center slider-dib-sm slider-4-grid owl-theme owl-carousel">
					<?php while($row_interest_communities = $result_interest_communities->fetch_assoc()) { ?>
					<?php
					if(!empty($row_interest_communities['headline'])) {
						 $page_interest_title = $row_interest_communities['headline'];
					} else {
						 $page_interest_title = decodeData($row_interest_communities['location']). ' | Community Guide';
					}
					?>
					<div class="item">
						<div class="listing-style1">
							<div class="list-thumb">
								<a href="community-guides/<?php echo cleanString($row_interest_communities['location']); ?>/<?php echo cleanString($page_interest_title)."-".$row_interest_communities['community_id']; ?>.html" tilte="<?php echo decodeData($page_interest_title); ?>" style="background-image: url('<?php echo localhost.'images/communities/thumbnails/'.$row_interest_communities['community_id'].'/'.$row_interest_communities['image']; ?>');">
								</a>
							</div>
							<div class="list-content">
								<h3 class="list-title">
									<a href="community-guides/<?php echo cleanString($row_interest_communities['location']); ?>/<?php echo cleanString($page_interest_title)."-".$row_interest_communities['community_id']; ?>.html" title="<?php echo decodeData($page_interest_title); ?>">
										<?php echo decodeData($row_interest_communities['location']); ?>
									</a>
								</h3>
								<h4>
				          <?php if(!empty($row_interest_communities['community_name'])) { echo decodeData($row_interest_communities['community_name']); } else { echo '-'; } ?>
				        </h4>
							</div>
						</div>
					</div>
					<?php unset($page_interest_title); ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php } ?>
<!-- Other Communities -->
