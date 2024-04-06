<section>
    <?php
    $show_star_image = $this->db->get_where('config', array('title' => 'show_star_image'))->row()->value;
    $theme_dir = 'theme/missav/';
    $assets_dir = 'assets/theme/missav/';
    ?>
    <div id="movie-details" class="flex md:pt-6">
        <?php if ($this->common_model->get_ads_status('player_top') == '1'): ?>
            <!-- player top to ads -->
            <div class="w-full text-center mb-5">
                <?php echo $this->common_model->get_ads('player_top'); ?>
            </div>
            <!-- player top to ads -->
        <?php endif; ?>
        <div class="flex-1">
            <?php
            if ($watch_videos->is_tvseries == '1'):
                $this->load->view($theme_dir . 'tvseries_player');
            else:
                $this->load->view($theme_dir . 'movie_player');
            endif;
            ?>
            <?php if ($this->common_model->get_ads_status('player_bottom') == '1'): ?>
                <!-- player bottom to ads -->
                <div class="w-full text-center mb-5">
                    <?php echo $this->common_model->get_ads('player_bottom'); ?>
                </div>
                <!-- player bottom to ads -->
            <?php endif; ?>
            <div class="mt-4">
                <h1 class="text-base lg:text-lg">
                    <?php echo $watch_videos->title; ?>
                </h1>
                <div class="flex flex-wrap justify-center space-x-4 md:space-x-6 py-8 rounded-md shadow-sm">
                    <button
                        class="inline-flex items-center text-sm text-gray-400 font-medium focus:outline-none hover:text-white"
                        onclick="wish_list_add('fav','<?php echo $watch_videos->videos_id; ?>')"><i
                            class="fa-solid fa-heart mr-2"></i> Favorite</button>
                    <button
                        class="inline-flex items-center text-sm text-gray-400 font-medium focus:outline-none hover:text-white"
                        onclick="wish_list_add('wl','<?php echo $watch_videos->videos_id; ?>')"><i
                            class="fa-solid fa-clock mr-2"></i> Save</button>
                    <?php if ($this->db->get_where('config', array('title' => 'social_share_enable'))->row()->value == '0'): ?>
                        <div class="addthis_inline_share_toolbox_yl99 m-t-30 m-b-10"
                            data-url="<?php echo base_url() . 'watch/' . $watch_videos->slug . '.html'; ?>"
                            data-title="Watch & Download <?php echo $watch_videos->title; ?>"></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="sm:mx-0 mb-8 rounded-0 sm:rounded-lg">
                <div class="mb-4 border-b border-gray-700">
                    <nav class="-mb-px flex space-x-2 sm:space-x-3" aria-label="Tabs">
                        <a class="group inline-flex items-center whitespace-nowrap pb-4 px-2 border-b-2 font-medium text-sm border-pink-500 text-pink-600" aria-current="page">
                            <i class="fa-solid fa-video mr-2"></i>
                            <span><?php echo trans('details'); ?></span>
                        </a>
                    </nav>
                </div>
                <div>
                    <p class="mb-3"><?php echo $watch_videos->description;?></p>
                    <div class="space-y-2">
                        <div>
                            <span><?php echo trans('release'); ?>:</span>
                            <span class="text-amber-300"><?php echo $watch_videos->release;?></span>
                        </div>
                        <div>
                            <span><?php echo trans('code'); ?>:</span>
                            <span class="text-amber-300 uppercase"><?php echo $watch_videos->writer;?></span>
                        </div>
                        <div>
                            <span><?php echo trans('genre'); ?>:</span>
                            <?php if($watch_videos->genre !='' && $watch_videos->genre !=NULL):
                                $i = 0;
                                $genres =explode(',', $watch_videos->genre);                                                
                                foreach ($genres as $genre_id):
                                if($i>0){ echo ',';} $i++;
                            ?>
                                <a class="text-amber-300" href="<?php echo $this->genre_model->get_genre_url_by_id($genre_id);?>"><?php echo $this->genre_model->get_genre_name_by_id($genre_id);?></a>
                            <?php endforeach; endif;?>                            
                        </div>
                        <div>
                            <span><?php echo trans('actor'); ?>:</span>
                            <?php if($watch_videos->stars !='' && $watch_videos->stars !=NULL):
                                $i = 0;
                                $stars =explode(',', $watch_videos->stars);                                                
                                foreach ($stars as $star_id):
                                if($i>0){ echo ',';} $i++;
                            ?>
                                <a class="text-amber-300" href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>"><?php echo $this->common_model->get_star_name_by_id($star_id);?></a>
                            <?php endforeach; endif;?>
                        </div>
                        <div>
                            <span><?php echo trans('director'); ?>:</span>
                            <?php if($watch_videos->director !='' && $watch_videos->director !=NULL):
                                $i = 0;
                                $stars =explode(',', $watch_videos->director);                                                
                                foreach ($stars as $star_id):
                                if($i>0){ echo ',';} $i++;
                            ?>
                                <a class="text-amber-300" href="<?php echo base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id);?>"><?php echo $this->common_model->get_star_name_by_id($star_id);?></a>
                            <?php endforeach; endif;?>
                        </div>
                        <div>
                            <span><?php echo trans('country'); ?>:</span>
                            <?php if($watch_videos->country !='' && $watch_videos->country !=NULL):
                                $i = 0;
                                $countries =explode(',', $watch_videos->country);                                                
                                foreach ($countries as $country_id):
                                if($i>0){ echo ',';} $i++;
                            ?>
                                <a class="text-amber-300" href="<?php echo $this->country_model->get_country_url_by_id($country_id);?>"><?php echo $this->country_model->get_country_name_by_id($country_id);?></a>
                            <?php endforeach; endif;?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view($theme_dir.'related_movies'); ?>
        </div>
        <div class="hidden lg:flex lg:flex-col h-full ml-6 w-[300px]">
            <?php if ($this->common_model->get_ads_status('sidebar') == '1'): ?>
                <!-- sidebar ads -->
                <div class="mb-5 w-[300px] h-[250px]">
                    <?php echo $this->common_model->get_ads('sidebar'); ?>
                </div>
                <!-- End sidebar ads -->
            <?php endif; ?>

            <h4 class="mb-5 text-lg"><?php echo trans('top_view_today'); ?></h4>
            <?php $hot_videos = $this->common_model->get_today_hot_videos(); ?>
            <?php foreach ($hot_videos as $videos) :?>
            <div class="mb-6 flex">
                <div class="relative aspect-video rounded overflow-hidden shadow-lg w-[165px]">
                    <a href="<?php echo base_url('watch/' . $videos['slug']) . '.html'; ?>" alt="<?php echo $videos['title']; ?>">
                        <img class="w-full h-auto aspect-video" alt="<?php echo $videos['title']; ?>"
                            src="<?php echo $this->common_model->get_video_poster_url($videos['videos_id']); ?>">
                    </a>
                    <a href="<?php echo base_url('watch/' . $videos['slug']) . '.html'; ?>" alt="<?php echo $videos['title']; ?>">
                        <span class="absolute bottom-1 right-1 rounded-lg px-2 py-1 text-xs text-nord5 bg-gray-800 bg-opacity-75"><?php echo $videos['runtime']; ?></span>
                    </a>
                </div>
                <div class="text-xs text-gray-300 w-[119px] ml-2 text-ellipsis">
                    <a class="line-clamp-4" href="<?php echo base_url('watch/' . $videos['slug']) . '.html'; ?>">
                        <?php echo $videos['title']; ?>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

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
                    beforeSend: function () { },
                    success: function (response) {
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
            $('.rate_now').click(function () {
                rate = $(this).val();
                video_id = "<?php echo $watch_videos->videos_id; ?>";
                current_rating = "<?php echo $watch_videos->total_rating; ?>";
                total_rating = Number(current_rating) + Number(1);
                if (parseInt(rate) && parseInt(video_id)) {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo base_url() . 'admin/rating'; ?>",
                        data: "rate=" + rate + "&video_id=" + video_id,
                        dataType: 'json',
                        success: function (response) {
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