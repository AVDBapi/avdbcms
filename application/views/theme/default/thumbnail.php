<?php $assets_dir  =   'assets/theme/default/'; ?>
<div class="popup" data-toggle="popover" data-container="body" title="<?php echo $videos['title'];?>" data-original-title="<?php echo $videos['title'];?>" data-content="
      <div class='trailer-container' >
          <div class='trailer-foreground'>
            <?php if($videos['trailler_youtube_source'] !='' && $videos['trailler_youtube_source'] !=NULL):?>
              <iframe src='https://www.youtube.com/embed/<?php echo $this->common_model->getYouTubeId($videos['trailler_youtube_source']);?>?autoplay=1&loop=1&controls=0&showinfo=0' frameborder='0' allow='autoplay; encrypted-media; fullscreen'></iframe>
            <?php else: ?>
              <img src='<?php echo $this->common_model->get_video_poster_url($videos['videos_id']); ?>'>
            <?php endif; ?>
          </div>
      </div>" >
  <div class="latest-movie-img-container lazy" style="background-image: url('<?php echo $this->common_model->get_video_thumb_url($videos['videos_id']); ?>'); display: inline-block;">
    <div class="movie-img">
      <a href="<?php echo base_url('watch/'.$videos['slug']).'.html';?>" class="ico-play ico-play-sm">
        <svg 
          version="1.1" 
          id="play_sv" 
          xmlns="http://www.w3.org/2000/svg" 
          xmlns:xlink="http://www.w3.org/1999/xlink" 
          x="0px" 
          y="0px" 
          height="60px" 
          width="60px" 
          viewBox="0 0 100 100" 
          enable-background="new 0 0 100 100" 
          xml:space="preserve">
          <path 
            class="stroke-solid" 
            fill="none" 
            stroke="#ff277d" 
            d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7 C97.3,23.7,75.7,2.3,49.9,2.5">
          </path>
          <path 
            class="stroke-dotted" 
            fill="none" 
            stroke="white" 
            d="M49.9,2.5C23.6,2.8,2.1,24.4,2.5,50.4C2.9,76.5,24.7,98,50.3,97.5c26.4-0.6,47.4-21.8,47.2-47.7 C97.3,23.7,75.7,2.3,49.9,2.5">
          </path>
          <path class="icon" fill="white" d="M38,69c-1,0.5-1.8,0-1.8-1.1V32.1c0-1.1,0.8-1.6,1.8-1.1l34,18c1,0.5,1,1.4,0,1.9L38,69z"></path>
        </svg>
      </a>
      <div class="overlay-div"></div>
      <?php if($videos['is_tvseries']!='1'): ?>
        <div class="video_quality_movie">          
          <span class="label label-primary"> <?php echo $videos['video_quality']; ?> </span>
        </div>
        <div class="video_year_movie">
          <span class="label label-year"> <?php echo date("Y",strtotime($videos['release']));?> </span>
        </div>
      <?php endif; ?>
      
      <?php if($videos['is_tvseries']=='1'): ?>
        <div class="video_quality_tv">          
          <span class="label label-primary"> <?php echo $this->common_model->get_num_episodes_by_id($videos['videos_id']).' EP'; ?> </span>
        </div>
        <div class="video_year_tv">
          <span class="label label-year"> <?php echo date("Y",strtotime($videos['release']));?> </span>
        </div>
      <?php endif; ?>
      <div class="imdb-rating">
        <span class="label label-imdb">
          <i class="fa fa-info-circle" aria-hidden="true"></i> IMDB <?php echo $videos['imdb_rating'];?> </span>
      </div>
      <div class="movie-title">
        <h3>
          <a href="<?php echo base_url('watch/'.$videos['slug']).'.html';?>"><?php echo $videos['title'];?></a>
        </h3>
      </div>
    </div>
  </div>
</div>

