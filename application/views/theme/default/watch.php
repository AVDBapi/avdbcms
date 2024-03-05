<section class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
    <?php
        $show_star_image    =   $this->db->get_where('config' , array('title'=>'show_star_image'))->row()->value;
        $theme_dir          =   'theme/default/';
        $assets_dir         =   'assets/theme/default/';
    ?>

    <div id="movie-details">
        <div class="container">
            <!-- row1 player -->
            <div class="row">
                <div class="<?php if($this->common_model->get_ads_status('sidebar')=='1'): echo "col-md-9 col-sm-6"; else: echo "col-md-12 col-sm-12"; endif; ?>">
                    <?php if($this->common_model->get_ads_status('player_top')=='1'): ?>
                        <!-- player top to ads -->
                        <div class="row">
                            <div class="col-md-12 text-center m-b-10">
                                <?php echo $this->common_model->get_ads('player_top'); ?>
                            </div>
                        </div>
                        <!-- player top to ads -->
                    <?php endif; ?>
                    <!-- player -->
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                                if($watch_videos->is_tvseries =='1'):
                                    $this->load->view($theme_dir.'tvseries_player');
                                else:
                                    $this->load->view($theme_dir.'movie_player');
                                endif;
                            ?>
                        </div>
                    </div>
                    <!-- End player -->
                    <?php if($this->common_model->get_ads_status('player_bottom')=='1'): ?>
                        <!-- player bottom to ads -->
                        <div class="row">
                            <div class="col-md-12 text-center m-b-10">
                                <?php echo $this->common_model->get_ads('player_bottom'); ?>
                            </div>
                        </div>
                        <!-- player bottom to ads -->
                    <?php endif; ?>
                </div>
                <?php if($this->common_model->get_ads_status('sidebar')=='1'): ?>
                    <!-- sidebar ads -->
                    <div class="col-md-3 col-sm-6">
                        <div class="sidebar">
                            <div class="ad_300x250 m-b-10">
                                 <?php echo $this->common_model->get_ads('sidebar'); ?>    
                            </div>
                        </div>
                    </div>
                    <!-- End sidebar ads -->
                <?php endif; ?>
            </div>        
            <!-- End row1 player -->

            <!-- row2 movie info -->
            <div class="row">
                <div class="<?php if($this->common_model->get_ads_status('sidebar')=='1'): echo "col-md-9 col-sm-6"; else: echo "col-md-12 col-sm-12"; endif; ?>">
                    <!-- movie info -->
                    <div class="row movies-list-wrap">
                    <div class="ml-title">
                        <span class="pull-left title"><?php echo $watch_videos->title;?></span>
                        <ul role="tablist" class="nav nav-tabs">
                            <li style="display: none;"><a data-toggle="tab" href="#in" style="display: none;"><?php echo trans('info'); ?></a></li>
                            <li class="active"><a data-toggle="tab" href="#info"><?php echo trans('info'); ?></a></li>
                            <?php if($show_star_image =='1'): ?>
                                <li><a data-toggle="tab" href="#actor_tab"><?php echo trans('actor'); ?></a></li>
                                <li><a data-toggle="tab" href="#director_tab"><?php echo trans('director'); ?></a></li>
                                <li><a data-toggle="tab" href="#writer_tab"><?php echo trans('writer'); ?></a></li>
                            <?php endif; ?>
                            <?php if($total_download_links >0 && $watch_videos->enable_download =='1'): ?>
                            <li><a data-toggle="tab" href="#download"><?php echo trans('download'); ?></a></li>
                            <?php endif; ?>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="tab-content">
                            <div id="info" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-3 m-t-10"><img class="img-responsive" style="min-width: 183px;" src="<?php echo $this->common_model->get_video_thumb_url($watch_videos->videos_id); ?>" alt="<?php echo $watch_videos->title;?>"></div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h1>
                                                    <?php echo $watch_videos->title;?>
                                                </h1>
                                                <button class="btn btn-sm btn-default" onclick="wish_list_add('fav','<?php echo $watch_videos->videos_id;?>')"><i class="fa fa-heart-o"></i></button>
                                                <button class="btn btn-sm btn-default" onclick="wish_list_add('wl','<?php echo $watch_videos->videos_id;?>')"><i class="fa fa-clock-o"></i></button>
                                                
                                                <?php  if($this->db->get_where('config' , array('title' =>'social_share_enable'))->row()->value =='1'):?>
                                                
                                                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                                <div class="addthis_inline_share_toolbox_yl99 m-t-30 m-b-10" data-url="<?php echo base_url().'watch/'.$watch_videos->slug.'.html';?>" data-title="Watch & Download <?php echo $watch_videos->title;?>"></div>
                                                <!-- Addthis Social tool -->
                                            <?php endif; ?>
                                                <p>
                                                    <?php echo $watch_videos->description;?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-left">
                                                <p> <strong><?php echo trans('genre'); ?>: </strong>
                                                    <?php if($watch_videos->genre !='' && $watch_videos->genre !=NULL):
                                                        $i = 0;
                                                        $genres =explode(',', $watch_videos->genre);                                                
                                                        foreach ($genres as $genre_id):
                                                        if($i>0){ echo ',';} $i++;                                           ?>
                                                    <a href="<?php echo $this->genre_model->get_genre_url_by_id($genre_id);?>"><?php echo $this->genre_model->get_genre_name_by_id($genre_id);?></a>
                                                <?php endforeach; endif;?>
                                                </p>
                                                <p> <strong><?php echo trans('actor'); ?>: </strong>
                                                    <?php if($watch_videos->stars !='' && $watch_videos->stars !=NULL):
                                                        $i = 0;
                                                        $stars =explode(',', $watch_videos->stars);                                                
                                                        foreach ($stars as $star_id):
                                                        if($i>0){ echo ',';} $i++;                                           ?>
                                                    <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>"><?php echo $this->common_model->get_star_name_by_id($star_id);?></a>
                                                <?php endforeach; endif;?>
                                                </p>

                                                <p> <strong><?php echo trans('director'); ?>: </strong>
                                                    <?php if($watch_videos->director !='' && $watch_videos->director !=NULL):
                                                        $i = 0;
                                                        $stars =explode(',', $watch_videos->director);                                                
                                                        foreach ($stars as $star_id):
                                                        if($i>0){ echo ',';} $i++;                                           ?>
                                                    <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>"><?php echo $this->common_model->get_star_name_by_id($star_id);?></a>
                                                <?php endforeach; endif;?>
                                                </p>

                                                <p> <strong><?php echo trans('writer'); ?>: </strong>
                                                    <?php if($watch_videos->writer !='' && $watch_videos->writer !=NULL):
                                                        $i = 0;
                                                        $stars =explode(',', $watch_videos->writer);                                                
                                                        foreach ($stars as $star_id):
                                                        if($i>0){ echo ',';} $i++;                                           ?>
                                                    <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>"><?php echo $this->common_model->get_star_name_by_id($star_id);?></a>
                                                <?php endforeach; endif;?>
                                                </p>
                                                <p> <strong><?php echo trans('country'); ?>: </strong>
                                                    <?php if($watch_videos->country !='' && $watch_videos->country !=NULL):
                                                        $i = 0;
                                                        $countries =explode(',', $watch_videos->country);                                                
                                                        foreach ($countries as $country_id):
                                                        if($i>0){ echo ',';} $i++;
                                                        ?>
                                                    <a href="<?php echo $this->country_model->get_country_url_by_id($country_id);?>"><?php echo $this->country_model->get_country_name_by_id($country_id);?></a>
                                                <?php endforeach; endif;?>
                                                </p>
                                                <p><strong><?php echo trans('release'); ?>: </strong>
                                                    <?php echo $watch_videos->release;?>
                                                </p>
                                            </div>
                                            <div class="col-md-6 text-left">
                                                <p><strong><?php echo trans('duration'); ?>:</strong>
                                                    <?php echo $watch_videos->runtime;?>
                                                </p>
                                                <p><strong><?php echo trans('quality'); ?>:</strong>  <span class="label label-primary"><?php echo $watch_videos->video_quality; ?></span></p>
                                                <p><strong><?php echo trans('rating'); ?>:</strong>
                                                    <?php echo $watch_videos->rating;?>
                                                </p>
                                                <?php if($watch_videos->imdb_rating !='' && $watch_videos->imdb_rating !=NULL): ?>
                                                <p><strong><img src="<?php echo base_url($assets_dir);?>images/imdb-logo.png"></strong>
                                                    <?php echo $watch_videos->imdb_rating;?>
                                                </p>
                                            <?php endif; ?>
                                                <div class='rating_selection pull-left'> <strong id="rated"><?php echo trans('rating'); ?>(<?php echo $watch_videos->total_rating;?>)</strong><br>
                                                    <input checked id='rating_0' class="rate_now" name='rating' type='radio' value='0'>
                                                    <label for='rating_0'> <span><?php echo trans('unrated'); ?></span> </label>
                                                    <input id='rating_1' class="rate_now" name='rating' type='radio' value='1'>
                                                    <label for='rating_1'> <span><?php echo trans('rate_1_star'); ?></span> </label>
                                                    <input id='rating_2' class="rate_now" name='rating' type='radio' value='2'>
                                                    <label for='rating_2'> <span><?php echo trans('rate_2_stars'); ?></span> </label>
                                                    <input id='rating_3' class="rate_now" name='rating' type='radio' value='3' checked>
                                                    <label for='rating_3'> <span><?php echo trans('rate_3_stars'); ?></span> </label>
                                                    <input id='rating_4' class="rate_now" name='rating' type='radio' value='4'>
                                                    <label for='rating_4'> <span><?php echo trans('rate_4_stars'); ?></span> </label>
                                                    <input id='rating_5' class="rate_now" name='rating' type='radio' value='5'>
                                                    <label for='rating_5'> <span><?php echo trans('rate_5_stars'); ?></span> </label>
                                                    <br>
                                                </div><br>
                                                
                                            </div>
                                        </div>
                                        <!-- tags -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <style>
                                                    .btn-tags{
                                                        border-radius: 20px;
                                                        text-transform: capitalize;
                                                        border:none;
                                                    }
                                                    .btn-tags:hover{
                                                        background-color: #0088cc;
                                                        color: #fff;
                                                    }
                                                </style>
                                                <?php if ($watch_videos->tags !='' && $watch_videos->tags !=NULL): ?>
                                                        <?php $tags=explode(',', $watch_videos->tags);
                                                        foreach ($tags as $tag):
                                                        ?><a class="btn btn-default btn-tags btn-sm" href="<?php echo base_url().'tags/'.$tag.'.html'; ?>">#<?php echo $tag; ?></a>
                                                        <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php if($total_download_links >0 && $watch_videos->enable_download =='1'): ?>
                            <div id="download" class="tab-pane fade m-t-10">
                              <?php foreach($download_links as $dw_link): $season_title =''; if($watch_videos->is_tvseries): $season_title = $this->common_model->get__seasons_name_by_id($dw_link['season_id']); endif;?>
                                    <a class='btn btn-default btn-inline btn-sm' href="<?php echo urldecode($dw_link['download_url']); ?>"><span class="btn-label"><i class="fa fa-download"></i></span><?php echo $season_title.'-'.$dw_link['link_title'].'-'.$dw_link['resolution'].'-'.$dw_link['file_size'] ?></a>
                              <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <?php if($show_star_image =='1'): ?>
                            <div id="actor_tab" class="tab-pane m-t-10">
                                <div class="row">
                                    <?php if($watch_videos->stars !='' && $watch_videos->stars !=NULL):
                                            $stars =explode(',', $watch_videos->stars);                                                
                                            foreach ($stars as $star_id):
                                    ?>
                                        <div class="col-md-2 col-sm-3 col-xs-4">
                                            <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>">
                                                <img class="thumbnail img-responsive" src="<?php echo $this->common_model->get_image_url('star',$star_id) ?>" alt="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>" title="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>">
                                            </a>
                                        </div>
                                    <?php endforeach; endif;?>
                                </div>
                            </div>
                            <div id="director_tab" class="tab-pane fade m-t-10">
                                <div class="row">
                                    <?php if($watch_videos->director !='' && $watch_videos->director !=NULL):
                                            $stars =explode(',', $watch_videos->director);                                                
                                            foreach ($stars as $star_id):
                                    ?>
                                    <div class="col-md-2 col-sm-3 col-xs-4">
                                        <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>">
                                            <img class="thumbnail img-responsive" src="<?php echo $this->common_model->get_image_url('star',$star_id) ?>" alt="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>" title="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>">
                                        </a>
                                    </div>
                                    <?php endforeach; endif;?>
                                </div>
                            </div>
                            <div id="writer_tab" class="tab-pane fade m-t-10">
                                <div class="row">
                                <?php if($watch_videos->writer !='' && $watch_videos->writer !=NULL):
                                        $stars =explode(',', $watch_videos->writer);                                                
                                        foreach ($stars as $star_id):
                                 ?>
                                 <div class="col-md-2 col-sm-3 col-xs-4">
                                    <a href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>">
                                        <img class="thumbnail img-responsive" src="<?php echo $this->common_model->get_image_url('star',$star_id) ?>" alt="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>" title="<?php echo $this->common_model->get_star_name_by_id($star_id); ?>">
                                    </a>
                                </div>
                                <?php endforeach; endif;?>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                    <!-- End movie info -->
                </div>
            </div>
                <?php if($this->common_model->get_ads_status('sidebar')=='1'): ?>
                    <!-- sidebar ads -->
                    <div class="col-md-3 col-sm-6">
                        <div class="sidebar">
                            <div class="ad_300x250 m-b-10">
                                 <?php echo $this->common_model->get_ads('sidebar'); ?>    
                            </div>
                        </div>
                    </div>
                    <!-- End sidebar ads -->
                <?php endif; ?>
            </div>
            <!-- End row2 movie info -->
            <?php $this->load->view($theme_dir.'related_movies'); ?>
            <?php $this->load->view($theme_dir.'comments',array('PAGE_URL' => base_url('watch/'.$watch_videos->slug.'.html'),'PAGE_IDENTIFIER'=>$watch_videos->videos_id)); ?>
        </div>
    </div>

    <!--sweet alert2 JS -->
    <!-- ajax add to wish-list -->
    <script type="text/javascript">
        function wish_list_add(list_type = '', videos_id = '') {

            if (list_type == 'fav') {
                list_name = 'Favorite';
            } else {
                list_name = 'Wish';
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>user/add_to_wish_list',
                data: "list_type=" + list_type + "&videos_id=" + videos_id,
                dataType: 'json',
                beforeSend: function() {},
                success: function(response) {
                    var status = response.status;
                    if (status == "success") {
                        swal('Good job!', 'Added to your ' + list_name + ' List.', 'success');
                    } else if (status == "login_fail") {
                        swal('OPPS!', 'Please login to add your ' + list_name + ' list.', 'error');
                    } else {
                        swal('OPPS!', 'Already exist on your ' + list_name + ' list.', 'error');
                    }
                }
            });
        }
    </script>
    <!-- End ajax add to wish-list -->
    <!-- Ajax Rating -->
    <script>
        $('.rate_now').click(function() {
            rate = $(this).val();
            video_id = "<?php echo $watch_videos->videos_id;?>";
            current_rating = "<?php echo $watch_videos->total_rating;?>";
            total_rating = Number(current_rating) + Number(1);
            if (parseInt(rate) && parseInt(video_id)) {
                $.ajax({
                    type: 'POST',
                    url: "<?php echo base_url().'admin/rating';?>",
                    data: "rate=" + rate + "&video_id=" + video_id,
                    dataType: 'json',
                    success: function(response) {
                        var post_status = response.post_status;
                        var rate = response.rate;
                        var video_id = response.video_id;
                        if (post_status == "success") {
                            $('#rated').html('Rating(' + total_rating + ')');
                        } else {
                            alert('Fail to submit rating'); 
                        }
                    }
                });
            }
        });
    </script>
    <!-- End ajax Rating -->
</section>


