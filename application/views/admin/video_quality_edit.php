<?php
  $qualitys    = $this->db->get_where('quality' , array('quality_id' => $param2) )->result_array();
  foreach ( $qualitys as $row):
?>

<?php echo form_open(base_url() . 'admin/video_quality/update/'.$param2 , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>

<h4 class="text-center"><?php echo trans('edit_video_type'); ?></h4>
<hr>
<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo trans('quality'); ?></label>
  <div class="col-sm-6">
    <input type="text"  name="quality" value="<?php echo $row['quality']; ?>" class="form-control" required />
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo trans('description'); ?></label>
  <div class="col-sm-6">
    <input type="text"  name="description"  value="<?php echo $row['description']; ?>" class="form-control"  />
  </div>
</div>

<div class="form-group">
  <div class="col-sm-offset-3 col-sm-9 m-t-15">
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