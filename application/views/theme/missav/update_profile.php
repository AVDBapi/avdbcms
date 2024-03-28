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
            <form id="profile-form" action="<?php echo base_url() . 'user/profile/update'; ?>" method="POST"
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
                    <label for="avatar" class="mb-2 md:mb-0 uppercase w-2/5">
                        <?php echo trans('avatar'); ?>
                    </label>
                    <div>
                        <div class="w-36 h-36 mb-3">
                            <img class="rounded-full w-full h-auto"
                                src="<?php echo $this->common_model->get_img('user', $profile_info->user_id) . '?' . time(); ?>">
                        </div>
                        <input name="photo" type="file" id="avatar">

                        <p class="help-block small">
                            <?php echo trans('accepted_JPG,_PNG._Photo_square,_limit_&lt;_2mb'); ?>
                        </p>
                        <p class="help-block small">
                            <?php echo trans(''); ?>
                        </p>
                        <span id="error-avatar" class="help-block error-block"></span>
                    </div>
                </div>
                <div class="block lg:flex mb-3 md:mb-5">
                    <label for="name" class="mb-2 md:mb-0 uppercase w-2/5">
                        <?php echo trans('full_name'); ?>
                    </label>

                    <div class="col-sm-8">
                        <input name="name" type="text" class="outline-none ring-0 border-none px-2 py-1 text-gray-700"
                            id="full_name" value="<?php echo $profile_info->name; ?>">
                        <span id="error-full_name" class="help-block error-block"></span>
                    </div>
                </div>
                <div class="block lg:flex mb-3 md:mb-5">
                    <label for="email" class="mb-2 md:mb-0 uppercase w-2/5">
                        <?php echo trans('email'); ?>
                    </label>

                    <div class="col-sm-8">
                        <input readonly="" type="email" class="outline-none ring-0 border-none px-2 py-1 text-gray-700"
                            id="email" value="<?php echo $profile_info->email; ?>">
                    </div>
                </div>
                <div class="block lg:flex mb-3 md:mb-5">
                    <label for="name" class="mb-2 md:mb-0 uppercase w-2/5">
                        <?php echo trans('phone'); ?>
                    </label>

                    <div class="col-sm-8">
                        <input name="phone" type="text" class="outline-none ring-0 border-none px-2 py-1 text-gray-700"
                            id="phone" value="<?php echo $profile_info->phone; ?>">

                        <span id="error-phone" class="help-block error-block"></span>
                    </div>
                </div>
                <div class="block lg:flex mb-3 md:mb-5">
                    <label for="name" class="mb-2 md:mb-0 uppercase w-2/5">
                        <?php echo trans('date_of_birth'); ?>
                    </label>

                    <div class="col-sm-8">
                        <input name="dob" type="text" class="outline-none ring-0 border-none px-2 py-1 text-gray-700"
                            id="dob" value="<?php echo date("Y-m-d", strtotime($profile_info->dob)); ?>">

                        <span id="error-dob" class="help-block error-block"></span>
                    </div>
                </div>

                <div class="block lg:flex mb-3 md:mb-5">
                    <label for="gender" class="mb-2 md:mb-0 uppercase w-2/5">
                        <?php echo trans('gender'); ?>
                    </label>

                    <div class="col-sm-3">
                        <select name="gender" class="outline-none ring-0 border-none px-2 py-1 text-gray-700"
                            id="gender">
                            <option value="1" <?php if ($profile_info->gender == '1') {
                                echo 'selected';
                            } ?>>
                                <?php echo trans("male"); ?>
                            </option>
                            <option value="2" <?php if ($profile_info->gender == '2') {
                                echo 'selected';
                            } ?>>
                                <?php echo trans("female"); ?>
                            </option>
                            <option value="0" <?php if ($profile_info->gender == '0') {
                                echo 'selected';
                            } ?>>
                                <?php echo trans("none"); ?>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="block lg:flex mb-3 md:mb-5">
                    <label for="username" class="mb-2 md:mb-0 uppercase"></label>

                    <div class="col-sm-2">
                        <button type="submit" value="submit"
                            class="px-3 py-1 bg-rose-500 text-white hover:bg-rose-600 rounded">
                            <?php echo trans('save_changes'); ?>s
                        </button>
                        <div style="display: none;" id="submit-loading" class="cssload-center">
                            <div class="cssload"><span></span></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Profile Section -->


    <script
        src="<?php echo base_url() ?>assets/theme/missav/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script>
        jQuery(document).ready(function () {
            $('#dob').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
</section>