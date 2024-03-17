<?php echo form_open(base_url() . 'admin/theme_options/update/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<div class="card">
  <div class="row">
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('theme_option'); ?></h3>
        </div>
        <div class="panel-body">
          <!-- panel  -->

            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo trans('website_preloader'); ?></label>
                <div class="col-sm-3 ">
                    <select class="form-control" name="preloader_disable" required>
                        <option value="0" <?php if (ovoo_config("preloader_disable") == "0") { echo "selected"; } ?>><?php echo trans('enable'); ?></option>
                        <option value="1" <?php if (ovoo_config("preloader_disable") == "1") { echo "selected";} ?>><?php echo trans('disable'); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo trans('dark_theme_enable'); ?></label>
                <div class="col-sm-3 ">
                    <select class="form-control" name="dark_theme" required>
                        <option value="1" <?php if (ovoo_config("dark_theme") == "1") { echo "selected"; } ?>><?php echo trans('enable'); ?></option>
                        <option value="0" <?php if (ovoo_config("dark_theme") == "0") { echo "selected";} ?>><?php echo trans('disable'); ?></option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo trans('bg_image'); ?></label>
                <div class="col-sm-3 ">
                    <select class="form-control" name="bg_img_disable" required>
                        <option value="0" <?php if ((ovoo_config('bg_img_disable')=='0')){ echo "selected";} ?>><?php echo trans('enable'); ?></option>
                        <option value="1" <?php if ((ovoo_config('bg_img_disable')=='1')) { echo "selected";} ?>><?php echo trans('disable'); ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label"><?php echo trans('website_background_image'); ?></label>
                <div class="col-sm-3">
                    <img class="img-fluid" id="bg_image" src="<?php echo (ovoo_config("bg_image") != '') ? base_url('uploads/bg/').ovoo_config("bg_image") : base_url('uploads/bg/bg.jpg'); ?>" alt="<?php echo trans('website_background_image'); ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-sm-3"></label>
                <div class="col-sm-3">
                    <input type="file" onchange="showImg2(this);" name="bg_image" class="filestyle" accept="image/*">
                </div>
            </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('landing_page_with_search'); ?></label>
            <div class="col-sm-3 ">
              <select class="form-control" name="landing_page_enable" required>
                <option value="1" <?php if (ovoo_config("landing_page_enable") == "1") {
                                    echo "selected";
                                  } ?>><?php echo trans('enable'); ?></option>
                <option value="0" <?php if (ovoo_config("landing_page_enable") == "0") {
                                    echo "selected";
                                  } ?>><?php echo trans('disable'); ?></option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('landing_page_image'); ?></label>
            <div class="col-sm-3">
              <img class="img-fluid" id="landing_page_image" src="<?php echo (ovoo_config("landing_page_image_url") != '') ? base_url('uploads/').ovoo_config("landing_bg") : base_url('uploads/landing_page/bg.jpg'); ?>" alt="Landing Page BG">
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3"></label>
            <div class="col-sm-3">
              <input type="file" onchange="showImg(this);" name="landing_page_image" class="filestyle" accept="image/*">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('front_end_theme_color'); ?></label>
            <div class="col-sm-3 ">
              <select class="form-control" name="front_end_theme" required>
                <option value="blue" <?php if (ovoo_config("front_end_theme") == "default") {
                                        echo "selected";
                                      } ?>>Default</option>
                <option value="green" <?php if (ovoo_config("front_end_theme") == "green") {
                                        echo "selected";
                                      } ?>>Green</option>
                <option value="blue" <?php if (ovoo_config("front_end_theme") == "blue") {
                                        echo "selected";
                                      } ?>>Blue</option>
                <option value="red" <?php if (ovoo_config("front_end_theme") == "red") {
                                      echo "selected";
                                    } ?>>Red</option>
                <option value="yellow" <?php if (ovoo_config("front_end_theme") == "yellow") {
                                          echo "selected";
                                        } ?>>Yellow</option>
                <option value="purple" <?php if (ovoo_config("front_end_theme") == "purple") {
                                          echo "selected";
                                        } ?>>Purple</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('header_template'); ?></label>
            <div class="col-sm-3 ">
              <select class="form-control" name="header_templete" required>
                <option value="header1" <?php if (ovoo_config("header_templete") == "header1") {
                                          echo "selected";
                                        } ?>>Header Default</option>
                <option value="header2" <?php if (ovoo_config("header_templete") == "header2") {
                                          echo "selected";
                                        } ?>>Header2</option>
                <option value="header3" <?php if (ovoo_config("header_templete") == "header3") {
                                          echo "selected";
                                        } ?>>Header3</option>
                <option value="header4" <?php if (ovoo_config("header_templete") == "header4") {
                                          echo "selected";
                                        } ?>>Header4</option>
                <option value="header5" <?php if (ovoo_config("header_templete") == "header5") {
                                          echo "selected";
                                        } ?>>Header5</option>
              </select>
            </div>
          </div>


          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('footer_template'); ?></label>
            <div class="col-sm-3 ">
              <select class="form-control" name="footer_templete" required>
                <option value="footer1" <?php if (ovoo_config("footer_templete") == "footer1") {
                                          echo "selected";
                                        } ?>>Footer Default</option>
                <option value="footer2" <?php if (ovoo_config("footer_templete") == "footer2") {
                                          echo "selected";
                                        } ?>>Footer2</option>
                <option value="footer3" <?php if (ovoo_config("footer_templete") == "footer3") {
                                          echo "selected";
                                        } ?>>Footer3</option>
                <option value="footer4" <?php if (ovoo_config("footer_templete") == "footer4") {
                                          echo "selected";
                                        } ?>>Footer4</option>
                <option value="footer5" <?php if (ovoo_config("footer_templete") == "footer5") {
                                          echo "selected";
                                        } ?>>Footer5</option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('google_map_api'); ?></label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo ovoo_config("map_api"); ?>" name="map_api" class="form-control" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('google_map_lat'); ?></label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo ovoo_config("map_lat"); ?>" name="map_lat" class="form-control" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('google_map_lang'); ?></label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo ovoo_config("map_lng"); ?>" name="map_lng" class="form-control" />
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

<!--instant image dispaly-->
<script type="text/javascript">
  function showImg(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#landing_page_image')
          .attr('src', e.target.result)
      };
      reader.readAsDataURL(input.files[0]);
    }
  }  function showImg2(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#bg_image')
          .attr('src', e.target.result)
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
<!--end instant image dispaly-->