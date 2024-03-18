<section>
    <?php if($this->common_model->get_ads_status('genre_header')=='1'): ?>
    <!-- header ads -->
    <div id="ads" style="padding: 20px 0px;text-align: center;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php echo $this->common_model->get_ads('genre_header'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- header ads -->
    <?php endif; ?>
    <!-- Secondary Section -->
    <div id="section-opt">
        <h1 class="text-center text-2xl mb-6 capitalize">Watch <?php echo $genre_name; ?> Online</h1>
        
        <?php if ($total_rows>0):?>
        <!-- All Movies -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
            <?php foreach ($all_published_videos as $videos): ?>
                <?php include ('thumbnail.php'); ?>
            <?php endforeach; ?>
        </div>
        <!-- End All Movies -->
        <?php else: echo "<h3 class='text-center text-capitalize'>No Movie Found by ".$genre_name."</h3>"; endif; ?>

        <?php if($total_rows > 24): echo $links;endif;?>
    </div>
    <!-- Secondary Section -->
</section>