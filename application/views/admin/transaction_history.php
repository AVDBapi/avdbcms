<?php $this->load->model('subscription_model'); ?>
<div class="card">
    <div class="row">
        <div class="col-sm-12">
                <br>
                <br>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>###</th>
                            <th><?php echo trans("user");?></th>
                            <th><?php echo trans("payment_method");?></th>
                            <th><?php echo trans("amount");?></th>
                            <th><?php echo trans("payment time");?></th>
                            <th><?php echo trans("transaction_id");?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sl = 1;
                            foreach ($subscriptions as $subscription): 
                        ?>
                        <tr id='row_<?php echo $subscription['subscription_id'];?>'>
                            <td><?php echo $sl++;?></td>
                            <td><strong><?php echo $this->common_model->get_user_name_by_id($subscription['user_id']);?></strong></td>
                            <td><?php echo $subscription['payment_method'];?></td>
                            <td><?php echo $subscription['currency'].' '.$subscription['paid_amount'];?></td>
                            <td><?php echo date('Y-m-d H:i:s',$subscription['payment_timestamp']);?></td>                            
                            <td><a href="#" data-toggle="modal" data-target="#exampleModalCenter" class="transaction_details" data-id='<?php echo $subscription['subscription_id'];?>'><?php echo $subscription['transaction_id'];?></a></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
        <div id="modal-loader" style="display: none; text-align: center;"> <img src="<?php echo base_url(); ?>assets/images/preloader.gif" /> </div>
        <div id="dynamic-content"></div>
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
            $('#dynamic-content').html('');
            $('#modal-loader').show();
            $.ajax({
                url: url,
                type: 'POST',
                data: {"subscription_id": id},
                dataType: 'html'
            })
            .done(function(data) {
                console.log(data);
                $('#dynamic-content').html('');
                $('#dynamic-content').html(data); // load response 
                $('#modal-loader').hide(); // hide ajax loader 
            })
            .fail(function() {
                $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                $('#modal-loader').hide();
            });
        });
    });
</script>
<!-- END Ajax modal  -->

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