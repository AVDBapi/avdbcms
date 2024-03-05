<div class="card">
    <div class="row">
        <div class="col-sm-12">
            <button data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/subscription_add/'.$user_data->user_id;?>" id="menu" class="btn btn-sm btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans("add_subscription");?></button>
                <br>
                <br>
            <table class="table table-bordered">
                <thead>
                    <th><?php echo trans("subscriber_name");?></th>
                    <th><?php echo trans("email");?></th>
                    <th><?php echo trans("gender");?></th>
                    <th><?php echo trans("joining_date");?></th>
                    <th><?php echo trans("last_login");?></th>
                </thead>
                <tr>
                    <td><?php echo $user_data->name; ?></td>
                    <td><?php echo $user_data->email; ?></td>
                    <td><?php if($user_data->gender =='1'){ echo trans("male");}else{ echo trans("female");} ?></td>
                    <td><?php echo date('d-m-Y',strtotime($user_data->join_date)); ?></td>
                    <td><?php echo date('d-m-Y H:i:s',strtotime($user_data->last_login)); ?></td>
                </tr>
            </table>
        </div>
        <div class="col-sm-12">
                            
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>                            
                            <th><?php echo trans("package_name");?></th>
                            <th><?php echo trans("from");?></th>
                            <th><?php echo trans("to");?></th>
                            <th><?php echo trans("payment_method");?></th>
                            <th><?php echo trans("trnasaction_id");?></th>
                            <th><?php echo trans("paid_amount");?></th>
                            <th><?php echo trans("status");?></th>
                            <th><?php echo trans("option");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sl = 1;
                            foreach ($subscriptions as $subscription): 
                        ?>
                        <tr id='row_<?php echo $subscription['subscription_id'];?>'>
                            <td><?php echo $sl++;?></td>
                            <td><strong><?php echo $this->subscription_model->get_plan_name_by_id($subscription['plan_id']);?><?php if(time() > $subscription['timestamp_to']){ echo '(expired)'; }?></strong></td>
                            <td><?php echo date('d-m-Y',$subscription['timestamp_from']);?></td>
                            <td><?php echo date('d-m-Y',$subscription['timestamp_to']);?></td>
                            <td><?php echo $subscription['payment_method']; ?></td>
                            <td><a href="#" data-toggle="modal" data-target="#exampleModalCenter" class="transaction_details" data-id='<?php echo $subscription['subscription_id'];?>'><?php echo $subscription['transaction_id'];?></a></td>
                            <td><?php echo $subscription['currency'].' '.$subscription['paid_amount']; ?></td>
                            <td><?php if($subscription['status'] =='1'){ echo 'ACTIVE';}else{ echo "INACTIVE";}?></td>
                            <td>
                                <div class="btn-group m-b-20">
                                    <a data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/subscription_edit/'. $subscription['subscription_id'];?>" id="menu" title="<?php echo trans('edit'); ?>" class="btn btn-icon"><i class="fa fa-pencil"></i></a>
                                    <a title="<?php echo trans('delete'); ?>" class="btn btn-icon" onclick="delete_row(<?php echo " 'subscription' ".','.$subscription['subscription_id'];?>)" class="delete"><i class="fa fa-remove"></i></a>
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
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php echo trans("transaction_details");?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="modal-loader2" style="display: none; text-align: center;"> <img src="<?php echo base_url(); ?>assets/images/preloader.gif" /> </div>
        <div id="dynamic-content2"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo trans("close");?></button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
<script>
    $(document).ready(function() {
        $(document).on('click', '.transaction_details', function(e) {
            e.preventDefault();
            var id  = $(this).data('id');
            var url = "<?php echo base_url('admin/get_transaction_details'); ?>";
            $('#dynamic-content2').html('');
            $('#modal-loader2').show();
            $.ajax({
                url: url,
                type: 'POST',
                data: {"subscription_id": id},
                dataType: 'html'
            })
            .done(function(data) {
                console.log(data);
                $('#dynamic-content2').html('');
                $('#dynamic-content2').html(data); // load response 
                $('#modal-loader2').hide(); // hide ajax loader 
            })
            .fail(function() {
                $('#dynamic-content2').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader2').hide();
            });
        });
    });
</script>
<!-- END Ajax modal  -->