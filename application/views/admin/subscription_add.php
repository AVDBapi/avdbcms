<?php echo form_open(base_url() . 'subscription/manage_subscription/add/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
<h4 class="text-center"><?php echo trans("add_subscription");?></h4>
<hr>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("package");?></label>
  <div class="col-sm-12 ">
    <select class="form-control" name="plan_id" required>
      <?php $plans = $this->db->get('plan')->result_array();
            foreach ($plans as $plan):?>
            <option value="<?php echo $plan['plan_id']; ?>"><?php echo $plan['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("start_date");?></label>
  <div class="col-sm-12 ">
    <div class="input-group">
      <input type="text" name="start_date" id="start_date" class="form-control" value="<?php echo date('Y-m-d') ?>">
      <span class="input-group-addon bg-custom b-0 text-white"><i class="fa fa-calendar" aria-hidden="true"></i></span>
    </div>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("payment_method");?></label>
  <div class="col-sm-12 ">
    <select class="form-control" name="payment_method" required>
      <option value="Paypal"><?php echo trans("paypal");?></option>
      <option value="Card"><?php echo trans("card");?></option>
      <option value="Cash"><?php echo trans("cash");?></option>
      <option value="Bank"><?php echo trans("bank");?></option>
      <option value="Local"><?php echo trans("local_payment_service");?></option>
      <option value="Others"><?php echo trans("others");?></option>
    </select>
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("amount").'('.ovoo_config('currency_symbol').')';?></label>
  <div class="col-sm-12">
    <input type="text"  name="paid_amount" value="" class="form-control" placeholder="Enter amount" required />
  </div>
</div>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("transaction_id");?></label>
  <div class="col-sm-12">
    <input type="text"  name="transaction_id" value="" class="form-control" placeholder="Enter amount" />
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("status");?></label>
  <div class="col-sm-12 ">
    <select  class="form-control"  name="status" required>
      <option value="1"><?php echo trans("active");?></option>
      <option value="0"><?php echo trans("inactive");?></option>
    </select>
  </div>
  <!-- End col-6 --> 
</div>
<!-- end form -group -->
<input type="hidden" name="user_id" value="<?php echo $param2; ?>">
<div class="form-group row">
  <div class="col-sm-offset-3 col-sm-9 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans("add");?> </button>
    <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans("close");?> </button>
  </div>
  <!-- End col-6 --> 
</div>
<!-- end form -group -->
</form>
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
