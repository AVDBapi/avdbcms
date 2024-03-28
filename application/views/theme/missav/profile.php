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
            <div class="flex flex-col lg:flex-row items-center">
                <div class="rounded-full w-36 h-36">
                    <img class="rounded-full aspect-square" src="<?php echo $this->common_model->get_img('user', $profile_info->user_id).'?'.time(); ?>" title="<?php echo $profile_info->name; ?>" alt="<?php echo $profile_info->name; ?>">
                </div>
                <div class="uct-info col-md-9">
                    <div class="block">
                        <label class="text-gray-300"><?php echo trans('full_name'); ?>:</label> <?php echo $profile_info->name; ?></div>
                    <div class="block">
                        <label class="text-gray-300"><?php echo trans('email'); ?>:</label> <?php echo $profile_info->email; ?> </div>
                    <div class="block">
                        <label class="text-gray-300"><?php echo trans('gender'); ?>:</label> <?php if($profile_info->gender=='1'){echo trans('male');}elseif($profile_info->gender=='2'){echo trans('female');}else{ echo 'N/a';} ?> </div>
                    <div class="block">
                        <label class="text-gray-300"><?php echo trans('join_date'); ?>e:</label> <?php echo date('d M Y',strtotime($profile_info->join_date)); ?></div>
                    <div class="block">
                        <label class="text-gray-300"><?php echo trans('last_login'); ?>:</label> <?php echo date('Y-m-d H:i:s',strtotime($profile_info->last_login)); ?> </div>
                    <div class="mt-5">
                        <a class="py-1 px-3 rounded bg-rose-600 text-white" href="<?php echo base_url('my-account/update'); ?>" title=""><?php echo trans('edit_account_info'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Profile Section -->
</section>
