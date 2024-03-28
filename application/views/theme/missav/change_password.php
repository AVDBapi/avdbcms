<section>
    <?php
    $success_msg = $this->session->flashdata('success');
    $error_msg = $this->session->flashdata('error');
    ?>
    <!-- Profile Section -->
    <div class="grid grid-cols-1 lg:grid-cols-6 gap-4">
        <div class="lg:col-span-2 uppercase">
            <h4 class="py-2 bg-slate-900 px-4 border-b border-gray-500">
                <?php echo trans("menu"); ?>
            </h4>
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
            <p class="text-base lg:text-xl font-bold mb-2 lg:mb-5">
                <?php echo trans('my_wish_list'); ?>
            </p>
            <form id="profile-form" action="<?php echo base_url() . 'user/change_password/update'; ?>" method="POST"
                class="form-horizontal" enctype="multipart/form-data">
                <?php
                if ($success_msg != '') {
                    echo '<div class="alert alert-success">' . $success_msg . '.</div>';
                }
                if ($error_msg != '') {
                    echo '<div class="alert alert-danger">' . $error_msg . '.</div>';
                }
                ?>

                <div class="block lg:flex mb-3 md:mb-5">
                    <label for="password" class="mb-2 md:mb-0 uppercase w-2/5">
                        <?php echo trans('old_password'); ?>
                    </label>

                    <div class="col-sm-8">
                        <input name="password" type="password" class="outline-none ring-0 border-none px-2 py-1 text-gray-700" id="full_name" value=""
                            placeholder="Enter Old Password" required>

                        <span id="error-full_name" class="help-block error-block"></span>
                    </div>
                </div>
                <div class="block lg:flex mb-3 md:mb-5">
                    <label for="new_password" class="mb-2 md:mb-0 uppercase w-2/5">
                        <?php echo trans('new_password'); ?>
                    </label>

                    <div class="col-sm-8">
                        <input name="new_password" type="password" class="outline-none ring-0 border-none px-2 py-1 text-gray-700" id="full_name" value=""
                            placeholder="Enter New Password" required>

                        <span id="error-full_name" class="help-block error-block"></span>
                    </div>
                </div>
                <div class="block lg:flex mb-3 md:mb-5">
                    <label for="retype_new_password" class="mb-2 md:mb-0 uppercase w-2/5">
                        <?php echo trans('new_password_again'); ?>
                    </label>

                    <div class="col-sm-8">
                        <input name="retype_new_password" type="password" class="outline-none ring-0 border-none px-2 py-1 text-gray-700" id="full_name" value=""
                            placeholder="Enter New Password" required>

                        <span id="error-full_name" class="help-block error-block"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="username" class="mb-2 md:mb-0 uppercase w-2/5"></label>

                    <div class="col-sm-2">
                        <button type="submit" value="submit" class="px-3 py-1 bg-rose-500 text-white hover:bg-rose-600 rounded">
                            <?php echo trans('save_changes'); ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>