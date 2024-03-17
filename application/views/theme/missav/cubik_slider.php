<!-- slider -->
<?php
  $theme_dir              =   'theme/default/';
  $assets_dir             =   'assets/theme/default/';
?>
<div class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
    <div class="slider-content container">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php 
                    $this->db->limit(20);
                    $this->db->order_by("videos_id","desc");
                    $slider_videos = $this->db->get_where('videos', array('publication'=>'1'))->result();
                    foreach ($slider_videos as $videos):
                ?>
                    <div class="swiper-slide">
                        <a  href="<?php echo base_url('watch/'.$videos->slug).'.html';?>" class="slide-link">
                            <img src="<?php echo $this->common_model->get_video_thumb_url($videos->videos_id); ?>" alt="<?php echo $videos->title;?>" />
                        </a>                        
                    </div>
                <?php endforeach; ?>                
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <?php include('popular_stars.php'); ?>    
</div>