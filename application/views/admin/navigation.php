<?php $active_menu = $this->session->userdata('active_menu'); ?>
<!-- Side-Nav-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item <?php if ($active_menu == 1) { echo " active "; } ?>" href="<?php echo base_url() . "admin/dashboard "; ?>">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label"><?php echo trans('dashboard') ?></span>
            </a>
        </li>
        <li class="treeview <?php if ($active_menu == 6 || $active_menu == 8 || $active_menu == 9) { echo " is-expanded "; } ?>">
            <a href="#" class="app-menu__item" data-toggle="treeview">
                <i class="app-menu__icon fa fa-video-camera" aria-hidden="true"></i>
                <span class="app-menu__label"><?php echo trans('movie') ?> :: <?php echo trans('video') ?> </span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item <?php if ($active_menu == 6) {  echo " active "; } ?>" href="<?php echo base_url() . 'admin/videos_add/' ?>">
                        <i class="app-menu__icon fa fa-plus"></i>
                        <?php echo trans('new_movie_or_video') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 8) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/videos/' ?>">
                        <i class="app-menu__icon fa fa-list"></i>
                        <?php echo trans('all_movie_or_video') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 9) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/video_type/' ?>">
                        <i class="app-menu__icon fa fa-tags"></i>
                        <?php echo trans('movie_or_video_type') ?> </span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview <?php if ($active_menu == 28 || $active_menu == 29 || $active_menu == 30) { echo " is-expanded "; } ?>">
            <a href="#" class="app-menu__item" data-toggle="treeview">
                <i class="app-menu__icon fa fa-film" aria-hidden="true"></i>
                <span class="app-menu__label"><?php echo trans('tv_series') ?></span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item <?php if ($active_menu == 29) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/tvseries_add/' ?>">
                        <i class="app-menu__icon fa fa-plus" aria-hidden="true"></i>
                        <?php echo trans('new_tv_series') ?></span>
                    </a>
                </li>
                <li><a class="treeview-item <?php if ($active_menu == 30) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/tvseries/' ?>">
                        <i class="app-menu__icon fa fa-list" aria-hidden="true"></i>
                        <?php echo trans('all_tv_series') ?> </span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 28) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/tv_series_setting/' ?>">
                        <i class="app-menu__icon fa fa-gear" aria-hidden="true"></i>
                        <?php echo trans('setting') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview <?php if ($active_menu == 26 || $active_menu == 27 || $active_menu == 35 || $active_menu == 39) { echo " is-expanded "; } ?>">
            <a href="#" class="app-menu__item" data-toggle="treeview">
                <i class="app-menu__icon fa fa-tv" aria-hidden="true"></i>
                <span class="app-menu__label"><?php echo trans('tv') ?>&nbsp;
                    <span class="label label-danger"><?php echo trans('live') ?></span>
                </span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item <?php if ($active_menu == 35) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/manage_live_tv/new' ?>">
                        <i class="app-menu__icon fa fa-plus" aria-hidden="true"></i>
                        <?php echo trans('new_tv_channel') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 26) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/manage_live_tv/' ?>">
                        <i class="app-menu__icon fa fa-list" aria-hidden="true"></i>
                        <?php echo trans('all_tv_channel') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 39) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/live_tv_category/' ?>">
                        <i class="app-menu__icon fa fa-tags" aria-hidden="true"></i>
                        <?php echo trans('category') ?> </span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 27) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/live_tv_setting/' ?>">
                        <i class="app-menu__icon fa fa-gear" aria-hidden="true"></i>
                        <?php echo trans('setting') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="app-menu__item <?php if ($active_menu == 7) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/movie_importer/' ?>">
                <i class="app-menu__icon fa fa-search" aria-hidden="true"></i>
                <span class="app-menu__label"><?php echo trans('search_and_import') ?></span>
            </a>
        </li>
        <li>
            <a class="app-menu__item <?php if ($active_menu == 2) { echo " active "; } ?>" href="<?php echo base_url(); ?>admin/country">
                <i class="app-menu__icon fa fa-globe"></i>
                <span class="app-menu__label"><?php echo trans('country') ?></span>
            </a>
        </li>
        <li>
            <a class="app-menu__item <?php if ($active_menu == 3) { echo " active "; } ?>" href="<?php echo base_url(); ?>admin/genre">
                <i class="app-menu__icon fa fa-archive"></i>
                <span class="app-menu__label"><?php echo trans('genre') ?></span>
            </a>
        </li>
        <li>
            <a class="app-menu__item <?php if ($active_menu == 333) { echo " active "; } ?>" href="<?php echo base_url(); ?>admin/movie_language">
                <i class="app-menu__icon fa fa-language"></i>
                <span class="app-menu__label"><?php echo trans('movie_language') ?></span>
            </a>
        </li>
        <li class="treeview <?php if ($active_menu == 4 || $active_menu == 5) { echo " is-expanded "; } ?>">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-stack-overflow"></i>
                <span class="app-menu__label"><?php echo trans('slider') ?></span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item <?php if ($active_menu == 4) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/slider/' ?>">
                        <i class="app-menu__icon fa fa-stack-overflow"></i>
                        <?php echo trans('image_slider') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 5) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/slider_setting/' ?>">
                        <i class="app-menu__icon fa fa-gears" aria-hidden="true"></i>
                        <?php echo trans('slider_setting') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview <?php if ($active_menu == 31 || $active_menu == 32 || $active_menu == 33) { echo " is-expanded "; } ?>">
            <a href="#" class="app-menu__item" data-toggle="treeview"><i class="app-menu__icon fa fa-comment"></i>
                <span class="app-menu__label"><?php echo trans('comments') ?></span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li><a class="treeview-item <?php if ($active_menu == 31) {
                        echo " active ";
                    } ?>" href="<?php echo base_url() . 'admin/comments/' ?>"><i
                                class="app-menu__icon fa fa-comments"></i><?php echo trans('movie_or_tv_comments') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 33) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/comments/post_comments' ?>">
                        <i class="app-menu__icon fa fa-comments"></i>
                        <?php echo trans('post_comments') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 32) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/comments_setting/' ?>">
                        <i class="app-menu__icon fa fa-gears"></i>
                        <?php echo trans('comments_setting') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview <?php if ($active_menu == 10 || $active_menu == 11) { echo " is-expanded "; } ?>">
            <a href="#" class="app-menu__item" data-toggle="treeview">
                <i class="app-menu__icon fa fa-file" aria-hidden="true"></i>
                <span class="app-menu__label"><?php echo trans('pages') ?></span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item <?php if ($active_menu == 10) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/pages_add/' ?>">
                        <i class="app-menu__icon fa fa-plus" aria-hidden="true"></i>
                        <?php echo trans('new_pages') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 11) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/pages/' ?>">
                        <i class="app-menu__icon fa fa-list" aria-hidden="true"></i>
                        <?php echo trans('all_pages') ?> </span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="treeview <?php if ($active_menu == 12 || $active_menu == 13 || $active_menu == 14) { echo " is-expanded "; } ?>">
            <a href="#" class="app-menu__item" data-toggle="treeview">
                <i class="app-menu__icon  fa fa-pencil-square-o" aria-hidden="true"></i>
                <span class="app-menu__label"><?php echo trans('post') ?></span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item <?php if ($active_menu == 12) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/posts_add/' ?>">
                        <i class="app-menu__icon fa fa-plus" aria-hidden="true"></i>
                        <?php echo trans('new_post') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 13) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/posts/' ?>">
                        <i class="app-menu__icon fa fa-list" aria-hidden="true"></i>
                        <?php echo trans('all_post') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 14) {
                        echo " active "; } ?>" href="<?php echo base_url() . 'admin/post_category/' ?>">
                        <i class="app-menu__icon fa fa-tags" aria-hidden="true"></i>
                        <?php echo trans('category') ?> </span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="app-menu__item <?php if ($active_menu == 25) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/manage_star' ?>">
                <i class="app-menu__icon fa fa-users"></i>
                <span class="app-menu__label"><?php echo trans('actor_or_director') ?></span>
            </a>
        </li>
        <li>
            <a class="app-menu__item <?php if ($active_menu == 15) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/manage_user' ?>">
                <i class="app-menu__icon fa fa-user"></i>
                <span class="app-menu__label"><?php echo trans('users') ?></span>
            </a>
        </li>
        <li>
            <a class="app-menu__item <?php if($active_menu==4001) {echo "active"; } ?>" href="<?php echo base_url().'admin/request_manage'?>"><i class="app-menu__icon fa fa-paper-plane-o"></i><span class="app-menu__label">MOVIE REQUEST</span></a>
        </li>
        <li>
            <a class="app-menu__item <?php if($active_menu==4002) {echo "active"; } ?>" href="<?php echo base_url().'admin/report_manage'?>"><i class="app-menu__icon fa fa-flag-o"></i><span class="app-menu__label">REPORT</span></a>
        </li>

        <li class="treeview <?php if ($active_menu == 16 || $active_menu == 17 || $active_menu == 18 || $active_menu == 19 || $active_menu == 20 || $active_menu == 21 || $active_menu == 22 || $active_menu == 24 || $active_menu == 34 || $active_menu == 350 || $active_menu == 78 || $active_menu == 79 || $active_menu == 80 || $active_menu == 160 || $active_menu == 161 || $active_menu == 162 || $active_menu == 40) {echo " is-expanded "; } ?>">
            <a href="#" class="app-menu__item" data-toggle="treeview">
                <i class="app-menu__icon fa fa-gears" aria-hidden="true"></i>
                <span class="app-menu__label"><?php echo trans('setting') ?></span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item <?php if ($active_menu == 160) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/system_setting/' ?>">
                        <i class="app-menu__icon fa fa-gear" aria-hidden="true"></i>
                        <?php echo trans('system_setting') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 16) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/theme_options/' ?>">
                        <i class="app-menu__icon fa fa-gear" aria-hidden="true"></i>
                        <?php echo trans('theme_options') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 40) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/android_setting/' ?>">
                        <i class="app-menu__icon fa fa-android" aria-hidden="true"></i>
                        <?php echo trans('android_setting') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 17) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/email_setting/' ?>">
                        <i class="app-menu__icon fa fa-envelope" aria-hidden="true"></i>
                        <?php echo trans('email_setting') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 18) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/logo_setting/' ?>">
                        <i class="app-menu__icon fa fa-picture-o"  aria-hidden="true"></i>
                        <?php echo trans('logo_and_favicon') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 19) {  echo " active "; } ?>" href="<?php echo base_url() . 'admin/footer_setting/' ?>">
                        <i class="app-menu__icon fa fa-list-alt" aria-hidden="true"></i>
                        <?php echo trans('footer_content') ?> </span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 20) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/seo_setting/' ?>">
                        <i class="app-menu__icon fa fa-facebook" aria-hidden="true"></i>
                        <?php echo trans('seo_and_socials') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 21) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/ad_setting/' ?>">
                        <i class="app-menu__icon fa fa-dollar" aria-hidden="true"></i>
                        <?php echo trans('ads_and_banner') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 79) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/mobile_ads_setting/' ?>">
                        <i class="app-menu__icon fa fa-dollar" aria-hidden="true"></i>
                        <?php echo trans('mobile_ads_setting') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 162) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/api_setting/' ?>">
                        <i class="app-menu__icon fa fa-exchange" aria-hidden="true"></i>
                        <?php echo trans('api_setting') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 22) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/social_login_setting/' ?>">
                        <i class="app-menu__icon fa fa-dollar" aria-hidden="true"></i>
                        <?php echo trans('social_login') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 24) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/video_quality/' ?>">
                        <i class="app-menu__icon fa fa-signal" aria-hidden="true"></i>
                        <?php echo trans('movie_or_video_quality') ?> </span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 34) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/player_setting/' ?>">
                        <i class="app-menu__icon fa fa-gear" aria-hidden="true"></i>
                        <?php echo trans('player_options') ?> </span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 350) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/copyright_privacy/' ?>">
                        <i class="app-menu__icon fa fa-copyright" aria-hidden="true"></i>
                        <?php echo trans('copyright_and_privacy') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 78) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/cron_setting/' ?>">
                        <i class="app-menu__icon fa fa-clock-o" aria-hidden="true"></i>
                        <?php echo trans('cron_setting') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 80) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/tmdb_setting/' ?>">
                        <i class="app-menu__icon fa fa-gear" aria-hidden="true"></i>
                        <?php echo trans('tmdb_setting') ?></span>
                    </a>
                </li>
                <li>
                    <a class="treeview-item <?php if ($active_menu == 161) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/update/' ?>">
                        <i class="app-menu__icon fa fa-upload" aria-hidden="true"></i>
                        <?php echo trans('update') ?></span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="app-menu__item <?php if ($active_menu == 179) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/language_setting' ?>">
                <i class="app-menu__icon fa fa-language"></i>
                <span class="app-menu__label"><?php echo trans('language') ?></span>
            </a>
        </li>
        <li class="treeview <?php if($active_menu==301 || $active_menu==302 || $active_menu==303|| $active_menu==3001 || $active_menu==3002) {echo "is-expanded"; } ?>"> <a href="#" class="app-menu__item" data-toggle="treeview"><i class="app-menu__icon fa fa-coffee"></i><span class="app-menu__label">SUBSCRIPTION</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item <?php if($active_menu==301) {echo "active"; } ?>" href="<?php echo base_url().'subscription/package/'?>" ><i class="app-menu__icon fa  fa fa-check"></i><?php echo trans("package");?> </a></li>
            <li><a class="treeview-item <?php if($active_menu==3002) {echo "active"; } ?>" href="<?php echo base_url().'subscription/payment_setting'?>"><i class="app-menu__icon fa fa fa-dollar" aria-hidden="true"></i><?php echo trans("payment_setting");?></a></li>
            <li><a class="treeview-item <?php if($active_menu==302) {echo "active"; } ?>" href="<?php echo base_url().'subscription/sub_setting'?>"><i class="app-menu__icon fa fa fa-wrench" aria-hidden="true"></i><?php echo trans("setting");?></a></li>
            <li><a class="treeview-item <?php if($active_menu==3001) {echo "active"; } ?>" href="<?php echo base_url().'subscription/transaction_history'?>"><i class="app-menu__icon fa fa fa-clock-o" aria-hidden="true"></i><?php echo trans("transaction_log");?></a></li>
          </ul>
        </li>
        <li class="treeview <?php if($active_menu == 36 || $active_menu == 37 || $active_menu == 370 || $active_menu == 371) {echo "is-expanded"; } ?>"> <a href="#" class="app-menu__item" data-toggle="treeview"><i class="app-menu__icon fa fa-bell" aria-hidden="true"></i><span class="app-menu__label"><?php echo trans("notification");?></span> <i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
              
              <li><a class="treeview-item <?php if($active_menu==37) {echo "active"; } ?>" href="<?php echo base_url().'admin/send_live_tv_notification/'?>"><i class="app-menu__icon fa fa-paper-plane-o" aria-hidden="true"></i><?php echo trans("live_tv");?></span> </a></li>
              <li><a class="treeview-item <?php if($active_menu==370) {echo "active"; } ?>" href="<?php echo base_url().'admin/send_movie_tvseries_notification/'?>"><i class="app-menu__icon fa fa-paper-plane-o" aria-hidden="true"></i><?php echo trans("movie_and_tvseries");?></span> </a></li>
              <li><a class="treeview-item <?php if($active_menu==371) {echo "active"; } ?>" href="<?php echo base_url().'admin/send_web_notification/'?>"><i class="app-menu__icon fa fa-paper-plane-o" aria-hidden="true"></i><?php echo trans("webview");?></span> </a></li>
              <li><a class="treeview-item <?php if($active_menu==36) {echo "active"; } ?>" href="<?php echo base_url().'admin/push_notification_setting/'?>"><i class="app-menu__icon fa fa-gear" aria-hidden="true"></i><?php echo trans("setting");?></span> </a></li>
            </ul>
          </li>
        <li>
            <a class="app-menu__item <?php if ($active_menu == 23) { echo " active "; } ?>" href="<?php echo base_url() . 'admin/backup_restore' ?>">
                <i class="app-menu__icon fa fa-database"></i>
                <span class="app-menu__label"><?php echo trans('backup') ?></span>
            </a>
        </li>
        
    </ul>
</aside>