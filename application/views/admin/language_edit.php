<div class="card">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-border panel-primary">
                <div class="panel-heading" style="margin-left: -10px;margin-right: -10px;">
                    <h3 class="panel-title"><?php echo trans('edit_language'); ?></h3>
                </div>
                <div class="panel-body" style="margin: 10px;">
                    <?php echo form_open('admin/language_edit/update'); ?>
                    <input type="hidden" name="id" value="<?php echo html_escape($language->id); ?>">
                    <div class="form-group row">
                        <label><?php echo trans('language_name'); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?php echo trans('language_name'); ?>" value="<?php echo $language->name; ?>" maxlength="200" required>
                        <small>(Ex: English)</small>
                    </div>

                    <div class="form-group row">
                        <label class="control-label"><?php echo trans('short_form'); ?> </label>
                        <input type="text" class="form-control" name="short_form" placeholder="<?php echo trans('short_form'); ?>" value="<?php echo $language->short_form; ?>" maxlength="200" required>
                        <small>(Ex: en)</small>
                    </div>

                    <div class="form-group row">
                        <label class="control-label"><?php echo trans('language_code'); ?> </label>
                        <input type="text" class="form-control" name="language_code" placeholder="<?php echo trans('language_code'); ?>" value="<?php echo $language->language_code; ?>" maxlength="200" required>
                        <small>(Ex: en_us)</small>
                    </div>

                    <div class="form-group row">
                        <label><?php echo trans('order'); ?></label>
                        <input type="number" class="form-control" name="language_order" placeholder="<?php echo trans('order'); ?>_1" value="<?php echo $language->language_order; ?>" min="1" required>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?php echo trans('text_direction'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_type_1" name="text_direction" value="ltr" class="square-purple" <?php echo ($language->text_direction == "ltr") ? 'checked' : ''; ?>>
                                <label for="rb_type_1" class="cursor-pointer"><?php echo trans('ltr'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_type_2" name="text_direction" value="rtl" class="square-purple" <?php echo ($language->text_direction == "rtl") ? 'checked' : ''; ?>>
                                <label for="rb_type_2" class="cursor-pointer"><?php echo trans('rtl'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?php echo trans('status'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="1" id="status1" class="square-purple" <?php echo ($language->status == "1") ? 'checked' : ''; ?>>
                                <label for="status1" class="option-label"><?php echo trans('active'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="0" id="status2" class="square-purple" <?php echo ($language->status != "1") ? 'checked' : ''; ?>>
                                <label for="status2" class="option-label"><?php echo trans('inactive'); ?></label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    <?php form_close(); ?>
                    <br><br><br>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .bootstrap-tagsinput .badge {
        ;
        background-color: #009688;
        border: 1px solid #035d54;
    }
</style>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script>
    jQuery(document).ready(function() {
        $('#tv_series_keyword').tagsinput();
        $('#focus_keyword').tagsinput();
        $('#live_tv_keyword').tagsinput();
        $('#movie_page_focus_keyword').tagsinput();
        $('#blog_keyword').tagsinput();
    });
</script>

<script type="text/javascript">
    function delete_language(row_id) {
        var table_row = '#row_' + row_id
        var base_url = '<?php echo base_url(); ?>'
        url = base_url + 'admin/delete_language/'
        swal({
                title: 'Are you sure?',
                text: "It will be deleted permanently!",
                icon: "warning",
                buttons: true,
                buttons: ["Cancel", "Delete"],
                dangerMode: true,
                closeOnClickOutside: false
            })
            .then(function(confirmed) {
                if (confirmed) {
                    $.ajax({
                            url: url,
                            type: 'POST',
                            data: 'row_id=' + row_id,
                            dataType: 'json'
                        })
                        .done(function(response) {
                            swal.stopLoading();
                            swal("Deleted!", response.message, response.status);
                            $(table_row).fadeOut(2000);
                        })
                        .fail(function() {
                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                        })
                }
            })
    }
</script>
<!-- END Ajax Delete -->