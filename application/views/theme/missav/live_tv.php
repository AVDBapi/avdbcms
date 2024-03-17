<section class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
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
    <!-- Secondary Section -->

    <?php if($this->live_tv_model->get_featured_tv_status()): ?>
    <!-- live tv section -->
    <div id="section-opt">
        <div class="container">
            <div class="row">
                <!-- Upcomming Movies -->
                <div class="col-md-12 col-sm-12">
                    <div class="latest-movie movie-opt">
                        <div class="movie-heading overflow-hidden"> <span><?php echo trans('featured_tv_channels'); ?></span>
                            <div class="disable-bottom-line"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="owl-carousel live_tv_owl">
                        <?php
                        $featured_tvs =$this->live_tv_model->get_featured_live_tv();
                        foreach ($featured_tvs as $tv):
                        ?>
                        <div class="item">
                            <figure class="figure">
                                <?php if($tv['is_paid'] == '1'):?>
                                    <span class="tv-ribbon">VIP</span> 
                                <?php endif; ?> 
                                <a href="<?php echo base_url('live-tv/').$tv['slug'].'.html'; ?>">
                                    <img class="owl-lazy" src="<?php echo base_url('uploads/default_image/tv_poster.jpg'); ?>" data-src="<?php echo $this->live_tv_model->get_tv_poster($tv['poster']); ?>" alt="<?php echo $tv['tv_name']; ?>" />
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
                            // autoplay: true,
                            // autoplayTimeout: 8500,
                            // smartSpeed: 450,
                            nav: true,
                            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                            dots: false,
                            responsive: {
                                0: {
                                    items: 2
                                },
                                600: {
                                    items: 3
                                },
                                800: {
                                    items: 4
                                },
                                1000: {
                                    items: 4
                                },
                                1200: {
                                    items: 5
                                }
                            }
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if($this->live_tv_model->get_tv_status()): ?>
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
                                <?php if($tv['is_paid'] == '1'):?>
                                    <span class="tv-ribbon">VIP</span> 
                                <?php endif; ?> 
                                <a href="<?php echo base_url('live-tv/').$tv['slug'].'.html'; ?>">
                                    <img class="owl-lazy" src="<?php echo base_url('uploads/default_image/tv_poster.jpg'); ?>" data-src="<?php echo $this->live_tv_model->get_tv_poster($tv['poster']); ?>" alt="<?php echo $tv['tv_name']; ?>" />
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
                            // autoplay: true,
                            // autoplayTimeout: 8500,
                            // smartSpeed: 450,
                            nav: true,
                            navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                            dots: false,
                            responsive: {
                                0: {
                                    items: 2
                                },
                                600: {
                                    items: 3
                                },
                                800: {
                                    items: 4
                                },
                                1000: {
                                    items: 4
                                },
                                1200: {
                                    items: 5
                                }
                            }
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php
        $live_tv_categories = $this->live_tv_model->get_all_live_tv_category();
        foreach ($live_tv_categories as $live_tv_category):
        $tvs = $this->live_tv_model->get_live_tv_by_category_id($live_tv_category['live_tv_category_id']);
        if(count($tvs) > 0):
    ?>
      <!-- live tv by category -->
      <div id="section-opt">
        <div class="container">
          <div class="row">
            <!-- Upcomming Movies -->
            <div class="col-md-12 col-sm-12">
              <div class="latest-movie movie-opt">
                <div class="movie-heading overflow-hidden"> 
                  <span>
                    <?php echo $live_tv_category['live_tv_category']; ?>
                  </span>
                  <div class="disable-bottom-line">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="owl-carousel live_tv_owl_cat_<?php echo $live_tv_category['live_tv_category_id']; ?>">
                <?php foreach ($tvs as $tv): ?>
                <div class="item">
                    <figure class="figure">
                        <?php if($tv['is_paid'] == '1'):?>
                            <span class="tv-ribbon">VIP</span> 
                        <?php endif; ?> 
                        <a href="<?php echo base_url('live-tv/').$tv['slug'].'.html'; ?>">
                            <img class="owl-lazy" src="<?php echo base_url('uploads/default_image/tv_poster.jpg'); ?>" data-src="<?php echo $this->live_tv_model->get_tv_poster($tv['poster']); ?>" alt="<?php echo $tv['tv_name']; ?>" />
                            <figcaption class="figure-caption "><?php echo $tv['tv_name']; ?></figcaption>
                        </a>
                    </figure>
                </div>
                <?php endforeach; ?>
              </div>
              <script type="text/javascript">
                $(".live_tv_owl_cat_<?php echo $live_tv_category['live_tv_category_id']; ?>").owlCarousel({
                    stagePadding: 0,
                    /*the little visible images at the end of the carousel*/
                    loop: true,
                    rtl: false,
                    lazyLoad: true,
                    margin: 15,
                    center: true,
                    // autoplay: true,
                    // autoplayTimeout: 8500,
                    // smartSpeed: 450,
                    nav: true,
                    navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                    dots: false,
                    responsive: {
                        0: {
                            items: 2
                        },
                        600: {
                            items: 3
                        },
                        800: {
                            items: 4
                        },
                        1000: {
                            items: 4
                        },
                        1200: {
                            items: 5
                        }
                    }
                })
            </script>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php endforeach; ?>
</section>
