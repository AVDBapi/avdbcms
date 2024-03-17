<section class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
    <!-- Breadcrumb -->
    <div id="title-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="page-title">
                        <h1 class="text-uppercase"><?php echo trans('star'); ?>: <?php echo $star_name; ?></h1>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i><?php echo trans('home'); ?></a>
                        </li>
                        <li class=""><?php echo trans('stars'); ?></li>
                        <li class="active"><?php echo $star_name; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Secondary Section -->
    <div id="section-opt">
        <div class="container">
            <div class="row">
                <!-- All Movies -->
                <?php if($total_rows > 0):  ?>
                    <div class="col-md-12 col-sm-12">
                        <div class="latest-movie movie-opt">
                            <div class="row clean-preset">
                                <div class="movie-container">
                                    <?php foreach ($all_published_videos as $videos) :?>
                                    <div class="col-md-2 col-sm-3 col-xs-6">
                                        <?php include('thumbnail.php'); ?>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- End All Movies -->
            </div>
            <?php echo $links; ?>
        </div>
    </div>
    <!-- Secondary Section -->
</section>