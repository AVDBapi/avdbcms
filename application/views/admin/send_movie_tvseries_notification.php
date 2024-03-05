    <div class="card">
      <div class="row"> 
        <!-- panel  -->
        <div class="col-md-12">
          <?php echo form_open(base_url() . 'admin/send_movie_tvseries_notification/send/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
          <div class="panel panel-border panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Send Movie/TV-Series Notification(OneSignal)</h3>
            </div>
            <div class="panel-body"> 
              <!-- panel  -->
              <div class="form-group row">
              <label class="control-label col-sm-4">Movie/TV-Series</label>
              <div class="col-sm-8">
                <select class="form-control" name="videos_id"  id="videos_id" required></select>
              </div>
            </div>            
              <div class="form-group row">
                <label class=" col-sm-4 control-label">Headings</label>
                <div class="col-sm-8">
                  <input type="text" name="headings" id="headings" class="form-control" value="" required>
                </div>
              </div>
              <div class="form-group row">
                <label class=" col-sm-4 control-label">Message</label>
                <div class="col-sm-8">
                  <textarea type="text" name="message" id="message" class="form-control" rows="4" required></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label class=" col-sm-4 control-label">Icon URL</label>
                <div class="col-sm-8">
                  <input type="text" name="icon" id="icon" class="form-control" value="" required>
                </div>
              </div>

              <div class="form-group row">
                <label class=" col-sm-4 control-label">Image URL(Large)</label>
                <div class="col-sm-8">
                  <input type="text" name="img" id="img" class="form-control" value="" required>
                </div>
              </div>


              <div class="col-sm-offset-3 col-sm-9 m-t-15">
                <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-paper-plane-o"></i></span>Send Notification</button>
              </div>
              <?php echo form_close(); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script>


<script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<script type="text/javascript">
      $('#videos_id').select2({
        placeholder: 'Select Movie/TV-Series',
        minimumInputLength: 2,
        ajax: {
          url: '<?=base_url('admin/get_movie_by_search_title')?>',
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
    $("#videos_id").change(function() {
        var videos_id = $("#videos_id option:selected").val();
        if (videos_id != '' && videos_id !=null){
          $.ajax({
            url: '<?=base_url('admin/get_single_movie_details_by_id')?>',
            type: 'POST',
            data: {"videos_id":videos_id},
            dataType: 'json'
         })
         .done(function(response){
            $("#icon").val(response.thumbnail_url);
            $("#img").val(response.poster_url);
            $("#headings").val('Watch '+response.title);
            $("#message").val(response.description);
         })
         .fail(function(response){
            alert('Something went wrong..');
         })
        }
    });
</script>




