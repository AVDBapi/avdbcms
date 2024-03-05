<div class="card">
  <div class="row">
    <div class="col-sm-6"><?php echo form_open(base_url() . 'admin/post_category/add/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
      <h4 class="text-center"><?php echo trans('add_new_post_category'); ?></h4>
      <hr>
      <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo trans('category_name'); ?></label>
        <div class="col-sm-6">
          <input type="text" name="category" class="form-control" required />
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo trans('description'); ?></label>
        <div class="col-sm-6">
          <input type="text" name="category_desc" class="form-control" />
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9 m-t-15">
          <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('add') ?> </button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
    <div class="col-sm-6">
      <h4 class="text-center"><?php echo trans('post_category_list'); ?></h4>
      <hr>
      <table id="datatable-buttons" class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th><?php echo trans('category'); ?></th>
            <th><?php echo trans('description'); ?></th>
            <th><?php echo trans('option'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php $sl = 1;
          foreach ($post_categories as $post_category) :

            ?>
            <tr id='row_<?php echo $post_category['post_category_id']; ?>'>
              <td><?php echo $sl++; ?></td>
              <td><strong><?php echo $post_category['category']; ?></strong></td>
              <td><?php echo $post_category['category_desc']; ?></td>
              <td>
                <div class="btn-group m-b-20"> <a data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/post_category_edit/' . $post_category['post_category_id']; ?>" id="menu" title="<?php echo trans('edit'); ?>" class="btn btn-icon"><i class="fa fa-pencil"></i></a> <a title="<?php echo trans('delete'); ?>" class="btn btn-icon" onclick="delete_row(<?php echo "'post_category'" . ',' . $post_category['post_category_id']; ?>)" class="delete"><i class="fa fa-remove"></i></a> </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script>

<!-- select2-->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<!-- select2-->