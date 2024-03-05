<div class="card">
  <div class="row">
    <div class="col-sm-6">
      <?php echo form_open(base_url() . 'admin/video_type/add/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
        <h4 class="text-center panel-title"><?php echo trans('add_new_video_type'); ?></h4>
        <hr>
        <div class="form-group">
          <label class="col-sm-3 control-label"><?php echo trans('video_type'); ?></label>
          <div class="col-sm-6">
            <input type="text"  name="video_type" class="form-control" required />
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-sm-3 control-label"><?php echo trans('description'); ?></label>
          <div class="col-sm-6">
            <input type="text"  name="video_type_desc"  class="form-control"  />
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3"><?php echo trans('primary_menu'); ?></label>
          <div class="col-sm-8">              
            <div class="animated-checkbox checkbox-inline">
              <label>
                <input type="checkbox" name='primary_menu' value="1"  ><span class="label-text"></span>
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="control-label col-md-3"><?php echo trans('footer_menu'); ?></label>
          <div class="col-sm-8">              
            <div class="animated-checkbox checkbox-inline">
              <label>
                <input type="checkbox" name='footer_menu' value="1"  ><span class="label-text"></span>
              </label>
            </div>
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
      <h4 class="text-center panel-title">Video Type List</h4>
        <hr>
        <table id="datatable-buttons" class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th><?php echo trans('video_type'); ?></th>
              <th><?php echo trans('description'); ?></th>
              <th><?php echo trans('menu_bar'); ?></th>
              <th><?php echo trans('footer'); ?></th>
              <th>_<?php echo trans('option'); ?>_</th>
            </tr>
          </thead>
          <tbody>
            <?php $sl = 1;
                  foreach ($video_types as $video_type):              

            ?>
            <tr id='row_<?php echo $video_type['video_type_id'];?>'>
              <td><?php echo $sl++;?></td>
              <td><strong><?php echo $video_type['video_type'];?></strong></td>
              <td><?php echo $video_type['video_type_desc'];?></td>
              <td><?php if($video_type['primary_menu']=='1'){ echo "Yes";}else{ echo "No";} ?></td>
              <td><?php if($video_type['footer_menu']=='1'){ echo "Yes";}else{ echo "No";} ?></td>
              <td>
                <div class="btn-group m-b-20"> <a data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/video_type_edit/'. $video_type['video_type_id'];?>" id="menu" title="<?php echo trans('edit'); ?>" class="btn btn-sm btn-icon"><i class="fa fa-pencil"></i></a> <a title="<?php echo trans('delete'); ?>" class="btn btn-sm btn-icon" onclick="delete_row(<?php echo " 'video_type' ".','.$video_type['video_type_id'];?>)" class="delete"><i class="fa fa-remove"></i></a> </div>
              </td>
            </tr>
            <?php endforeach;?>
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
