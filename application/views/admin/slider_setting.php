<?php echo form_open(base_url() . 'admin/slider_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
<div class="card">
    <div class="row">                
        <!-- panel  -->
        <div class="col-md-12">
            <div class="panel panel-border panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <?php echo trans('slider_setting'); ?>
                    </h3>
                </div>
                <div class="panel-body">
                    <!-- panel  -->
                    <div class="form-group">
                        <label class="control-label col-md-3"><?php echo trans('slider_type'); ?></label>
                        <div class="col-sm-6">
                            <select class="form-control m-bot15" id="slider_type" name="slider_type">
                                <option value="cubik" <?php if(ovoo_config('slider_type')=='cubik'){echo 'selected';}?> id="ad1_image_selection"><?php echo trans('cubik'); ?></option>
                                <option value="image" <?php if(ovoo_config('slider_type')=='image'){echo 'selected';}?> id="ad1_image_selection"><?php echo trans('image_slider'); ?></option>
                                <option value="movie" <?php if(ovoo_config('slider_type')=='movie'){echo 'selected';}?> id="ad1_code_selection"><?php echo trans('latest_movies'); ?></option>
                                <option value="tv" <?php if(ovoo_config('slider_type')=='tv'){echo 'selected';}?> id="ad1_code_selection"><?php echo trans('latest_tv_channels'); ?></option>
                                <option value="disable" <?php if(ovoo_config('slider_type')=='disable'){echo 'selected';}?> id="ad1_disable"><?php echo trans('disable'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div id="total_movie_in_slider">
                        <div class="form-group">
                            <label class=" col-sm-6 control-label"><?php echo trans('total_movie'); ?></label>
                            <div class="col-sm-6">
                                <input type="text" name="total_movie_in_slider" value="<?php echo $this->db->get_where('config' , array('title' =>'total_movie_in_slider'))->row()->value; ?>" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class=" col-sm-6 control-label"><?php echo trans('slider_wide'); ?></label>
                            <div class="col-sm-6">
                                <select class="form-control m-bot15" id="slider_fullwide" name="slider_fullwide">
                                    <option value="1" <?php if(ovoo_config('slider_fullwide')=='1'){echo 'selected';}?> id="ad1_disable"><?php echo trans('fullwide'); ?></option>
                                    <option value="0" <?php if(ovoo_config('slider_fullwide')=='0'){echo 'selected';}?> id="ad1_disable"><?php echo trans('box'); ?></option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class=" col-sm-6 control-label"><?php echo trans('slider_height').'(px)'; ?></label>
                            <div class="col-sm-6">
                                <input type="number" name="slider_height" value="<?php echo ovoo_config('slider_height'); ?>" class="form-control" required>
                                <small><?php echo trans('slider_height_note'); ?></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-sm-6 control-label"><?php echo trans('slider_border_radius').'(px)'; ?></label>
                            <div class="col-sm-6">
                                <input type="number" name="slider_border_radius" value="<?php echo ovoo_config('slider_border_radius'); ?>" class="form-control" required>
                                <small><?php echo trans('slider_border_radius_note'); ?></small>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-sm-6 control-label"><?php echo trans('slider_bullet'); ?></label>
                            <div class="col-sm-6">
                                <select class="form-control m-bot15" id="slider_bullet" name="slider_bullet">
                                    <option value="1" <?php if(ovoo_config('slider_bullet')=='1'){echo 'selected';}?> id="ad1_disable"><?php echo trans('enable'); ?></option>
                                    <option value="0" <?php if(ovoo_config('slider_bullet')=='0'){echo 'selected';}?> id="ad1_disable"><?php echo trans('disable'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class=" col-sm-6 control-label"><?php echo trans('slider_arrow'); ?></label>
                            <div class="col-sm-6">
                                <select class="form-control m-bot15" id="slider_arrow" name="slider_arrow">
                                    <option value="1" <?php if(ovoo_config('slider_arrow')=='1'){echo 'selected';}?> id="ad1_disable"><?php echo trans('enable'); ?></option>
                                    <option value="0" <?php if(ovoo_config('slider_arrow')=='0'){echo 'selected';}?> id="ad1_disable"><?php echo trans('disable'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-offset-3 col-sm-9 m-t-15">
                        <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?> </button>
                    </div>
                    <?php echo form_close(); ?>
                </div>
                <!--end panel body -->
            </div>
            <!--end panel -->
        </div>
        <!--end col-6 -->
    </div>
</div>


<script>
    $(document).ready(function() {
        <?php $slider_type=ovoo_config('slider_type');
        if ($slider_type=='image' || $slider_type=='cubik'):?>
        $("#total_movie_in_slider").fadeOut();
        <?php endif; if ($slider_type=='movie'):?>
        $("#total_movie_in_slider").fadeIn();
        <?php endif; if ($slider_type=='disable'):?>
        $("#total_movie_in_slider").fadeOut();
        <?php endif;?>
        
    });
    $("#slider_type").change(function() {
        var slider_type = $("#slider_type option:selected").val();
        if (slider_type == 'cubik') {    
            $("#total_movie_in_slider").fadeOut();
        }else if (slider_type == 'image') {    
            $("#total_movie_in_slider").fadeOut();
        } else if (slider_type == 'movie') {
            $("#total_movie_in_slider").fadeIn();
        } else if (slider_type == 'disable') {    
            $("#total_movie_in_slider").fadeOut();
        }
    });
</script>