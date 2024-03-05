
<?php
    $subscriptions    = $this->db->get_where('subscription' , array('subscription_id' => $param2) )->result_array();
    foreach ( $subscriptions as $row):
?>
<?php echo form_open(base_url() . 'subscription/manage_subscription/update/'.$param2 , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
<h4 class="text-center"><?php echo trans("edit_subscription");?></h4>
<hr>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("plan");?></label>
  <div class="col-sm-12 ">
    <select class="form-control" name="plan_id" required>
      <?php $plans = $this->db->get('plan')->result_array();
            foreach ($plans as $plan):?>
            <option value="<?php echo $plan['plan_id']; ?>" <?php if($row['plan_id'] == $plan['plan_id']){ echo "selected";} ?>><?php echo $plan['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("start_date");?></label>
  <div class="col-sm-12 ">
    <div class="input-group">
      <input type="text" name="start_date" id="start_date" class="form-control" value="<?php echo date("Y-m-d",$row['timestamp_from']); ?>">
      <span class="input-group-addon bg-custom b-0 text-white"><i class="fa fa-calendar" aria-hidden="true"></i></span>
    </div>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("payment_method");?></label>
  <div class="col-sm-12 ">
    <select class="form-control" name="payment_method" required>
      <option value="Paypal" <?php if($row['plan_id'] == "Paypal"){ echo "selected";} ?>><?php echo trans("paypal");?></option>
      <option value="Card" <?php if($row['plan_id'] == "Card"){ echo "selected";} ?>><?php echo trans("card");?></option>
      <option value="Cash" <?php if($row['plan_id'] == "Cash"){ echo "selected";} ?>><?php echo trans("cash");?></option>
      <option value="Bank" <?php if($row['plan_id'] == "Bank"){ echo "selected";} ?>><?php echo trans("bank");?></option>
      <option value="Local" <?php if($row['plan_id'] == "Local"){ echo "selected";} ?>><?php echo trans("local_payment_service");?></option>
      <option value="Others" <?php if($row['plan_id'] == "Others"){ echo "selected";} ?>><?php echo trans("others");?></option>
    </select>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("amount").'('.ovoo_config('currency_symbol').')';?></label>
  <div class="col-sm-12">
    <input type="text"  name="paid_amount" value="<?php echo $row['paid_amount'] ?>" class="form-control" placeholder="Enter amount" required />
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("transaction_id");?></label>
  <div class="col-sm-12">
    <input type="text"  name="transaction_id" value="<?php echo $row['transaction_id'] ?>" class="form-control" placeholder="Enter amount" />
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("status");?></label>
  <div class="col-sm-12 ">
    <select  class="form-control"  name="status" required>
      <option value="1" <?php if($row['status'] == '1'){ echo "selected";} ?>><?php echo trans("active");?></option>
      <option value="0" <?php if($row['status'] == '0'){ echo "selected";} ?>><?php echo trans("inactive");?></option>
    </select>
  </div>
  <!-- End col-6 --> 
</div>
<!-- end form -group -->
<input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
<div class="form-group row">
  <div class="col-sm-offset-3 col-sm-9 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans("save_change");?> </button>
    <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans("close");?> </button>
  </div>
  <!-- End col-6 --> 
</div>
<!-- end form -group -->
</form>
<?php endforeach; ?>
<script>
  jQuery(document).ready(function() {
    $(".select2").select2();
    $('form').parsley(); 
    $('#start_date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true
    });
  });
</script> 
