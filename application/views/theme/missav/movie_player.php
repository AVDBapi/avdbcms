
<?php
$theme_dir      =   'theme/default/';
$assets_dir     =   'assets/theme/default/';
?>



<div class="movie-payer">
    <?php
    if(($total_video_files >0)):
        $player_color_skin          =   $this->db->get_where('config' , array('title'=>'player_color_skin'))->row()->value;
        if(isset($_GET['key'])):
            $video_file 	= $this->common_model->get_single_video_file_details_by_key($_GET['key']);
            $video_file_id  = $video_file->video_file_id;
            $source_type    = $video_file->source_type;
            $file_source    = $video_file->file_source;
            $file_url       = $video_file->file_url;

        else:
            $video_file 	= $this->common_model->get_first_video_details_videos_id($videos_id);
            $video_file_id  = $video_file->video_file_id;
            $source_type    = $video_file->source_type;
            $file_source    = $video_file->file_source;
            $file_url       = $video_file->file_url;
        endif;
        $subtitles = $this->db->get_where('subtitle', array('video_file_id'=>$video_file_id))->result_array();
    if($file_source=='mp4' || $file_source=='webm' || $file_source=='flv' || $file_source=='m3u8' || $file_source=='gdrive' || $file_source=='amazone'):
        ?>
        <!-- script -->
        <?php  if($file_source=='m3u8' || $file_source=='flv'): ?>
        <script src="https://unpkg.com/videojs-flash/dist/videojs-flash.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.14.1/videojs-contrib-hls.min.js"></script>
    <?php endif; ?>
        <video id="play" class="video-js vjs-big-play-centered skin-<?php echo $player_color_skin; ?> vjs-16-9" controls preload="none" width="640" height="265" poster="<?php echo $this->common_model->get_video_poster_url($watch_videos->videos_id); ?>" data-setup="{}">                            <!-- video source -->
            <?php
            foreach ($subtitles as $subtitle):
                ?>
                <!-- subtitle source -->
                <track kind="<?php echo $subtitle['kind']; ?>" src="<?php echo $subtitle['src']; ?>" srclang="<?php echo $subtitle['srclang']; ?>" label="<?php echo $subtitle['language']; ?>"></track><!-- Tracks need an ending tag thanks to IE9 -->
            <?php endforeach; ?>
            <!-- worning text if needed -->
            <p class="vjs-no-js"><?php echo trans('to_view_this_video_please_enable_JavaScript,_and_consider_upgrading_to_a_web_browser_that'); ?> <a href="http://videojs.com/html5-video-support/" target="_blank"><?php echo trans('supports_html5_video'); ?></a></p>
        </video>
        <script>
            var options;
            options = {
                "controls": true,
                "autoplay": false,
                "preload": "auto" ,
                "playbackRates": [0.5, 1, 1.5, 2, 3, 4],
                techOrder: [ 'chromecast', 'html5' ],
                sources: [
                    { src: '<?php echo $file_url; ?>', type: '<?php if($file_source =='mp4' || $file_source =='gdrive' || $file_source =='amazone'){echo 'video/mp4';}else if($file_source =='flv'){echo 'video/x-flv';}else if($file_source =='webm' || $file_source =='mkv'){echo 'video/webm';}else if($file_source =='m3u8'){echo 'application/x-mpegURL';} ?>'}
                ],
                chromecast: {
                    requestTitleFn: function(source) { // Not required
                        return '<?php echo str_replace('"','',str_replace("'", "", $watch_videos->title)); ?>';
                    },
                    requestSubtitleFn: function(source) { // Not required
                        return 'Watching Movie';
                    },
                    requestCustomDataFn: function(source) { // Not required
                        return {
                            'live': false,
                        }
                    },
                    requestPosterFn: function () {
                        return [
                            {
                                'url': '<?php echo $this->common_model->get_video_thumb_url($watch_videos->videos_id); ?>'
                            }
                        ];
                    }
                },
                plugins: {
                    chromecast: {
                        customData: {
                            live: false
                        }
                    },
                }
            };
            var ovoo_player = videojs('play', options);
        </script>
        <?php $this->load->view($theme_dir.'player_plugin', array('unique_file_id' => $video_file->video_file_id)); ?>
    <?php endif; ?>
    <?php if($file_source=='youtube'): ?>
        <!-- play from youtube file -->
        <video id="play" class="video-js vjs-big-play-centered skin-<?php echo $player_color_skin; ?> vjs-16-9" poster="<?php echo $this->common_model->get_video_poster_url($watch_videos->videos_id); ?>">
            <?php
            foreach ($subtitles as $subtitle):
                ?>
                <!-- subtitle source -->
                <track kind="<?php echo $subtitle['kind']; ?>" src="<?php echo $subtitle['src']; ?>" srclang="<?php echo $subtitle['srclang']; ?>" label="<?php echo $subtitle['language']; ?>"></track><!-- Tracks need an ending tag thanks to IE9 -->
            <?php endforeach; ?>
        </video>
        <!-- youtube -->
        <script src="<?php echo base_url(); ?>assets/player/plugins/videojs-youtube/Youtube.min.js"></script>

        <script>
            videojs("play", {
                "controls": true,
                "autoplay": true,
                "preload": "auto" ,
                "width": 640,
                "height": 265,
                "techOrder":  ["youtube"],
                "sources": [{ "type": "video/youtube", "src": "<?php echo $file_url; ?>"}],
            });
        </script>
    <?php endif; ?>
        <!-- mkv file -->
    <?php if($file_source=='mkv'): ?>
    <link rel="stylesheet" href="https://cdn.fluidplayer.com/v2/current/fluidplayer.min.css" type="text/css"/>
        <script src="https://cdn.fluidplayer.com/v2/current/fluidplayer.min.js"></script>
        <video id="video-id"> <source src="<?php echo $file_url; ?>" type="video/mp4"/>
            <?php
            foreach ($subtitles as $subtitle):
                ?>
                <!-- subtitle source -->
                <track kind="<?php echo $subtitle['kind']; ?>" src="<?php echo $subtitle['src']; ?>" srclang="<?php echo $subtitle['srclang']; ?>" label="<?php echo $subtitle['language']; ?>"></track><!-- Tracks need an ending tag thanks to IE9 -->
            <?php endforeach; ?>
        </video>
        <script>
            fluidPlayer("video-id",{
                layoutControls: {
                    fillToContainer: true, // Default true
                    posterImage: '<?php echo $this->common_model->get_video_poster_url($watch_videos->videos_id); ?>',
                    doubleclickFullscreen: true, // Default true
                }
            });
        </script>
    <?php endif; ?>
        <!-- END mkv -->
    <?php if($file_source=='vimeo'): ?>
        <!--  play from vimeo file -->
        <script src="<?php echo base_url(); ?>assets/player/video-js-5/video.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/player/plugins/videojs-vimeo/vimeo.js"></script>
        <video id="playerjs" class="video-js vjs-big-play-centered skin-<?php echo $player_color_skin; ?> vjs-16-9" controls autoplay width="960" height="400"
               data-setup='{}'
        >
        </video>
        </center>
        <script>
            videojs("playerjs", {
                "controls": true,
                "autoplay": true,
                "preload": "auto" ,
                "width": 640,
                "height": 265,
                "techOrder":  ["vimeo"],
                "sources": [{ "type": "video/vimeo", "src": "<?php echo $file_url; ?>"}],
            });
        </script>
    <?php endif; ?>
    <?php if($file_source=='embed'): ?>
        <!-- play from embed url  -->
        <style type="text/css">
            .video-embed-container {
                position: relative;
                padding-bottom: 56.25%;
                padding-top: 30px; height: 0; overflow: hidden;
            }
            .video-embed-container iframe,
            .video-embed-container object,
            .video-embed-container embed {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
        </style>
        <div class="video-embed-container"><iframe class="responsive-embed-item" src="<?php echo $file_url; ?>" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>
    <?php endif; ?>
    <?php else: ?>
        <!-- play trailler from youtube -->
        <style type="text/css">
            .video-embed-container {
                position: relative;
                padding-bottom: 56.25%;
                padding-top: 30px; height: 0; overflow: hidden;
            }
            .video-embed-container iframe,
            .video-embed-container object,
            .video-embed-container embed {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }
        </style>
        <div class="video-embed-container"><iframe width="853" height="480" src="https://www.youtube.com/embed?listType=search&list=<?php echo $watch_videos->title; ?>" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>
    <?php endif; ?>
    <?php $this->load->view($theme_dir.'disclaimer'); ?>
    <!-- server -->
    <div class="row">
        <div class="col-md-12 m-b-10">
            <div class="season">
                <?php
                $sources = $this->common_model->get_video_file_by_videos_id($watch_videos->videos_id);
                $i=0;
                if(isset($_GET['key'])){
                    $current_file_id = $_GET['key'];
                }else{
                    $current_file_id = '000000';
                }
                foreach($sources as $source):
                    $i++;
                    ?>
                    <a href="<?php echo base_url().'watch/'.$watch_videos->slug.'.html?key='.$source['stream_key']; ?>" class="btn btn-sm btn-inline <?php if($source['stream_key']==$current_file_id){ echo 'btn-success';}else if($current_file_id=='000000' && $i=='1'){ echo 'btn-success';}else{ echo 'btn-default';} ?>"><?php echo $source['label']; ?></a>
                <?php endforeach; ?>
                <?php $movie_report_enable =   $this->db->get_where('config' , array('title' =>'movie_report_enable'))->row()->value;?>
                <div class="pull-right">
                    <?php if($watch_videos->trailler_youtube_source !=NULL && $watch_videos->trailler_youtube_source !=''): ?>
                        <a href="<?php echo $watch_videos->trailler_youtube_source; ?>" class="popup-youtube btn btn-sm btn-inline btn-success"><?php echo trans('trailler'); ?></a>
                    <?php endif; ?>
                    <?php if($movie_report_enable == '1'): ?>
                        <a data-toggle="modal" id="menu" class="btn" data-target="#report-modal" data-id="<?php echo base_url('home/view_modal/report/'.$watch_videos->videos_id) ?>" style="text-transform: lowercase;font-size: 13px;color: yellow;" href="#"><i class="fa fa-warning"></i>&nbsp;report</a>
                    <?php endif; ?>
                </div>
                <?php if($movie_report_enable == '1'): $this->load->view($theme_dir.'report'); endif; ?>
            </div>
        </div>
    </div>
    <style type="text/css">
        .season{
            min-height: 50px;
            padding: 10px;
            background-color: rgba(255,255,255, 0.04);
        }
    </style>
    <!-- END server -->
</div>