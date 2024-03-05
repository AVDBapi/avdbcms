<style>
    .tv-ribbon{
        left: 15px;
    }
</style>

<?php if($this->common_model->get_ads_status('tv_header')=='1'): ?>
<!-- header ads -->
<div id="ads" style="padding: 20px 0px;text-align: center;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php echo $this->common_model->get_ads('tv_header'); ?>
            </div>
        </div>
    </div>
</div>
<!-- header ads -->
<?php endif; ?>

<div id="section-opt">
    <div class="container">
        <div class="row">
            <!-- Upcomming Movies -->
            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt">
                    <div class="movie-heading overflow-hidden"> <span><?php echo $category_info[0]['live_tv_category']; ?></span>
                        <div class="disable-bottom-line"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
                foreach ($channels as $tv):
            ?>
                <figure class="figure col-md-3 col-sm-4 col-xs-6">
                    <?php if($tv['is_paid'] == '1'):?>
                        <span class="tv-ribbon">VIP</span> 
                    <?php endif; ?> 
                    <a href="<?php echo base_url('live-tv/').$tv['slug'].'.html'; ?>">
                        <img class="img-responsive lazy" src="<?php echo base_url('uploads/default_image/tv_poster.jpg'); ?>" data-src="<?php echo $this->live_tv_model->get_tv_poster($tv['poster']); ?>" alt="<?php echo $tv['tv_name']; ?>" />
                        <figcaption class="figure-caption "><?php echo $tv['tv_name']; ?></figcaption>
                    </a>
                </figure>
            <?php endforeach; ?>
        </div>
    </div>
</div>

