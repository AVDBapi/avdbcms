<!-- Footer Area -->
<?php    
    $facebook_url               =   ovoo_config('facebook_url');
    $twitter_url                =   ovoo_config('twitter_url');
    $vimeo_url                  =   ovoo_config('vimeo_url');
    $linkedin_url               =   ovoo_config('linkedin_url');
    $youtube_url                =   ovoo_config('youtube_url');
    $footer1_title              =   ovoo_config('footer1_title');
    $footer1_content            =   ovoo_config('footer1_content');
    $footer2_title              =   ovoo_config('footer2_title');
    $footer2_content            =   ovoo_config('footer2_content');
    $footer3_title              =   ovoo_config('footer3_title');
    $footer3_content            =   ovoo_config('footer3_content');
    $footer_text                =   ovoo_config('copyright_text');
    $theme_dir                  =   'theme/default/';
    $assets_dir                 =   'assets/theme/default/';
?>
<div id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <div class="footer-about  " >
                    <div class="movie-heading"> <span><?php echo $footer1_title; ?></span>
                        <div class="disable-bottom-line"></div>
                    </div>
                    <img class="img-responsive" src="<?php echo base_url(); ?>uploads/system_logo/<?php echo ovoo_config('logo'); ?>" alt="Logo">
                    <?php echo $footer1_content; ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="bottom-post " >
                    <div class="movie-heading"> <span><?php echo $footer2_title; ?></span>
                        <div class="disable-bottom-line"></div>
                    </div>
                    <?php echo $footer2_content; ?>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="sendus  ">
                    <div class="movie-heading"> <span><?php echo trans('subscribe'); ?></span>
                        <div class="disable-bottom-line"></div>
                    </div>
                    <div id="contact-form">
                        <div class="expMessage"></div>
                        <p class="text-light"><?php echo trans('subscribe_mail_list_text'); ?></p>
                            <input type="text" name="formInput[name]" id="name" class="form-control half-wdth-field pull-right" placeholder="Your name" required>
                            <input type="email" name="formInput[email]" id="email" class="form-control half-wdth-field pull-right" placeholder="Email" required>
                            <div>
                            <div id="error" style="display: none;"></div>
                                <a class="btn btn-success" id="subscribe-btn"><?php echo trans('subscribe'); ?> </a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer Area -->
<?php $this->load->view($theme_dir.'copyright'); ?>

<!-- ajax subscription -->
<script type="text/javascript">
    $(document).on('click', '#subscribe-btn', function() {
        var email = $("#email").val();
        var name = $("#name").val();
        if(name==''){
            name='New Subscriber';
        }
        var hasError = false;
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (email == '') {
            var hasError = true;
            $("#error").fadeIn();
            $("#error").html('<p class="text-danger"><strong><?php echo trans('opps'); ?>&nbsp;</strong><?php echo trans('email_required') ?></p>');
        } else if (!emailReg.test(email)) {
            var hasError = true;
            $("#error").html('<p class="text-danger"><?php echo trans('valid_email');?></p>');
        }

        if (hasError != true) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>user/subscribe',
                data: "name="+name+"&email="+email,
                dataType: 'json',
                beforeSend: function() {
                    $("#error").fadeOut();
                    $("#subscribe-btn").html('<?php echo trans('subscribing');?>');

                },
                success: function(response) {
                    var subscribe_status = response.subscribe_status;
                    if (subscribe_status == "success") {
                        $("#error").fadeIn();
                        $("#subscribe-btn").html('<i class="fa fa-check" aria-hidden="true"></i> &nbsp;Subscribed');
                        $("#error").html('<p class="text-success"><strong>Well done!</strong> Subscription successful.</p>');
                    }else if (subscribe_status == "exist"){
                        $("#error").fadeIn();
                        $("#subscribe-btn").html('Subscribe');
                        $("#error").html('<p class="text-warning">You already subscribe us earlier.</p>');
                    }else {
                        $("#error").fadeIn();
                        $("#subscribe-btn").html('Subscribe');
                        $("#error").html('<p class="text-warning"><strong>Opps!</strong> Subscription Successfully But Confirmation Email not Send.</p>');
                    }
                }
            });
        }
    });
</script>
<!-- End ajax subscription -->