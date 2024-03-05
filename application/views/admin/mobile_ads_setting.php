 <?php echo form_open(base_url() . 'admin/mobile_ads_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
<div class="card">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-border panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Ads Setting</h3>
                </div>
                <div class="alert alert-warning">If you are using OXOO Android version V1.3.7 or earlier, Please update ads setting from <a href="<?php echo base_url('admin/mobile_ads_setting_legacy') ?>" class="link">here</a></div>
                <strong>Reward Ads</strong>
                <hr>
                <div class="form-group row">
                  <label class="col-sm-3 control-label">Reward Ads</label>
                  <div class="col-sm-3 ">
                    <select class="form-control" name="reward_ad" required>
                      <option value="disable" <?php if(ovoo_config('reward_ad') == 'disable'): echo "selected"; endif; ?>>Disable</option>
                      <option value="admob" <?php if(ovoo_config('reward_ad') == 'admob'): echo "selected"; endif; ?>>AdMob</option>
                      <option value="applovin" <?php if(ovoo_config('reward_ad') == 'applovin'): echo "selected"; endif; ?>>AppLovin</option>
                      <option value="unity" <?php if(ovoo_config('reward_ad') == 'unity'): echo "selected"; endif; ?>>Unity Ads</option>
                      <option value="fan" <?php if(ovoo_config('reward_ad') == 'fan'): echo "selected"; endif; ?>>Facebook Audiance Network</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Reward Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo ovoo_config('reward_ad_id');?>" name="reward_ad_id" class="form-control" required  />
                    </div>
                </div>

                <strong>Banner Ads</strong>
                <hr>
                <div class="form-group row">
                  <label class="col-sm-3 control-label">Banner Ads</label>
                  <div class="col-sm-3 ">
                    <select class="form-control" name="banner_ad" required>
                      <option value="disable" <?php if(ovoo_config('banner_ad') == 'disable'): echo "selected"; endif; ?>>Disable</option>
                      <option value="admob" <?php if(ovoo_config('banner_ad') == 'admob'): echo "selected"; endif; ?>>AdMob</option>
                      <option value="applovin" <?php if(ovoo_config('banner_ad') == 'applovin'): echo "selected"; endif; ?>>AppLovin</option>
                      <option value="unity" <?php if(ovoo_config('banner_ad') == 'unity'): echo "selected"; endif; ?>>Unity Ads</option>
                      <option value="fan" <?php if(ovoo_config('banner_ad') == 'fan'): echo "selected"; endif; ?>>Facebook Audiance Network</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Banner Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo ovoo_config('banner_ad_id');?>" name="banner_ad_id" class="form-control" required  />
                    </div>
                </div>

                <strong>Interstitial Ads</strong>
                <hr>
                <div class="form-group row">
                  <label class="col-sm-3 control-label">Interstitial Ads</label>
                  <div class="col-sm-3 ">
                    <select class="form-control" name="interstitial_ad" required>
                      <option value="disable" <?php if(ovoo_config('interstitial_ad') == 'disable'): echo "selected"; endif; ?>>Disable</option>
                      <option value="admob" <?php if(ovoo_config('interstitial_ad') == 'admob'): echo "selected"; endif; ?>>AdMob</option>
                      <option value="applovin" <?php if(ovoo_config('interstitial_ad') == 'applovin'): echo "selected"; endif; ?>>AppLovin</option>
                      <option value="unity" <?php if(ovoo_config('interstitial_ad') == 'unity'): echo "selected"; endif; ?>>Unity Ads</option>
                      <option value="fan" <?php if(ovoo_config('interstitial_ad') == 'fan'): echo "selected"; endif; ?>>Facebook Audiance Network</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Interstitial Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo ovoo_config('interstitial_ad_id');?>" name="interstitial_ad_id" class="form-control" required  />
                    </div>
                </div>

                <strong>Native Ads</strong>
                <hr>
                <div class="form-group row">
                  <label class="col-sm-3 control-label">Native Ads</label>
                  <div class="col-sm-3 ">
                    <select class="form-control" name="native_ad" required>
                      <option value="disable" <?php if(ovoo_config('native_ad') == 'disable'): echo "selected"; endif; ?>>Disable</option>
                      <option value="admob" <?php if(ovoo_config('native_ad') == 'admob'): echo "selected"; endif; ?>>AdMob</option>
                      <option value="applovin" <?php if(ovoo_config('native_ad') == 'applovin'): echo "selected"; endif; ?>>AppLovin</option>
                      <option value="fan" <?php if(ovoo_config('native_ad') == 'fan'): echo "selected"; endif; ?>>Facebook Audiance Network</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Native Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo ovoo_config('native_ad_id');?>" name="native_ad_id" class="form-control" required  />
                    </div>
                </div>


                <strong>Admob</strong>
                <hr>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Publisher ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo ovoo_config('admob_publisher_id');?>" name="admob_publisher_id" class="form-control" required  />
                    </div>
                </div>

                <strong>Unity</strong>
                <hr>

                <div class="form-group row">
                    <label class="control-label col-sm-3 ">Test Mode</label>
                    <div class="col-sm-6">
                      <div class="toggle">
                        <label>
                          <input type="checkbox" name="unity_test_mode" <?php if(ovoo_config('unity_test_mode') =='1'){ echo 'checked';} ?>><span class="button-indecator"></span>
                        </label>
                      </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Unity Game ID(Android)</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo ovoo_config('unity_android_game_id');?>" name="unity_android_game_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Unity Game ID(iOS)</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo ovoo_config('unity_ios_game_id');?>" name="unity_ios_game_id" class="form-control" required  />
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