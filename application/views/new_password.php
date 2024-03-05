<?php    
    $system_name              =   $this->db->get_where('config' , array('title'=>'system_name'))->row()->value;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">
    <!-- CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
     <!-- toast notification  Start-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.css">
      <script src="<?php echo base_url(); ?><?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>
  <script src="<?php echo base_url(); ?><?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?><?php echo base_url(); ?>assets/js/validation.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?><?php echo base_url(); ?>assets/js/login-form.js"></script>
    <title><?php echo $system_name; ?> - Login</title>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries-->
    <!--if lt IE 9
    script(src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')
    script(src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js')
    -->
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
      <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="Ovoo" height="40">        
      </div>
      <div class="login-box">
        <form class="login-form" method="post" action="<?php echo base_url().'login/complete_reset/save' ?>">
        <input type="hidden" name="token" value="<?php if(isset($token)){ echo $token;} ?>">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>SAVE NEW PASSWORD</h3>
          <!-- error/success message -->
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
          <!-- error/success message End-->

          <div class="form-group">
            <label class="control-label">NEW PASSWORD</label>
            <input class="form-control" type="text" name="password" id="password" placeholder="New Password" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">CONFIRM NEW PASSWORD</label>
            <input class="form-control" type="text" name="password2" id="password2" placeholder="Confirn New Password">
          </div>
          <div id="error"></div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" id="btn-login">Save <i class="fa fa-floppy-o"></i></button>
          </div>
        </form>
      </div>
    </section>
  </body>
  <script src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/plugins/pace.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
<!-- toast notification  Start-->
<script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>

<!-- toast notification  End-->
</html>