<?php
$s = 0;
$seasons = $this->common_model->get_seasons_by_videos_id($watch_videos->videos_id);
foreach ($seasons as $season):
    if ($this->common_model->get_num_episodes_by_seasons_id($season['seasons_id']) > 0):
        $episodes = $this->common_model->get_episodes_by_videos_id_and_season_id($watch_videos->videos_id, $season['seasons_id']);
        $s++;
        $i = 0;
        $current_key = '000000';
        if (isset ($_GET['key'])):
            $current_key = $_GET['key'];
        else:
            $current_key = $first_ep_details->stream_key;
        endif;
        ?>

        <div class="pb-6 mt-3 md:mt-5 text-lg capitalize">
            <?php echo $season['seasons_name']; ?>
        </div>
        <div class="flex flex-wrap items-center">
            <?php
            foreach ($episodes as $episode):
                $i++;
                ?>
                <div class="m-1">
                    <a href="<?php echo base_url() . 'watch/' . $watch_videos->slug . '.html?key=' . $episode['stream_key']; ?>"
                        class="px-4 py-2 bg-gray-800 text-gray-400 hover:bg-pink-500 hover:text-white <?php if ($current_key == $episode['stream_key']) { echo 'bg-pink-500 text-white';} ?>">
                        <?php echo $episode['episodes_name']; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>