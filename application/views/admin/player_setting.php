<?php
$player_color_skin          =   $this->db->get_where('config', array('title' => 'player_color_skin'))->row()->value;
$player_watermark           =   $this->db->get_where('config', array('title' => 'player_watermark'))->row()->value;
$player_watermark_logo      =   $this->db->get_where('config', array('title' => 'player_watermark_logo'))->row()->value;
$player_watermark_url       =   $this->db->get_where('config', array('title' => 'player_watermark_url'))->row()->value;
$player_share               =   $this->db->get_where('config', array('title' => 'player_share'))->row()->value;
$player_share_fb_id         =   $this->db->get_where('config', array('title' => 'player_share_fb_id'))->row()->value;
$player_seek_button         =   $this->db->get_where('config', array('title' => 'player_seek_button'))->row()->value;
$player_seek_forward        =   $this->db->get_where('config', array('title' => 'player_seek_forward'))->row()->value;
$player_seek_back           =   $this->db->get_where('config', array('title' => 'player_seek_back'))->row()->value;
$player_volume_remember     =   $this->db->get_where('config', array('title' => 'player_volume_remember'))->row()->value;
?>
<?php echo form_open(base_url() . 'admin/player_setting/update/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<div class="card">
  <div class="row">
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('player_setting'); ?></h3>
        </div>
        <div class="panel-body">
          <!-- panel  -->
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo trans('color_skin'); ?></label>
            <div class="col-sm-3 ">
              <select class="form-control" name="player_color_skin" required>
                <option value="blue" <?php if ($player_color_skin == "default") {
                                        echo "selected";
                                      } ?>>Default</option>
                <option value="green" <?php if ($player_color_skin == "green") {
                                        echo "selected";
                                      } ?>>Green</option>
                <option value="blue" <?php if ($player_color_skin == "blue") {
                                        echo "selected";
                                      } ?>>Blue</option>
                <option value="red" <?php if ($player_color_skin == "red") {
                                      echo "selected";
                                    } ?>>Red</option>
                <option value="yellow" <?php if ($player_color_skin == "yellow") {
                                          echo "selected";
                                        } ?>>Yellow</option>
                <option value="purple" <?php if ($player_color_skin == "purple") {
                                          echo "selected";
                                        } ?>>Purple</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo trans('volume_remember'); ?></label>
            <div class="col-sm-3">
              <div class="animated-checkbox checkbox-inline">
                <label>
                  <input type="checkbox" name='player_volume_remember' value="1" <?php if ($player_volume_remember == '1') {
                                                                                    echo 'checked';
                                                                                  } ?>><span class="label-text"></span>
                </label>
              </div>
            </div>
          </div>

          <h4 class="text-left"><?php echo trans('player_watermark') ?></h4>
          <hr>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo trans('watermark'); ?></label>
            <div class="col-sm-3 ">
              <div class="animated-checkbox checkbox-inline">
                <label>
                  <input type="checkbox" name='player_watermark' value="1" <?php if ($player_watermark == '1') {
                                                                              echo 'checked';
                                                                            } ?>><span class="label-text"></span>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-3"></label>
            <div class="col-sm-9">
              <img id="website_logo" src="<?php echo base_url() . $player_watermark_logo; ?>" alt="logo">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo trans('player_watermark_logo'); ?></label>
            <div class="col-sm-3 ">
              <input name="player_watermark_logo" id="FileInput" type="file" />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo trans('watermark_url'); ?></label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo $this->db->get_where('config', array('title' => 'player_watermark_url'))->row()->value; ?>" name="player_watermark_url" class="form-control" required />
            </div>
          </div>
          <h4 class="text-left"><?php echo trans('player_share') ?></h4>
          <hr>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo trans('share'); ?></label>
            <div class="col-sm-3 ">
              <div class="animated-checkbox checkbox-inline">
                <label>
                  <input type="checkbox" name='player_share' value="1" <?php if ($player_share == '1') {
                                                                          echo 'checked';
                                                                        } ?>><span class="label-text"></span>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo trans('player_share_fb_id'); ?></label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo $this->db->get_where('config', array('title' => 'player_share_fb_id'))->row()->value; ?>" name="player_share_fb_id" class="form-control" required />
            </div>
          </div>

          <h4 class="text-left"><?php echo trans('player_seek_button') ?></h4>
          <hr>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo trans('seek_button'); ?></label>
            <div class="col-sm-3 ">
              <div class="animated-checkbox checkbox-inline">
                <label>
                  <input type="checkbox" name='player_seek_button' value="1" <?php if ($player_seek_button == '1') {
                                                                                echo 'checked';
                                                                              } ?>><span class="label-text"></span>
                </label>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo trans('player_seek_forward'); ?></label>
            <div class="col-sm-9">
              <input type="number" value="<?php echo $this->db->get_where('config', array('title' => 'player_seek_forward'))->row()->value; ?>" name="player_seek_forward" class="form-control" required />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label"><?php echo trans('player_seek_back'); ?></label>
            <div class="col-sm-9">
              <input type="number" value="<?php echo $this->db->get_where('config', array('title' => 'player_seek_back'))->row()->value; ?>" name="player_seek_back" class="form-control" required />
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

<!-- file select-->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>
<!-- file select-->