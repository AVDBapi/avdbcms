<?php
$g_login_enable = $this->db->get_where('config', array('title' => 'google_login_enable'))->row()->value;
$f_login_enable = $this->db->get_where('config', array('title' => 'facebook_login_enable'))->row()->value;
$registration_enable = $this->db->get_where('config', array('title' => 'registration_enable'))->row()->value;
$registration_enable = $this->db->get_where('config', array('title' => 'registration_enable'))->row()->value;
$recaptcha_enable = $this->db->get_where('config', array('title' => 'recaptcha_enable'))->row()->value;
?>
<!-- Main Section -->
<div id="section-opt" style="padding-top: 75px;">
    <div class="container">
        <div class="grid <?php if($registration_enable == '1'){ echo "grid-cols-2";} else { echo "grid-cols-1";} ?> items-center justify-center gap-8">
            <div>
                <h2 class="text-2xl md:text-4xl text-center mb-3">
                    <?php echo trans('login'); ?><br>
                    <small class="text-sm">
                        <?php echo trans('login_text'); ?>
                    </small>
                </h2>
                <div class="sendus">
                    <?php if ($this->session->flashdata('login_success') != ''): ?>
                        <div class="alert alert-success">
                            <?php echo $this->session->flashdata('login_success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('login_error') != ''): ?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('login_error'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($g_login_enable == '1' || $f_login_enable == '1'): ?>
                        <div class="movie-heading m-b-20"> <span>
                                <?php echo trans('connect_with_social_profile'); ?>
                            </span>
                            <div class="disable-bottom-line"></div>
                        </div><br>
                        <?php if ($this->db->get_where('config', array('title' => 'google_login_enable'))->row()->value == '1'): ?>
                            <a class="btn btn-gplus btn-sm" href="<?php echo $login_url; ?>"> <span class="btn-label"><i
                                        class="fa fa-google-plus"></i></span>
                                <?php echo trans('connect_with_google'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if ($this->db->get_where('config', array('title' => 'facebook_login_enable'))->row()->value == '1'): ?>
                            <a class="btn btn-fb btn-sm" href="<?php echo $facebook_login_url; ?>"> <span class="btn-label"><i
                                        class="fa fa-facebook"></i></span>
                                <?php echo trans('connect_with_facebook'); ?>
                            </a>
                        <?php endif; ?>
                        <br><br><br>
                    <?php endif; ?>
                    <div class="mb-8"> <span>
                            <?php echo trans('enter_credential'); ?>
                        </span>
                        <div class="disable-bottom-line"></div>
                    </div>
                    <div id="contact-form">
                        <form class="custom-form text-sm" id="login-form" method="post"
                            action="<?php echo base_url() . 'user/do_login'; ?>">
                            <input type="email" name="email" id="login_email" class="w-full py-3 px-1 outline-none border-none bg-white text-gray-800 rounded mb-3"
                                placeholder="Email" required>
                            <div id="name_error"></div>
                            <input type="password" name="password" id="login_password"
                                class="w-full py-3 px-1 outline-none border-none bg-white text-gray-800 rounded" placeholder="Password" required>
                            <div id="email_error1"></div>
                            <input type="hidden" name="action" value="submitform">
                            <p class="italic my-2"><a href="<?php echo base_url() . 'user/forget_password'; ?>">
                                    <?php echo trans('forget_password?'); ?>
                                </a></p>
                            <?php if ($recaptcha_enable == '1'):
                                echo $this->recaptcha->create_box(); endif; ?>
                            <div>
                                <button type="submit" value="submit" id="submit-btn"
                                    class="px-4 py-2 bg-pink-700 text-white rounded-md mt-5"> <span class="btn-label"><i
                                            class="fi ion-ios-unlocked-outline"></i></span>
                                    <?php echo trans('login'); ?>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
            <?php if ($registration_enable == '1'): ?>
                <div class="">
                    <h2 class="text-2xl md:text-4xl text-center mb-3">
                        <?php echo trans('signup_to_join'); ?><br>
                        <small class="text-sm">
                            <?php echo trans('signup_text'); ?>
                        </small>
                    </h2>

                    <div class="sendus">
                        <div class="movie-heading m-b-20"> <span>
                                <?php echo trans('enter_your_details'); ?>
                            </span>
                            <div class="disable-bottom-line"></div>
                        </div>
                        <?php if ($this->session->flashdata('sign_up_success') != ''): ?>
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('sign_up_success'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($this->session->flashdata('sign_up_error') != ''): ?>
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('sign_up_error'); ?>
                            </div>
                        <?php endif; ?>
                        <div id="contact-form">
                            <div class="expMessage"></div>
                            <form class="custom-form" id="signup-form" method="post"
                                action="<?php echo base_url() . 'user/signup/do_signup'; ?>">
                                <input type="text" name="name" id="name2" class="w-full py-3 px-1 outline-none border-none bg-white text-gray-800 rounded mb-3"
                                    placeholder="Full Name" required>
                                <input type="email" name="email" id="email2" class="w-full py-3 px-1 outline-none border-none bg-white text-gray-800 rounded mb-3"
                                    placeholder="Email" required>
                                <div id="name_error"></div>
                                <input type="password" name="password" id="password"
                                    class="w-full py-3 px-1 outline-none border-none bg-white text-gray-800 rounded pull-right mb-3" placeholder="Password" required>
                                <input type="password" name="password2" id="password2"
                                    class="w-full py-3 px-1 outline-none border-none bg-white text-gray-800 rounded pull-right" placeholder="Confirm Password" required>
                                <div id="email_error"></div>
                                <?php if ($recaptcha_enable == '1'):
                                    echo $this->recaptcha->create_box(); endif; ?>
                                <input type="hidden" name="action" value="submitform">
                                <div>
                                    <button type="submit" value="submit" id="submit-btn2"
                                        class="px-4 py-2 bg-pink-700 text-white rounded-md mt-5"> <span class="btn-label"><i
                                                class="fi ion-ios-unlocked-outline"></i></span>
                                        <?php echo trans('signup'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- End Main Section -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#login-form').parsley();
        $('#signup-form').parsley();
    });
</script>
<style>
    .parsley-required {
        color: red;
        list-style: none;
        margin-left: -30px;
    }
</style>