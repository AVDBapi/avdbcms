<?php echo form_open(base_url() . 'admin/fetch_actor_from_tmdb/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>

<h4 class="text-center"><?php echo trans('fetch_actor_from_tmdb'); ?></h4>
<hr>
<div class="form-group">
  <label class="control-label"><?php echo trans('from'); ?></label>
  <select class="form-control" name="from" required>
    <option value="movie"><?php echo trans('tmdb_movie'); ?></option>
    <option value="tv"><?php echo trans('tmdb_tv_series'); ?></option>
  </select>
</div>
<div class="form-group">
  <label class="control-label"><?php echo trans('tmdb_id'); ?></label>
  <input type="text" name="id" class="form-control" placeholder="Enter TMDB Movie/Tv-Series ID" />
</div>
<div class="alert alert-info"><strong><?php echo trans('note'); ?>:</strong> <?php echo trans('actors_photo_will_import_by_cron.'); ?></div>

<div class="form-group">
  <div class="col-sm-offset-3 col-sm-9 m-t-15">
    <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-exchange"></i></span><?php echo trans('fetch_and_import'); ?> </button>
    <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans('close.'); ?> </button>
  </div>
</div>
</form>
<script>
  jQuery(document).ready(function() {
    $('form').parsley();
  });
</script>