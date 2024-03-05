<?php
  $live_tv_categorys    = $this->db->get_where('live_tv_category' , array('live_tv_category_id' => $param2) )->result_array();
  foreach ( $live_tv_categorys as $row):
?>

<?php echo form_open(base_url() . 'admin/live_tv_category/update/'.$param2 , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>

<h4 class="text-center"><?php echo trans('edit_live_tv_category'); ?></h4>
<hr>
<div class="form-group row">
  <label class="col-sm-3 control-label"><?php echo trans('live_tv_category'); ?></label>
  <div class="col-sm-9">
    <input type="text"  name="live_tv_category" value="<?php echo $row['live_tv_category']; ?>" class="form-control" required />
  </div>
</div>

<div class="form-group row">
  <label class="col-sm-3 control-label"><?php echo trans('description'); ?></label>
  <div class="col-sm-9">
    <input type="text"  name="live_tv_category_desc"  value="<?php echo $row['live_tv_category_desc']; ?>" class="form-control"  />
  </div>
</div>

<div class="form-group row">
  <div class="col-sm-offset-3 col-sm-6 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save') ?> </button>
    
  </div>
</div>
<?php echo form_close(); ?>
<?php endforeach; ?>
<script>
  jQuery(document).ready(function() {
    $('form').parsley(); 
  });
</script> 