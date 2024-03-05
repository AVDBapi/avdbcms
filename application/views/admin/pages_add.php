<style type="text/css">
  .bootstrap-tagsinput .badge {
    ;
    background-color: #009688;
    border: 1px solid #035d54;
  }
</style>
<div class="card">
  <div class="row">
    <div class="col-sm-12"> <?php echo form_open(base_url() . 'admin/pages/add/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
      <h4 class="text-center"><?php echo trans('add_new_post') ?></h4>
      <hr>
      <div class="form-group">
        <label class=" control-label"><?php echo trans('page_title'); ?></label>
        <input type="text" name="page_title" id="title" class="form-control" required>
      </div>
      <div class="form-group">
        <label class="control-label"><?php echo trans('slug'); ?> (<?php echo base_url(); ?>)</label>
        <input type="text" id="slug" name="slug" class="form-control input-sm" required>
      </div>
      <div class="form-group">
        <label class="control-label"><?php echo trans('content'); ?></label>
        <textarea class="wysihtml5 form-control" name="content" id="content" rows="10"></textarea>
      </div>
      <div class="form-group">
        <label class="control-label"><?php echo trans('hook_to'); ?></label>
        <div class="animated-checkbox checkbox-inline">
          <label>
            <input type="checkbox" name='primary_menu' value="1"><span class="label-text"><?php echo trans('primary_menu'); ?> </span>
          </label>
        </div>
        <div class="animated-checkbox checkbox-inline">
          <label>
            <input type="checkbox" name='footer_menu' value="1"><span class="label-text"><?php echo trans('footer_menu'); ?> </span>
          </label>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label"><?php echo trans('publication'); ?></label>
        <select class="form-control m-bot15" name="publication">
          <option value="1"><?php echo trans('published'); ?></option>
          <option value="0"><?php echo trans('unpublished'); ?></option>
        </select>
      </div>
      <h4 class="text-center"><?php echo trans('seo_setting') ?></h4>
      <hr>
      <div class="form-group">
        <label class=" control-label"><?php echo trans('seo_title') ?></label>
        <input type="text" name="seo_title" id="title" class="form-control">
      </div>

      <div class="form-group">
        <label class=" control-label"><?php echo trans('focus_keyword'); ?></label>
        <input type="text" name="focus_keyword" id="focus_keyword" class="form-control">
        <br>
        <p><?php echo trans('use_comma_to_separate_keyword'); ?></p>
      </div>
      <div class="form-group">
        <label class="control-label"><?php echo trans('meta_description'); ?></label>
        <textarea class="wysihtml5 form-control" name="meta_description" id="meta_description" rows="5"></textarea>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9 m-t-15">
          <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('create'); ?> </button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script>

<!-- select2-->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<!-- select2-->



<!-- select2-->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<!-- select2-->

<!--form validation init-->
<script src="<?php echo base_url() ?>assets/plugins/summernote/dist/summernote.min.js"></script>
<script>
  jQuery(document).ready(function() {
    $('#content').summernote({
      height: 200, // set editor height
      minHeight: null, // set minimum height of editor
      maxHeight: null, // set maximum height of editor
      focus: false // set focus to editable area after initializing summernote
    });

    $('#stars').tagsinput();
    $('#focus_keyword').tagsinput();

    $("#title").keyup(function() {
      var Text = $(this).val();
      Text = Text.toLowerCase();
      Text = Text.replace(/[^\w ]+/g, '');
      Text = Text.replace(/ +/g, '-');
      $("#slug").val(Text);
    });


  });
</script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>