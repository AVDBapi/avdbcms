<!-- Breadcrumb -->
<div id="title-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8 col-xs-12">
                <div class="page-title">
                    <h1 class="text-uppercase">
                        <?php echo trans('watch_free_requested _movies'); ?>
                    </h1>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 text-right">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url(); ?>">
                            <i class="fi ion-ios-home"></i>
                            <?php echo trans('home'); ?>
                        </a>
                    </li>
                    <li class="active">
                        <?php echo trans('requested_movies'); ?>
                    </li>
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
            <?php if ($total_rows > 0) {
                if ($total_rows > 24) {
                    echo $links;
                } ?>
                <div class="col-md-12 col-sm-12">
                    <div class="latest-movie movie-opt">
                        <div class="row clean-preset">
                            <div class="movie-container">
                                <?php foreach ($all_published_videos as $videos): ?>
                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                        <div class="latest-movie-img-container">
                                            <div class="movie-img">
                                                <img class="img-responsive" src="<?php echo $videos->image_link; ?>" alt="<?php echo $videos->title; ?>">
                                                <a href="<?php echo base_url('watch/' . $videos->slug . '.html'); ?>" class="ico-play ico-play-sm">
                                                    <img
                                                        class="img-responsive play-svg svg"
                                                        src="<?php echo base_url(); ?>assets/front_end/images/play-button.svg"
                                                        alt="play"
                                                        onerror="this.src='<?php echo base_url(); ?>assets/front_end/images/play-button.png'"
                                                    >
                                                </a>
                                                <div class="overlay-div"></div>
                                                <div class="video_quality">
                                                    <span class="label label-primary">
                                                        <?php echo $videos->video_quality ?>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="movie-title">
                                                <h1>
                                                    <a href="<?php echo base_url('watch/' . $videos->slug . '.html'); ?>">
                                                        <?php echo $videos->title; ?>
                                                    </a>
                                                </h1>
                                                <p class="movie-desc">
                                                    <span><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo $videos->runtime; ?></span><span>&nbsp;&#47;</span>
                                                    <span><?php echo $videos->total_view; ?><?php echo trans('views'); ?></span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End All Movies -->
            </div>
            <?php if ($total_rows > 24) {
                echo $links;
            }
            } else {
                echo '<center><h3> ' . trans('opps!!_no_movie_found') . '</h3></center>';
            } ?>

    </div>
</div>
<!-- Secondary Section -->