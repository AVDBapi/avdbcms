<div>
    <h4 class="text-xl lg:text-2xl mb-3"> <?php echo trans('you_may_like'); ?> </h4>
</div>
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
    <?php
        $i = 0;
        if($watch_videos->is_tvseries == '1'):
            $related_videos = $this->common_model->get_related_tvseries($watch_videos->videos_id,$watch_videos->genre);
        else:   
            $related_videos = $this->common_model->get_related_movie($watch_videos->videos_id,$watch_videos->genre);
        endif;
        //var_dump($related_videos);        
        foreach ($related_videos as $videos):
            $i++;
    ?>
        <?php include('thumbnail.php'); ?>
    <?php endforeach; ?>
</div>