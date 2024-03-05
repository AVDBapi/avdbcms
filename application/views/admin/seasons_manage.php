

<div class="card">
    <div class="row">
        <div class="col-sm-12">
            <a class="btn btn-sm btn-primary waves-effect" href="<?php echo base_url('admin/tvseries'); ?>"> <span class="btn-label"><i class="fa fa-arrow-left"></i></span><?php echo trans('back_to_list'); ?></a>
            <a class="btn btn-sm btn-primary waves-effect" href="<?php echo base_url('watch/') . $slug; ?>" target="_blank"> <span class="btn-label"><i class="fa fa-eye"></i></span><?php echo trans('preview'); ?></a>

            <button data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/seasons_add/' . $param1; ?>" id="menu" class="btn btn-sm btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('add_seasons'); ?></button>
            <br>
            <br>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo trans('session_name'); ?></th>
                        <th><?php echo trans('episodes'); ?></th>
                        <th><?php echo trans('order'); ?></th>
                        <th><?php echo trans('option'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php echo form_open(base_url() . 'admin/seasons_manage/change_order/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
                <input type="hidden" name="videos_id" value="<?php echo $param1; ?>">
                    <?php $sl = 1;
                        $seasons = $this->common_model->get_seasons_by_videos_id($param1);
                        foreach ($seasons as $seasons) :
                        ?>
                        <tr id='row_<?php echo $seasons['seasons_id']; ?>'>
                            <td><?php echo $sl++; ?></td>
                            <td><strong><?php echo $seasons['seasons_name']; ?></strong></td>
                            <td><?php echo $this->common_model->get_total_episods_by_seasons_id($seasons['seasons_id']); ?> <?php echo trans('episodes'); ?></td>
                            <td>
                                <input type="hidden" name="seasons_id[]" value="<?php echo $seasons['seasons_id']; ?>">
                                <input type="number" name="order[]" value="<?php echo $seasons['order']; ?>" class="form-control" style="width:80px" required>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-sm" href="<?php echo base_url() . 'admin/episodes_manage/' . $param1 . '/' . $seasons['seasons_id']; ?>"><?php echo trans('manage_episodes'); ?></a>
                                <a class="btn btn-primary btn-sm" href="<?php echo base_url().'admin/episodes_download/'.$param1.'/'.$seasons['seasons_id']; ?>"><?php echo trans('episodes_download'); ?></a>
                                <div class="btn-group m-b-20"> <a data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/seasons_edit/' . $seasons['seasons_id']; ?>" id="menu" title="<?php echo trans('edit'); ?>" class="btn btn-icon"><i class="fa fa-pencil"></i></a> <a title="<?php echo trans('delete'); ?>" class="btn btn-icon" onclick="delete_row(<?php echo " 'seasons' " . ',' . $seasons['seasons_id']; ?>)" class="delete"><i class="fa fa-remove"></i></a> </div>
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

<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();
    });
</script>

<!-- select2-->
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<!-- select2-->