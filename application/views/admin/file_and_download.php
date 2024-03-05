<?php $video_source = 'mp4';?>
<div class="card">
  <div class="row">
    <div class="col-md-12">
      <a class="btn btn-sm btn-primary waves-effect" href="<?php echo base_url('admin/videos'); ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span><?php echo trans('back_to_list'); ?></a>
      <a class="btn btn-sm btn-primary waves-effect" href="<?php echo base_url('watch/') . $slug; ?>" target="_blank"> <span class="btn-label"><i class="fa fa-eye"></i></span><?php echo trans('preview'); ?></a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('upload_videos') ?></h3>
        </div>
        <div class="panel-body">
          <?php echo form_open_multipart(base_url('admin/movie_upload')); ?>           
            <input type="hidden" name="videos_id" value="<?php echo $param1; ?>">
            <div class="form-group">
              <label class="control-label"><?php echo trans('label') ?></label>&nbsp;&nbsp;<input id="label" type="text" name="label" class="form-control" placeholder="Server#1" required="">
            </div>
            <div class="form-group">
              <label class="control-label"><?php echo trans('order'); ?></label>
              <input type="number" name="order" class="form-control" placeholder="0 to 9999" required>
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
      </div>      
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('video_list') ?></h3>
        </div>
        <div class="panel-body">
            <?php echo form_open(base_url() . 'admin/file_and_download/change_order/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
            <input type="hidden" name="videos_id" value="<?php echo $param1; ?>">
          <table class="table table-bordered" id="video-list">
            <thead>
              <tr>
                <th>#</th>
                <th><?php echo trans('source') ?></th>
                <th><?php echo trans('order') ?></th>
                <th><?php echo trans('label') ?></th>
                <th><?php echo trans('url') ?></th>
                <th><?php echo trans('subtitle') ?></th>
                <th><?php echo trans('action') ?></th>
              </tr>
            </thead>
            <?php
            $sl = 0;
            $video_files = $this->common_model->get_video_file_by_videos_id($param1);
            foreach ($video_files as $video_file) :
              $sl++;
              ?>
              <tr id="row_<?php echo $video_file['video_file_id']; ?>">
                <td><?php echo $sl; ?></td>
                <td><a href="<?php echo base_url('watch/') . $this->common_model->get_slug_by_videos_id($video_file['videos_id']) . '.html?key=' . $video_file['stream_key']; ?>"><?php echo $video_file['file_source']; ?></a></td>
                <td>
                    <input type="hidden" name="video_file_id[]" value="<?php echo $video_file['video_file_id']; ?>">
                    <input type="number" name="order[]" value="<?php echo $video_file['order']; ?>" class="form-control" style="width:80px" required>
                </td>
                <td><?php echo $video_file['label']; ?></td>
                <td><?php echo urldecode($video_file['file_url']); ?></td>
                <td>
                  <?php if ($video_file['file_source'] == 'youtube' || $video_file['file_source'] == 'vimeo') : ?>
                    <p><?php echo trans('unsupported') ?></p>
                  <?php else : ?>
                    <?php
                        $subtitles = $this->db->get_where('subtitle', array('video_file_id' => $video_file['video_file_id']))->result_array();
                        foreach ($subtitles as $subtitle) :
                          ?>
                      <a class="label label-default" href="#" onclick="delete_row('subtitle',<?php echo urldecode($subtitle['subtitle_id']); ?>)"><?php echo $subtitle['language']; ?></a>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-white btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a class="dropdown-item"href="<?php echo base_url('admin/file_and_download/edit/'. $video_file['video_file_id']); ?>"><?php echo trans('edit') ?></a></li>
                      <li><a class="dropdown-item" target="_blank" href="<?php echo base_url('watch/') . $this->common_model->get_slug_by_videos_id($video_file['videos_id']) . '.html?key=' . $video_file['stream_key']; ?>"><?php echo trans('watch_now') ?></a></li>
                      <?php if ($video_file['file_source'] != 'youtube' && $video_file['file_source'] != 'vimeo' && $video_file['file_source'] != 'embed') : ?>
                        <li><a href="#" class="dropdown-item" data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/subtitle_add/' . $video_file['videos_id'] . '/' . $video_file['video_file_id']; ?>" id="menu"><?php echo trans('add_subtitle') ?></a> </li>
                      <?php endif; ?>
                      <li><a class="dropdown-item" title="<?php echo trans('delete'); ?>" href="#" onclick="delete_row('video_file',<?php echo urldecode($video_file['video_file_id']); ?>)" class="delete"><?php echo trans('delete'); ?></a> </li>
                    </ul>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
          <div class="pull-right" style="margin-bottom:10px;"><button type="submit" class="btn btn-primary btn-sm"><?php echo trans('save_order');?></button></div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo trans("download_url");?></h3>
          </div>
          <div class="panel-body">          
            <div id="download_link_section">
              <?php echo form_open_multipart(base_url('admin/download_link/')); ?>
              <input type="hidden" name="videos_id" value="<?php echo $param1; ?>">
              <div class="form-group" id="_source2">
                <label class="control-label" ><?php echo trans("link_title");?></label>&nbsp;&nbsp;<input id="link_title" type="text" name="link_title" class="form-control" placeholder="Ex; Google Drive" required="">
              </div>
              <div class="form-group" id="">
                <label class="control-label" ><?php echo trans("resolution");?></label>&nbsp;&nbsp;<input id="resolution" type="text" name="resolution" class="form-control" placeholder="Ex: 720p" required="">
              </div>
              <div class="form-group" id="">
                <label class="control-label" ><?php echo trans("file_size");?></label>&nbsp;&nbsp;<input id="file_size" type="text" name="file_size" class="form-control" placeholder="Ex: 300MB" required="">
              </div>
              <div class="form-group" id="">
                <label class="control-label" ><?php echo trans("download_url");?></label>&nbsp;&nbsp;<input id="download_url" type="url" name="download_url" class="form-control" placeholder="Ex: http://server-2.com/movies/titalic.mp4" required="">              
            </div>
            <div class="form-group">
              <label class="control-label"><?php echo trans('download_type'); ?></label>
              <select class="form-control" name="in_app_download">
                <option value="0"><?php echo trans('external_download');?></option>
                <option value="1"><?php echo trans('in_app_download');?></option>                
              </select>
            </div>
            <button type="submit" class="btn btn-sm btn-primary waves-effect" id="add-download-link"> <span class="btn-label"><i class="fa fa-plus"></i></span>Submit</button><br><br>
            </form>            
        </div>
      </div>
    </div>
      <div class="panel panel-border panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Download Link List</h3>
          </div>
          <div class="panel-body">                
            <table class="table table-bordered" id="download-link-list">
              <?php $download_links = $this->db->get_where('download_link', array('videos_id'=> $param1))->result_array();
                    foreach($download_links as $download_link):
               ?>
              <tr id="row_<?php echo $download_link['download_link_id']; ?>">
                <td><a href="<?php echo $download_link['download_url']; ?>"><strong><?php echo $download_link['link_title']; ?></strong></a></td>
                <td><?php if($download_link['in_app_download'] == '1'): echo "In-App Download";else: echo "External Download"; endif; ?></td>
                <td><?php echo $download_link['resolution']; ?></td>
                <td><?php echo $download_link['file_size']; ?></td>
                <td><a href="<?php echo urldecode($download_link['download_url']); ?>"><?php echo urldecode($download_link['download_url']); ?></a></td>
                <td><a title="Delete" class="btn btn-icon" onclick="delete_row(<?php echo " 'download_link' ".','.$download_link['download_link_id'];?>)" class="delete"><i class="fa fa-remove"></i></a></td>
              </tr>
            <?php endforeach; ?>
            </table>       
        </div>
      </div>
    </div>

    <script>
      $(document).ready(function() {
        $("#upload-active").click(function() {
          $("#upload_section").show();
          $("#link_section").hide();
        });
        $("#link-active").click(function() {
          $("#upload_section").hide();
          $("#link_section").show();
        });
      });
    </script>
    <script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
    <script>
      jQuery(document).ready(function() {
          $('form').parsley();
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