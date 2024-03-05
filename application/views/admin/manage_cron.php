<?php
$cron_key               =   $this->db->get_where('config', array('title' => 'cron_key'))->row()->value;
$db_backup              =   $this->db->get_where('config', array('title' => 'db_backup'))->row()->value;
$backup_schedule        =   $this->db->get_where('config', array('title' => 'backup_schedule'))->row()->value;
?>
<?php echo form_open(base_url() . 'admin/cron_setting/update/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<div class="card">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('cron_setting'); ?></h3>
        </div>

        <div class="panel-body">
          <div class="alert alert-info"><strong><?php echo trans('image_import_cron'); ?>: &nbsp;</strong><code>wget -O /dev/null <?php echo base_url('cron/image/' . $cron_key); ?></code></div>
        </div>

        <div class="panel-body">
          <div class="alert alert-info"><strong><?php echo trans('email_newlater_cron'); ?>: &nbsp;</strong><code>wget -O /dev/null <?php echo base_url('cron/email/' . $cron_key); ?></code></div>
        </div>

        <div class="panel-body">
          <div class="alert alert-info"><strong><?php echo trans('daily_cron'); ?>: &nbsp;</strong><code>wget -O /dev/null <?php echo base_url('cron/daily/' . $cron_key); ?></code></div>
        </div>

        <div class="panel-body">
          <div class="alert alert-info"><strong><?php echo trans('weekly_cron'); ?>: &nbsp;</strong><code>wget -O /dev/null <?php echo base_url('cron/weekly/' . $cron_key); ?></code></div>
        </div>

        <div class="panel-body">
          <div class="alert alert-info"><strong><?php echo trans('monthly_cron'); ?>: &nbsp;</strong><code>wget -O /dev/null <?php echo base_url('cron/monthly/' . $cron_key); ?></code></div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 control-label"><?php echo trans('cron_key'); ?></label>
          <div class="col-sm-3">
            <input type="text" value="<?php echo $cron_key; ?>" data-parsley-minlength="16" name="cron_key" class="form-control" required />
          </div>
        </div>

        <div class="form-group row">
          <label class="control-label col-sm-3 "><?php echo trans('auto_database_backup'); ?></label>
          <div class="col-sm-6">
            <div class="toggle">
              <label>
                <input type="checkbox" name="db_backup" <?php if ($db_backup == '1') {
                                                          echo 'checked';
                                                        } ?>><span class="button-indecator"></span>
              </label>
            </div>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-sm-3 control-label"><?php echo trans('backup_schedule'); ?></label>
          <div class="col-sm-3 ">
            <select class="form-control" name="backup_schedule" required>
              <option value="1" <?php if ($backup_schedule == "1") {
                                  echo "selected";
                                } ?>>Daily</option>
              <option value="7" <?php if ($backup_schedule == "7") {
                                  echo "selected";
                                } ?>>Weekly</option>
              <option value="30" <?php if ($backup_schedule == "30") {
                                    echo "selected";
                                  } ?>>Monthly</option>
            </select>
          </div>
        </div>

        <div class="col-sm-offset-3 col-sm-9 m-t-15">
          <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?> </button>
        </div>

      </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script>