
<!-- Main Section -->
<div id="section-opt">
    <div class="container">
        <div class="row">
        <div class="col-md-3 col-xs-12"></div>
            <div class="col-md-6 col-xs-12">
                <h2 class="block-title text-center"><?php echo trans('enter_new_password'); ?><br>
                    <small><?php echo trans('enter_new_password_to_change_password.'); ?></small>
                </h2>
                <div class="sendus">
                    <div class="movie-heading m-b-20"> <span><?php echo trans('enter_password'); ?></span>
                        <div class="disable-bottom-line"></div>
                    </div>
                    <?php if($this->session->flashdata('reset_success') !=''):?>
                        <div class="alert alert-success">
                           <?php echo $this->session->flashdata('reset_success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('reset_error') !=''):?>
                        <div class="alert alert-danger">
                          <?php echo $this->session->flashdata('reset_error'); ?>
                        </div>
                    <?php endif; ?>
                    <div id="contact-form">                        
                        <form class="custom-form" id="recovery-form" method="post" action="<?php echo base_url().'user/complete_reset/save'; ?>">
                            <input type="hidden" name="token" value="<?php if(isset($token)){ echo $token;} ?>">
                            <input type="password" name="password" id="password" data-parsley-type="text" class="form-control half-wdth-field" placeholder="Enter password" required>
                            <input type="password" name="password2" id="password2" data-parsley-equalto="#password" class="form-control half-wdth-field" placeholder="Confirm password" required>                              
                            <p> <?php echo trans('back_to'); ?> <a href="<?php echo base_url().'user/login'; ?>"><?php echo trans('login'); ?></a></p>
                            <div>
                                <button type="submit" value="submit" id="submit-btn" class="btn btn-success pull-right"> <span class="btn-label"><i class="fi ion-ios-unlocked-outline"></i></span><?php echo trans('recover'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-xs-12"></div>
        </div>
    </div>
</div>
<!-- End Main Section -->

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('#recovery-form').parsley();
    });
</script>
<style>
    .parsley-required, .parsley-type{
        color:red;
        list-style:none;
        margin-left:-30px;
    }
</style> 




