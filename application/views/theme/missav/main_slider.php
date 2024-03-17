<!-- slider -->

<?php
  $theme_dir              =   'theme/default/';
  $assets_dir             =   'assets/theme/default/';
  $header_templete        =   ovoo_config('header_templete');
  $slider_type            =   ovoo_config('slider_type');
  $slider_fullwide        =   ovoo_config('slider_fullwide');
  $slider_height          =   ovoo_config('slider_height').'px';
  $slider_border_radius   =   ovoo_config('slider_border_radius').'px';
  $slider_arrow           =   ovoo_config('slider_arrow');
  $slider_bullet          =   ovoo_config('slider_bullet');
  $total_movie_in_slider  =   ovoo_config('total_movie_in_slider');
  ?>
<?php if ($slider_type=="movie" || $slider_type=="image" || $slider_type=="tv"): ?>
<style>
  .slider-content{
    height: <?php echo $slider_height; ?>;
    <?php if($slider_fullwide == '1'): ?>
    margin-top: -20px;
    <?php endif; ?>
  }
  #slider {
    border-radius: <?php echo $slider_border_radius; ?>;    
  }
</style>
<div class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
  <div class="slider-content <?php if($slider_fullwide != '1'): echo 'container'; endif; ?>">
    <div id="slider" class="swiper-container-horizontal">
        <div class="swiper-wrapper">
          <?php
            if ($slider_type=="movie"):
              $this->db->limit($total_movie_in_slider);
              $this->db->order_by("videos_id","desc");
              $slider_videos = $this->db->get_where('videos', array('publication'=>'1'))->result();
              foreach ($slider_videos as $videos):
          ?>
            <div class="swiper-slide" style="background-image: url('<?php echo $this->common_model->get_video_poster_url($videos->videos_id); ?>');">
                <a href="<?php echo base_url('watch/'.$videos->slug).'.html';?>" class="slide-link" title="<?php echo $videos->title;?>"> </a>
                <span class="slide-caption">
                  <h2><?php echo $videos->title;?></h2>
                  <p class="sc-desc"><?php echo substr(strip_tags($videos->description),0,220);?></p>
                  <div class="slide-caption-info">
                    <div class="block">
                      <strong><?php echo trans('genre'); ?>: </strong>
                      <?php if($videos->genre !='' && $videos->genre !=NULL):
                              $i = 0;
                              $genres =explode(',', $videos->genre);                                                
                              foreach ($genres as $genre_id):
                              if($i>0){ echo ',';} $i++;?><?php echo $this->genre_model->get_genre_name_by_id($genre_id);?>
                      <?php endforeach; endif;?>
                    </div>
                    <div class="block"><strong><?php echo trans('duration'); ?>:</strong> <?php echo $videos->runtime; ?></div>
                    <div class="block"><strong><?php echo trans('release'); ?>:</strong> 2019</div>
                    <div class="block"><strong>IMDb:</strong> <?php echo $videos->imdb_rating;?></div>
                  </div>
                  <a href="<?php echo base_url('watch/'.$videos->slug).'.html';?>" >
                    <div class="btn btn-sm btn-success mt20" style="margin-top: 10px;"><?php echo trans('watch_now') ?></div>
                  </a>
                </span>
            </div>
          <?php endforeach; ?>
        <?php 
          elseif($slider_type == "image"):
            $all_published_slider= $this->common_model->all_published_slider();
            foreach ($all_published_slider as $slider):
              $action_url = $slider->action_url;
              if($slider->action_type == 'movie' || $slider->action_type == 'tvseries' || $slider->action_type == 'tv'):
                if($slider->action_type == 'movie' || $slider->action_type == 'tvseries'):
                  $action_url = base_url("watch/".$this->common_model->get_slug_by_videos_id($slider->action_id).'.html');
                elseif($slider->action_type == 'tv'):
                  $action_url = base_url("live-tv/".$this->live_tv_model->get_slug_by_live_tv_id($slider->action_id).'.html');
                endif;
              endif;
        ?>
              <div class="swiper-slide" style="background-image: url('<?php echo $slider->image_link;?>');">
                <a href="<?php echo $action_url;?>" class="slide-link" title="<?php echo $slider->title;?>"> </a>
                <span class="slide-caption">
                  <h2><?php echo $slider->title;?></h2>
                  <p class="sc-desc"><?php echo $slider->description;?></p>
                  <a href="<?php echo $action_url;?>" >
                    <div class="btn btn-sm btn-success mt20" style="margin-top: 10px;"><?php echo $slider->action_btn_text; ?></div>
                  </a>
                </span>
            </div>
            <?php endforeach; ?>
        <?php 
          elseif($slider_type == "tv"):
            $this->db->limit($total_movie_in_slider);
             $this->db->order_by("live_tv_id","desc");
            $latset_tvs = $this->db->get_where('live_tv', array('publish'=>'1'))->result();
            foreach ($latset_tvs as $slider):
              $action_url = base_url('live-tv/'.$slider->slug.'.html');
        ?>
              <div class="swiper-slide" style="background-image: url('<?php echo $this->live_tv_model->get_tv_poster($slider->poster);?>');">
                <a href="<?php echo $action_url;?>" class="slide-link" title="<?php echo $slider->tv_name;?>"> </a>
                <span class="slide-caption">
                  <h2><?php echo $slider->tv_name;?></h2>
                  <p class="sc-desc"><?php echo $slider->description;?></p>
                  <a href="<?php echo $action_url;?>" >
                    <div class="btn btn-sm btn-success mt20" style="margin-top: 10px;"><?php echo trans("watch_now");?></div>
                  </a>
                </span>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if($slider_bullet == '1'): ?>
          <!-- Add Pagination -->
          <div class="swiper-pagination"></div>
        <?php endif; ?>
        <?php if($slider_arrow == '1'): ?>
          <!-- Add Arrows -->
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div style="margin-top: 20px;"></div>
  <?php include('popular_stars.php'); ?>  
</div>
<?php endif; ?>





