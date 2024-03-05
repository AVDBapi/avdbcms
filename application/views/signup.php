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
        <form class="login-form" id="signup_form">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN UP</h3>
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
            <label class="control-label">USERNAME</label>
            <input class="form-control" type="text" id="username" placeholder="Username" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">EMAIL</label>
            <input class="form-control" type="email" id="email" placeholder="Password">
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" id="password" placeholder="Password">
          </div>
          <div id="error"></div>
          <div class="form-group">
            <div class="utility">
              <p class="semibold-text mb-0"><a href="<?php echo base_url('login'); ?>">Already Have an Account ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" id="btn-login">SIGN UP <i class="fa fa-sign-in"></i></button>
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
<script>
    $(document).ready(function() {
        $("#signup_form").submit(function(e) {
            e.preventDefault();
            username = $("#username").val();
            email = $("#email").val();
            password = $("#password").val();
            $.ajax({
                type: 'POST',
                url: 'http://localhost/ovoo/login/ajax_signup',
                data: "username=" + username + "&password=" + password + "&email=" + email,
                dataType: 'json',
                beforeSend: function() {
                    $("#error").fadeOut();
                    $("#btn-login").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp; Processing!! &nbsp;Wait...');
                },
                success: function(response) {
                    var signup_status = response.signup_status;
                    var redirect = response.redirect_url;
                    toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": true,
                            "positionClass": "toast-bottom-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                    if (signup_status == "success") {                      
                        Command: toastr["success"]("Signup Success..", "Success");                        
                        setTimeout(' window.location.href = "' + redirect + '"; ', 2000);
                    }
                    else if (signup_status == "user_exist") {                      
                        Command: toastr["error"]("User Name or Email Already Exist..", "Opps");
                        $("#btn-login").html('<i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; SIGN UP');
                    }
                    else if (signup_status == "empty_input") {                      
                        Command: toastr["error"]("Please Enter Email & Username Properly", "Opps");
                        $("#btn-login").html('<i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; SIGN UP');
                    }
                    else {
                        $("#error").fadeIn(1000, function() {
                          Command: toastr["error"]("Signup Fail.Please Contact With System Administrator..", "Opps")
                          $("#btn-login").html('<i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; SIGN UP');
                        });
                    }
                }
            });
            return false;

        });
    });

</script>


</html>