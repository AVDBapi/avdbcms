<?php 
  $trial_enable                 =   ovoo_config('trial_enable');
  $paypal_enable                =   ovoo_config('paypal_enable');  
  $paypal_email                 =   ovoo_config('paypal_email');  
  $paypal_client_id             =   ovoo_config('paypal_client_id'); 
  $stripe_enable                =   ovoo_config('stripe_enable'); 
  $stripe_publishable_key       =   ovoo_config('stripe_publishable_key');  
  $stripe_secret_key            =   ovoo_config('stripe_secret_key'); 
  $razorpay_enable              =   ovoo_config('razorpay_enable');  
  $razorpay_key_id              =   ovoo_config('razorpay_key_id');   
  $razorpay_key_secret          =   ovoo_config('razorpay_key_secret');   
  $currency_symbol              =   ovoo_config('currency_symbol');
  $currency                     =   ovoo_config('currency');  
  $exchange_rate_update_by_cron =   ovoo_config('exchange_rate_update_by_cron');  
  $enable_ribbon                =   ovoo_config('enable_ribbon'); 
  $razorpay_inr_exchange_rate   =   ovoo_config('razorpay_inr_exchange_rate');
  $offline_payment_enable       =   ovoo_config('offline_payment_enable');
  $offline_payment_title        =   ovoo_config('offline_payment_title');
  $offline_payment_instruction  =   ovoo_config('offline_payment_instruction');

?>
<?php echo form_open(base_url() . 'subscription/payment_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
<div class="card">
  <div class="row">  
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('payment_setting');?></h3>
        </div>
        <div class="panel-body"> 
          <!-- panel  -->

          <strong><?php echo trans('offline_payment');?></strong><hr>
            <div class="form-group row">
                <label class="control-label col-sm-3 "><?php echo trans('offline_payment');?>?</label>
                <div class="col-sm-6">
                    <div class="toggle">
                        <label>
                            <input type="checkbox" name="offline_payment_enable" <?php if($offline_payment_enable =='true'){ echo 'checked';} ?>><span class="button-indecator"></span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-6 control-label"><?php echo trans('offline_payment_title');?></label>
                <div class="col-sm-6">
                    <input type="text"  value="<?php echo $offline_payment_title; ?>" name="offline_payment_title" class="form-control" required />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-6 control-label"><?php echo trans('offline_payment_instruction');?></label>
                <div class="col-sm-6">
                    <textarea name="offline_payment_instruction" class="form-control" required rows="5" id="offline_payment_instruction">
                        <?php echo $offline_payment_instruction; ?>
                    </textarea>
                </div>
            </div>


          <strong>PayPal Payment Gateway</strong><hr>
          <div class="form-group row">
              <label class="control-label col-sm-3 ">Paypal Enable/Disable?</label>
              <div class="col-sm-6">
                <div class="toggle">
                  <label>
                    <input type="checkbox" name="paypal_enable" <?php if($paypal_enable =='true'){ echo 'checked';} ?>><span class="button-indecator"></span>
                  </label>
                </div>
              </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">PayPal Merchant Email</label>
            <div class="col-sm-6">
              <input type="email"  value="<?php echo $paypal_email; ?>" name="paypal_email" class="form-control" required />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">PayPal Client ID(For mobile App Only)</label>
            <div class="col-sm-6">
              <input type="text"  value="<?php echo $paypal_client_id; ?>" name="paypal_client_id" class="form-control" required />
            </div>
          </div>

          <strong>Stripe Payment Gateway</strong><hr>

          <div class="form-group row">
              <label class="control-label col-sm-3 ">Stripe Enable/Disable?</label>
              <div class="col-sm-6">
                <div class="toggle">
                  <label>
                    <input type="checkbox" name="stripe_enable" <?php if($stripe_enable =='true'){ echo 'checked';} ?>><span class="button-indecator"></span>
                  </label>
                </div>
              </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Stripe Publishable Key</label>
            <div class="col-sm-6">
              <input type="text"  value="<?php echo $stripe_publishable_key; ?>" name="stripe_publishable_key" class="form-control" required />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Stripe Secret Key</label>
            <div class="col-sm-6">
              <input type="text"  value="<?php echo $stripe_secret_key; ?>" name="stripe_secret_key" class="form-control" required />
            </div>
          </div>

          <strong>Razorpay Payment Gateway</strong><hr>
          <div class="alert alert-success">Razorpay transaction will be process by INR currency.</div>

          <div class="form-group row">
              <label class="control-label col-sm-3 ">Razorpay Enable/Disable?</label>
              <div class="col-sm-6">
                <div class="toggle">
                  <label>
                    <input type="checkbox" name="razorpay_enable" <?php if($razorpay_enable =='true'){ echo 'checked';} ?>><span class="button-indecator"></span>
                  </label>
                </div>
              </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Exchange Rate</label>
            <div class="col-sm-6 ">
              <input type="text"  value="<?php echo $razorpay_inr_exchange_rate; ?>" name="razorpay_inr_exchange_rate" class="form-control" required />
              <small>(Please Enter The Exchange Rate For 1 <strong><?php echo $this->db->get_where('config' , array('title'=>'currency'))->row()->value; ?></strong> = INR?)</small>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Razorpay Key ID</label>
            <div class="col-sm-6">
              <input type="text"  value="<?php echo $razorpay_key_id; ?>" name="razorpay_key_id" class="form-control" required />
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-6 control-label">Razorpay Key Secret</label>
            <div class="col-sm-6">
              <input type="text"  value="<?php echo $razorpay_key_secret; ?>" name="razorpay_key_secret" class="form-control" required />
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
<script src="<?php echo base_url() ?>assets/plugins/summernote/dist/summernote.min.js"></script>
<script>
    jQuery(document).ready(function() {
        $('#offline_payment_instruction').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
    });
</script>

