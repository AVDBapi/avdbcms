<style type="text/css">
  span.select2.select2-container.select2-container--default.select2-container--below,span.select2.select2-container.select2-container--default.select2-container--focus,span.select2.select2-container.select2-container--default.select2-container--open,span.select2.select2-container.select2-container--default {
      width: 100% !important;
  }
</style>

<?php 
$sliders   = $this->db->get_where('slider' , array('slider_id' => $param2) )->result_array();
foreach ( $sliders as $row):
?>
<?php echo form_open(base_url() . 'admin/slider/update/'.$param2 , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>

<h4 class="text-center">Slider Edit</h4>
<hr>

<div class="form-group">
    <label class=" col-sm-3 control-label">Title</label>
    <div class="col-sm-12">
        <input type="text" name="title" value="<?php echo $row['title'];?>" class="form-control" required>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-3">Description</label>
    <div class="col-sm-12">
        <textarea class="wysihtml5 form-control" name="description" rows="10"><?php echo $row['description'];?></textarea>
    </div>
</div>

<div class="form-group">
  <label class="control-label col-md-12">Sort Order</label>
  <div class="col-sm-12">
      <input type="number" name="order" value="<?php echo $row['order'];?>" class="form-control" required>
  </div>
</div>

<div class="form-group">
    <label class="control-label col-sm-3">Image</label>
    <div class="col-sm-12">
        <div class="profile-info-name text-center"> <img id="thumb_image" src="<?php echo $row['image_link'];?>" class="img-thumbnail" alt=""> </div>
        <br>
        <div id="thumbnail_content">
            <input type="file" id="thumbnail_file" onchange="showImg(this);" name="image" class="filestyle" data-input="false" accept="image/*"></div><br>
        <p class="btn btn-white" id="thumb_link" href="#"><span class="btn-label"><i class="fa fa-link"></i></span>
           Link
        </p>
        <p class="btn btn-white" id="thumb_file" href="#"><span class="btn-label"><i class="fa fa-file-o"></i></span>
            File
        </p>
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-12" >Action Type</label>
    <div class="col-sm-12">
        <select class="form-control m-bot15" name="action_type" id="action_type">
          <option value="movie" <?php if($row['action_type']=='movie'): echo "selected"; endif; ?>>Play Movie</option>
          <option value="tvseries" <?php if($row['action_type']=='tvseries'): echo "selected"; endif; ?>>Play TVSeries</option>
          <option value="tv" <?php if($row['action_type']=='tv'): echo "selected"; endif; ?>>Watch TV Channel</option>
          <option value="external_browser" <?php if($row['action_type']=='external_browser'): echo "selected"; endif; ?>>Open URL by External Browser</option>
          <option value="webview" <?php if($row['action_type']=='webview'): echo "selected"; endif; ?>>Open WebView URL</option>
        </select>
    </div>
</div>

<div class="form-group" id="movie" <?php if($row['action_type'] !='movie'): echo 'style="display: none;"'; endif; ?> >
  <label class="control-label col-md-12">Movie</label>
  <div class="col-sm-12">
    <select class="form-control" name="movie_id" id="select_movie">
        <?php if($row['action_id'] !='' && $row['action_id'] !=NULL &&  $row['action_type'] =='movie'): ?>
            <option value="<?php echo $row['action_id']; ?>" selected>
                <?php echo $this->common_model->get_title_by_videos_id($row['action_id']); ?>
            </option>
        <?php endif; ?>
    </select>
  </div>
</div>

<div class="form-group" id="tvseries" <?php if($row['action_type'] !='tvseries'): echo 'style="display: none;"'; endif; ?>>
  <label class="control-label col-md-12">TVSeries</label>
  <div class="col-sm-12">
    <select class="form-control" name="tvseries_id" id="select_tvseries">
        <?php if($row['action_id'] !='' && $row['action_id'] !=NULL && $row['action_type'] =='tvseries'): ?>
            <option value="<?php echo $row['action_id']; ?>" selected>
                <?php echo $this->common_model->get_title_by_videos_id($row['action_id']); ?>
            </option>
        <?php endif; ?>
    </select>
  </div>
</div>

<div class="form-group" id="tv" <?php if($row['action_type'] !='tv'): echo 'style="display: none;"'; endif; ?>>
  <label class="control-label col-md-12">TV Channel</label>
  <div class="col-sm-12">
    <select class="form-control" name="tv_id" id="select_tv">
        <?php if($row['action_id'] !='' && $row['action_id'] !=NULL && $row['action_type'] =='tv'): ?>
            <option value="<?php echo $row['action_id']; ?>" selected>
                <?php echo $this->live_tv_model->get_live_tv_title_by_id($row['action_id']); ?>
            </option>
        <?php endif; ?>
    </select>
  </div>
</div>
<div id="url" <?php if($row['action_type'] !='external_browser' && $row['action_type'] !='webview'): echo 'style="display: none;"'; endif; ?>>
  <div class="form-group">
    <label class=" col-sm-12 control-label">URL</label>
    <div class="col-sm-12">
        <input type="url" name="action_url" value="<?php echo $row['action_url'];?>" class="form-control">
    </div>
  </div>
</div>

<div class="form-group">
  <label class=" col-sm-12 control-label">Action Buton Text</label>
  <div class="col-sm-12">
      <input type="text" name="action_btn_text" value="<?php echo $row['action_btn_text'];?>" class="form-control" required>
  </div>
</div>






<div class="form-group">
    <label class="control-label col-md-3">Publication</label>
    <div class="col-sm-12">
        <select class="form-control m-bot15" name="publication">
            <option value="1"  <?php if($row['publication']=='1'){echo 'selected';} ?>>Published</option>
            <option value="0"  <?php if($row['publication']=='0'){echo 'selected';} ?>>Unpublished</option>
        </select>
    </div>
</div>
<?php endforeach; ?>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
        <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-floppy-o"></i></span>SAVE </button>
        <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal">CLOSE </button>
    </div>
</div>
</form>
<script>
  jQuery(document).ready(function() {
    $('#action_type').on('change', function() {
      if( this.value == 'movie'){
        $("#movie").show();
        $("#tvseries").hide();
        $("#tv").hide();
        $("#url").hide();
      }else if(this.value == 'tvseries'){
        $("#movie").hide();
        $("#tvseries").show();
        $("#tv").hide();
        $("#url").hide();
      }else if(this.value == 'tv'){
        $("#movie").hide();
        $("#tvseries").hide();
        $("#tv").show();
        $("#url").hide();
      }else if(this.value == 'external_browser' || this.value == 'webview'){
        $("#movie").hide();
        $("#tvseries").hide();
        $("#tv").hide();
        $("#url").show();
      }
    });

    $('form').parsley(); 
  });
</script>
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<script type="text/javascript">
  $('#select_movie').select2({
    placeholder: 'Select Movie',
    minimumInputLength: 2,
    ajax: {
      url: '<?=base_url('admin/load_movie')?>',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
</script>

<script type="text/javascript">
  $('#select_tvseries').select2({
    placeholder: 'Select TVSeries',
    minimumInputLength: 2,
    ajax: {
      url: '<?=base_url('admin/load_tvseries')?>',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
</script>

<script type="text/javascript">
  $('#select_tv').select2({
    placeholder: 'Select TV Channel',
    minimumInputLength: 2,
    ajax: {
      url: '<?=base_url('admin/get_live_tv_by_search_title')?>',
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
        return {
          results: data
        };
      },
      cache: true
    }
  });
</script>

<script>
jQuery(document).ready(function() {
    $('#thumb_link').click(function() {
        $('#thumbnail_content').html('<input type="text" name="image_link" value="<?php echo $row['image_link'];?>" class="form-control">');
    });

    $('#thumb_file').click(function() {
        $('#thumbnail_content').html('<input type="file" id="thumbnail_file" onchange="showImg(this);" name="image" class="filestyle" data-input="false" accept="image/*"></div>');
    });

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