<section class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
    <!-- Breadcrumb -->
    <div id="title-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <div class="page-title">
                        <h1 class="text-uppercase">
                            <?php echo trans('profile_information'); ?>
                        </h1>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12 text-right">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i><?php echo trans('home'); ?></a>
                        </li>
                        <li class="active"><?php echo trans('profile'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->


    <!-- Profile Section -->
    <div id="section-opt">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="profiles-wrap">
                        <div class="sidebar col-md-3 col-sm-9">
                            <div class="sidebar-menu">
                                <div class="sb-title"><i class="fa fa-navicon mr5"></i> <?php echo trans("menu");?></div>
                                <ul>
                                    <li class="active">
                                        <a href="<?php echo base_url('my-account/profile'); ?>">
                                            <i class="fi ion-ios-person-outline m-r-10"></i> <?php echo trans("profile");?>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo base_url('my-account/subscription'); ?>">
                                            <i class="fi ion-ios-briefcase-outline m-r-10"></i> <?php echo trans("my_subscription");?>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo base_url('my-account/favorite'); ?>">
                                            <i class="fi ion-ios-heart-outline m-r-10"></i><?php echo trans("favorite");?>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo base_url('my-account/watch-later'); ?>">
                                            <i class="fi ion-ios-clock-outline m-r-10"></i> <?php echo trans("watch_later");?>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo base_url('my-account/update'); ?>">
                                            <i class="fi ion-edit m-r-10"></i> <?php echo trans("update_profile");?>
                                        </a>
                                    </li>
                                    <li class="">
                                        <a href="<?php echo base_url('my-account/change-password'); ?>">
                                            <i class="fi ion-key m-r-10"></i> <?php echo trans("change_password");?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="pp-main col-md-9 col-sm-9">
                            <div class="ppm-head">
                                <div class="ppmh-title"><i class="fa fa-user mr5"></i> <?php echo trans('profile'); ?></div>
                            </div>
                            <div class="ppm-content user-content row">
                                <div class="uct-avatar col-md-3">
                                    <img src="<?php echo $this->common_model->get_img('user', $profile_info->user_id).'?'.time(); ?>" title="<?php echo $profile_info->name; ?>" alt="<?php echo $profile_info->name; ?>">
                                </div>
                                <div class="uct-info col-md-9">
                                    <div class="block">
                                        <label><?php echo trans('full_name'); ?>:</label> <?php echo $profile_info->name; ?></div>
                                    <div class="block">
                                        <label><?php echo trans('email'); ?>:</label> <?php echo $profile_info->email; ?> </div>
                                    <div class="block">
                                        <label><?php echo trans('gender'); ?>:</label> <?php if($profile_info->gender=='1'){echo trans('male');}elseif($profile_info->gender=='2'){echo trans('female');}else{ echo 'N/a';} ?> </div>
                                    <div class="block">
                                        <label><?php echo trans('join_date'); ?>e:</label> <?php echo date('d M Y',strtotime($profile_info->join_date)); ?></div>
                                    <div class="block">
                                        <label><?php echo trans('last_login'); ?>:</label> <?php echo date('Y-m-d H:i:s',strtotime($profile_info->last_login)); ?> </div>
                                    <div class="mt20">
                                        <a href="<?php echo base_url('my-account/update'); ?>" class="btn btn-success" title=""><?php echo trans('edit_account_info'); ?></a>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
