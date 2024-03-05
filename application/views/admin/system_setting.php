<?php
    $registration_enable        = ovoo_config('purchase_code');
    $frontend_login_enable      = ovoo_config('frontend_login_enable');
    $blog_enable                = ovoo_config('blog_enable');
    $country_to_primary_menu    = ovoo_config('country_to_primary_menu');
    $genre_to_primary_menu      = ovoo_config('genre_to_primary_menu');
    $release_to_primary_menu    = ovoo_config('release_to_primary_menu');
    $contact_to_primary_menu    = ovoo_config('contact_to_primary_menu');
    $contact_to_footer_menu     = ovoo_config('contact_to_footer_menu');
    $show_star_image            = ovoo_config('show_star_image');
    $movie_report_enable        = ovoo_config('movie_report_enable');
    $movie_report_email         = ovoo_config('movie_report_email');
    $movie_request_enable       = ovoo_config('movie_request_enable');
    $movie_request_email        = ovoo_config('movie_request_email');
    $movie_report_note          = ovoo_config('movie_report_note');
    $recaptcha_enable           = ovoo_config('recaptcha_enable');
    $recaptcha_site_key         = ovoo_config('recaptcha_site_key');
    $recaptcha_secret_key       = ovoo_config('recaptcha_secret_key');
    $az_to_primary_menu         = ovoo_config('az_to_primary_menu');
    $az_to_footer_menu          = ovoo_config('az_to_footer_menu');
    $current_timezone           = ovoo_config('timezone');
    $purchase_code              = ovoo_config('purchase_code');
    $purchase_code              = substr($purchase_code, 0,10).'***********'.substr($purchase_code, -8);
?>


<?php echo form_open(base_url() . 'admin/system_setting/update/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<div class="card">
  <div class="row">
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('theme_options'); ?></h3>
        </div>
        <div class="panel-body">
          <!-- panel  -->

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('theme'); ?></label>
            <div class="col-sm-3 ">
              <select class="form-control" name="active_theme" required>
                <?php
                  $theme_path = APPPATH."views/theme/"; 
                  $scan       = scandir($theme_path);
                  foreach($scan as $theme_title):
                  if (is_dir($theme_path."$theme_title") && $theme_title !="." && $theme_title !=".."):
                ?>
                  <option value="<?php echo $theme_title; ?>" <?php if ($active_theme == $theme_title): echo "selected"; endif;?>><?php echo $theme_title; ?></option>
                <?php endif; endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('purchase_code'); ?></label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo $purchase_code; ?>" name="purchase_code" class="form-control" required />
            </div>
          </div>          

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('timezone'); ?></label>
            <div class="col-sm-9">
              <select class="form-control select2" name="timezone" id="timezone">
                <?php $timezones = $this->db->get('calendar')->result_array();
                foreach ($timezones as $timezone) : ?>
                    <option value="<?php echo $timezone['timezone']; ?>" <?php if($current_timezone == $timezone['timezone']): echo "selected"; endif; ?>><?php echo $timezone['timezone']; ?></option>
                <?php endforeach; ?>
              </select>
              <small>Server Time: <?php echo date('Y-m-d H:i:s');?></small>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('site_name'); ?></label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo ovoo_config('site_name'); ?>" name="site_name" class="form-control" required />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('site_url'); ?></label>
            <div class="col-sm-9">
              <input type="url" value="<?php echo ovoo_config('site_url'); ?>" name="site_url" class="form-control" required />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('system_email'); ?></label>
            <div class="col-sm-9">
              <input type="email" value="<?php echo ovoo_config('system_email'); ?>" name="system_email" class="form-control" required />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('business_address'); ?></label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo ovoo_config('business_address'); ?>" name="business_address" class="form-control" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('business_phone'); ?></label>
            <div class="col-sm-9">
              <input type="number" value="<?php echo ovoo_config('business_phone'); ?>" name="business_phone" class="form-control" data-parsley-length="[10, 14]" />
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('contact_email'); ?></label>
            <div class="col-sm-9">
              <input type="email" value="<?php echo ovoo_config('contact_email'); ?>" name="contact_email" class="form-control" />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('registration_enable'); ?></label>
            <div class="col-sm-3 ">
              <select class="form-control" name="registration_enable" required>
                <option value="1" <?php if ($registration_enable == "1") {
                                    echo "selected";
                                  } ?>><?php echo trans('enable'); ?></option>
                <option value="0" <?php if ($registration_enable == "0") {
                                    echo "selected";
                                  } ?>><?php echo trans('disable'); ?></option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('front_end_login'); ?></label>
            <div class="col-sm-3 ">
              <select class="form-control" name="frontend_login_enable" required>
                <option value="1" <?php if ($frontend_login_enable == "1") {
                                    echo "selected";
                                  } ?>><?php echo trans('enable'); ?></option>
                <option value="0" <?php if ($frontend_login_enable == "0") {
                                    echo "selected";
                                  } ?>><?php echo trans('disable'); ?></option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('blog_enable'); ?></label>
            <div class="col-sm-3 ">
              <select class="form-control" name="blog_enable" required>
                <option value="1" <?php if ($blog_enable == "1") {
                                    echo "selected";
                                  } ?>><?php echo trans('enable'); ?></option>
                <option value="0" <?php if ($blog_enable == "0") {
                                    echo "selected";
                                  } ?>><?php echo trans('disable'); ?></option>
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('show_country_to_main_menu'); ?></label>
            <div class="col-sm-6">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="country_to_primary_menu" <?php if ($country_to_primary_menu == '1') {
                                                                          echo 'checked';
                                                                        } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('show_genre_to_main_menu'); ?></label>
            <div class="col-sm-6">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="genre_to_primary_menu" <?php if ($genre_to_primary_menu == '1') {
                                                                        echo 'checked';
                                                                      } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('show_release_to_main_menu'); ?></label>
            <div class="col-sm-6">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="release_to_primary_menu" <?php if ($release_to_primary_menu == '1') {
                                                                          echo 'checked';
                                                                        } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('show_contact_to_main_menu'); ?></label>
            <div class="col-sm-6">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="contact_to_primary_menu" <?php if ($contact_to_primary_menu == '1') { echo 'checked';} ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('show_contact_to_footer_menu'); ?></label>
            <div class="col-sm-6">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="contact_to_footer_menu" <?php if ($contact_to_footer_menu == '1') { echo 'checked';} ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('show_actor_director_and_writer_image_to_movie_page'); ?></label>
            <div class="col-sm-6">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="show_star_image" <?php if ($show_star_image == '1') {echo 'checked'; } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('show_az_list_to_main_menu'); ?></label>
            <div class="col-sm-9">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="az_to_primary_menu" <?php if ($az_to_primary_menu == '1') {
                                                                      echo 'checked';
                                                                    } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('show_az_list_to_footer_menu'); ?></label>
            <div class="col-sm-9">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="az_to_footer_menu" <?php if ($az_to_footer_menu == '1') {
                                                                    echo 'checked';
                                                                  } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('enable_movie_report'); ?></label>
            <div class="col-sm-9">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="movie_report_enable" <?php if ($movie_report_enable == '1') {
                                                                      echo 'checked';
                                                                    } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('movie_report_send_to_email'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $movie_report_email; ?>" name="movie_report_email" class="form-control" />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('movie_report_attention_text'); ?></label>
            <div class="col-sm-6">
              <textarea type="text" rows="4" name="movie_report_note" class="form-control"><?php echo $movie_report_note; ?></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('enable_movie_request'); ?></label>
            <div class="col-sm-9">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="movie_request_enable" <?php if ($movie_request_enable == '1') {
                                                                        echo 'checked';
                                                                      } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('movie_request_send_to_email'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $movie_request_email; ?>" name="movie_request_email" class="form-control" />
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans('enable_google_recaptcha'); ?></label>
            <div class="col-sm-9">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="recaptcha_enable" <?php if ($recaptcha_enable == '1') {
                                                                    echo 'checked';
                                                                  } ?>><span class="button-indecator"></span>
                </label>
                <p class="text-danger"><?php echo trans('recaptcha_alert_text');?></p>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('recaptcha_site_key'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $recaptcha_site_key; ?>" name="recaptcha_site_key" class="form-control" />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('recaptcha_secret_key'); ?></label>
            <div class="col-sm-6">
              <input type="text" value="<?php echo $recaptcha_secret_key; ?>" name="recaptcha_secret_key" class="form-control" />
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
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<!-- file select-->

<!--instant image dispaly-->
<script type="text/javascript">
  jQuery(document).ready(function() {
    $('#timezone').select2({
        placeholder: '<?php echo trans('timezone');?>'
    });
  });
  function showImg(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#landing_page_image')
          .attr('src', e.target.result)
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
<!--end instant image dispaly-->