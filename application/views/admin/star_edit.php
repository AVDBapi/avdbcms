<?php
$stars    = $this->db->get_where('star', array('star_id' => $param2))->result_array();
foreach ($stars as $row) :
  ?>
  <?php echo form_open(base_url() . 'admin/manage_star/update/' . $param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>

  <h4 class="text-center"><?php echo trans('edit_star_information'); ?></h4>
  <hr>
  <div class="form-group">
    <label class="control-label"><?php echo trans('star_type'); ?></label>
    <select class="form-control" name="star_type" required>
      <option value="actor" <?php if ($row['star_type'] == 'actor') {
                                echo 'selected';
                              } ?>><?php echo trans('actor'); ?></option>
      <option value="director" <?php if ($row['star_type'] == 'director') {
                                    echo 'selected';
                                  } ?>><?php echo trans('director'); ?></option>
      <option value="writer" <?php if ($row['star_type'] == 'writer') {
                                  echo 'selected';
                                } ?>><?php echo trans('writer'); ?></option>
    </select>
  </div>
  <div class="form-group">
    <label class="control-label"><?php echo trans('star_name'); ?></label>
    <input type="text" name="star_name" value="<?php echo $row['star_name']; ?>" class="form-control" placeholder="Enter star full name" required />
  </div>

  <div class="form-group">
    <label class="control-label"><?php echo trans('star_bio'); ?></label>
    <input type="text" name="star_desc" value="<?php echo $row['star_desc']; ?>" class="form-control" placeholder="Enter star information" />
  </div>

  <div class="form-group">
    <label class="control-label"><?php echo trans('photo'); ?></label>
    <input type="file" name="photo" class="filestyle" data-input="false" accept="image/*">
  </div>

  <div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
      <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-flopy-o"></i></span><?php echo trans('save_changes'); ?></button>
      <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans('close'); ?> </button>
    </div>
    <!-- End col-6 -->
  </div>
  <!-- end form -group -->
  </form>
<?php endforeach; ?>
<script>
  jQuery(document).ready(function() {
    $('form').parsley();
  });
</script>