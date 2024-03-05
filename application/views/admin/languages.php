<div class="card">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-border panel-primary">
                <div class="panel-heading" style="margin-left: -10px;margin-right: -10px;">
                    <h3 class="panel-title"><?php echo trans('default_language'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo form_open('admin/language_setting/change_default'); ?>
                    <div class="form-group row">
                        <select name="site_lang" class="form-control">
                            <?php foreach ($languages as $language) : ?>
                                <option value="<?php echo $language->id; ?>" <?php echo (ovoo_config('active_language_id') == $language->id) ? 'selected' : ''; ?>><?php echo $language->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('save_changes'); ?></button>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <br><br><br>

            <div class="panel panel-border panel-primary">
                <div class="panel-heading" style="margin-left: -10px;margin-right: -10px;">
                    <h3 class="panel-title"><?php echo trans('add_language'); ?></h3>
                </div>
                <div class="panel-body">
                    <?php echo form_open('admin/language_setting/add_language'); ?>
                    <div class="form-group row">
                        <label><?php echo trans('language_name'); ?></label>
                        <input type="text" class="form-control" name="name" placeholder="<?php echo trans('language_name'); ?>" value="" maxlength="200" required>
                        <small>(Ex: English)</small>
                    </div>

                    <div class="form-group row">
                        <label class="control-label"><?php echo trans('short_form'); ?> </label>
                        <input type="text" class="form-control" name="short_form" placeholder="<?php echo trans('short_form'); ?>" value="" maxlength="200" required>
                        <small>(Ex: en)</small>
                    </div>

                    <div class="form-group row">
                        <label class="control-label"><?php echo trans('language_code'); ?> </label>
                        <input type="text" class="form-control" name="language_code" placeholder="<?php echo trans('language_code'); ?>" value="" maxlength="200" required>
                        <small>(Ex: en_us)</small>
                    </div>

                    <div class="form-group row">
                        <label><?php echo trans('order'); ?></label>
                        <input type="number" class="form-control" name="language_order" placeholder="<?php echo trans('order'); ?>_1" value="1" min="1" required>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4 col-xs-12">
                                <label><?php echo trans('text_direction'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_type_1" name="text_direction" value="ltr" class="square-purple" checked>
                                <label for="rb_type_1" class="cursor-pointer"><?php echo trans('ltr'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" id="rb_type_2" name="text_direction" value="rtl" class="square-purple">
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
                                <input type="radio" name="status" value="1" id="status1" class="square-purple" checked>
                                <label for="status1" class="option-label"><?php echo trans('active'); ?></label>
                            </div>
                            <div class="col-sm-4 col-xs-12 col-option">
                                <input type="radio" name="status" value="0" id="status2" class="square-purple">
                                <label for="status2" class="option-label"><?php echo trans('inactive'); ?></label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><?php echo trans('add_language'); ?></button>
                    <?php form_close(); ?>
                    <br><br><br>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="panel panel-border panel-primary">
                <div class="panel-heading" style="margin-left: -10px;margin-right: -10px;">
                    <h3 class="panel-title"><?php echo trans('language_list'); ?></h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-striped dataTable" id="cs_datatable" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr role="row">
                                <th width="20"><?php echo trans('id'); ?></th>
                                <th><?php echo trans('language_name'); ?></th>
                                <th><?php echo trans('folder_name'); ?></th>
                                <th class="max-width-120"><?php echo trans('option'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($languages as $item) : ?>
                                <tr id="row_<?php echo $item->id; ?>">
                                    <td><?php echo html_escape($item->id); ?></td>
                                    <td><?php echo html_escape($item->name); ?>&nbsp;
                                        <?php if ($item->status == 1) : ?>
                                            <label class="label label-success pull-right lbl-lang-status"><?php echo trans('active'); ?></label>
                                        <?php else : ?>
                                            <label class="label label-danger pull-right lbl-lang-status"><?php echo trans('inactive'); ?></label>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo html_escape($item->folder_name); ?></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn bg-purple dropdown-toggle btn-select-option btn-sm" type="button" data-toggle="dropdown">...
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu options-dropdown">
                                                <li>
                                                    <a class="dropdown-item" href="<?php echo base_url('admin/update_phrases/' . $item->id); ?>"><i class="fa fa-exchange option-icon"></i><?php echo trans('edit_phrases'); ?></a></li>
                                                <li>
                                                <li>
                                                    <a class="dropdown-item" href="<?php echo base_url('admin/language_edit/' . html_escape($item->id)); ?>"><i class="fa fa-edit option-icon"></i><?php echo trans('edit'); ?></a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0)" onclick="delete_language('<?php echo $item->id; ?>');"><i class="fa fa-trash option-icon"></i><?php echo trans('delete'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
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
                            data: {id:row_id},
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