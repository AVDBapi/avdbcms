<div class="row hidden-xs">
    <div class="col-md-12">
        <div class="similler-movie">
            <div class="movie-heading overflow-hidden"> <span class="fadeInUp" data-wow-duration="0.8s"> <?php echo trans('you_may_like'); ?> </span>
                <div class="disable-bottom-line" data-wow-duration="0.8s"> </div>
            </div>
            <div class="row">
                <div class="movie-container">
                    <?php
                        $i      = 0;
                        if($watch_videos->is_tvseries == '1'):
                            $related_videos = $this->common_model->get_related_tvseries($watch_videos->videos_id,$watch_videos->genre);
                        else:   
                            $related_videos = $this->common_model->get_related_movie($watch_videos->videos_id,$watch_videos->genre);
                        endif;
                        //var_dump($related_videos);        
                        foreach ($related_videos as $videos):
                            $i++;
                    ?>
                    <div class="col-md-2 col-sm-3 col-xs-6">
                        <?php include('thumbnail.php'); ?>
                    </div>
                    <?php if($i%6==0){ echo "</div></div><div class='row'><div class='movie-container'>";} ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>