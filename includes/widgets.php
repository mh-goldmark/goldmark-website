<section class="pt50 pb50 pb20-md general-widget contact-details">
	<div class="container">
		<div class="col-7 col-md-10 offset-3 offset-md-1">
			<div class="row justify-content-between align-items-center">
				<?php while($row_widgets = $result_widgets->fetch_assoc()) { ?>
				<div class="col-12 col-md-4 mb30-md d-flex justify-content-center align-items-center flex-start">
					<div class="contact-icon text-gray">
						<img class="widget-icon" src="<?php echo localhost.'images/widgets/'.cleanString($row_widgets['category']).'/'.$row_widgets['icon']; ?>" alt="<?php echo decodeData($row_widgets['details']).' '.decodeData($row_widgets['label']); ?>"/>
					</div>
					<div class="contact-label">
						<span>
							<?php echo decodeData($row_widgets['details']); ?>
						</span>
						<p class="text-gray">
							<?php echo decodeData($row_widgets['label']); ?>
						</p>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
