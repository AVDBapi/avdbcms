<?php    
    $currency_symbol              =   $this->db->get_where('config' , array('title'=>'currency_symbol'))->row()->value;
?>

<?php echo form_open(base_url() . 'subscription/package/add/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
<h4 class="text-center"><?php echo trans("add_plan_information");?></h4>
<hr>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("name");?></label>
  <div class="col-sm-12">
    <input type="text"  name="name" value="" class="form-control" placeholder="<?php echo trans("enter_plan_full_name");?>" required />
  </div>
  <!-- End col-6 --> 
</div>
<!-- end form -group -->

<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("validity_day");?></label>
  <div class="col-sm-12 ">
    <select  class="form-control"  name="day" required>
      <option value="7">1 Week (7 Day)</option>
      <option value="14">2 Week (14 Day)</option>
      <option value="21">3 Week (21 Day)</option>
      <option value="28">4 Week (28 Day)</option>
      <option value="30">1 Month (30 Day)</option>
      <option value="60">2 Month (60 Day)</option>
      <option value="90">3 Month (90 Day)</option>
      <option value="120">4 Month (120 Day)</option>
      <option value="150">5 Month (150 Day)</option>
      <option value="180">6 Month (180 Day)</option>
      <option value="210">7 Month (210 Day)</option>
      <option value="240">8 Month (240 Day)</option>
      <option value="270">9 Month (270 Day)</option>
      <option value="300">10 Month (300 Day)</option>
      <option value="330">11 Month (330 Day)</option>
      <option value="365">12 Month (365 Day)</option>
    </select>
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("price");?>(<?php echo $currency_symbol; ?>)</label>
  <div class="col-sm-12">
    <input type="number"  step="0.01" name="price" value=""  class="form-control"  placeholder="<?php echo trans("enter_price");?>" required />
  </div>
  <!-- End col-6 --> 
</div>

<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("status");?></label>
  <div class="col-sm-12 ">
    <select  class="form-control"  name="status" required>
      <option value="1"><?php echo trans("enable");?></option>
      <option value="0"><?php echo trans("enable");?></option>
    </select>
  </div>
</div>
<div class="form-group row">
  <div class="col-sm-offset-3 col-sm-9 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"><span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans("create");?> </button>
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
  });
</script> 
