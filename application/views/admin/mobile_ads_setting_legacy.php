<?php 
    $mobile_ads_enable                  =   $this->db->get_where('config' , array('title' => 'mobile_ads_enable'))->row()->value;
    $mobile_ads_network                 =   $this->db->get_where('config' , array('title' => 'mobile_ads_network'))->row()->value;
    $admob_publisher_id                 =   $this->db->get_where('config' , array('title' => 'admob_publisher_id'))->row()->value;
    $admob_app_id                       =   $this->db->get_where('config' , array('title' => 'admob_app_id'))->row()->value;
    $admob_banner_ads_id                =   $this->db->get_where('config' , array('title' => 'admob_banner_ads_id'))->row()->value;
    $admob_interstitial_ads_id          =   $this->db->get_where('config' , array('title' => 'admob_interstitial_ads_id'))->row()->value;
    $admob_native_ads_id                =   $this->db->get_where('config' , array('title' => 'admob_native_ads_id'))->row()->value;
    $fan_native_ads_placement_id        =   $this->db->get_where('config' , array('title' => 'fan_native_ads_placement_id'))->row()->value;
    $fan_banner_ads_placement_id        =   $this->db->get_where('config' , array('title' => 'fan_banner_ads_placement_id'))->row()->value;
    $fan_interstitial_ads_placement_id  =   $this->db->get_where('config' , array('title' => 'fan_interstitial_ads_placement_id'))->row()->value;
    $fan_native_ads_placement_id        =   $this->db->get_where('config' , array('title' => 'fan_native_ads_placement_id'))->row()->value;
    $startapp_app_id                    =   $this->db->get_where('config' , array('title' => 'startapp_app_id'))->row()->value;
 ?>
 <?php echo form_open(base_url() . 'admin/mobile_ads_setting_legacy/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
<div class="card">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-border panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Ads Setting</h3>
                </div>

                <div class="alert alert-warning">If you are using OXOO Android version V1.3.8 or later, Please update ads setting from <a href="<?php echo base_url('admin/mobile_ads_setting') ?>" class="link">here</a></div>

                <div class="form-group row">
                    <label class="control-label col-sm-3 ">Ads Enable</label>
                    <div class="col-sm-6">
                      <div class="toggle">
                        <label>
                          <input type="checkbox" name="mobile_ads_enable" <?php if($mobile_ads_enable =='1'){ echo 'checked';} ?>><span class="button-indecator"></span>
                        </label>
                      </div>
                    </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-3 control-label">Ads Network</label>
                  <div class="col-sm-3 ">
                    <select class="form-control" name="mobile_ads_network" required>
                      <option value="admob" <?php if($mobile_ads_network == 'admob'): echo "selected"; endif; ?>>AdMob</option>
                      <option value="fan" <?php if($mobile_ads_network == 'fan'): echo "selected"; endif; ?>>Facebook Audiance Network</option>
                      <option value="startapp" <?php if($mobile_ads_network == 'startapp'): echo "selected"; endif; ?>>StartApp</option>
                    </select>
                  </div>
                </div>
                <strong>Admob</strong>
                <hr>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Publisher ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_publisher_id;?>" data-parsley-minlength="10" name="admob_publisher_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob APP ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_app_id;?>" data-parsley-minlength="10" name="admob_app_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Banner Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_banner_ads_id;?>" data-parsley-minlength="10" name="admob_banner_ads_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Interstitial Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_interstitial_ads_id;?>" data-parsley-minlength="10" name="admob_interstitial_ads_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Native Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_native_ads_id;?>" data-parsley-minlength="10" name="admob_native_ads_id" class="form-control" required  />
                    </div>
                </div>

                <strong>Facebook Audance Network</strong>
                <hr>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Facebook Native Ads Placement ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $fan_native_ads_placement_id;?>" data-parsley-minlength="10" name="fan_native_ads_placement_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Facebook Banner Ads Placement ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $fan_banner_ads_placement_id;?>" data-parsley-minlength="10" name="fan_banner_ads_placement_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Facebook Interstitial Ads Placement ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $fan_interstitial_ads_placement_id;?>" data-parsley-minlength="10" name="fan_interstitial_ads_placement_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Facebook Native Ads Placement ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $fan_native_ads_placement_id;?>" data-parsley-minlength="10" name="fan_native_ads_placement_id" class="form-control" required  />
                    </div>
                </div>

                <strong>StartApp</strong>
                <hr>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">StartApp App ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $startapp_app_id;?>" data-parsley-minlength="8" name="startapp_app_id" class="form-control" required  />
                    </div>
                </div>


                <div class="col-sm-offset-3 col-sm-9 m-t-15">
                    <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span>save changes </button>
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