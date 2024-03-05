<?php $video_source = ovoo_config('video_source');?>
<style>
.tab-content {
    margin-left: 10px;
    margin-right: 10px;
    margin-top: 10px;
}
</style>
<div class="card">
  <div class="row justify-content-md-center">
    <div class="col-md-6">
      <a class="btn btn-sm btn-primary waves-effect mb-20" href="<?php echo base_url('admin/seasons_manage/') . $episode_info->videos_id; ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span><?php echo trans('back_to_seasons'); ?></a>
      <a class="btn btn-sm btn-primary waves-effect mb-20" href="<?php echo base_url('admin/episodes_manage/') . $episode_info->videos_id.'/'.$episode_info->seasons_id; ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span><?php echo trans('back_to_episodes'); ?></a>
<br><br>
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('edit_episode') ?></h3>
        </div>
        <div class="panel-body">
            <?php echo form_open_multipart(base_url('admin/episodes_update/'.$episode_info->episodes_id)); ?>           
              <input type="hidden" name="videos_id" value="<?php echo $episode_info->videos_id; ?>">
              <input type="hidden" name="seasons_id" value="<?php echo $episode_info->seasons_id; ?>">
              <div class="form-group">
                <label class="control-label"><?php echo trans('episodes_name') ?></label>&nbsp;&nbsp;<input id="episodes_name" type="text" value="<?php echo $episode_info->episodes_name; ?>" name="episodes_name" class="form-control" placeholder="Episode-1" required="">
              </div>
              <div class="form-group">
                <label class="control-label"><?php echo trans('order'); ?></label>
                <input type="number" name="order" class="form-control" value="<?php echo $episode_info->order; ?>" placeholder="0 to 9999" required>
              </div>
              <div class="form-group">
                <label class="control-label"><?php echo trans('select_thumb'); ?></label><br>
                <img class="img img-thumbnail" src="<?php echo $this->common_model->get_episode_image_url($episode_info->videos_id,$episode_info->episodes_id).'?'.time(); ?>" alt="<?php echo $episode_info->episodes_name; ?>" width="150"><br>
                  <input class="imageselect" name="thumbnail" type="file" accept="image/*" />
              </div>
              <div class="form-group">
                <label class="control-label"><?php echo trans('source'); ?></label>
                <select class="form-control" name="source" id="selected-source">
                  <option value="upload" <?php if($video_source =='upload' || $episode_info->file_source =='upload'): echo 'selected'; endif;?>><?php echo trans('upload');?></option>
                  <option value="youtube" <?php if($video_source =='youtube' || $episode_info->file_source =='youtube'): echo 'selected'; endif;?>><?php echo trans('youtube');?></option>
                  <option value="vimeo" <?php if($video_source =='vimeo' || $episode_info->file_source =='vimeo'): echo 'selected'; endif;?>><?php echo trans('video');?></option>
                  <option value="embed" <?php if($video_source ==''): echo 'selected'; endif;?>><?php echo trans('google_drive');?></option>
                  <option value="amazone" <?php if($video_source =='amazone' || $episode_info->file_source =='amazone'): echo 'selected'; endif;?>><?php echo trans('amazone_s3');?></option>
                  <option value="mp4" <?php if($video_source =='mp4' || $episode_info->file_source =='mp4'): echo 'selected'; endif;?>><?php echo trans('mp4_from_url');?></option>
                  <option value="webm" <?php if($video_source =='webm' || $episode_info->file_source =='webm'): echo 'selected'; endif;?>><?php echo trans('webm_from_url');?></option>
                  <option value="m3u8" <?php if($video_source =='m3u8' || $episode_info->file_source =='m3u8'): echo 'selected'; endif;?>><?php echo trans('m3u8_from_url');?></option>
                  <option value="embed" <?php if($video_source =='embed' || $episode_info->file_source =='embed'): echo 'selected'; endif;?>><?php echo trans('embed_url');?></option>
                </select>
              </div>
              <div class="form-group" <?php if($video_source =='upload'): echo 'style="display:none;"'; endif;?> id="url-input">
                <label class="control-label"><?php echo trans('url') ?></label>
                <input type="text" name="url" id="url-input-field" class="form-control" value="<?php echo $episode_info->file_url; ?>" placeholder="http://server-2.com/movies/titalic.mp4" <?php if($video_source !='upload'): echo 'required'; endif;?> ><br>
              </div>
              <div class="form-group" <?php if($video_source !='upload'): echo 'style="display:none;"'; endif;?> id="image-input">
                <label class="control-label"><?php echo trans('select_video'); ?></label>
                <input class="videoselect" name="videofile" id="image-input-field" type="file" accept="video/*" <?php if($video_source =='upload'): echo 'required'; endif;?> />
              </div>
              <div class="form-group">
                <button class="btn btn-sm btn-primary waves-effect" type="submit"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('save_changes') ?> </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
    <script>
      jQuery(document).ready(function() {
          $('form').parsley();
          $(".imageselect").filestyle({
              input: true,
              icon: true,
              buttonBefore: true,
              text: "<?php echo trans('select_image'); ?>",
              htmlIcon: '<span class="fa fa-file-image-o"></span>',
              badge: true,
              badgeName: "badge-danger"
          });
          $(".videoselect").filestyle({
              input: true,
              icon: true,
              buttonBefore: true,
              text: "<?php echo trans('select_video'); ?>",
              htmlIcon: '<span class="fa fa-file-video-o"></span>',
              badge: true,
              badgeName: "badge-danger"
          });

          $( "#selected-source" ).change(function() {
             var source = $("#selected-source option:selected" ).val();
             if(source == 'upload'){
               $("#image-input").show('slow');
               $("#url-input").hide('slow');
               $("#image-input-field").attr("required", true);
               $("#url-input-field").attr("required", false);
             }else{
               $("#image-input").hide('slow');
               $("#url-input").show('slow');
               $("#image-input-field").attr("required", false);
               $("#url-input-field").attr("required", true);
             }
          });
      });
    </script>