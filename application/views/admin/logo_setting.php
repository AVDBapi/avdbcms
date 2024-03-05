<?php echo form_open(base_url() . 'admin/logo_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?> 
<div class="card">
  <div class="row"> 
    <!-- panel  -->
    <div class="col-md-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('logo_setting'); ?></h3>
        </div>
        <div class="panel-body"> 
          <!-- panel  -->
          <div class="form-group row">
            <label class="control-label col-sm-3"></label>
            <div class="col-sm-9">
               <img id="website_logo" src="<?php echo base_url().'uploads/system_logo/'.ovoo_config('logo'); ?>"  alt="logo" >
            </div>
          </div>              

          <div class="form-group row">
            <label class="control-label col-sm-3"><?php echo trans('website_logo'); ?></label>
            <div class="col-sm-9">
              <input type="file" onchange="showImg(this);" name="website_logo" class="filestyle" accept="image/*">
              <small><?php echo trans('logo_recommended_text'); ?></small>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-sm-3"></label>
            <div class="col-sm-9">
               <img id="website_favicon" src="<?php echo base_url().'uploads/system_logo/'.ovoo_config('favicon'); ?>"  alt="favicon" ><br>
               <small><?php echo trans('favicon_recommended_text'); ?></small>
            </div>
          </div>              

          <div class="form-group row">
            <label class="control-label col-sm-3"><?php echo trans('website_favicon'); ?></label>
            <div class="col-sm-9">
              <input type="file" onchange="showImgFav(this);" name="website_favicon" class="filestyle" accept="image/*">
            </div>
          </div>


          
          <div class="col-sm-offset-3 col-sm-9 m-t-15">
            <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?> </button>
          </div>
          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- file select--> 
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script> 
<!-- file select--> 



<!--instant image dispaly-->
<script type="text/javascript">
    function showImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#website_logo')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
<!--end instant image dispaly-->

<!--instant image dispaly-->
<script type="text/javascript">
    function showImgFav(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#website_favicon')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
<!--end instant image dispaly-->



