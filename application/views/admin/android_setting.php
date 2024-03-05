<?php
  $app_menu                   =   $this->db->get_where('config' , array('title' =>'app_menu'))->row()->value;
  $app_program_guide_enable   =   $this->db->get_where('config' , array('title' =>'app_program_guide_enable'))->row()->value;
  $app_mandatory_login        =   $this->db->get_where('config' , array('title' =>'app_mandatory_login'))->row()->value;
  $genre_visible              =   $this->db->get_where('config' , array('title' =>'genre_visible'))->row()->value;
  $country_visible            =   $this->db->get_where('config' , array('title' =>'country_visible'))->row()->value;
  $version_code               =   $this->db->get_where('config' , array('title'=>'apk_version_code'))->row()->value;      
  $version_name               =   $this->db->get_where('config' , array('title'=>'apk_version_name'))->row()->value;      
  $whats_new                  =   $this->db->get_where('config' , array('title'=>'apk_whats_new'))->row()->value;      
  $apk_url                    =   $this->db->get_where('config' , array('title'=>'latest_apk_url'))->row()->value;
  $is_skipable                =   $this->db->get_where('config' , array('title'=>'apk_update_is_skipable'))->row()->value;
 ?>

<?php echo form_open(base_url() . 'admin/android_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
<div class="card">
  <div class="row"> 
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('android_setting'); ?></h3>
        </div>
        <div class="panel-body"> 
          <!-- panel  -->         

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans('terms_url_for_android');?></label>
            <div class="col-sm-9">
            <?php echo trans('terms_url_note_line1');?>
            <p><small><?php echo trans('terms_url_note_line1');?></small></p>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><?php echo trans('android_navigation_menu');?></label>
            <div class="col-sm-3">
                <select class="form-control m-bot15" id="app_menu" name="app_menu">
                  <option value="grid" <?php if($app_menu == 'grid'){echo 'selected';}?> ><?php echo trans('grid');?></option>
                  <option value="vertical" <?php if($app_menu == 'vertical'){echo 'selected';}?> ><?php echo trans('vertical');?></option>
                </select>
                <p><small><?php echo trans('');?>Close app then reopen to take effect any changes.</small></p>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-3"><?php echo trans('android_mandatory_login');?></label>
            <div class="col-sm-3">
                <select class="form-control m-bot15" id="app_mandatory_login" name="app_mandatory_login">
                  <option value="true" <?php if($app_mandatory_login == 'true'){echo 'selected';}?> ><?php echo trans('enable');?></option>
                  <option value="false" <?php if($app_mandatory_login == 'false'){echo 'selected';}?> ><?php echo trans('disable');?></option>
                </select>
                <p><small><?php echo trans('app_config_change_note');?></small></p>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><?php echo trans('android_display_genre_on_app_home');?></label>
            <div class="col-sm-3">
                <select class="form-control m-bot15" id="genre_visible" name="genre_visible">
                  <option value="true" <?php if($genre_visible == 'true'){echo 'selected';}?> ><?php echo trans('yes');?></option>
                  <option value="false" <?php if($genre_visible == 'false'){echo 'selected';}?> ><?php echo trans('no');?></option>
                </select>
                <p><small><?php echo trans('app_config_change_note');?></small></p>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><?php echo trans('android_display_country_on_app_home');?></label>
            <div class="col-sm-3">
                <select class="form-control m-bot15" id="country_visible" name="country_visible">
                  <option value="true" <?php if($country_visible == 'true'){echo 'selected';}?> ><?php echo trans('yes');?></option>
                  <option value="false" <?php if($country_visible == 'false'){echo 'selected';}?> ><?php echo trans('no');?></option>
                </select>
                <p><small><?php echo trans('app_config_change_note');?></small></p>
            </div>
          </div>

           <strong><?php echo trans("app_updater");?></strong>
           <hr>
          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans("latest_apk_version_name");?></label>
            <div class="col-sm-9">
              <input type="text"  value="<?php echo $version_name;?>" name="apk_version_name" placeholder="Ex: V1.0.0" class="form-control" required  />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans("latest_apk_version_code");?></label>
            <div class="col-sm-9">
              <input type="number"  value="<?php echo $version_code;?>" name="apk_version_code" placeholder="Ex: 12" class="form-control" required  />
              <small><?php echo trans("versioncode_note");?></samll>
            </div>
          </div>         

          <div class="form-group row">
            <label class="control-label col-sm-3 "><?php echo trans("apk_file_url");?></label>
            <div class="col-sm-9">
              <input type="text"  value="<?php echo $apk_url;?>" name="latest_apk_url" placeholder="Ex: PlayStore URL or any other direct download URL" class="form-control" required  />
            </div>
          </div>

          <div class="form-group row">
            <label class="col-sm-3 control-label"><?php echo trans("what_is_new_on_latest_apk");?></label>
            <div class="col-sm-9">
              <textarea type="text" rows="6" name="apk_whats_new" class="form-control"><?php echo $whats_new; ?></textarea>
            </div>
          </div>

          <div class="form-group row">
              <label class="control-label col-sm-3 "><?php echo trans("update_skipable?");?></label>
              <div class="col-sm-6">
                <div class="toggle">
                  <label>
                    <input type="checkbox" name="apk_update_is_skipable" <?php if($is_skipable =='1'){ echo 'checked';} ?>><span class="button-indecator"></span>
                  </label>
                </div>
              </div>
          </div>


          <div class="col-sm-offset-3 col-sm-9 m-t-15">
            <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_change');?></button>
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
    }
</script>
<!--end instant image dispaly-->

