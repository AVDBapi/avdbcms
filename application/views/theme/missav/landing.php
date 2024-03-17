<?php    
    $default_meta_description       =   $this->db->get_where('config' , array('title'=>'meta_description'))->row()->value;
    $default_focus_keyword          =   $this->db->get_where('config' , array('title'=>'focus_keyword'))->row()->value;
    $author                         =   $this->db->get_where('config' , array('title'=>'author'))->row()->value;
    $front_end_theme                =   $this->db->get_where('config' , array('title'=>'front_end_theme'))->row()->value;
    $theme_dir                      =   'theme/default/';
    $assets_dir                     =   'assets/theme/default/';
    $dark_theme                     =   $this->db->get_where('config' , array('title'=>'dark_theme'))->row()->value;
    $google_analytics_id            =   $this->db->get_where('config' , array('title'=>'google_analytics_id'))->row()->value;
    $header_templete                =   $this->db->get_where('config' , array('title'=>'header_templete'))->row()->value;   
    $footer_templete                =   $this->db->get_where('config' , array('title'=>'footer_templete'))->row()->value;
    $share_this_enable              =   $this->db->get_where('config' , array('title' =>'social_share_enable'))->row()->value;    
    $site_name              		=   $this->db->get_where('config' , array('title' =>'site_name'))->row()->value;
    $registration_enable            =   $this->db->get_where('config' , array('title' =>'registration_enable'))->row()->value;    
	$frontend_login_enable          =   $this->db->get_where('config' , array('title' =>'frontend_login_enable'))->row()->value;   
	$landing_page_image_url         =   'uploads/'.ovoo_config('landing_bg');  
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="canonical" href="<?php if(isset($canonical) && !empty($canonical)): echo $canonical; else: echo base_url(); endif; ?>">
		<meta name="description" content="<?php if (isset($meta_description)) { echo $meta_description;} else{ echo $default_meta_description;} ?>">
		<meta name="keywords" content="<?php if (isset($focus_keyword)) { echo $focus_keyword;} else{ echo $default_focus_keyword ; } ?>">
		<meta name="author" content="<?php echo $author; ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php if(isset($title) && !empty($title)): echo $title; else: echo $site_name; endif; ?></title>   
		<link rel="shortcut icon" href="<?php echo base_url(); ?>uploads/system_logo/favicon.ico">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/additional.css">
		<!-- Font Icons -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/font-awesome.min.css">
		<script src="<?php echo base_url($assets_dir); ?>js/jquery-2.2.4.min.js" crossorigin="anonymous"></script>
		<script src="<?php echo base_url($assets_dir); ?>js/bootstrap.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir.'landing/'); ?>style.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir.'landing/'); ?>header.css">
		<!-- typehead search  -->
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<link href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" rel="stylesheet" type="text/css" media="all"/>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url($assets_dir); ?>css/auto-complete.css">
		<!-- typehead search  -->
		<style>
			#body-search {
				background-image: url(<?php echo ($landing_page_image_url !='') ? $landing_page_image_url : base_url('uploads/landing_page/bg.jpg'); ?>);
			}
			.search-box .input-search {
			    height: 56px;
			    background: #fff;
			    font-size: 20px;
			    padding-left: 20px;
			    padding-right: 90px;
			    box-shadow: none;
			    color: #111;
			    border: 1px solid rgba(0, 0, 0, 0.2);
			    border-radius: 5px;
			    border-radius: 5px 0 0 5px;
			}
			.input-group-addon {
			    padding: 6px 12px;
			    font-size: 14px;
			    font-weight: 400;
			    line-height: 1;
			    color: #555;
			    text-align: center;
			    background-color: <?php if($front_end_theme =='blue'): echo "#0088cc";elseif($front_end_theme =='green'): echo "#5DC560";elseif($front_end_theme =='red'): echo "#ff0000";elseif($front_end_theme =='yellow'): echo "#FDD922";elseif($front_end_theme =='purple'): echo "#6d0eb1";else: echo "#0088cc";endif; ?>;
			    border: none;
			    border-radius: 4px;
			}
			.btn-all-movie {
				background-color: <?php if($front_end_theme =='blue'): echo "#0088cc";elseif($front_end_theme =='green'): echo "#5DC560";elseif($front_end_theme =='red'): echo "#ff0000";elseif($front_end_theme =='yellow'): echo "#FDD922";elseif($front_end_theme =='purple'): echo "#6d0eb1";else: echo "#0088cc";endif; ?>;
				border-color: <?php if($front_end_theme =='blue'): echo "#0088c9";elseif($front_end_theme =='green'): echo "#5DC569";elseif($front_end_theme =='red'): echo "#ff0009";elseif($front_end_theme =='yellow'): echo "#FDD929";elseif($front_end_theme =='purple'): echo "#6d0eb9";else: echo "#0088c9";endif; ?>;
			}
			.btn-all-movie:hover {
			    background-color: <?php if($front_end_theme =='blue'): echo "#0088c9";elseif($front_end_theme =='green'): echo "#5DC569";elseif($front_end_theme =='red'): echo "#ff0009";elseif($front_end_theme =='yellow'): echo "#FDD929";elseif($front_end_theme =='purple'): echo "#6d0eb9";else: echo "#0088c9";endif; ?>;
				border-color: <?php if($front_end_theme =='blue'): echo "#0088c9";elseif($front_end_theme =='green'): echo "#5DC569";elseif($front_end_theme =='red'): echo "#ff0009";elseif($front_end_theme =='yellow'): echo "#FDD929";elseif($front_end_theme =='purple'): echo "#6d0eb9";else: echo "#0088c9";endif; ?>;
			}
			.submit_btn{
				background-color: transparent;
			    border: none;
			    color: #fff;
			    font-size: 18px;
			}
			.search_container{
				padding-top: 150px;
			}

			.footer_container{
				padding-top: 150px;
			}		
		</style>
	</head>
	<body id="body-search">
		<div id="bh-header">
			<div id="bhh-menu">
				<ul class="top-menu">
					<li class="active"><a href="<?php echo base_url(); ?>" title="<?php echo trans('home'); ?>"><?php echo trans('home'); ?></a></li>
					<li><a href="<?php echo base_url('movies.html'); ?>" title="<?php echo trans('movies'); ?>"><?php echo trans('movies'); ?></a></li>
					<?php 
		              $tv_series_publish          = $this->db->get_where('config',array('title'=>'tv_series_publish'))->row()->value;
		              $tv_series_pin_primary_menu = $this->db->get_where('config',array('title'=>'tv_series_pin_primary_menu'))->row()->value;
		              if($tv_series_publish =='1' && $tv_series_pin_primary_menu =='1'):
		            ?>
					<li><a href="<?php echo base_url('tv-series.html'); ?>" title="<?php echo trans('tv_series'); ?>"><?php echo trans('tv_series'); ?></a></li>
					<?php endif; ?>
					<?php 
		              $live_tv_publish          = $this->db->get_where('config',array('title'=>'live_tv_publish'))->row()->value;
		              $live_tv_pin_primary_menu = $this->db->get_where('config',array('title'=>'live_tv_pin_primary_menu'))->row()->value;
		              if($live_tv_publish =='1' && $live_tv_pin_primary_menu =='1'):
		            ?>
					<li><a href="<?php echo base_url('live-tv.html'); ?>" title="<?php echo trans('live_tv'); ?>"><?php echo trans('tv'); ?></a></li>
					<?php endif; ?>
				</ul>
				<div class="clearfix"></div>
			</div>
		</div>

		<div class="container search_container">
			<div class="row text-center">
				<div class="clo-md-12">
					<div style="margin-bottom: 40px;">
						<a href="<?php echo base_url(); ?>">
							<img src="<?php echo base_url(); ?>uploads/system_logo/<?php echo ovoo_config('logo'); ?>" alt="logo">
						</a>

					</div>

				</div>
				<form action="<?php echo base_url('search') ?>" method="get">
			        <div class="col-sm-6 col-sm-offset-3">
			            <div id="imaginary_container">
			            	<?php  if($share_this_enable =='1'):?>
		                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
		                        <div class="addthis_inline_share_toolbox_yl99 m-t-30 m-b-10" data-url="<?php echo base_url();?>" data-title="<?php echo base_url(); ?>"></div>
		                        <!-- Addthis Social tool -->
		                    <?php endif; ?>
			                <div class="input-group stylish-input-group search-box">
			                    <input type="text" name="q" class="form-control input-search"  autocomplete="off" id="search-input" placeholder="<?php echo trans('search'); ?>" >
			                    <span class="input-group-addon">
			                        <button type="submit" class="submit_btn">
			                            <?php echo trans('search'); ?>
			                        </button>  
			                    </span>
			                </div>
			            </div>
			        </div>
		        </form>
			</div>
			<div class="row text-center" style="margin-top: 20px;">
				<a href="<?php echo base_url('all-movies.html') ?>" class="btn btn-success btn-all-movie"><?php echo trans('brows_all_movies_and_tvseries'); ?></a>
				<div style="margin-top: 10px;margin-bottom: 10px;">
					<?php 
						if($this->common_model->get_ads_status('billboard')=='1'):
	                        echo $this->common_model->get_ads('billboard');
	                	 endif;
	                ?>
                </div>
			</div>
		</div>

		<div class="copyright footer_container">
			<div class="container">
				<div class="row text-center">
					<p><?php echo trans('copyright'); ?> © <?php echo $site_name.' '.trans('all_rights_reserved'); ?> </p>
					<?php if($this->session->userdata('login_status') == 1): ?>
						<p>
							<a href="<?php echo base_url('my-account/profile') ?>"><?php echo trans('my_account'); ?></a> | <a href="<?php echo base_url('login/logout') ?>"><?php echo trans('logout'); ?></a>
							
						</p>
					<?php else: ?>
						<p>
							<?php if($frontend_login_enable =='1'  && $registration_enable =='1'): ?>
								<a href="<?php echo base_url('user/login') ?>"><?php echo trans('login'); ?></a> | <a href="<?php echo base_url('user/login') ?>"><?php echo trans('signup'); ?></a>
							<?php endif; ?>
						</p>
					<?php endif; ?>
				</div>
				
			</div>
		</div>
		<!-- typehead search  -->
		<script type="text/javascript">
		$(document).ready(function(){
		$("#search-input").autocomplete({
		source: "<?php echo base_url(); ?>/home/autocompleteajax",
		focus: function( event, ui ) {
		//$( "#search" ).val( ui.item.title ); // uncomment this line if you want to select value to search box
		return false;
		},
		select: function( event, ui ) {
		window.location.href = ui.item.url;
		}
		}).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
		var inner_html = '<a href="' + item.url + '" ><div class="list_item_container"><div class="image"><img src="' + item.image + '" ></div><div class="th-title"><b>' + item.title + '</b></div><br><div class="th-title">' + item.type + '</div></div></a>';
		return $( "<li></li>" )
		.data( "item.autocomplete", item )
		.append(inner_html)
		.appendTo( ul );
		};
		});
		</script>
		    
	<?php if($google_analytics_id !='' && $google_analytics_id !=NULL && !empty($google_analytics_id)): ?>
	<!-- Google analytics -->
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
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
	<?php
		$push_notification_enable       =   $this->db->get_where('config' , array('title' =>'push_notification_enable'))->row()->value; 
	    if($push_notification_enable == '1'):
	    $onesignal_appid                    =   $this->db->get_where('config' , array('title' =>'onesignal_appid'))->row()->value;    
	    $onesignal_actionmessage            =   $this->db->get_where('config' , array('title' =>'onesignal_actionmessage'))->row()->value;    
	    $onesignal_acceptbuttontext         =   $this->db->get_where('config' , array('title' =>'onesignal_acceptbuttontext'))->row()->value;    
	    $onesignal_cancelbuttontext         =   $this->db->get_where('config' , array('title' =>'onesignal_cancelbuttontext'))->row()->value;    
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
	            /* These prompt options values configure both the HTTP prompt and the HTTP popup. */
	            /* actionMessage limited to 90 characters */
	            actionMessage: "<?php echo $onesignal_actionmessage;?>",
	            /* acceptButtonText limited to 15 characters */
	            acceptButtonText: "<?php echo $onesignal_acceptbuttontext;?>",
	            /* cancelButtonText limited to 15 characters */
	            cancelButtonText: "<?php echo $onesignal_cancelbuttontext;?>"
	        }
	    }]);
	</script>
	<script>
	    function subscribe() {
	        // OneSignal.push(["registerForPushNotifications"]);
	        OneSignal.push(["registerForPushNotifications"]);
	        event.preventDefault();
	    }
	    function unsubscribe(){
	        OneSignal.setSubscription(true);
	    }

	    var OneSignal = OneSignal || [];
	    OneSignal.push(function() {
	        /* These examples are all valid */
	        // Occurs when the user's subscription changes to a new value.
	        OneSignal.on('subscriptionChange', function (isSubscribed) {
	            console.log("The user's subscription state is now:", isSubscribed);
	            OneSignal.sendTag("user_id","4444", function(tagsSent)
	            {
	                // Callback called when tags have finished sending
	                console.log("Tags have finished sending!");
	            });
	        });

	        var isPushSupported = OneSignal.isPushNotificationsSupported();
	        if (isPushSupported)
	        {
	            // Push notifications are supported
	            OneSignal.isPushNotificationsEnabled().then(function(isEnabled)
	            {
	                if (isEnabled)
	                {
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
	<?php  if($share_this_enable =='1'):?>
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58d74b9dcfd76af7"></script>
    <?php endif; ?>
	</body>
</html>