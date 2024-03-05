<?php
$seasons    = $this->db->get_where('seasons', array('seasons_id' => $param2))->result_array();
foreach ($seasons as $row) :
  ?>
  <?php echo form_open(base_url() . 'admin/seasons_manage/update/' . $param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>

  <h4 class="text-center"><?php echo trans('edit_seasons_information'); ?></h4>
  <hr>
  <div class="form-group row">
    <label class="control-label"><?php echo trans('seasons_name'); ?></label>
    <input type="text" name="seasons_name" value="<?php echo $row['seasons_name']; ?>" class="form-control" placeholder="Enter user full name" required />
  </div>

  <div class="form-group row">
    <label class="control-label"><?php echo trans('order'); ?></label>
    <input type="text" name="order" value="<?php echo $row['order']; ?>" class="form-control" required />
  </div>

  <input type="hidden" name="videos_id" value="<?php echo $row['videos_id']; ?>">

<?php endforeach; ?>
<div class="form-group row">
  <div class="col-sm-offset-3 col-sm-6 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('create'); ?></button>
    <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans('close'); ?> </button>
  </div>
  <!-- End col-6 -->
</div>
<!-- end form -group -->
</form>
<script>
  jQuery(document).ready(function() {
    $('form').parsley();

  });
</script>