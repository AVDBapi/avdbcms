    <div class="card">
      <div class="row"> 
        <!-- panel  -->
        <div class="col-md-12">
          <?php echo form_open(base_url() . 'admin/send_web_notification/send/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
          <div class="panel panel-border panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Send Push Notification</h3>
            </div>
            <div class="panel-body"> 
              <!-- panel  -->              
              <div class="form-group row">
                <label class=" col-sm-4 control-label">Headings</label>
                <div class="col-sm-8">
                  <input type="text" name="headings" class="form-control" value="" required>
                </div>
              </div>
              <div class="form-group row">
                <label class=" col-sm-4 control-label">Message</label>
                <div class="col-sm-8">
                  <textarea type="text" name="message" class="form-control" rows="4" required></textarea>
                </div>
              </div>              

              <div class="form-group row">
                <label class=" col-sm-4 control-label">URL</label>
                <div class="col-sm-8">
                  <input type="text" name="url" class="form-control" value="<?php echo base_url(); ?>" required>
                </div>
              </div>
              <div class="form-group row">
                <label class=" col-sm-4 control-label">Icon URL</label>
                <div class="col-sm-8">
                  <input type="text" name="icon" class="form-control" value="<?php echo base_url('uploads/system_logo/logo.png'); ?>" required>
                </div>
              </div>

              <div class="form-group row">
                <label class=" col-sm-4 control-label">Image URL(Large)</label>
                <div class="col-sm-8">
                  <input type="text" name="img" class="form-control" value="<?php echo base_url('uploads/system_logo/logo.png'); ?>" required>
                </div>
              </div>


              <div class="col-sm-offset-3 col-sm-9 m-t-15">
                <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-paper-plane-o"></i></span>Send Notification</button>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script>




