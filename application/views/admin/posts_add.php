<style type="text/css">
  .bootstrap-tagsinput .badge {
    ;
    background-color: #009688;
    border: 1px solid #035d54;
  }
</style>
<div class="card">
  <div class="row">
    <div class="col-sm-12">
      <?php echo form_open(base_url() . 'admin/posts/add/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
      <h4 class="text-center"><?php echo trans('add_new_post') ?></h4>
      <hr>
      <div class="form-group">
        <label class="control-label"><?php echo trans('post_title'); ?></label>
        <input type="text" name="post_title" id="title" class="form-control" required>
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
        <label class="control-label col-sm-3"><?php echo trans('thumbnail'); ?></label>
        <div class="profile-info-name text-center"> <img id="thumb_image" src="" class="img-thumbnail" alt=""> </div>
        <br>
        <div id="thumbnail_content">
          <input type="file" id="thumbnail_file" onchange="showImg(this);" name="thumbnail" class="filestyle" data-input="false" accept="image/*"></div><br>
        <p class="btn btn-white" id="thumb_link" href="#"><span class="btn-label"><i class="fa fa-link"></i></span><?php echo trans('link') ?></p>
        <p class="btn btn-white" id="thumb_file" href="#"><span class="btn-label"><i class="fa fa-file-o"></i></span><?php echo trans('file') ?></p>
      </div>


      <div class="form-group">
        <label class="control-label"><?php echo trans('category'); ?></label>
        <?php
        $categories = $this->db->get('post_category')->result_array();
        foreach ($categories as $category) : ?>
          <div class="animated-checkbox checkbox-inline">
            <label>
              <input type="checkbox" name='category_id[]' id="<?php echo $category['post_category_id']; ?>" value="<?php echo $category['post_category_id']; ?>" required><span class="label-text"><?php echo $category['category']; ?> </span>
            </label>
          </div>
        <?php endforeach; ?>
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
        <label class="control-label"><?php echo trans('seo_title') ?></label>
        <input type="text" name="seo_title" id="title" class="form-control">
      </div>
      <div class="form-group">
        <label class="control-label"><?php echo trans('focus_keyword'); ?></label>
        <input type="text" name="focus_keyword" id="focus_keyword" class="form-control">
        <br>
        <p><?php echo trans('use_comma_to_separate_keyword') ?></p>
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
    </div>
  </div>
</div>
</div>
<?php echo form_close(); ?>

<script>
  jQuery(document).ready(function() {
    $(".select2").select2();
    $('form').parsley();

  });
</script>
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
  });
</script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<!-- file select-->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>
<!-- file select-->
<script>
  jQuery(document).ready(function() {
    $('#thumb_link').click(function() {
      $('#thumbnail_content').html('<input type="text" name="thumb_link" class="form-control">');
    });

    $('#thumb_file').click(function() {
      $('#thumbnail_content').html('<input type="file" id="thumbnail_file" onchange="showImg(this);" name="thumbnail" class="filestyle" data-input="false" accept="image/*"></div>');
    });
    $('#description').summernote({
      height: 200, // set editor height
      minHeight: null, // set minimum height of editor
      maxHeight: null, // set maximum height of editor
      focus: false // set focus to editable area after initializing summernote
    });
  });
</script>

<script>
  $("#title").keyup(function() {
    var Text = $(this).val();
    Text = Text.toLowerCase();
    Text = Text.replace(/[^\w ]+/g, '');
    Text = Text.replace(/ +/g, '-');
    $("#slug").val(Text);
  });
</script>

<!--instant image dispaly-->
<script type="text/javascript">
  function showImg(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#thumb_image')
          .attr('src', e.target.result)
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
<!--end instant image dispaly-->