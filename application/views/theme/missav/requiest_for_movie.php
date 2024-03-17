<?php    
    $business_address              =   $this->db->get_where('config' , array('title'=>'business_address'))->row()->value;
    $business_phone        =   $this->db->get_where('config' , array('title'=>'business_phone'))->row()->value;
    $contact_email                =   $this->db->get_where('config' , array('title'=>'contact_email'))->row()->value;
    $business_phone         =   $this->db->get_where('config' , array('title'=>'business_phone'))->row()->value;
    $site_name             =   $this->db->get_where('config' , array('title'=>'site_name'))->row()->value;
    $site_url             =   $this->db->get_where('config' , array('title'=>'site_url'))->row()->value;
?>
<!-- Main Section -->
<div id="section-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h2 class="block-title text-center"><?php echo trans('send_a_request'); ?><br>
                    <small><?php echo trans('movie_not_avilable?_send_us_a_note_using_the_form_below.'); ?></small>
                </h2>

                <div class="sendus">
                    <div class="movie-heading m-b-20"> <span><?php echo trans('send_us_request'); ?></span>
                        <div class="disable-bottom-line"></div>
                    </div>
                    <div id="contact-form">
                        <div class="expMessage"></div>
                        <form class="custom-form" id="request-form" method="post" action="<?php echo base_url('send_movie_requiest'); ?>">
                            <input type="text" name="name" id="name" value="<?php if($this->session->userdata('name')) { echo $this->session->userdata('name');} ?>" class="form-control half-wdth-field" placeholder="Your Name" >
                            <div id="name_error"></div>
                            <input type="text" name="email" id="email" value="<?php if($this->session->userdata('email')) { echo $this->session->userdata('email');} ?>" class="form-control half-wdth-field pull-right" placeholder="Your Email" >
                            <div id="email_error"></div>
                            <input type="text" name="movie_name" id="movie_name" class="form-control half-wdth-field pull-right" placeholder="Movie Name" >
                            <div id="movie_name_error"></div>
                            <textarea name="message" id="message" class="form-control" rows="4" placeholder="Message"></textarea>
                            <div id="message_error"></div>
                            <input type="hidden" name="action" value="submitform">
                            <div>
                                <button type="submit" value="submit" id="submit-btn" class="btn btn-success"> <span class="btn-label"><i class="fi ion-paper-airplane"></i></span><?php echo trans('send_message'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <address class="m-l-50">
                    <h2 class="block-title text-center"><?php echo trans('or_contact_us'); ?><br>
                        <small><?php echo trans('our_business_address_is_below.'); ?></small>
                    </h2>
                    <p><strong><?php echo trans('address'); ?>:&nbsp;</strong><?php echo $business_address; ?></p>
                    <p><strong><?php echo trans('email'); ?>:&nbsp;</strong><a href="mailto:<?php echo $contact_email; ?>"><?php echo $contact_email; ?></a></p>
                    <p><strong><?php echo trans('phone'); ?>:&nbsp;</strong><?php echo $business_phone; ?></p>
                    <p><strong><?php echo trans('web'); ?>:&nbsp;</strong><a href="<?php echo $site_url; ?>"><?php echo $site_url; ?></a></p>
                </address>
            </div>
        </div>
    </div>
</div>
<!-- End Main Section -->

<!-- ajax contact form -->
<!-- <script src="<?php echo base_url(); ?>assets/front_end/js/jquery-1.12.3.min.js"></script>
<script>
    $(document).ready(function() {
        $("#request-form").submit(function(e) {
            e.preventDefault();
            //reset error message
            $("#name_error").fadeOut();
            $("#email_error").fadeOut();
            $("#movie_name_error").fadeOut();
            $("#message_error").fadeOut();
            var name = $("#name").val();
            var email = $("#email").val();
            var movie_name = $("#movie_name").val();
            var message = $("#message").val();
            var hasError = false;
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if (name == '') {
                var hasError = true;                
                $("#name_error").html('<p class="text-danger"><strong>Opps!&nbsp;</strong>Name must not be blank.</p>');
                $("#name_error").fadeIn();
            }

            if (email == '') {
                var hasError = true;                
                $("#email_error").html('<p class="text-danger"><strong>Opps!&nbsp;</strong>Email must not be blank.</p>');
                $("#email_error").fadeIn();
            } else if (!emailReg.test(email)) {
                var hasError = true;                
                $("#email_error").html('<p class="text-danger">Enter a valid email address.</p>');
                $("#email_error").fadeIn();
            }
            if (movie_name == '') {
                var hasError = true;
                $("#movie_name_error").fadeIn();
                $("#movie_name_error").html('<p class="text-danger"><strong>Opps!&nbsp;</strong>Movie name must not be blank.</p>');
            }
            if (message == '') {
                var hasError = true;
                $("#message_error").fadeIn();
                $("#message_error").html('<p class="text-danger"><strong>Opps!&nbsp;</strong>Name must not be blank.</p>');
            }

            if (hasError != true) {
                $.ajax({                    
                    type: 'POST',
                    url: '<?php echo base_url(); ?>send_movie_requiest2',
                    data: {"name" : name,"email" : email,"movie_name":movie_name,"message" : message},
                    dataType: 'json',
                    beforeSend: function() {
                        $("#error").fadeOut();
                        $("#submit-btn").html('<span class="btn-label"><i class="fi ion-load-a"></i></span>Sending..!');

                    },
                    success: function(response) {
                        var status = response.status;
                        if (status == "success") {
                            $("#name_error").fadeOut();
                            $("#email_error").fadeOut();
                            $("#message_error").fadeIn();
                            $("#submit-btn").html('<span class="btn-label"><i class="fi ion-paper-airplane"></i></span>Send Message ');
                            $("#message_error").html('<p class="text-success"><strong>Well done!</strong> Message send successful.</p>');
                        } else {
                            $("#message_error").fadeIn();
                            $("#subscribe-btn").html('Subscribe');
                            $("#error").html('<p class="text-danger"><strong>Opps!</strong> Subscription fail please contact with system administrator.</p>');
                        }
                    }
                });
            }
        });
    });
</script> -->
<!-- End ajax contact form -->