<?php
    $post_categories    = $this->db->get_where('post_category' , array('post_category_id' => $param2) )->result_array();
    foreach ( $post_categories as $row):
?>

<?php echo form_open(base_url() . 'admin/post_category/update/'.$param2 , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>

<h4 class="text-center"><?php echo trans('edit_post_category'); ?></h4>
<hr>
<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo trans('category_name'); ?></label>
  <div class="col-sm-6">
    <input type="text"  name="category" value="<?php echo $row['category']; ?>" class="form-control" required />
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label"><?php echo trans('description'); ?></label>
  <div class="col-sm-6">
    <input type="text"  name="category_desc"  value="<?php echo $row['category_desc']; ?>" class="form-control"  />
  </div>
</div>

<div class="form-group">
  <div class="col-sm-offset-3 col-sm-9 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save') ?> </button>    
  </div>
</div>
</form>
<?php endforeach; ?>
<script>
        jQuery(document).ready(function() {
          $('form').parsley();                            

          });
</script> 