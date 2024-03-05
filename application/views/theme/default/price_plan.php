<section class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
  <?php    
      $currency_symbol              =   $this->db->get_where('config' , array('title'=>'currency_symbol'))->row()->value;
      $offline_payment_enable       =   $this->db->get_where('config' , array('title'=>'offline_payment_enable'))->row()->value;
      // paypal
      $paypal_enable              = true;
      $query                                  = $this->db->get_where('config' , array('title'=>'paypal_enable'));
      if($query->num_rows() >0):
          if($query->first_row()->value == "false"):
              $paypal_enable= false;
          endif;
      endif;
      // stripe
      $stripe_enable              = true;
      $query                                  = $this->db->get_where('config' , array('title'=>'stripe_enable'));
      if($query->num_rows() >0):
          if($query->first_row()->value == "false"):
              $stripe_enable= false;
          endif;
      endif;
      $razorpay_enable            = true;
      $query                                  = $this->db->get_where('config' , array('title'=>'razorpay_enable'));
      if($query->num_rows() >0):
          if($query->first_row()->value == "false"):
              $razorpay_enable= false;
          endif;
      endif;
  ?>
  <!-- Breadcrumb -->
  <div id="title-bar">
      <div class="container">
          <div class="row">
              <div class="col-md-6 col-sm-8 col-xs-12">
                  <div class="page-title">
                      <h1 class="text-uppercase">
                          <?php echo trans("upgrade_membership");?>
                      </h1>
                  </div>
              </div>
              <div class="col-md-6 col-sm-4 col-xs-12 text-right">
                  <ul class="breadcrumb">
                      <li>
                          <a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i><?php echo trans("home");?></a>
                      </li>
                      <li><?php echo trans("subscription");?></li>
                      <li class="active"><?php echo trans("upgrade");?></li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
  <!-- End Breadcrumb -->
  <div class="container" >
    <h2 class="block-title text-center"><?php echo trans('purchase_plan'); ?><br>
        <small><?php echo trans('purchase_plan_text'); ?></small>
    </h2>
    <form method="post" action="">
      <div class="row">
        <?php 
            $sl = 0;
            $num_result = count($plans);
            foreach ($plans as $plan):
            $sl++;
        ?>
          <div class="col-md-4 price-table">
            <ul class="price">
              <li class="header" <?php if($sl == 2): echo 'style="background-color:var(--primary-color);"'; endif; ?>><?php echo $plan['name']; ?></li>
              <li class="grey"><?php echo $currency_symbol.''.$plan['price']; ?></li>
              <li><span><?php echo $plan['day']; ?></span> <?php echo trans("days");?></li>
              <li><?php echo trans("unlimited_movies_and_series");?></li>
              <li><?php echo trans("unlimited_live_tv");?></li>
              <li><?php echo trans("cancel_anytime");?></li>
              <li class="grey">
                <input type="radio" id="<?php echo 'checkbox_'.$plan['plan_id']; ?>" name="plan_id" value="<?php echo $plan['plan_id']; ?>" onChange="enable_btn()">
                <label for="<?php echo 'checkbox_'.$plan['plan_id']; ?>"></label>
              </li>
            </ul>
          </div>
          <?php if($num_result == $sl): echo "</div>"; endif; ?>
        <?php endforeach; ?>
        <div class="row">
          <div class="col-md-12">
            <div>
              <a class="btn btn-default btn-back clearfix" onClick="javascript:history.back()"><?php echo trans("back");?></a>
              <?php if($paypal_enable): ?>
                <button type="submit" id="paypal-btn" class="paypal-buy-now-button" disabled formaction="<?php echo base_url('subscription/paypal/process');?>">
                   <span><?php echo trans("pay_by");?></span> 
                   <svg aria-label="PayPal" xmlns="http://www.w3.org/2000/svg" width="90" height="33" viewBox="34.417 0 90 33"><path fill="#253B80" d="M46.211 6.749h-6.839a.95.95 0 0 0-.939.802l-2.766 17.537a.57.57 0 0 0 .564.658h3.265a.95.95 0 0 0 .939-.803l.746-4.73a.95.95 0 0 1 .938-.803h2.165c4.505 0 7.105-2.18 7.784-6.5.306-1.89.013-3.375-.872-4.415-.972-1.142-2.696-1.746-4.985-1.746zM47 13.154c-.374 2.454-2.249 2.454-4.062 2.454h-1.032l.724-4.583a.57.57 0 0 1 .563-.481h.473c1.235 0 2.4 0 3.002.704.359.42.469 1.044.332 1.906zM66.654 13.075h-3.275a.57.57 0 0 0-.563.481l-.146.916-.229-.332c-.709-1.029-2.29-1.373-3.868-1.373-3.619 0-6.71 2.741-7.312 6.586-.313 1.918.132 3.752 1.22 5.03.998 1.177 2.426 1.666 4.125 1.666 2.916 0 4.533-1.875 4.533-1.875l-.146.91a.57.57 0 0 0 .562.66h2.95a.95.95 0 0 0 .939-.804l1.77-11.208a.566.566 0 0 0-.56-.657zm-4.565 6.374c-.316 1.871-1.801 3.127-3.695 3.127-.951 0-1.711-.305-2.199-.883-.484-.574-.668-1.392-.514-2.301.295-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.499.589.697 1.411.554 2.317zM84.096 13.075h-3.291a.955.955 0 0 0-.787.417l-4.539 6.686-1.924-6.425a.953.953 0 0 0-.912-.678H69.41a.57.57 0 0 0-.541.754l3.625 10.638-3.408 4.811a.57.57 0 0 0 .465.9h3.287a.949.949 0 0 0 .781-.408l10.946-15.8a.57.57 0 0 0-.469-.895z"></path>              <path fill="#179BD7" d="M94.992 6.749h-6.84a.95.95 0 0 0-.938.802l-2.767 17.537a.57.57 0 0 0 .563.658h3.51a.665.665 0 0 0 .656-.563l.785-4.971a.95.95 0 0 1 .938-.803h2.164c4.506 0 7.105-2.18 7.785-6.5.307-1.89.012-3.375-.873-4.415-.971-1.141-2.694-1.745-4.983-1.745zm.789 6.405c-.373 2.454-2.248 2.454-4.063 2.454h-1.031l.726-4.583a.567.567 0 0 1 .562-.481h.474c1.233 0 2.399 0 3.002.704.358.42.467 1.044.33 1.906zM115.434 13.075h-3.272a.566.566 0 0 0-.562.481l-.146.916-.229-.332c-.709-1.029-2.289-1.373-3.867-1.373-3.619 0-6.709 2.741-7.312 6.586-.312 1.918.131 3.752 1.22 5.03 1 1.177 2.426 1.666 4.125 1.666 2.916 0 4.532-1.875 4.532-1.875l-.146.91a.57.57 0 0 0 .563.66h2.949a.95.95 0 0 0 .938-.804l1.771-11.208a.57.57 0 0 0-.564-.657zm-4.565 6.374c-.314 1.871-1.801 3.127-3.695 3.127-.949 0-1.711-.305-2.199-.883-.483-.574-.666-1.392-.514-2.301.297-1.855 1.805-3.152 3.67-3.152.93 0 1.686.309 2.184.892.501.589.699 1.411.554 2.317zM119.295 7.23l-2.807 17.858a.569.569 0 0 0 .562.658h2.822c.469 0 .866-.34.938-.803l2.769-17.536a.57.57 0 0 0-.562-.659h-3.16a.571.571 0 0 0-.562.482z"></path>
                   </svg>
                </button>
              <?php endif; ?>
              <?php if($stripe_enable): ?>
                <button type="submit" id="stripe-btn" class="btn btn-success btn-stripe clearfix" disabled formaction="<?php echo base_url('subscription/stripe_payment');?>"><?php echo trans("pay_by_stripe");?></button> 
              <?php endif; ?>
              <?php if($razorpay_enable): ?>
                <button type="submit" id="razorpay-btn" class="btn btn-success btn-stripe clearfix" disabled formaction="<?php echo base_url('subscription/razorpay_payment');?>"><?php echo trans("pay_by_razorpay");?></button> 
              <?php endif; ?>
              <?php if($offline_payment_enable): ?>
                <button type="button" class="btn btn-success btn-stripe clearfix" data-toggle="modal" data-target="#offline-payment-modal"><?php echo ovoo_config('offline_payment_title'); ?></button> 
                <!-- Modal -->
                <div class="modal fade" id="offline-payment-modal" tabindex="-1" role="dialog" aria-labelledby="offline-payment-modalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="offline-payment-modalLabel"><?php echo ovoo_config('offline_payment_title'); ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <?php echo ovoo_config('offline_payment_instruction'); ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo trans('close'); ?></button>
                        <button type="button" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </form>
  </div>
  <script>
    function enable_btn()
    {
        <?php if($paypal_enable): ?>
          $('#paypal-btn').removeAttr('disabled');
        <?php endif; ?>
        <?php if($stripe_enable): ?>
          $('#stripe-btn').removeAttr('disabled');
        <?php endif; ?>
        <?php if($razorpay_enable): ?>
          $('#razorpay-btn').removeAttr('disabled');
        <?php endif; ?>
    }
  </script>
</section>