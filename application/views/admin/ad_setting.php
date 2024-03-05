<div class="card">
    <div class="row">
        <div class="col-sm-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>##</th>
                        <th> <?php echo trans('ads_name'); ?></th>
                        <th><?php echo trans('unique_name'); ?></th>
                        <th><?php echo trans('type'); ?></th>
                        <th><?php echo trans('ads_size'); ?></th>
                        <th><?php echo trans('status'); ?></th>
                        <th><?php echo trans('edit'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ads = $this->common_model->get_all_ads();
                    $sl = 1;
                    foreach ($ads as $ad) :
                        ?>
                        <tr id='row_<?php echo $ad['ads_id']; ?>'>
                            <td><?php echo $sl++; ?></td>
                            <td><strong><?php echo $ad['ads_name']; ?></strong></td>
                            <td><?php echo $ad['unique_name']; ?></td>
                            <td><?php echo $ad['ads_type']; ?></td>
                            <td><?php echo $ad['ads_size']; ?></td>
                            <td><?php if ($ad['enable'] == '1') {
                                        echo "Enabled";
                                    } else {
                                        echo "Disabled";
                                    } ?></td>
                            <td>
                                <a href="<?php echo base_url() . 'admin/ad_setting/edit/' . $ad['ads_id']; ?>" class="btn btn-primary"><?php echo trans('edit'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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