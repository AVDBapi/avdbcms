<?php    
    $assets_dir         =   'assets/theme/default/';
    $favicon            =   ovoo_config('favicon');
    $front_end_theme    =   ovoo_config('front_end_theme');   
?>   

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Razorpay Payment - <?php echo $site_name; ?></title>
        <link rel="shortcut icon" href="<?php echo base_url('uploads/system_logo/').$favicon; ?>">       
    </head>
    <body>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <form name='razorpayform' action="<?php echo base_url('subscription/save_razorpay') ?>" method="POST">
            <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
            <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
        </form>
        <script>
            var options = <?php echo json_encode($razorpay_options)?>;
            options.handler = function (response){
                console.log(response);
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                document.getElementById('razorpay_signature').value = response.razorpay_signature;
                document.razorpayform.submit();
            };
            options.theme.image_padding = false;
            options.modal = {
                ondismiss: function() {
                    console.log("This code runs when the popup is closed");
                },
                escape: false,
                backdropclose: false
            };
            var rzp = new Razorpay(options);
            rzp.open();
        </script>
    </body>
</html>