<section class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
    <?php 
        $theme_dir          =   'theme/default/';
    ?>
    <style type="text/css">
        .media-left img {
            max-width: 138px !important;
            max-height: 120px !important;
        }
    </style>

    <div id="movie-details">
        <div class="container">
            <!-- row1 player -->
            <div class="row">
                <div class="<?php if($this->common_model->get_ads_status('sidebar')=='1'): echo "col-md-9 col-sm-6"; else: echo "col-md-12 col-sm-12"; endif; ?>">
                    <?php if($this->common_model->get_ads_status('player_top')=='1'): ?>
                        <!-- player top to ads -->
                        <div class="row">
                            <div class="col-md-12 text-center m-b-10">
                                <?php echo $this->common_model->get_ads('player_top'); ?>
                            </div>
                        </div>
                        <!-- player top to ads -->
                    <?php endif; ?>
                    <!-- player -->
                    <div class="row">
                        <div class="col-md-12">
                            <?php $this->load->view($theme_dir.'/tv_player');?>
                        </div>
                    </div>
                    <!-- End player -->

                    <?php if($this->common_model->get_ads_status('player_bottom')=='1'): ?>
                        <!-- player bottom to ads -->
                        <div class="row">
                            <div class="col-md-12 text-center m-b-10">
                                <?php echo $this->common_model->get_ads('player_bottom'); ?>
                            </div>
                        </div>
                        <!-- player bottom to ads -->
                    <?php endif; ?>
                </div>
                <?php if($this->common_model->get_ads_status('sidebar')=='1'): ?>
                    <!-- sidebar ads -->
                    <div class="col-md-3 col-sm-6">
                        <div class="sidebar">
                            <div class="ad_300x250 m-b-10">
                                 <?php echo $this->common_model->get_ads('sidebar'); ?>    
                            </div>
                        </div>
                    </div>
                    <!-- End sidebar ads -->
                <?php endif; ?>
            </div>        
            <!-- End row1 player -->
        </div>
    </div>

    <!-- live tv section -->
    <div id="section-opt">
        <div class="container">
            <div class="row">
                <!-- All tv section -->
                <div class="col-md-12 col-sm-12">
                    <div class="latest-movie movie-opt">
                        <div class="movie-heading overflow-hidden"> <span><?php echo trans('all_tv_channels'); ?></span>
                            <div class="disable-bottom-line"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="owl-carousel live_tv_owl">
                        <?php
                        $all_tvs =$this->live_tv_model->get_all_live_tv();
                        foreach ($all_tvs as $tv):
                        ?>
                        <div class="item">
                            <figure class="figure">
                                <a href="<?php echo base_url('live-tv/').$tv['slug'].'.html'; ?>">
                                    <img class="owl-lazy" src="<?php echo base_url('uploads/default_image/tv_thumbnail.jpg'); ?>" data-src="<?php echo $this->live_tv_model->get_tv_thumbnail($tv['thumbnail']); ?>" alt="" />
                                    <figcaption class="figure-caption "><?php echo $tv['tv_name']; ?></figcaption>
                                </a>
                            </figure>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <script type="text/javascript">
                        $('.live_tv_owl').owlCarousel({
                            stagePadding: 0,
                            /*the little visible images at the end of the carousel*/
                            loop: true,
                            rtl: false,
                            lazyLoad: true,
                            margin: 15,
                            center: true,
                            nav: true,
                            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                            dots: false,
                            responsive: {
                                0: {
                                    items: 3
                                },
                                600: {
                                    items: 6
                                },
                                800: {
                                    items: 8
                                },
                                1000: {
                                    items: 8
                                },
                                1200: {
                                    items: 10
                                }
                            }
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
</section>


