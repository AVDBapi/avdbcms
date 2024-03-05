    <div class="card">
      <div class="row">
        <!-- panel  -->
        <div class="col-md-6">
          <?php echo form_open(base_url() . 'admin/social_login_setting/update_facebook/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
          <div class="panel panel-border panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo trans('facebook_login_details'); ?></h3>
            </div>
            <div class="panel-body">
              <!-- panel  -->
              <div class="form-group">
                <label class="control-label col-md-3"><?php echo trans('facebook_login'); ?></label>
                <div class="col-sm-8">
                  <div class="animated-checkbox checkbox-inline">
                    <label>
                      <input type="checkbox" name='facebook_login_enable' value="1" <?php if ($this->db->get_where('config', array('title' => 'facebook_login_enable'))->row()->value == '1') {
                                                                                      echo 'checked';
                                                                                    } ?>><span class="label-text"><?php echo trans('enable'); ?></span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class=" col-sm-3 control-label"><?php echo trans('facebook_app_id'); ?></label>
                <div class="col-sm-8">
                  <input type="text" name="facebook_app_id" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'facebook_app_id'))->row()->value; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class=" col-sm-3 control-label"><?php echo trans('facebook_app_secret'); ?></label>
                <div class="col-sm-8">
                  <input type="text" name="facebook_app_secret" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'facebook_app_secret'))->row()->value; ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class=" col-sm-3 control-label"><?php echo trans('facebook_graph_version'); ?></label>
                <div class="col-sm-8">
                  <input type="text" name="facebook_graph_version" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'facebook_graph_version'))->row()->value; ?>" required>
                </div>
              </div>


              <div class="col-sm-offset-3 col-sm-9 m-t-15">
                <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?> </button>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <?php echo form_open(base_url() . 'admin/social_login_setting/update_google/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
          <div class="panel panel-border panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo trans('google_login_details'); ?></h3>
            </div>
            <div class="panel-body">
              <!-- panel  -->
              <div class="form-group">
                <label class="control-label col-md-3"><?php echo trans('google_login'); ?></label>
                <div class="col-sm-8">
                  <div class="animated-checkbox checkbox-inline">
                    <label>
                      <input type="checkbox" name='google_login_enable' value="1" <?php if ($this->db->get_where('config', array('title' => 'google_login_enable'))->row()->value == '1') {
                                                                                    echo 'checked';
                                                                                  } ?>><span class="label-text"><?php echo trans('enable'); ?></span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label class=" col-sm-3 control-label"><?php echo trans('application_name'); ?></label>
                <div class="col-sm-8">
                  <input type="text" name="google_application_name" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'google_application_name'))->row()->value; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class=" col-sm-3 control-label"><?php echo trans('client_id'); ?></label>
                <div class="col-sm-8">
                  <input type="text" name="google_client_id" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'google_client_id'))->row()->value; ?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class=" col-sm-3 control-label"><?php echo trans('client_secret'); ?></label>
                <div class="col-sm-8">
                  <input type="text" name="google_client_secret" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'google_client_secret'))->row()->value; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <label class=" col-sm-3 control-label"><?php echo trans('google_redirect_uri'); ?></label>
                <div class="col-sm-8">
                  <input type="text" name="google_redirect_uri" class="form-control" value="<?php echo base_url('user/google_login'); ?>" required readonly>
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