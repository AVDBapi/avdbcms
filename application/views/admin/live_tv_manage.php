<div class="card">
    <div class="row">
        <div class="col-sm-12">
            <?php if ($total_rows > 0) : ?>
                <div class="row">
                    <div class="col-md-3">
                        <a href="<?php echo base_url() . 'admin/manage_live_tv/new'; ?>" class="btn btn-sm btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('add_channel'); ?></a> <br>
                        <br>
                    </div>
                    <div class="col-md-9">
                        <form class="form-inline pull-right" method="get" action="<?php echo base_url('admin/manage_live_tv') ?>">
                            <div class="form-group mx-sm-3 mb-2 ">
                                <label for="title" class="sr-only">Name</label>
                                <input type="text" name="name" value="<?php if(isset($name)){ echo $name;} ?>" class="form-control" id="title" placeholder="<?php echo trans("channel_name"); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2"><span class="btn-label"><i class="fa fa-search"></i></span><?php echo trans("search");?></button>
                        </form>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>##</th>
                            <th><?php echo trans('photo'); ?></th>
                            <th><?php echo trans('tv_name'); ?></th>
                            <th><?php echo trans('stream_url'); ?></th>
                            <th><?php echo trans('description'); ?></th>
                            <th><?php echo trans('category'); ?></th>
                            <th><?php echo trans('featured'); ?></th>
                            <th><?php echo trans('paid'); ?></th>
                            <th><?php echo trans('publish'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1;
                            foreach ($tvs as $tv) :
                                ?>
                            <tr id='row_<?php echo $tv['live_tv_id']; ?>'>
                                <td><?php echo $sl++; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-white btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a class="dropdown-item" target="_blank" href="<?php echo base_url() . 'live-tv/' . $tv['slug'] . '.html'; ?>"><?php echo trans('preview'); ?></a></li>
                                            <li><a class="dropdown-item" href="<?php echo base_url() . 'admin/manage_live_tv/edit/' . $tv['live_tv_id']; ?>"><?php echo trans('edit'); ?></a></li>
                                            <li><a class="dropdown-item" title="<?php echo trans('delete'); ?>" href="#" onclick="delete_row(<?php echo " 'live_tv' " . ',' . $tv['live_tv_id']; ?>)" class="delete"><?php echo trans('delete'); ?></a> </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <img src="<?php echo $this->live_tv_model->get_tv_thumbnail($tv['thumbnail']); ?>" class="" width="60" alt="<?php echo $tv['tv_name']; ?>_photo">
                                </td>
                                <td><strong><?php echo $tv['tv_name']; ?></strong></td>
                                <td>
                                    <?php
                                            echo mb_substr($tv['stream_url'], 0, 35) . '..';
                                            echo mb_substr($this->live_tv_model->get_live_tv_url($tv['live_tv_id'], 'sd'), 0, 35) . '..';
                                            echo mb_substr($this->live_tv_model->get_live_tv_url($tv['live_tv_id'], 'lq'), 0, 35) . '..';
                                            ?>
                                </td>
                                <td><?php echo $tv['description']; ?></td>
                                <td> <?php echo $this->live_tv_model->get_live_tv_category($tv['live_tv_category_id']); ?></td>
                                <td>
                                    <div class="animated-checkbox checkbox-inline">
                                        <label>
                                            <input
                                                    type="checkbox"
                                                    class="update_status"
                                                    id="<?php echo $tv['live_tv_id']; ?>"
                                                    data-id="<?php echo uniqid(); ?>"
                                                    data-table="live_tv"
                                                    data-primary_key="live_tv_id"
                                                    data-primary_key_value="<?php echo $tv['live_tv_id']; ?>"
                                                    data-column="featured"
                                                    data-column_value="<?php echo $tv['featured']; ?>"
                                                    value="<?php echo $tv['featured']; ?>"
                                                    <?php if ($tv['featured'] == '1'): echo 'checked'; endif;?>
                                            >
                                            <span class="label-text"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="animated-checkbox checkbox-inline">
                                        <label>
                                            <input
                                                    type="checkbox"
                                                    class="update_status"
                                                    id="<?php echo $tv['live_tv_id']; ?>"
                                                    data-id="<?php echo uniqid(); ?>"
                                                    data-table="live_tv"
                                                    data-primary_key="live_tv_id"
                                                    data-primary_key_value="<?php echo $tv['live_tv_id']; ?>"
                                                    data-column="publish"
                                                    data-column_value="<?php echo $tv['publish']; ?>"
                                                    value="<?php echo $tv['publish']; ?>"
                                                <?php if ($tv['publish'] == '1'): echo 'checked'; endif;?>
                                            >
                                            <span class="label-text"></span>
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="animated-checkbox checkbox-inline">
                                        <label>
                                            <input
                                                    type="checkbox"
                                                    class="update_status"
                                                    id="<?php echo $tv['live_tv_id']; ?>"
                                                    data-id="<?php echo uniqid(); ?>"
                                                    data-table="live_tv"
                                                    data-primary_key="live_tv_id"
                                                    data-primary_key_value="<?php echo $tv['live_tv_id']; ?>"
                                                    data-column="publish"
                                                    data-column_value="<?php echo $tv['is_paid']; ?>"
                                                    value="<?php echo $tv['is_paid']; ?>"
                                                <?php if ($tv['is_paid'] == '1'): echo 'checked'; endif;?>
                                            >
                                            <span class="label-text"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
            <?php echo $links; ?>
        </div>
    </div>
    <?php if ($total_rows == 0) : ?>
        <div class="row">
            <div class="col-md-12 text-center">
                <h6><strong><?php echo trans('no_channel_added'); ?>!</strong></h6>
                <p><?php echo trans('add_channel_by_click_on_add_live_tv_button'); ?></p>
                <a href="<?php echo base_url() . 'admin/manage_live_tv/new'; ?>" class="btn btn-sm btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('add_channel'); ?></a>
            </div>
        </div>
    <?php endif; ?>
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
<script src="<?php echo base_url() ?>assets/plugins/summernote/dist/summernote.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>