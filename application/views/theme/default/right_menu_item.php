<?php
  $registration_enable            =   ovoo_config('registration_enable');    
  $frontend_login_enable          =   ovoo_config('frontend_login_enable');
?>
<ul class="nav navbar-nav navbar-right">
<?php if($this->session->userdata('login_status') == 1):?>
  <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img class="img img-circle" src="<?php echo $this->common_model->get_img('user', $this->session->userdata('user_id'));?>" height="20"> </a>
      <ul class="dropdown-menu" role="menu">
      <?php 
          if($this->session->userdata('admin_is_login') == 1):
              echo '<li><a href="'.base_url().'admin"><i class="fi ion-ios-speedometer-outline m-r-10"></i>'.trans('control_panel').'</a></li>';
          endif; 
      ?>
      <li><a href="<?php echo base_url('my-account/profile'); ?>"><i class="fi ion-ios-person-outline m-r-10"></i><?php echo trans('profile'); ?></a></li>
      <li><a href="<?php echo base_url('my-account/subscription'); ?>"><i class="fi ion-ios-briefcase-outline m-r-10"></i><?php echo trans('my_subscription'); ?></a></li>
      <li><a href="<?php echo base_url('my-account/favorite'); ?>"><i class="fi ion-ios-heart-outline m-r-10"></i><?php echo trans('my_favorite'); ?></a></li>
      <li><a href="<?php echo base_url('my-account/watch-later'); ?>"><i class="fi ion-ios-clock-outline m-r-10"></i><?php echo trans('wish_list'); ?></a></li>
      <li><a href="<?php echo base_url('my-account/update'); ?>"><i class="fi ion-edit m-r-10"></i><?php echo trans('update_profile'); ?></a></li>
      <li><a href="<?php echo base_url('my-account/change-password'); ?>"><i class="fi ion-key m-r-10"></i><?php echo trans('change_password'); ?></a></li>
      <li><a href="<?php echo base_url('login/logout'); ?>"><i class="fi ion-log-out m-r-10"></i><?php echo trans('logout'); ?></a></li>
      </ul>
  </li>
<?php else: ?>
  <?php if($frontend_login_enable =='1'): ?>
    <li class="hidden-xs-down"><a href="<?php echo base_url('user/login'); ?>"><?php echo trans('account'); ?></a></li>
  <?php endif; ?>
<?php endif; ?>
    <?php $languages = $this->language_model->get_languages(); if(count($languages) > 1): ?>
      <!-- language switch -->
      <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" style="text-transform: capitalize;"><?php echo $this->language_model->language_by_id($this->session->userdata('active_language_id')); ?></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
              <?php
                  foreach ($languages as $language) : ?>
                  <li><a class="dropdown-item" href="<?php echo base_url('language/language_switch/').$language->short_form; ?>"><?php echo $language->name; ?></a></li>
              <?php endforeach; ?>
          </ul>
      </li>
      <!-- END language -->
    <?php endif; ?>
</ul>


  