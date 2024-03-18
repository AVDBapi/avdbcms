<?php
$header_templete = ovoo_config('header_templete');
$theme_dir = 'theme/missav/';
$assets_dir = 'assets/theme/missav/';
$registration_enable = ovoo_config('registration_enable');
$frontend_login_enable = ovoo_config('frontend_login_enable');
$country_to_primary_menu = ovoo_config('country_to_primary_menu');
$genre_to_primary_menu = ovoo_config('genre_to_primary_menu');
$release_to_primary_menu = ovoo_config('release_to_primary_menu');
$contact_to_primary_menu = ovoo_config('contact_to_primary_menu');
$privacy_policy_to_primary_menu = ovoo_config('privacy_policy_to_primary_menu');
$dmca_to_primary_menu = ovoo_config('dmca_to_primary_menu');
$az_to_primary_menu = ovoo_config('az_to_primary_menu');
$az_to_footer_menu = ovoo_config('az_to_footer_menu');
$movie_request_enable = ovoo_config('movie_request_enable');
$facebook_url = ovoo_config('facebook_url');
$twitter_url = ovoo_config('twitter_url');
$vimeo_url = ovoo_config('vimeo_url');
$linkedin_url = ovoo_config('linkedin_url');
$youtube_url = ovoo_config('youtube_url');
$business_phone = ovoo_config('business_phone');
$contact_email = ovoo_config('contact_email');
?>

<div class="sticky top-0 z-20">
    <nav class="h-16 bg-black flex items-center justify-between md:justify-normal">
        <a class="flex-none" href="<?php echo base_url(); ?>">
            <img src="<?php echo base_url(); ?>uploads/system_logo/<?php echo ovoo_config('logo'); ?>" alt="logo">
        </a>
        <?php $this->load->view($theme_dir . 'left_menu_item'); ?>
    </nav>
</div>