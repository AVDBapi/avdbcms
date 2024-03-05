<?php
$rest_logins    = $this->db->get_where('rest_logins', array('id' => $param2))->result_array();
foreach ($rest_logins as $row) :
  ?>
  <?php echo form_open(base_url() . 'admin/api_setting/update_authentication/' . $param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>

  <h4 class="text-center">Edit Authentication</h4>
  <hr>
  <div class="form-group">
    <label class="control-label">Username</label>
    <input type="text" name="username" value="<?php echo $row['username']; ?>" class="form-control" placeholder="Enter username" required />
  </div>
  <div class="form-group">
    <label class="control-label">Password</label>
    <input type="text" name="password" value="<?php echo $row['password']; ?>" class="form-control" placeholder="Enter password" required />
  </div>
<?php endforeach; ?>
<div class="form-group">
  <div class="col-sm-offset-3 col-sm-9 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"><span class="btn-label"><i class="fa fa-floppy-o"></i></span>Save </button>
    <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal">Close </button>
  </div>
</div>
</form>
<script>
  jQuery(document).ready(function() {
    $('form').parsley();
  });
</script>