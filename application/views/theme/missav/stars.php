<?php $star_per_page              =   30; ?>
<?php if($this->common_model->get_ads_status('movie_header')=='1'): ?>
<!-- header ads -->
<div id="ads" style="padding: 20px 0px;text-align: center;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php echo $this->common_model->get_ads('movie_header'); ?>
            </div>
        </div>
    </div>
</div>
<!-- header ads -->
<?php endif; ?>

<section class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
    <!-- Secondary Section -->
    <div id="section-opt">
        <div class="container">
            <div class="row">
                <!-- All Movies -->
                <?php if($total_rows > 0){  ?>
                <div class="col-md-12 col-sm-12">
                    <div class="latest-movie movie-opt">
                        <div class="movies-list-wrap mlw-latestmovie">
                            <div class="ml-title m-b-10">
                                <span class="pull-left title"><?php echo trans('popular_stars'); ?></span>
                            </div>
                        </div>
                        <div class="row clean-preset">
                            <div class="movie-container">
                                <?php foreach ($stars as $star) :?>
                                <div class="col-md-2 col-sm-3 col-xs-6">
                                    <div class="latest-movie-img-container lazy" style="background-image: url(<?php echo $this->common_model->get_image_url('star',$star['star_id']) ?>);">
                                      <div class="movie-img">
                                        <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star['star_id']);?>" class="ico-play ico-play-sm"></a>
                                        <div class="movie-title">
                                          <h3>
                                            <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star['star_id']);?>"><?php echo $star['star_name'] ?></a>
                                          </h3>
                                        </div>
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
            <?php if($total_rows > $star_per_page){ echo $links; } }else{ echo '<center><h3>'.trans("no_movie_found").'</h3></center>'; } ?>
            
        </div>
    </div>
    <!-- Secondary Section -->
</section>