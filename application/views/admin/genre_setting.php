<?php $genre_to_primary_menu           =   $this->db->get_where('config', array('title' => 'genre_to_primary_menu'))->row()->value; ?>
<?php echo form_open(base_url() . 'admin/genre_setting/update/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<div class="card">
  <div class="row">
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('genre_setting'); ?></h3>
        </div>
        <div class="panel-body">
          <!-- panel  -->
          <div class="form-group">
            <label class="control-label col-sm-3 "><?php echo trans('add_to_primary_menu'); ?></label>
            <div class="col-sm-6">
              <div class="toggle">
                <label>
                  <input type="checkbox" name="genre_to_primary_menu" <?php if ($genre_to_primary_menu == '1') {
                                                                        echo 'checked';
                                                                      } ?>><span class="button-indecator"></span>
                </label>
              </div>
            </div>
          </div>

          <div class="col-sm-offset-3 col-sm-9 m-t-15">
            <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?></button>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script>