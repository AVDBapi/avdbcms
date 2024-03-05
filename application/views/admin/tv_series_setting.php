<?php
$tv_series_publish                      =   $this->db->get_where('config', array('title' => 'tv_series_publish'))->row()->value;
$tv_series_pin_primary_menu             =   $this->db->get_where('config', array('title' => 'tv_series_pin_primary_menu'))->row()->value;
$tv_series_pin_footer_menu              =   $this->db->get_where('config', array('title' => 'tv_series_pin_footer_menu'))->row()->value;
$season_order                           =   $this->db->get_where('config', array('title' => 'season_order'))->row()->value;
$episode_order                          =   $this->db->get_where('config', array('title' => 'episode_order'))->row()->value;
?>
<?php echo form_open(base_url() . 'admin/tv_series_setting/update/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<div class="card">
  <div class="row">
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('tv_series_setting'); ?></h3>
        </div>
        <div class="panel-body">
          <!-- panel  -->


          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('primary_menu'); ?></label>
            <div class="col-sm-6">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="tv_series_pin_primary_menu" <?php if ($tv_series_pin_primary_menu == '1') {
                                                                              echo 'checked';
                                                                            } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('footer_menu'); ?></label>
            <div class="col-sm-6">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="tv_series_pin_footer_menu" <?php if ($tv_series_pin_footer_menu == '1') {
                                                                            echo 'checked';
                                                                          } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('published'); ?></label>
            <div class="col-sm-6">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="tv_series_publish" <?php if ($tv_series_publish == '1') {
                                                                    echo 'checked';
                                                                  } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('season_order'); ?></label>
            <div class="col-sm-3">
              <select class="form-control" name="season_order" required>
                  <option value="ASC" <?php if ($season_order == "ASC") { echo "selected";} ?>><?php echo trans('ascending'); ?></option>
                  <option value="DESC" <?php if ($season_order == "DESC") { echo "selected";} ?>><?php echo trans('descending'); ?></option>
                </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('episode_order'); ?></label>
            <div class="col-sm-3">
              <select class="form-control" name="episode_order" required>
                  <option value="ASC" <?php if ($episode_order == "ASC") { echo "selected";} ?>><?php echo trans('ascending'); ?></option>
                  <option value="DESC" <?php if ($episode_order == "DESC") { echo "selected";} ?>><?php echo trans('descending'); ?></option>
                </select>
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