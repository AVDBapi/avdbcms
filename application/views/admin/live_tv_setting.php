<?php
$live_tv_publish           =   $this->db->get_where('config', array('title' => 'live_tv_publish'))->row()->value;
$live_tv_pin_primary_menu           =   $this->db->get_where('config', array('title' => 'live_tv_pin_primary_menu'))->row()->value;
$live_tv_pin_footer_menu           =   $this->db->get_where('config', array('title' => 'live_tv_pin_footer_menu'))->row()->value;
?>
<?php echo form_open(base_url() . 'admin/live_tv_setting/update/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<div class="card">
  <div class="row">
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('live_tv_setting'); ?></h3>
        </div>
        <div class="panel-body">
          <!-- panel  -->
          <div class="form-group row">
            <label class="control-label col-sm-3"><?php echo trans('primary_menu'); ?></label>
            <div class="toggle">
              <label>
                <input type="checkbox" name="live_tv_pin_primary_menu" <?php if ($live_tv_pin_primary_menu == '1') {
                                                                          echo 'checked';
                                                                        } ?>><span class="button-indecator"></span>
              </label>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('footer_menu'); ?></label>
            <div class="toggle">
              <label>
                <input type="checkbox" name="live_tv_pin_footer_menu" <?php if ($live_tv_pin_footer_menu == '1') {
                                                                        echo 'checked';
                                                                      } ?>><span class="button-indecator"></span>
              </label>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('published'); ?></label>
            <div class="toggle">
              <label>
                <input type="checkbox" name="live_tv_publish" <?php if ($live_tv_publish == '1') {
                                                                echo 'checked';
                                                              } ?>><span class="button-indecator"></span>
              </label>
            </div>
          </div>

          <div class="col-sm-offset-3 col-sm-9 m-t-15">
            <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?></button>
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