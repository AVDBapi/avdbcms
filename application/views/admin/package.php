
<?php    
    $currency_symbol              =   $this->db->get_where('config' , array('title'=>'currency_symbol'))->row()->value;
?>
<div class="card">
    <div class="row">
        <div class="col-sm-12">
            <button data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/plan_add';?>" id="menu" class="btn btn-sm btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans("add_package");?></button>
                <br>
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo trans("package_name");?></th>
                            <th><?php echo trans("validity_day");?></th>
                            <th><?php echo trans("price");?>(<?php echo $currency_symbol; ?>)</th>
                            <th><?php echo trans("status");?></th>
                            <th><?php echo trans("option");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 0;
                            foreach ($plans as $plan):
                            $sl++;
                        ?>
                        <tr id='row_<?php echo $plan['plan_id'];?>'>
                            <td><?php echo $sl; ?></td>
                            <td><strong><?php echo $plan['name'];?></strong></td>
                            <td><?php echo $plan['day'];?></td>
                            <td><?php echo $plan['price'];?></td>
                            <td><?php if($plan['status'] =='1'){ echo 'ACTIVE';}else{ echo "INACTIVE";}?></td>
                            <td>
                                <div class="btn-group m-b-20">
                                    <a data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/plan_edit/'. $plan['plan_id'];?>" id="menu" title="<?php echo trans('edit'); ?>" class="btn btn-icon"><i class="fa fa-pencil"></i></a>
                                    <a title="<?php echo trans('delete'); ?>" class="btn btn-icon" onclick="delete_row(<?php echo " 'plan' ".','.$plan['plan_id'];?>)" class="delete"><i class="fa fa-remove"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
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