<?php
    $currency_symbol              =   $this->db->get_where('config' , array('title'=>'currency_symbol'))->row()->value;
    $plans    = $this->db->get_where('plan' , array('plan_id' => $param2) )->result_array();
    foreach ( $plans as $row):
?>
<?php echo form_open(base_url() . 'subscription/package/update/'.$param2 , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>

<h4 class="text-center"><?php echo trans("edit_plan_information");?></h4>
<hr>
<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("name");?></label>
  <div class="col-sm-12">
    <input type="text"  name="name" value="<?php echo $row['name']; ?>" class="form-control" placeholder="<?php echo trans("enter_plan_full_name");?>" />
  </div>
  <!-- End col-6 --> 
</div>
<!-- end form -group -->

<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("validity_day");?></label>
  <div class="col-sm-12 ">
    <select  class="form-control"  name="day" required>
      <option value="7"  <?php if($row['day']=="7"){ echo "selected"; }?>>1 Week (7 Day)</option>
      <option value="14"  <?php if($row['day']=="14"){ echo "selected"; }?>>2 Week (14 Day)</option>
      <option value="21"  <?php if($row['day']=="21"){ echo "selected"; }?>>3 Week (21 Day)</option>
      <option value="28"  <?php if($row['day']=="28"){ echo "selected"; }?>>4 Week (28 Day)</option>
      <option value="30"  <?php if($row['day']=="30"){ echo "selected"; }?>>1 Month (30 Day)</option>
      <option value="60"  <?php if($row['day']=="60"){ echo "selected"; }?>>2 Month (60 Day)</option>
      <option value="90"  <?php if($row['day']=="90"){ echo "selected"; }?>>3 Month (90 Day)</option>
      <option value="120"  <?php if($row['day']=="120"){ echo "selected"; }?>>4 Month (120 Day)</option>
      <option value="150"  <?php if($row['day']=="150"){ echo "selected"; }?>>5 Month (150 Day)</option>
      <option value="180"  <?php if($row['day']=="180"){ echo "selected"; }?>>6 Month (180 Day)</option>
      <option value="210"  <?php if($row['day']=="210"){ echo "selected"; }?>>7 Month (210 Day)</option>
      <option value="240"  <?php if($row['day']=="240"){ echo "selected"; }?>>8 Month (240 Day)</option>
      <option value="270"  <?php if($row['day']=="270"){ echo "selected"; }?>>9 Month (270 Day)</option>
      <option value="300"  <?php if($row['day']=="300"){ echo "selected"; }?>>10 Month (300 Day)</option>
      <option value="330"  <?php if($row['day']=="330"){ echo "selected"; }?>>11 Month (330 Day)</option>
      <option value="365"  <?php if($row['day']=="365"){ echo "selected"; }?>>12 Month (365 Day)</option>
    </select>
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("price");?>(<?php echo $currency_symbol; ?>)</label>
  <div class="col-sm-12">
    <input type="number"  step="0.01" name="price" value="<?php echo $row['price']; ?>"  class="form-control"  placeholder="<?php echo trans("enter_price");?>" required />
  </div>
  <!-- End col-6 --> 
</div>

<div class="form-group row">
  <label class="col-sm-12 control-label"><?php echo trans("status");?></label>
  <div class="col-sm-12 ">
    <select  class="form-control"  name="status" required>
      <option value="1" <?php if($row['status']=="1"){ echo "selected"; }?>><?php echo trans("enable");?></option>
      <option value="0"  <?php if($row['status']!="1"){ echo "selected"; }?>><?php echo trans("disable");?></option>
    </select>
  </div>
</div>

<?php endforeach; ?>
<div class="form-group">
  <div class="col-sm-offset-3 col-sm-9 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans("save");?> </button>
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
