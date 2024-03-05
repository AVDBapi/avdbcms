<?php    
    $business_address               =   $this->db->get_where('config' , array('title'=>'business_address'))->row()->value;
    $business_phone                 =   $this->db->get_where('config' , array('title'=>'business_phone'))->row()->value;
    $contact_email                  =   $this->db->get_where('config' , array('title'=>'contact_email'))->row()->value;
    $business_phone                 =   $this->db->get_where('config' , array('title'=>'business_phone'))->row()->value;
    $site_name                      =   $this->db->get_where('config' , array('title'=>'site_name'))->row()->value;
    $site_url                       =   $this->db->get_where('config' , array('title'=>'site_url'))->row()->value;
    $map_api                        =   $this->db->get_where('config' , array('title'=>'map_api'))->row()->value;
    $map_lat                        =   $this->db->get_where('config' , array('title'=>'map_lat'))->row()->value;
    $map_lng                         =   $this->db->get_where('config' , array('title'=>'map_lng'))->row()->value;
?>
<!-- Main Section -->
<div id="section-opt">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-xs-12">
                <h2 class="block-title text-center"><?php echo trans('send_a_message'); ?><br>
                    <small><?php echo trans('have_a_query?_send_us_a_note_using_the_form_below.'); ?></small>
                </h2>

                <div class="sendus">
                    <div class="movie-heading m-b-20"> <span><?php echo trans('send_us_message'); ?></span>
                        <div class="disable-bottom-line"></div>
                    </div>
                    <?php if($this->session->flashdata('success') !=''):?>
                        <div class="alert alert-success">
                           <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if($this->session->flashdata('error') !=''):?>
                        <div class="alert alert-danger">
                          <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>
                    <div id="contact-form">
                        <div class="expMessage"></div>
                        <form class="custom-form" id="" method="post" action="<?php echo base_url().'contact_process'; ?>">
                            <input type="text" name="name" id="name" class="form-control half-wdth-field" placeholder="Name" >
                            <div id="name_error"></div>
                            <input type="text" name="email" id="email" class="form-control half-wdth-field pull-right" placeholder="Email" >
                            <div id="email_error"></div>
                            <textarea name="message" id="message" class="form-control" rows="4" placeholder="Message"></textarea>
                            <div id="message_error"></div>
                            <input type="hidden" name="action" value="submitform">
                            <div>
                                <button type="submit" value="submit" id="submit-btn" class="btn btn-success"> <span class="btn-label"><i class="fi ion-paper-airplane"></i></span><?php echo trans('send'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xs-12">
                <address class="m-l-50 text-center">
                    <h2 class="block-title "><?php echo trans('our_location'); ?><br>
                        <small><?php echo trans('our_business_address_is_below.'); ?></small>
                    </h2>
                    <div id="map" style="height:250px;background:white" class="m-b-20"></div>
                    <script>
                        function myMap() {
                            var mapOptions = {
                                center: new google.maps.LatLng(<?php echo $map_lat; ?>, <?php echo $map_lng; ?>),
                                zoom: 15,
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            }
                            var map = new google.maps.Map(document.getElementById("map"), mapOptions);
                        }
                    </script>
                    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $map_api ?>&callback=myMap"></script>

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




