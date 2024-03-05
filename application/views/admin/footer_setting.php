<div class="card">
  <?php echo form_open(base_url() . 'admin/footer_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
  <div class="row"> 
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('footer_setting'); ?></h3>
        </div>
        <div class="panel-body"> 
          <!-- panel  -->
          
          <div class="form-group row">
            <label class=" col-sm-3 control-label"><?php echo trans('Footer_1_title'); ?></label>
            <div class="col-sm-8">
              <input type="text" name="footer1_title" class="form-control" value="<?php echo $this->db->get_where('config' , array('title' =>'footer1_title'))->row()->value;?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-3"><?php echo trans('footer_1_content'); ?></label>
            <div class="col-md-8">
              <textarea class="wysihtml5 form-control" name="footer1_content" id="footer-1" rows="10"><?php echo $this->db->get_where('config' , array('title' =>'footer1_content'))->row()->value;?></textarea>
            </div>
          </div>
          <div class="form-group row">
            <label class=" col-sm-3 control-label"><?php echo trans('Footer_2_title'); ?></label>
            <div class="col-sm-8">
              <input type="text" name="footer2_title" class="form-control" value="<?php echo $this->db->get_where('config' , array('title' =>'footer2_title'))->row()->value;?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-3"><?php echo trans('footer_2_content'); ?></label>
            <div class="col-md-8">
              <textarea class="wysihtml5 form-control" name="footer2_content" id="footer-2" rows="10"><?php echo $this->db->get_where('config' , array('title' =>'footer2_content'))->row()->value;?></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class=" col-sm-3 control-label"><?php echo trans('Footer_3_title'); ?></label>
            <div class="col-sm-8">
              <input type="text" name="footer3_title" class="form-control" value="<?php echo $this->db->get_where('config' , array('title' =>'footer3_title'))->row()->value;?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-3"><?php echo trans('footer_3_content'); ?></label>
            <div class="col-md-8">
              <textarea class="wysihtml5 form-control" name="footer3_content" id="footer-3" rows="10"><?php echo $this->db->get_where('config' , array('title' =>'footer3_content'))->row()->value;?></textarea>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-3"><?php echo trans('copyright_text'); ?></label>
            <div class="col-md-8">
              <textarea class="wysihtml5 form-control" name="copyright_text" id="copyright_text" rows="10"><?php echo $this->db->get_where('config' , array('title' =>'copyright_text'))->row()->value;?></textarea>
            </div>
          </div>              


          <div class="col-sm-offset-3 col-sm-9 m-t-15">
            <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?> </button>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- file select-->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>
<!-- file select-->

<!--form validation init-->
<script src="<?php echo base_url() ?>assets/plugins/summernote/dist/summernote.min.js"></script>
<script>
    jQuery(document).ready(function() {

        $('#footer-1').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
        $('#footer-2').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
        $('#footer-3').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
        $('#copyright_text').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

    });

</script>
