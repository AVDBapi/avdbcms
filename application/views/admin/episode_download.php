<?php $video_source = 'mp4';?>
<div class="card">
  <div class="row">
    <div class="col-md-12">
      <a class="btn btn-sm btn-primary waves-effect" href="<?php echo base_url('admin/videos'); ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span><?php echo trans('back_to_list'); ?></a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo trans('download_url'); ?></h3>
          </div>
          <div class="panel-body">          
            <div id="download_link_section">
              <?php echo form_open_multipart(base_url('admin/episode_download_link/')); ?>
              <input type="hidden" name="videos_id" value="<?php echo $param1; ?>">
              <input type="hidden" name="season_id" value="<?php echo $param2; ?>">
              <div class="form-group" id="_source2">
                <label class="control-label" ><?php echo trans('link_title'); ?></label>&nbsp;&nbsp;<input id="link_title" type="text" name="link_title" class="form-control" placeholder="Ex; Google Drive" required="">
              </div>
              <div class="form-group" id="">
                <label class="control-label" ><?php echo trans('resolution'); ?></label>&nbsp;&nbsp;<input id="resolution" type="text" name="resolution" class="form-control" placeholder="Ex: 720p" required="">
              </div>
              <div class="form-group" id="">
                <label class="control-label" ><?php echo trans('file_size'); ?></label>&nbsp;&nbsp;<input id="file_size" type="text" name="file_size" class="form-control" placeholder="Ex: 300MB" required="">
              </div>
              <div class="form-group" id="">
                <label class="control-label" ><?php echo trans('download_url'); ?></label>&nbsp;&nbsp;<input id="download_url" type="url" name="download_url" class="form-control" placeholder="Ex: http://server-2.com/movies/titalic.mp4" required="">              
            </div>
            <div class="form-group">
              <label class="control-label"><?php echo trans('download_type'); ?></label>
              <select class="form-control" name="in_app_download">
                <option value="0"><?php echo trans('external_download');?></option>
                <option value="1"><?php echo trans('in_app_download');?></option>                
              </select>
            </div>
            <button type="submit" class="btn btn-sm btn-primary waves-effect" id="add-download-link"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('submit');?></button><br><br>
            </form>            
        </div>
      </div>
    </div>
      <div class="panel panel-border panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo trans('download_link_list');?></h3>
          </div>
          <div class="panel-body">                
            <table class="table table-bordered" id="download-link-list">
              <?php $download_links = $this->db->get_where('episode_download_link', array('videos_id'=> $param1,'season_id'=>$param2))->result_array();
                    foreach($download_links as $download_link):
               ?>
              <tr id="row_<?php echo $download_link['episode_download_link_id']; ?>">
                <td><a href="<?php echo $download_link['download_url']; ?>"><strong><?php echo $download_link['link_title']; ?></strong></a></td>
                <td><?php if($download_link['in_app_download'] == '1'): echo "In-App Download";else: echo "External Download"; endif; ?></td>
                <td><?php echo $download_link['resolution']; ?></td>
                <td><?php echo $download_link['file_size']; ?></td>
                <td><a href="<?php echo urldecode($download_link['download_url']); ?>"><?php echo urldecode($download_link['download_url']); ?></a></td>
                <td><a title="Delete" class="btn btn-icon" onclick="delete_row(<?php echo " 'episode_download_link' ".','.$download_link['episode_download_link_id'];?>)" class="delete"><i class="fa fa-remove"></i></a></td>
              </tr>
            <?php endforeach; ?>
            </table>       
        </div>
      </div>
    </div>
    <script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>