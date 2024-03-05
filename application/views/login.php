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
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
     <!-- toast notification  Start-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.css">
      <script src="assets/js/jquery-2.1.4.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/validation.min.js"></script>
    <script type="text/javascript" src="assets/js/login-form.js"></script>
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
        <form class="login-form" id="login_form">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
          
          <div class="row">
            <?php if($this->db->get_where('config' , array('title' =>'google_login_enable'))->row()->value =='1'): ?>
            <div class="col-sm-6">
              <div class="form-group">
                <a class="btn btn-gplus" href="<?php echo $login_url; ?>"><i class="fa fa-google-plus left"></i> Google Login</a>
              </div>
            </div>
          <?php endif; ?>
          <?php if($this->db->get_where('config' , array('title' =>'facebook_login_enable'))->row()->value =='1'): ?>
            <div class="col-sm-6">
              <div class="form-group">
                <a class="btn btn-fb" href="<?php echo $facebook_login_url; ?>" ><i class="fa fa-facebook left"></i> Facebook Login</a>
              </div>
            </div>
          </div>
          <?php endif; ?>

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
            <label class="control-label">PASSWORD</label>
            <input class="form-control" type="password" id="password" placeholder="Password">
          </div>
          <div id="error"></div>
          

          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label class="semibold-text">
                <p class="semibold-text mb-0"><a href="<?php echo base_url('user/signup'); ?>">Signup</a></p>
                </label>
              </div>
              <p class="semibold-text mb-0"><a data-toggle="flip">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block" id="btn-login">SIGN IN <i class="fa fa-sign-in fa-lg"></i></button>
          </div>
        </form>
        <form class="forget-form" method="post" action="<?php echo base_url().'user/forget_password/do_reset' ?>">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
          <div class="form-group">
            <label class="control-label">EMAIL</label>
            <input class="form-control" type="text" name="email" value="<?php if(isset($email)){ echo $email;} ?>" placeholder="Email">
          </div>
          <div class="form-group btn-container">
            <button class="btn btn-primary btn-block">RESET<i class="fa fa-unlock fa-lg"></i></button>
          </div>
          <div class="form-group mt-20">
            <p class="semibold-text mb-0"><a data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>
        </form>
      </div>
    </section>
  </body>
  <script src="assets/js/jquery-2.1.4.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/plugins/pace.min.js"></script>
  <script src="assets/js/main.js"></script>
<!-- toast notification  Start-->
<script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>

<!-- toast notification  End-->
<script>
    $(document).ready(function() {
        $("#login_form").submit(function(e) {
            e.preventDefault();
            username = $("#username").val();
            password = $("#password").val();
            $.ajax({
                type: 'POST',
                url: 'login/ajax_login',
                data: "username=" + username + "&password=" + password,
                dataType: 'json',
                beforeSend: function() {
                    $("#error").fadeOut();
                    $("#btn-login").html('<i class="fa fa-exchange" aria-hidden="true"></i> &nbsp; Processing!! &nbsp;Wait...');
                },
                success: function(response) {
                    var login = response.login_status;
                    var redirect = response.redirect_url;
                    if (login == "success") {
                        Command: toastr["success"]("Login Success..", "Success")
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
                      setTimeout(' window.location.href = "' + redirect + '"; ', 2000);
                    }
                    else {
                        $("#error").fadeIn(1000, function() {
                            Command: toastr["warning"]("User Name or Password Worng..", "Opps")
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
                            $("#btn-login").html('<i class="fa fa-sign-in" aria-hidden="true"></i> &nbsp; Sign In');
                        });
                    }
                }
            });
            return false;
        });
    });
</script>
</html>