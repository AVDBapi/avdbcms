<?php 
    $theme_dir                      =   'theme/'.ovoo_config('active_theme').'/';
    $assets_dir                     =   'assets/theme/'.ovoo_config('active_theme').'/';

    $homepage_sections   = $this->db->get_where('homepage_sections', array('id' => $param2))->result_array();

    foreach ($homepage_sections as $row) :

    echo form_open(base_url() . 'admin/section/update/'. $param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); 
?>

<h4 class="text-center"><?php echo trans('new_section_add'); ?></h4>
<hr>
<div class="form-group">
    <label class=" col-sm-3 control-label"><?php echo trans('title'); ?></label>
    <div class="col-sm-12">
        <input type="text" name="title" class="form-control" required value="<?php echo $row['title']; ?>">
    </div>
</div>

<div class="form-group">
    <label class="control-label col-md-6"><?php echo trans('content_type'); ?></label>
    <div class="col-sm-12">
        <select class="form-control m-bot15" name="content_type" id="content_type">
            <option value="live_tv_list" <?php echo $row['content_type'] == 'live_tv_list'? 'selected':''; ?>><?php echo trans('live_tv'); ?></option>
            <option value="popular_actors" <?php echo $row['content_type'] == 'popular_actors'? 'selected':''; ?>><?php echo trans('popular_actors'); ?></option>
            <option value="latest_episodes" <?php echo $row['content_type'] == 'latest_episodes'? 'selected':''; ?>><?php echo trans('latest_episodes'); ?></option>
            <option value="latest_movies" <?php echo $row['content_type'] == 'latest_movies'? 'selected':''; ?>><?php echo trans('latest_movies'); ?></option>
            <option value="latest_tvseries" <?php echo $row['content_type'] == 'latest_tvseries'? 'selected':''; ?>><?php echo trans('latest_tvseries'); ?></option>
            <option value="popular_movies" <?php echo $row['content_type'] == 'popular_movies'? 'selected':''; ?>><?php echo trans('popular_movies'); ?></option>
            <option value="popular_tv_series" <?php echo $row['content_type'] == 'popular_tv_series'? 'selected':''; ?>><?php echo trans('popular_tv_series'); ?></option>
            <option value="genre" <?php echo $row['content_type'] == 'genre'? 'selected':''; ?>><?php echo trans('genre'); ?></option>
        </select>
    </div>
</div>

<div class="form-group <?php echo $row['content_type'] != 'genre'? 'd-none':''; ?>" id="genre-area">
    <label class="control-label col-md-6"><?php echo trans('genre'); ?></label>
    <div class="col-sm-12">
        <select class="form-control m-bot15" name="genre">
            <?php
                foreach($genres as $genre):
            ?>
            <option value="<?php echo $genre['genre_id']; ?>"><?php echo $genre['name']; ?></option>
            <?php
                endforeach;
            ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class=" col-sm-3 control-label"><?php echo trans('order'); ?></label>
    <div class="col-sm-12">
        <input type="number" name="order" class="form-control" required value="<?php echo $row['order']; ?>">
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
        <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('update'); ?> </button>
        <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans('close'); ?> </button>
    </div>
</div>
</form>

<?php endforeach; ?>
<script>
    jQuery(document).ready(function() {
        $('form').parsley();
    });

    jQuery(document).ready(function(){
        $('#content_type').on('change', function(){

            if($(this).val() == "genre"){
                $("#genre-area").removeClass('d-none');
            }else{
                $("#genre-area").addClass('d-none');
            }
        });
    });
</script>
<script>
  jQuery(document).ready(function(){
    $('#thumb_link').click(function(){
      $('#thumbnail_content').html('<input type="text" name="image_link" class="form-control">');
    });

    $('#thumb_file').click(function(){
      $('#thumbnail_content').html('<input type="file" id="thumbnail_file" onchange="showImg(this);" name="image" class="filestyle" data-input="false" accept="image/*"></div>');
    });

  });
</script>

<!--instant image display--> 
<script type="text/javascript">
 function showImg(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#thumb_image')
                .attr('src', e.target.result)                        
        };
        reader.readAsDataURL(input.files[0]);
      }
  }
</script> 
<!--end instant image display--> 