<div class="container">
    <div class="movies-list-wrap mlw-latestmovie">
        <div class="ml-title">
            <span class="pull-left title"><?php echo trans('popular_stars'); ?></span>
            <a href="<?php echo base_url(); ?>star.html" class="pull-right cat-more"><?php echo trans('view_more'); ?> »</a>
            <div class="clearfix"></div>
        </div>
        <br />
        <div class="swiper-container-horizontal" id="star-slider">
            <div class="swiper-wrapper">
                <?php
                    $popular_actors = $this->common_model->get_popular_stars();
                    foreach($popular_actors as $popular_actor):
                ?>
                    <div class="swiper-slide">
                        <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($popular_actor['star_id']);?>"><img style="border-radius: 10%;" src="<?php echo $this->common_model->get_star_image($popular_actor['star_id']); ?>" alt="<?php echo $popular_actor['star_name']; ?>_photo" onerror="this.onerror=null;this.src='<?php echo base_url('uploads/default_image/actor.jpg') ?>';" /></a>
                        <div class="movie-title3">
                            <h3>
                                <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($popular_actor['star_id']);?>"><?php echo $popular_actor['star_name']; ?></a>
                            </h3>
                        </div>
                    </div>
                <?php endforeach; ?>                                     
            </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>
</div>