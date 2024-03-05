    <div class="card">
      <div class="row"> 
        <!-- panel  -->
        <div class="col-md-12">
          <?php echo form_open(base_url() . 'admin/push_notification_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
          <div class="panel panel-border panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo trans('push_notification_setting'); ?></h3>
            </div>
            <div class="panel-body"> 
              <!-- panel  -->
              <div class="form-group row">
                <label class="control-label col-md-3"><?php echo trans('push_notification'); ?></label>
                <div class="col-sm-9">              
                  <div class="animated-checkbox checkbox-inline">
                    <label>
                      <input type="checkbox" name='push_notification_enable' value="1"  <?php if($this->db->get_where('config' , array('title' =>'push_notification_enable'))->row()->value =='1'){echo 'checked';}?>><span class="label-text">Enable</span>
                    </label>
                  </div>
                </div>
              </div>
              
              

              <div class="form-group row">
                <label class=" col-sm-4 control-label"><?php echo trans('onesignal_appid'); ?></label>
                <div class="col-sm-9">
                  <input type="text" name="onesignal_appid" class="form-control" value="<?php echo $this->db->get_where('config' , array('title' =>'onesignal_appid'))->row()->value;?>" required>
                </div>
              </div>

              <div class="form-group row">
                <label class=" col-sm-4 control-label"><?php echo trans('onesignal_api_keys'); ?></label>
                <div class="col-sm-9">
                  <input type="text" name="onesignal_api_keys" class="form-control" value="<?php echo $this->db->get_where('config' , array('title' =>'onesignal_api_keys'))->row()->value;?>" required>
                </div>
              </div>

              <div class="form-group row">
                <label class=" col-sm-4 control-label"><?php echo trans('onesignal_actionmessage'); ?></label>
                <div class="col-sm-9">
                  <input type="text" name="onesignal_actionmessage" class="form-control" value="<?php echo $this->db->get_where('config' , array('title' =>'onesignal_actionmessage'))->row()->value;?>" data-parsley-maxlength="90" required>
                </div>
              </div>              

              <div class="form-group row">
                <label class=" col-sm-4 control-label"><?php echo trans('onesignal_acceptbuttontext'); ?></label>
                <div class="col-sm-9">
                  <input type="text" name="onesignal_acceptbuttontext" class="form-control" value="<?php echo $this->db->get_where('config' , array('title' =>'onesignal_acceptbuttontext'))->row()->value;?>" data-parsley-maxlength="15" required>
                </div>
              </div>

              <div class="form-group row">
                <label class=" col-sm-4 control-label"><?php echo trans('onesignal_cancelbuttontext'); ?></label>
                <div class="col-sm-9">
                  <input type="text" name="onesignal_cancelbuttontext" class="form-control" value="<?php echo $this->db->get_where('config' , array('title' =>'onesignal_cancelbuttontext'))->row()->value;?>" data-parsley-maxlength="15" required>
                </div>
              </div>


              <div class="col-sm-offset-3 col-sm-9 m-t-15">
                <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?> </button>
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




