<?php
$requests    = $this->db->get_where('request', array('request_id' => $param2))->result_array();
foreach ($requests as $row) :
  ?>
  <?php echo form_open(base_url() . 'admin/request_manage/update/' . $param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>

  <h4 class="text-center"><?php echo trans('edit_request_information'); ?></h4>
  <hr>
  <div class="form-group">
    <label class="control-label"><?php echo trans('full_name'); ?></label>
    <input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control" placeholder="Enter user full name" />
  </div>
  <div class="form-group">
    <label class="control-label"><?php echo trans('email'); ?></label>
    <input type="text" name="email" value="<?php echo $row['email']; ?>" class="form-control" placeholder="Enter email" />
  </div>
  <div class="form-group">
    <label class="control-label"><?php echo trans('movie_name'); ?></label>
    <input type="text" name="movie_name" value="<?php echo $row['movie_name'];?>" class="form-control" placeholder="Enter login password" />
  </div>


  <div class="form-group">
    <label class="control-label"><?php echo trans('status'); ?></label>
    <select class="form-control" name="status" required>
      <option style="text-transform: capitalize;" value="pending" <?php if($row['status'] == "pending"): echo "pending";endif; ?>><?php echo trans('pending'); ?></option>
        <option style="text-transform: capitalize;" value="added" <?php if($row['status'] == "added"): echo "added";endif; ?>><?php echo trans('added'); ?></option>
        <option style="text-transform: capitalize;" value="cancelled" <?php if($row['status'] == "cancelled"): echo "cancelled";endif; ?>><?php echo trans('cancelled'); ?></option>
        <option style="text-transform: capitalize;" value="invalid" <?php if($row['status'] == "invalid"): echo "invalid";endif; ?>><?php echo trans('invalid'); ?></option>
        <option style="text-transform: capitalize;" value="spam" <?php if($row['status'] == "spam"): echo "spam";endif; ?>><?php echo trans('spam'); ?></option>
        <option style="text-transform: capitalize;" value="upcomming" <?php if($row['status'] == "upcomming"): echo "upcomming";endif; ?>><?php echo trans('upcomming'); ?></option>

    </select>
  </div>
<?php endforeach; ?>
<div class="form-group">
  <div class="col-sm-offset-3 col-sm-9 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?> </button>
    <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans('close'); ?> </button>
  </div>
</div>
</form>
<script>
  jQuery(document).ready(function() {
    $(".select2").select2();
    $('form').parsley();

  });
</script>