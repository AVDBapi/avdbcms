<section>
    <!-- Profile Section -->
    <div class="grid grid-cols-1 lg:grid-cols-6 gap-4">
        <div class="lg:col-span-2 uppercase">
            <h4 class="py-2 bg-slate-900 px-4 border-b border-gray-500"><?php echo trans("menu"); ?></h4>
            <ul class="bg-slate-900 px-4 mt-1 text-gray-400">
                <li class="py-2 hover:text-gray-200 hover:ml-2">
                    <a href="<?php echo base_url('my-account/profile'); ?>">
                        <?php echo trans("profile"); ?>
                    </a>
                </li>
                <li class="py-2 hover:text-gray-200 hover:ml-2">
                    <a href="<?php echo base_url('my-account/favorite'); ?>">
                        <?php echo trans("favorite"); ?>
                    </a>
                </li>
                <li class="py-2 hover:text-gray-200 hover:ml-2">
                    <a href="<?php echo base_url('my-account/watch-later'); ?>">
                        <?php echo trans("watch_later"); ?>
                    </a>
                </li>
                <li class="py-2 hover:text-gray-200 hover:ml-2">
                    <a href="<?php echo base_url('my-account/update'); ?>">
                        <?php echo trans("update_profile"); ?>
                    </a>
                </li>
                <li class="py-2 hover:text-gray-200 hover:ml-2">
                    <a href="<?php echo base_url('my-account/change-password'); ?>">
                        <?php echo trans("change_password"); ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="lg:col-span-4">
            <p class="text-base lg:text-xl font-bold mb-2 lg:mb-5"><?php echo trans('my_wish_list'); ?></p>
            <table class="table table-striped">
                <?php 
                    foreach($wl_videos as $favorite_videos):
                    $all_fav_videos = $this->db->get_where('videos', array('videos_id'=>$favorite_videos['videos_id']))->result_array();
                    foreach ($all_fav_videos as $videos) :
                ?>
                    <tr id="row_<?php echo $favorite_videos['wish_list_id'];?>" class="flex flex-col lg:block mb-3">
                        <td valign="top" class="w-40"><a href="<?php echo base_url('watch/'.$videos['slug'].'.html');?>"><img class="aspect-video w-full h-auto rounded-md" src="<?php echo $this->common_model->get_video_thumb_url($videos['videos_id']); ?>"></a></td>
                        <td valign="top">
                            <a class="text-sm hover:text-pink-500 line-clamp-3 text-ellipsis" href="<?php echo base_url('watch/'.$videos['slug'].'.html');?>"><?php echo $videos['title'];?></a>
                        </td>
                        <td class="w-20" valign="top">
                            <a class="text-base text-sky-500 mr-4" href="<?php echo base_url('watch/'.$videos['slug'].'.html');?>"><i class="fa fa-eye"></i></a>
                            <button class="text-base text-red-500" onclick="wish_list_remove('<?php echo $favorite_videos['wish_list_id'];?>')"><i class="fa fa-close"></i></button>                                                
                        </td>
                    </tr>
                <?php endforeach; endforeach; ?>
            </table>
        </div>
    </div>
    <!-- Profile Section -->

    <!--sweet alert2 JS -->
    <!-- ajax add to wish-list -->
    <script type="text/javascript">
        function wish_list_remove(wish_list_id = '') {
            var table_row = '#row_' + wish_list_id;
            var base_url = '<?php echo base_url(); ?>'
            url = base_url + 'user/remove_wish_list/'
            swal({
                title: "Are you confirm to remove?",
                text: "It will remove from your wish-list parmanently!!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3CB371',
                cancelButtonText: "Cancel",
                confirmButtonText: "Delete",
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: 'wish_list_id=' + wish_list_id,
                            dataType: 'json'
                        })
                            .done(function (response) {
                                if (response.status == 'success') {
                                    swal("Success", "Removed successfully!", "success");
                                    $(table_row).fadeOut(2000);
                                } else if (response.status == 'login_error') {
                                    swal('Login Error', "Please login to remove", "error");
                                    $(table_row).fadeOut(2000);
                                } else {
                                    swal('Fail!!', "Unable to remove!", "error");
                                    $(table_row).fadeOut(2000);
                                }

                            })
                            .fail(function () {
                                swal('Oops...', response.message, response.status);
                            });
                    });
                },
                allowOutsideClick: false
            });
        }
    </script>
</section>