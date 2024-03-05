<?php
  $tmdb_language      =   $this->db->get_where('config', array('title' => 'tmdb_language'))->row()->value;
  $languages          =   $this->db->get('languages_iso')->result_array();
?>

    <div class="card">
      <div class="row justify-content-md-center">
        <!-- panel  -->
        <div class="col-md-6">
          <?php echo form_open(base_url() . 'admin/tmdb_setting/update/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
          <div class="panel panel-border panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo trans('tmdb_details'); ?></h3>
            </div>
            <div class="panel-body">
              <!-- panel  -->

              <div class="form-group">
                <label class=" col-sm-3 control-label"><?php echo trans('tmdb_api_key'); ?></label>
                <div class="col-sm-8">
                  <input type="text" name="tmbd_api_key" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'tmbd_api_key'))->row()->value; ?>" required>
                </div>
              </div>
              <div class="form-group mb-3">
                <label class=" col-sm-3 control-label"><?php echo trans('tmdb_deafult_language'); ?></label>
                <div class="col-sm-8">
                  <select class="form-control" name="tmdb_language" id="lang">
                      <?php foreach ($languages as $language) :?>
                          <option value="<?php echo $language['iso'] ?>" <?php if ($tmdb_language == $language['iso']) : echo "selected";endif; ?>><?php echo $language['name'] ?></option>
                      <?php endforeach; ?>
                  </select>
               </div>
             </div>
            <div class="form-group mb-3">
                <label class=" col-sm-3 control-label"><?php echo trans('tmdb_image_grab_by'); ?></label>
                <div class="col-sm-8">
                    <select class="form-control" name="tmdb_image_import_by_cron">
                        <option value="1" <?php if (ovoo_config("tmdb_image_import_by_cron") == "1") : echo "selected";endif; ?>><?php echo trans("cron"); ?></option>
                        <option value="0" <?php if (ovoo_config("tmdb_image_import_by_cron") == "0") : echo "selected";endif; ?>><?php echo trans("direct_with_import"); ?></option>
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