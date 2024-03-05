<?php if($this->common_model->get_ads_status('home_header')=='1'): ?>
<!-- header ads -->
<div id="ads" style="padding: 20px 0px;text-align: center;">
	<div class="container">
		<div class="row">
			<div class="col-md-12 text-center">
				<?php echo $this->common_model->get_ads('home_header'); ?>
			</div>
		</div>
	</div>
</div>
<!-- header ads -->
<?php endif; ?>