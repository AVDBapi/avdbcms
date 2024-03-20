<?php
$default_meta_description = ovoo_config('meta_description');
$default_focus_keyword = ovoo_config('focus_keyword');
$author = ovoo_config('author');
$front_end_theme = ovoo_config('front_end_theme');
$theme_dir = 'theme/' . ovoo_config('active_theme') . '/';
$assets_dir = 'assets/theme/' . ovoo_config('active_theme') . '/';
$dark_theme = ovoo_config('dark_theme');
$google_analytics_id = ovoo_config('google_analytics_id');
$footer_templete = ovoo_config('footer_templete');
$share_this_enable = ovoo_config('social_share_enable');
$push_notification_enable = ovoo_config('push_notification_enable');
$site_name = ovoo_config('site_name');
$recaptcha_enable = ovoo_config('recaptcha_enable');
$favicon = ovoo_config('favicon');
$enable_ribbon = ovoo_config('enable_ribbon');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description"
        content="<?php if (isset ($meta_description)) {
            echo $meta_description;
        } else {
            echo $default_meta_description;
        } ?>" />
    <meta name="keywords"
        content="<?php if (isset ($focus_keyword)) {
            echo $focus_keyword;
        } else {
            echo $default_focus_keyword;
        } ?>" />
    <meta name="author" content="<?php echo $author; ?>" />
    <link rel="canonical"
        href="<?php if (isset ($canonical) && !empty ($canonical)):
            echo $canonical; else:
            echo base_url(); endif; ?>">
    <?php if ($page_name == 'watch' || $page_name == 'watch_tv' || $page_name == 'blog_details'): ?>
        <meta property="og:locale" content="en_US" />
        <meta name="twitter:card" content="summary">
        <meta name="twitter:description" content="<?php echo $meta_description; ?>" />
        <meta name="twitter:title" content="<?php echo $og_title; ?>" />
        <meta property="og:title" content="<?php echo $og_title; ?>" />
        <meta property="og:url" content="<?php echo $og_url; ?>" />
        <meta property="og:type" content="movie" />
        <meta property="og:description" content="<?php echo $meta_description; ?>" />
        <meta property="og:image" content="<?php echo $og_image_url; ?>" />
    <?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php if (isset ($title) && !empty ($title)):
            echo $title; else:
            echo $site_name; endif; ?>
    </title>
    <link rel="shortcut icon" href="<?php echo base_url('uploads/system_logo/') . $favicon; ?>">

    <script src="<?php echo base_url($assets_dir); ?>js/jquery-2.2.4.min.js" crossorigin="anonymous"></script>

    <?php if ($page_name == 'watch' || $page_name == 'watch_tv'): ?>
        <link href="<?php echo base_url(); ?>assets/player/video-js-6.13.0/video-js.css" rel="stylesheet"
            type="text/css">
        <link href="<?php echo base_url(); ?>assets/player/plugins/videojs-mobile-ui/videojs-mobile-ui.css"
            rel="stylesheet" type="text/css">
        <!-- tube skin CSS -->
        <!-- <link href="<?php echo base_url(); ?>assets/player/plugins/tube-skin/videojs-tube.min.css" media="only screen and (min-width: 820px)" rel="stylesheet"/> -->
        <script src="<?php echo base_url(); ?>assets/player/video-js-6.13.0/video.min.js"
            crossorigin="anonymous"></script>
        <script
            src="<?php echo base_url(); ?>assets/player/plugins/videojs-mobile-ui/videojs-mobile-ui.min.js"></script>
        <!-- watermark CSS -->
        <link href="<?php echo base_url(); ?>assets/player/plugins/watermark/videojs-logo.min.css" rel="stylesheet">
        <!-- social share CSS -->
        <link href="<?php echo base_url(); ?>assets/player/plugins/videojs-share/videojs-share.css" rel="stylesheet">
        <!-- social share CSS -->
        <link href="<?php echo base_url(); ?>assets/player/plugins/videojs-seek-buttons/videojs-seek-buttons.css"
            rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/player/plugins/tube-skin/videojs-tube.min.css" rel="stylesheet"
            type="text/css">

        <!-- videojs-chromecast js -->
        <script
            src="<?php echo base_url(); ?>assets/player/plugins/silvermine-videojs-chromecast/silvermine-videojs-chromecast.min.js"></script>
        <!-- videojs-chromecast CSS -->
        <link
            href="<?php echo base_url(); ?>assets/player/plugins/silvermine-videojs-chromecast/silvermine-videojs-chromecast.css"
            rel="stylesheet">
        <!-- chromecast sdk -->
        <script type="text/javascript"
            src="https://www.gstatic.com/cv/js/sender/v1/cast_sender.js?loadCastFramework=1"></script>

        <?php if ($page_name == 'watch'): ?>
            <!-- magnific popup -->
            <link rel="stylesheet" type="text/css"
                href="<?php echo base_url(); ?>assets/plugins/magnific-popup/dist/magnific-popup.css">
        <?php endif; ?>

    <?php endif; ?>

    <?php if ($recaptcha_enable == '1'): ?>
        <!-- reCAPTCHA JavaScript API -->
        <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php endif; ?>

    <!-- typehead search  -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- typehead search  -->
    <style>
        .bg_img {
            background-image: url(<?php echo (ovoo_config("bg_image") != '' && file_exists('uploads/bg/' . ovoo_config("bg_image"))) ? base_url('uploads/bg/') . ovoo_config("bg_image") : base_url('uploads/bg/bg.jpg'); ?>);
        }
    </style>
    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/styles.css">
</head>

<body class="deep-black scroll-smooth antialiased relative text-white font-inter">
    <div id="wrapper">
        <div id="main-content" class="container px-3 md:px-0">
            <?php $this->load->view($theme_dir . 'header');?>

            <div class="pt-0 md:pt-20">
                <?php
                $this->load->view($theme_dir . $page_name);
                $this->load->view($theme_dir . 'footer/' . $footer_templete);
                $this->load->view($theme_dir . 'movie_request');
                ?>
            </div>
        </div>
    </div>
    <a href="#" class="scrollToTop"><i class="fa fa-angle-up"></i></a>

    <script type="text/javascript" charset="utf8"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
    <!-- lazy image loading -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.6/jquery.lazy.min.js"></script>
    <script type="text/javascript"
        src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.6/jquery.lazy.plugins.min.js"></script>
    <!-- end lazy image loading -->
    <script src="<?php echo base_url($assets_dir); ?>js/ovoo.js"></script>

    <?php if ($google_analytics_id != '' && $google_analytics_id != NULL && !empty ($google_analytics_id)): ?>
        <!-- Google analytics -->
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
            ga('create', '<?php echo $google_analytics_id; ?>', 'auto');
            ga('send', 'pageview');
        </script>
        <!-- END Google analytics -->
    <?php endif; ?>

    <?php if ($share_this_enable == '1'): ?>
        <!-- Go to www.addthis.com/dashboard to customize your tools -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58d74b9dcfd76af7"></script>
    <?php endif; ?>
    <!--sweet alert2 JS -->
    <script src="<?php echo base_url(); ?>assets/plugins/swal2/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function () {
            var success_message = '<?php echo $this->session->flashdata('success'); ?>';
            var error_message = '<?php echo $this->session->flashdata('error'); ?>';
            if (success_message != '') {
                swal('Success!', success_message, 'success');
            }
            if (error_message != '') {
                swal('Error!', error_message, 'error');
            }
        });
    </script>
    <?php
    if ($push_notification_enable == '1'):
        $onesignal_appid = ovoo_config('onesignal_appid');
        $onesignal_actionmessage = ovoo_config('onesignal_actionmessage');
        $onesignal_acceptbuttontext = ovoo_config('onesignal_acceptbuttontext');
        $onesignal_cancelbuttontext = ovoo_config('onesignal_cancelbuttontext');
        ?>
        <!-- oneSignal -->
        <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
        <script>
            var OneSignal = window.OneSignal || [];
            OneSignal.push(["init", {
                appId: "<?php echo $onesignal_appid; ?>",
                subdomainName: 'push',
                autoRegister: false,
                promptOptions: {
                    actionMessage: "<?php echo $onesignal_actionmessage; ?>",
                    acceptButtonText: "<?php echo $onesignal_acceptbuttontext; ?>",
                    cancelButtonText: "<?php echo $onesignal_cancelbuttontext; ?>"
                }
            }]);
        </script>
        <script>
            function subscribe() {
                OneSignal.push(["registerForPushNotifications"]);
                event.preventDefault();
            }
            function unsubscribe() {
                OneSignal.setSubscription(true);
            }

            var OneSignal = OneSignal || [];
            OneSignal.push(function () {
                OneSignal.on('subscriptionChange', function (isSubscribed) {
                    console.log("The user's subscription state is now:", isSubscribed);
                    OneSignal.sendTag("user_id", "4444", function (tagsSent) {
                        console.log("Tags have finished sending!");
                    });
                });

                var isPushSupported = OneSignal.isPushNotificationsSupported();
                if (isPushSupported) {
                    OneSignal.isPushNotificationsEnabled().then(function (isEnabled) {
                        if (isEnabled) {
                            console.log("Push notifications are enabled!");

                        } else {
                            OneSignal.showHttpPrompt();
                            console.log("Push notifications are not enabled yet.");
                        }
                    });

                } else {
                    console.log("Push notifications are not supported.");
                }
            });
        </script>
    <?php endif; ?>
    <?php if ($page_name == 'watch'): ?>
        <!-- magnific popup -->
        <script src="<?php echo base_url(); ?>assets/plugins/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.popup-youtube').magnificPopup({
                    type: 'iframe'
                });
            });
        </script>
    <?php endif; ?>
</body>

</html>