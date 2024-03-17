<?php
    $s =0;
    $seasons = $this->common_model->get_seasons_by_videos_id($watch_videos->videos_id);
    foreach ($seasons as $season):
        if($this->common_model->get_num_episodes_by_seasons_id($season['seasons_id']) > 0):
            $episodes = $this->common_model->get_episodes_by_videos_id_and_season_id($watch_videos->videos_id,$season['seasons_id']);
            $s++;
            $i=0;
            $current_key = '000000';
            if(isset($_GET['key'])):
                $current_key = $_GET['key'];
            else:
                $current_key = $first_ep_details->stream_key;
            endif;
?>

<div class="row">
    <!-- Upcomming Movies -->
    <div class="col-md-12 col-sm-12">
        <div class="latest-movie movie-opt">
            <div class="movie-heading overflow-hidden"> <span><?php echo $season['seasons_name']; ?></span>
                <div class="disable-bottom-line"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="owl-carousel <?php echo 'season_'.$season['seasons_id']; ?>">
            <?php
                foreach($episodes as $episode):
                $i++;
            ?>

            <div class="item">
                <figure class="figure">
                    <?php if($current_key == $episode['stream_key']):?>
                        <span class="tv-ribbon">Playing..</span> 
                    <?php endif; ?>                                                  
                    <a href="<?php echo base_url().'watch/'.$watch_videos->slug.'.html?key='.$episode['stream_key']; ?>">
                        <div>                                    
                            <img class="owl-lazy" src="<?php echo base_url().'uploads/default_image/episode.jpg'; ?>" data-src="<?php echo $this->common_model->get_episode_image_url($watch_videos->videos_id,$episode['episodes_id']); ?>" alt="<?php echo $episode['episodes_name']; ?>" />
                        </div>
                        <figcaption class="figure-caption "><?php echo $episode['episodes_name']; ?></figcaption>
                    </a>
                </figure>
            </div>
            <?php endforeach; ?>
        </div>
        <script type = "text/javascript" >
            $('<?php echo '.season_'.$season['seasons_id']; ?>').owlCarousel({
                stagePadding: 0,
                loop: false,
                rtl: false,
                lazyLoad: true,
                margin: 15,
                center: false,
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
            }); 
        </script>
    </div>
</div>

<?php endif; ?>
<?php endforeach; ?>