<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <title>Login | ovoo</title>

        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />


        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.3-jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/validation.min.js"></script>


        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="assets/js/modernizr.min.js"></script>

<style type="text/css">
  .navbar-default {
  background-color: #16163F;
  border-bottom: solid 5px #16163F;
}

.btn-success,
.btn-success:hover,
.btn-success:focus,
.btn-success:active,
.btn-success.active,
.btn-success.focus,
.btn-success:active,
.btn-success:focus,
.btn-success:hover,
.open > .dropdown-toggle.btn-success {
  background-color: #16163F !important;
  border: 1px solid #16163F !important;
}

.btn-success{
  color:#fff;
  background-color:#16163F;
  border-color:#16163F;
}

.btn-custom.btn-success {
  color: #fff !important;
}

.bg-custom {
  background-color: #16163F !important;
}

#sidebar-menu > ul > li > a.active {
  background: #666E76 !important;
  border-left: 3px solid #16163F;
  color: #16163F !important;
}

.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus {
  background-color: #16163F;
  border-color: #16163F;
}

.widget-bg-color-icon .bg-icon-success {
  background-color: rgba(129, 200, 104, 0.2);
  border: 1px solid #16163F;
}

.text-success {
  color: #16163F;
}

.label-success {
  background-color: #16163F;
}


.panel-border.panel-success .panel-heading {
  /*border-color: #fff !important;*/
  color: #16163F !important;
}

.widget-bg-color-icon .bg-icon-danger {
  background-color: rgba(8, 38, 72, 0.1);
  border: 1px solid #16163F;
}

.panel-success > .panel-heading {
  /*background-color: #16163F;*/
}
.close{
  color: #fff;
}
.panel-primary>.panel-heading{color:#fff;background-color:#16163F;border-color:#16163F}

</style>
        
    </head>
    <body>
        <script type="text/javascript">
            var baseurl=<?php echo base_url();?>
        </script>

        <div class="animationload">
            <div class="loader"></div>
        </div>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class=" card-box">
            <div class="panel-heading"> 
                <div class="text-center">
                        <a href="<?php echo base_url(); ?>" class="logo">
                            <img src="<?php echo base_url(); ?>assets/images/logo-mini.png"  style="margin-top:25px;" class="icon-magnet icon-c-logo" alt="logo"> 
                            <span><img src="<?php echo base_url(); ?>uploads/system_logo/logo.png<?php echo '?'.time(); ?>"  class="md md-album" alt="ovoo">
                            </span>
                        </a>
                </div><br>
                <h3 class="text-center"> <strong class="text-success">Recover Your Password</strong></h3>
                <hr>

            </div>
            <?php if($this->session->flashdata('success') !='') : ?>
            <div class="alert alert-success alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                ×
              </button>
              <?php echo $this->session->flashdata('success'); ?>
            </div>
          <?php endif; ?>
          <?php if($this->session->flashdata('error') !='') : ?>
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                ×
              </button>
              <?php echo $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

		                                   
            <div class="panel-body">
                <div id="error"></div>
            <form  id="signup_form"  method="post" action="<?php echo base_url().'user/forget_password/do_reset' ?>" class="form-horizontal m-t-20" role="form">
                
                <div class="form-group ">
                    <div class="col-xs-12">                        
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" id="email" name="email" value="<?php if(isset($email)){ echo $email;} ?>" class="form-control" placeholder="email" required>
                        </div>
                    </div>
                </div>

                
                
                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button id="btn-login" class="btn btn-success btn-block text-uppercase waves-effect waves-light" type="submit"><i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; <?php echo tr_wd('recover_now') ?></button>
                    </div>
                </div>
            </form> 
            
            </div>
            <div class="row">
        <div class="col-sm-12 text-center">
          <p>
            <?php echo tr_wd('already_have_account?') ?> <a href="<?php echo base_url().'login'; ?>" class="text-primary m-l-5"><b><?php echo tr_wd('signin') ?></b></a>
          </p>
        </div>
      </div>

            </div>                            
          </div>
        
        

        
    	<script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <!-- <script src="assets/js/jquery.min.js"></script> -->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/detect.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/fastclick.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/wow.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.nicescroll.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>


        <script src="<?php echo base_url(); ?>assets/js/jquery.core.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/jquery.app.js"></script>	


        <script src="<?php echo base_url(); ?>assets/plugins/notifyjs/dist/notify.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/notifications/notify-metro.js"></script>

        <script type="text/javascript">
          $('documet').ready(function(){
            $("#signup_form").validate({
              rules:
                {
                password: {
                          required: true,
                          },
                username: {
                          required: true            
                          },
                email: {
                          required: true            
                          },
                },
                messages:
                {
                email:{
                      required: "please enter  email"
                     },
                     password:{
                      required: "please enter  password"
                     },
                    username: "please enter your username",
                      },     
                    });
                  })
        </script>


	
	</body>
</html>