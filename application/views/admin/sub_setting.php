<?php 
  $trial_enable               =   ovoo_config('trial_enable');
  $paypal_email               =   ovoo_config('paypal_email');  
  $paypal_client_id           =   ovoo_config('paypal_client_id');  
  $stripe_publishable_key     =   ovoo_config('stripe_publishable_key');  
  $stripe_secret_key          =   ovoo_config('stripe_secret_key');   
  $razorpay_key_id            =   ovoo_config('razorpay_key_id');   
  $razorpay_key_secret        =   ovoo_config('razorpay_key_secret');   
  $currency_symbol            =   ovoo_config('currency_symbol');
  $currency                   =   ovoo_config('currency');  
  $exchange_rate_update_by_cron=   ovoo_config('exchange_rate_update_by_cron');  
  $enable_ribbon              =   ovoo_config('enable_ribbon');  
  $exchnage_rate              =   $this->common_model->get_usd_exchange_rate($currency);

?>
<?php echo form_open(base_url() . 'subscription/sub_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
<div class="card">
  <div class="row">  
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title">Subscription Setting</h3>
        </div>
        <div class="panel-body"> 
          <!-- panel  -->

          <div class="form-group">
            <label class="col-sm-6 control-label">Currency Symbol</label>
            <div class="col-sm-6 ">
              <input type="text"  value="<?php echo $currency_symbol; ?>" name="currency_symbol" class="form-control" required />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Currency</label>
            <div class="col-sm-6 ">
              <select  class="form-control"  name="currency" required>
                <?php foreach ($currencies as $currency2): ?>
                  <option value="<?php echo $currency2['iso_code'] ?>" <?php if($currency2['iso_code']==$currency){ echo "selected"; }?>><?php echo $currency2['iso_code'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Exchange Rate</label>
            <div class="col-sm-6 ">
              <input type="text"  value="<?php echo $exchnage_rate; ?>" name="exchnage_rate" class="form-control" required />
              <small>(Please Enter The Exchange Rate For 1 USD = ?)</small>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Update Exchange rate form online(by Cron)</label>
            <div class="col-sm-6 ">
              <select class="form-control" name="exchange_rate_update_by_cron" required>
                <option value="1" <?php if ($exchange_rate_update_by_cron == "1") { echo "selected";} ?>><?php echo trans('enable'); ?></option>
                <option value="0" <?php if ($exchange_rate_update_by_cron == "0") { echo "selected";} ?>><?php echo trans('disable'); ?></option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Show Ribbon for Paid Content</label>
            <div class="col-sm-6 ">
              <select class="form-control" name="enable_ribbon" required>
                <option value="1" <?php if ($enable_ribbon == "1") { echo "selected";} ?>><?php echo trans('enable'); ?></option>
                <option value="0" <?php if ($enable_ribbon == "0") { echo "selected";} ?>><?php echo trans('disable'); ?></option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Trial Functionality</label>
            <div class="col-sm-6 ">
              <select  class="form-control"  name="trial_enable" required>
                <option value="1" <?php if($trial_enable =="1"){ echo "selected"; }?>>Enable</option>
                <option value="0"  <?php if($trial_enable =="0"){ echo "selected"; }?>>Disable</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Trial Period Number of days</label>
            <div class="col-sm-6">
              <input type="number"  value="<?php echo $this->db->get_where('config' , array('title' =>'trial_period'))->row()->value;?>" name="trial_period" class="form-control"   />
            </div>
          </div>
          <div class="col-sm-offset-3 col-sm-9 m-t-15">
            <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span>save changes </button>
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

