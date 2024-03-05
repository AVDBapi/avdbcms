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
      <a class="btn btn-sm btn-primary waves-effect mb-20" href="<?php echo base_url('admin/seasons_manage/') . $param1; ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span><?php echo trans('back_to_seasons'); ?></a>
      <a class="btn btn-sm btn-primary waves-effect mb-20" href="<?php echo base_url('watch/') . $slug; ?>" target="_blank"> <span class="btn-label"><i class="fa fa-eye"></i></span><?php echo trans('preview'); ?></a><br><br>

      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('add_video') ?></h3>
        </div>
        <div class="panel-body">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab"><?php echo trans('add_video');?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab"><?php echo trans('bulk_tool');?></a>
          </li>
        </ul><!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane active" id="tabs-1" role="tabpanel">
            <?php echo form_open_multipart(base_url('admin/episodes_upload')); ?>           
              <input type="hidden" name="videos_id" value="<?php echo $param1; ?>">
              <input type="hidden" name="seasons_id" value="<?php echo $param2; ?>">
              <div class="form-group">
                <label class="control-label"><?php echo trans('episodes_name') ?></label>&nbsp;&nbsp;<input id="episodes_name" type="text" name="episodes_name" class="form-control" placeholder="Episode-1" required="">
              </div>
              <div class="form-group">
                <label class="control-label"><?php echo trans('order'); ?></label>
                <input type="number" name="order" class="form-control" placeholder="0 to 9999" required>
              </div>
              <div class="form-group">
                <label class="control-label"><?php echo trans('select_thumb'); ?></label>
                  <input class="imageselect" name="thumbnail" type="file" accept="image/*" />
              </div>
              <div class="form-group">
                <label class="control-label"><?php echo trans('source'); ?></label>
                <select class="form-control" name="source" id="selected-source">
                  <option value="upload" <?php if($video_source =='upload'): echo 'selected'; endif;?>><?php echo trans('upload');?></option>
                  <option value="youtube" <?php if($video_source =='youtube'): echo 'selected'; endif;?>><?php echo trans('youtube');?></option>
                  <option value="vimeo" <?php if($video_source =='vimeo'): echo 'selected'; endif;?>><?php echo trans('video');?></option>
                  <option value="embed" <?php if($video_source ==''): echo 'selected'; endif;?>><?php echo trans('google_drive');?></option>
                  <option value="amazone" <?php if($video_source =='amazone'): echo 'selected'; endif;?>><?php echo trans('amazone_s3');?></option>
                  <option value="mp4" <?php if($video_source =='mp4'): echo 'selected'; endif;?>><?php echo trans('mp4_from_url');?></option>
                  <option value="mkv" <?php if($video_source =='mkv'): echo 'selected'; endif;?>><?php echo trans('mkv_from_url');?></option>
                  <option value="webm" <?php if($video_source =='webm'): echo 'selected'; endif;?>><?php echo trans('webm_from_url');?></option>
                  <option value="m3u8" <?php if($video_source =='m3u8'): echo 'selected'; endif;?>><?php echo trans('m3u8_from_url');?></option>
                  <option value="embed" <?php if($video_source =='embed'): echo 'selected'; endif;?>><?php echo trans('embed_url');?></option>
                </select>
              </div>
              <div class="form-group" <?php if($video_source =='upload'): echo 'style="display:none;"'; endif;?> id="url-input">
                <label class="control-label"><?php echo trans('url') ?></label>
                <input type="text" name="url" id="url-input-field" value="" class="form-control" placeholder="http://server-2.com/movies/titalic.mp4" <?php if($video_source !='upload'): echo 'required'; endif;?> ><br>
              </div>
              <div class="form-group" <?php if($video_source !='upload'): echo 'style="display:none;"'; endif;?> id="image-input">
                <label class="control-label"><?php echo trans('select_video'); ?></label>
                <input class="videoselect" name="videofile" id="image-input-field" type="file" accept="video/*" <?php if($video_source =='upload'): echo 'required'; endif;?> />
              </div>
              <div class="form-group">
                <button class="btn btn-sm btn-primary waves-effect" type="submit"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('add') ?> </button>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="tabs-3" role="tabpanel">
            <p>Upcoming..</p>
          </div>
        </div>
      </div>
    </div></div></div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-border panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo trans('episodes_list') ?></h3>
            </div>
            <div class="panel-body">
              <?php echo form_open(base_url() . 'admin/episodes_manage/change_order/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
              <input type="hidden" name="videos_id" value="<?php echo $param1; ?>">
              <table class="table table-bordered" id="video-list">
                <thead>
                  <tr>
                  <th><?php echo trans('thumbnail') ?></th>
                    <th><?php echo trans('episodes_name') ?></th>
                    <th><?php echo trans('source') ?></th>
                    <th><?php echo trans('order') ?></th>
                    <th><?php echo trans('url') ?></th>
                    <th><?php echo trans('subtitle') ?></th>
                    <th><?php echo trans('action') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $episodes = $this->common_model->get_episodes_by_videos_id_and_season_id($param1,$param2);
                    foreach ($episodes as $video_file) :
                    ?>
                    <tr id="row_<?php echo $video_file['episodes_id']; ?>">
                    <td><img src="<?php echo $this->common_model->get_episode_image_url($param1,$video_file['episodes_id']); ?>" alt="<?php echo $video_file['episodes_name']; ?>" width="80"></td>
                      <td><strong><?php echo $video_file['episodes_name']; ?></strong></td>
                      <td><strong><?php echo $video_file['file_source']; ?></strong></td>
                      <td>
                          <input type="hidden" name="episodes_id[]" value="<?php echo $video_file['episodes_id']; ?>">
                          <input type="number" name="order[]" value="<?php echo $video_file['order']; ?>" class="form-control" style="width:80px" required>
                      </td>
                      <td><?php echo $video_file['file_url']; ?></a></td>
                      <td>
                        <?php if ($video_file['file_source'] == 'youtube' || $video_file['file_source'] == 'vimeo' || $video_file['file_source'] == 'embed') : ?>
                          <p><?php echo trans('unsupported') ?></p>
                        <?php else : ?>
                          <?php
                              $subtitles = $this->db->get_where('tvseries_subtitle', array('episodes_id' => $video_file['episodes_id']))->result_array();
                              foreach ($subtitles as $subtitle) :
                                ?>
                            <a class="label label-default" href="#" onclick="delete_row('tvseries_subtitle',<?php echo urldecode($subtitle['tvseries_subtitle_id']); ?>)"><?php echo $subtitle['language']; ?></a>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <div class="btn-group">
                          <button type="button" class="btn btn-white btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                          <ul class="dropdown-menu" role="menu">
                            <li><a class="dropdown-item" href="<?php echo base_url('admin/episodes_manage/edit/'.$video_file['episodes_id']); ?>"><?php echo trans('edit_episode') ?></a></li>
                            <li><a class="dropdown-item" target="_blank" href="<?php echo base_url('watch/') . $this->common_model->get_slug_by_videos_id($video_file['videos_id']) . '.html?key=' . $video_file['stream_key']; ?>"><?php echo trans('watch_now') ?></a></li>
                            <?php if ($video_file['file_source'] != 'youtube' && $video_file['file_source'] != 'vimeo' && $video_file['file_source'] != 'embed') : ?>
                              <li><a href="#" class="dropdown-item" data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/tvseries_subtitle_add/' . $video_file['videos_id'] . '/' . $video_file['seasons_id'] . '/' . $video_file['episodes_id']; ?>" id="menu"><?php echo trans('add_subtitle') ?></a> </li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" title="<?php echo trans('delete'); ?>" href="#" onclick="delete_row('episodes',<?php echo urldecode($video_file['episodes_id']); ?>)" class="delete"><?php echo trans('delete'); ?></a> </li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <div class="pull-right"><button type="submit" class="btn btn-primary btn-sm"><?php echo trans('save_order');?></button></div>
              <?php echo form_close();?>
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