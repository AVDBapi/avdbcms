<section>
	<?php if ($this->common_model->get_ads_status('country_header') == '1'): ?>
		<!-- header ads -->
		<div id="ads" style="padding: 20px 0px;text-align: center;">
			<div class="container">
				<div class="row">
					<div class="col-md-12 text-center">
						<?php echo $this->common_model->get_ads('country_header'); ?>
					</div>
				</div>
			</div>
		</div>
		<!-- header ads -->
	<?php endif; ?>

	<!-- Secondary Section -->
	<div id="section-opt">
		<h3 class="text-xl md:text-3xl font-semibold mb-3 md:mb-6 text-center"><?php echo "Watch ". $country_name . " movies and series" ?></h3>
		<div class="">
			<?php if ($total_rows > 0): ?>
				<!-- All Movies -->
				<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
					<?php foreach ($all_published_videos as $videos) : ?>
						<?php include ('thumbnail.php'); ?>
					<?php endforeach; ?>
				</div>
				<!-- End All Movies -->
			<?php else:
				echo "<h3 class='text-center text-uppercase'>No movie found by Country:  " . $country_name . "</h3>"; endif; ?>
		</div>
		<?php if ($total_rows > 24):
			echo $links; endif; ?>
	</div>
	<!-- Secondary Section -->
</section>