<?php echo form_open(base_url() . 'admin/manage_star/add/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>

<h4 class="text-center"><?php echo trans('new_star_information'); ?></h4>
<hr>
<div class="form-group">
  <label class="control-label"><?php echo trans('star_type'); ?></label>
  <select class="form-control" name="star_type" required>
    <option value="actor"><?php echo trans('actor'); ?></option>
    <option value="director"><?php echo trans('director'); ?></option>
    <option value="writer"><?php echo trans('writer'); ?></option>
  </select>
</div>
<!-- end form -group -->
<div class="form-group">
  <label class="control-label"><?php echo trans('star_name'); ?></label>
  <input type="text" name="star_name" class="form-control" placeholder="Enter star full name" required />
</div>
<!-- end form -group -->

<div class="form-group">
  <label class="control-label"><?php echo trans('star_bio'); ?></label>
  <input type="text" name="star_desc" class="form-control" placeholder="Enter star information" />
</div>
<!-- end form -group -->

<div class="form-group">
  <label class="control-label col-sm-3"><?php echo trans('photo'); ?></label>
  <input type="file" name="photo" class="filestyle" data-input="false" accept="image/*">
</div>

<div class="form-group">
  <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('create'); ?> </button>
  <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans('close'); ?> </button>
</div>
</form>
<script>
  jQuery(document).ready(function() {
    $('form').parsley();

  });
</script>