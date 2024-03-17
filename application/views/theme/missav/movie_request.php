<?php 
  $movie_request_enable                  =   $this->db->get_where('config' , array('title' =>'movie_request_enable'))->row()->value;
  if($movie_request_enable == '1'):
    $recaptcha_enable                   =   $this->db->get_where('config' , array('title' =>'recaptcha_enable'))->row()->value;
    $requiest_success_message             = $this->session->flashdata('requiest_success');
    $requiest_error_message               = $this->session->flashdata('requiest_error');

 ?>
<!-- movie requiest modal  -->
  <div id="movieRequest" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content p-0 b-0">
        <div class="panel report-panel panel-color panel-primary">
          <div class="panel-heading">
            <button type="button" class="close m-t-5" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 class="panel-title text-light"><?php echo trans('movie_request'); ?></h3>
          </div>
          <div class="modal-body">
            <?php if($requiest_success_message !=''): ?>
              <div class="alert alert-dsuccess"><?php echo $requiest_success_message; ?></div>
              <script>
                $(document).ready(function() {
                  $('#movieRequest').modal('show');
                });
              </script>
            <?php endif; ?>

            <?php if($requiest_error_message !=''): ?>
              <div class="alert alert-danger"><?php echo $requiest_error_message; ?></div>
              <script>
                $(document).ready(function() {
                  $('#movieRequest').modal('show');
                });
              </script>
            <?php endif; ?>
            <?php echo form_open(base_url('send_movie_request') , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data', 'id' =>'report_form'));?>
              
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo trans('name'); ?></label>
                <div class="col-sm-9">
                  <input name="name" type="text" class="form-control" rows="4" placeholder="Your Name" value="<?php if($this->session->userdata('name')) { echo $this->session->userdata('name');} ?>"  required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo trans('email'); ?></label>
                <div class="col-sm-9">
                  <input name="email" type="email" class="form-control" rows="4" placeholder="Your Email" value="<?php if($this->session->userdata('email')) { echo $this->session->userdata('email');} ?>"  required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo trans('movie_name'); ?></label>
                <div class="col-sm-9">
                  <input name="movie_name" type="text" class="form-control" rows="4" placeholder="Movie Name"  required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo trans('message'); ?></label>
                <div class="col-sm-9">
                  <textarea name="message" id="message" class="form-control" rows="4" placeholder="Write your message here" ></textarea>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-9">
                  <?php if($recaptcha_enable == '1'): echo $this->recaptcha->create_box(); endif;?>
                </div>
              </div>
              <div id="response"></div>
          </div>
          <div class="modal-footer">
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9 m-t-15">
                <button type="submit" id="submit_btn" class="btn btn-sm btn-success waves-effect"><span class="btn-label"><i class="fa fa-paper-plane"></i></span><?php echo trans('send'); ?> </button>
                <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans('close'); ?> </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END movie requiest modal -->
</form>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script>
  jQuery(document).ready(function() {
    $('form').parsley();
  });
</script>
<?php endif; ?>