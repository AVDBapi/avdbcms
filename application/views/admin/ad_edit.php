<?php echo form_open(base_url() . 'admin/ad_setting/update/' . $ads_id, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<div class="card">
    <div class="row">
        <!-- panel  -->
        <div class="col-md-12">
            <div class="panel panel-border panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo trans('edit'); ?> <?php echo $ads_info->ads_name; ?> <?php echo trans('ads'); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <!-- panel  -->
                    <div class="form-group">
                        <label class="control-label col-md-3"><?php echo trans('ads'); ?> (<?php echo $ads_info->ads_size; ?>)</label>
                        <div class="col-sm-3">
                            <select class="form-control m-bot15" id="ad_option" name="ads_type">
                                <option value="0" id="ad_disable"><?php echo trans('disable'); ?></option>
                                <option value="image" <?php if ($ads_info->ads_type == 'image' && $ads_info->enable == '1') {
                                                            echo 'selected';
                                                        } ?> id="ad_image_selection"><?php echo trans('image'); ?></option>
                                <option value="code" <?php if ($ads_info->ads_type == 'code' && $ads_info->enable == '1') {
                                                            echo 'selected';
                                                        } ?> id="ad_code_selection"><?php echo trans('ads_code'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div id="ad_image_section" style="display:none;">
                        <div class="form-group">
                            <label class="control-label col-sm-3"><?php echo trans('images'); ?></label>
                            <div class="col-sm-9">
                                <div class="profile-info-name"> <img id="thumb_image" src="<?php echo $ads_info->ads_image_url . '?' . time(); ?>" class="img-thumbnail" alt=""> </div>
                                <br>
                                <div id="thumbnail_content">
                                    <input type="file" id="thumbnail_file" onchange="showImg(this);" name="ads_image" class="filestyle" data-input="false" accept="image/*"></div><br>
                                <p class="btn btn-white" id="thumb_link" href="#"><span class="btn-label"><i class="fa fa-link"></i></span>
                                    <?php echo trans('link'); ?>
                                </p>
                                <p class="btn btn-white" id="thumb_file" href="#"><span class="btn-label"><i class="fa fa-file-o"></i></span>
                                    <?php echo trans('file'); ?>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" col-sm-3 control-label"><?php echo trans('target_url'); ?></label>
                            <div class="col-sm-9">
                                <input type="text" name="ads_url" class="form-control" value="<?php echo $ads_info->ads_url; ?>">
                            </div>
                        </div>
                    </div>
                    <div id="ad_code_section" style="display:none;">
                        <div class="form-group">
                            <label class="control-label col-md-3"><?php echo trans('ads_code'); ?></label>
                            <div class="col-md-9">
                                <textarea class="wysihtml5 form-control" name="ads_code" id="footer-1" rows="10"><?php echo $ads_info->ads_code; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-offset-3 col-sm-9 m-t-15">
                        <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?></button>
                    </div>
                    </form>
                </div>
                <!--end panel body -->
            </div>
            <!--end panel -->
        </div>
        <!--end col-6 -->
    </div>
</div>


<script>
    jQuery(document).ready(function() {
        $('#thumb_link').click(function() {
            $('#thumbnail_content').html('<input type="text" name="ads_image_url" class="form-control">');
        });

        $('#thumb_file').click(function() {
            $('#thumbnail_content').html(
                '<input type="file" id="thumbnail_file" onchange="showImg(this);" name="ads_image" class="filestyle" data-input="false" accept="image/*"></div>'
            );
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

<script>
    $(document).ready(function() {
        <?php
        if($ads_info->ads_type == "image" && $ads_info->enable == "1"): ?>
            $("#ad_image_section").fadeIn("slow"); 

        <?php endif; ?>
        <?php
        if ($ads_info->ads_type == "code" && $ads_info->enable == "1"): ?>
            $("#ad_code_section").fadeIn("slow"); 
        <?php endif; ?>
        $("#ad_option").change(function() {
            var ad_val = $("#ad_option option:selected").val();
            if (ad_val == "image") {
                $("#ad_image_section").fadeIn("slow");
                $("#ad_code_section").fadeOut("slow");
            } else if (ad_val == 0) {
                $("#ad_image_section").fadeOut("slow");
                $("#ad_code_section").fadeOut("slow");
            } else if (ad_val == "code") {
                $("#ad_image_section").fadeOut("slow");
                $("#ad_code_section").fadeIn("slow");
            }
        });
    });
</script>