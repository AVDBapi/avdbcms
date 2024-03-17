<?php 
    $site_name   =   $this->db->get_where('config' , array('title'=>'site_name'))->row()->value;
    $assets_dir  =   'assets/theme/default/';
    $favicon     =   ovoo_config('favicon');
    $front_end_theme =   ovoo_config('front_end_theme');
?>   

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Stripe Payment - <?php echo $site_name; ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo base_url('uploads/system_logo/').$favicon; ?>">
        <!-- Style Sheets -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/additional.css">
        <!-- Font Icons -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/socicon-styles.css">
        <!-- Font Icons -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/hover-min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/animate.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/styles.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/responsive.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/<?php echo $front_end_theme; ?>.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/stripe.css">
        <script src="<?php echo base_url($assets_dir); ?>js/jquery-2.2.4.min.js" crossorigin="anonymous"></script>
    </head>
    <body>        
        <form method="post" action="<?php echo base_url('subscription/stripe/'.$plan_id);?>">            
            <label>
                <div id="card-element" class="field is-empty"></div>
                <span><span>Enter Credit / Debit card</span></span>
            </label>
            <button type="submit" class="btn btn-primary btn-block" id="stripe-pay-button">pay now</button>
            <div class="outcome">
                <div class="error" role="alert"></div>
                <div class="success">
                  Success! Your Stripe token is <span class="token"></span>
                </div>
            </div>
            <input type="hidden" name="stripeToken" value="">
        </form>
        <script src="https://js.stripe.com/v3/"></script>
        <script>
            var stripe = Stripe('<?php echo $this->db->get_where('config',array('title'=>'stripe_publishable_key'))->row()->value;?>'); 
            var elements = stripe.elements();
            var card = elements.create("card", {
                iconStyle: "solid",
                style: {
                    base: {
                        iconColor: "#8898AA",
                        color: "white",
                        lineHeight: "36px",
                        fontWeight: 300,
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSize: "19px",

                        "::placeholder": {
                            color: "#8898AA"
                        }
                    },
                    invalid: {
                        iconColor: "#e85746",
                        color: "#e85746"
                    }
                },
                classes: {
                    focus: "is-focused",
                    empty: "is-empty"
                }
            });
            card.mount("#card-element");

            var inputs = document.querySelectorAll("input.field");
            Array.prototype.forEach.call(inputs, function(input) {
                input.addEventListener("focus", function() {
                    input.classList.add("is-focused");
                });
                input.addEventListener("blur", function() {
                    input.classList.remove("is-focused");
                });
                input.addEventListener("keyup", function() {
                    if (input.value.length === 0) {
                        input.classList.add("is-empty");
                    } else {
                        input.classList.remove("is-empty");
                    }
                });
            });

            var form = document.querySelector("form");
            function setOutcome(result) {
                var successElement = document.querySelector(".success");
                var errorElement = document.querySelector(".error");
                successElement.classList.remove("visible");
                errorElement.classList.remove("visible");

                if (result.token) {                    
                    form.querySelector("input[name=stripeToken]").value = result.token.id;
                    form.submit();
                } else if (result.error) {
                    errorElement.textContent = result.error.message;
                    errorElement.classList.add("visible");
                }
            }

            card.on("change", function(event) {
                setOutcome(event);
            });

            document.querySelector("form").addEventListener("submit", function(e) {
                e.preventDefault();
                var extraDetails = {
                };
                stripe.createToken(card, extraDetails).then(setOutcome);
            });
        </script>
    </body>
</html>