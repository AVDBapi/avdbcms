<!-- Footer Area -->
<?php
$facebook_url = ovoo_config('facebook_url');
$twitter_url = ovoo_config('twitter_url');
$vimeo_url = ovoo_config('vimeo_url');
$linkedin_url = ovoo_config('linkedin_url');
$youtube_url = ovoo_config('youtube_url');
$footer1_title = ovoo_config('footer1_title');
$footer1_content = ovoo_config('footer1_content');
$footer2_title = ovoo_config('footer2_title');
$footer2_content = ovoo_config('footer2_content');
$footer3_title = ovoo_config('footer3_title');
$footer3_content = ovoo_config('footer3_content');
$footer_text = ovoo_config('copyright_text');
$about_us_enable = $this->db->get_where('config', array('title' => 'about_us_enable'))->row()->value;
$about_us_to_footer_menu = $this->db->get_where('config', array('title' => 'about_us_to_footer_menu'))->row()->value;
$about_us_text = $this->db->get_where('config', array('title' => 'about_us_text'))->row()->value;
$contact_to_footer_menu = $this->db->get_where('config', array('title' => 'contact_to_footer_menu'))->row()->value;
$tv_series_pin_footer_menu = $this->db->get_where('config', array('title' => 'tv_series_pin_footer_menu'))->row()->value;
$live_tv_pin_footer_menu = $this->db->get_where('config', array('title' => 'live_tv_pin_footer_menu'))->row()->value;
$privacy_policy_to_footer_menu = $this->db->get_where('config', array('title' => 'privacy_policy_to_footer_menu'))->row()->value;
$dmca_to_footer_menu = $this->db->get_where('config', array('title' => 'dmca_to_footer_menu'))->row()->value;
$theme_dir = 'theme/default/';
$assets_dir = 'assets/theme/default/';
?>
<div id="footer" class="mx-auto py-12 lg:py-16">
    <div class="lg:grid lg:grid-cols-3 lg:gap-8">
        <div class="space-y-4">
            <a class="text-4xl leading-normal" href="<?php echo base_url(); ?>">
                <img class="img-responsive"
                    src="<?php echo base_url() ?>uploads/system_logo/<?php echo ovoo_config('logo'); ?>" alt="Logo">
            </a>
            <p class="text-gray-500 text-base">
                <?php echo $footer1_content; ?>
            </p>
        </div>
        <div class="mt-12 grid grid-cols-2 gap-8 lg:mt-0 lg:col-span-2">
            <div>
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                    <?php echo trans('genres'); ?>
                </h3>
                <ul class="mt-4 space-y-4">
                    <?php
                    $featured_genres = $this->common_model->get_features_genres(6);
                    foreach ($featured_genres as $genre):
                        ?>
                        <li>
                            <a href="<?php echo base_url('genre/' . $genre['slug'] . '.html'); ?>"
                                class="text-base text-gray-500 hover:text-pink-500">
                                <?php echo trans($genre['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">
                    <?php echo trans('links'); ?>
                </h3>
                <ul class="mt-4 space-y-4">
                    <?php if ($about_us_enable == '1' && $about_us_to_footer_menu == '1'): ?>
                        <li><a class="text-base text-gray-500 hover:text-pink-500"
                                href="<?php echo base_url('about-us.html') ?>">
                                <?php echo trans('about_us'); ?>
                            </a></li>
                    <?php endif; ?>
                    <?php if ($live_tv_pin_footer_menu == '1'): ?>
                        <li><a class="text-base text-gray-500 hover:text-pink-500"
                                href="<?php echo base_url('live-tv.html') ?>">
                                <?php echo trans('live_tv'); ?>
                            </a></li>
                    <?php endif; ?>
                    <?php if ($tv_series_pin_footer_menu == '1'): ?>
                        <li><a class="text-base text-gray-500 hover:text-pink-500"
                                href="<?php echo base_url('tv-series.html') ?>">
                                <?php echo trans('tv_series'); ?>
                            </a></li>
                    <?php endif; ?>
                    <?php if ($privacy_policy_to_footer_menu == '1'): ?>
                        <li><a class="text-base text-gray-500 hover:text-pink-500"
                                href="<?php echo base_url('privacy-policy.html') ?>">
                                <?php echo trans('privacy_policy'); ?>
                            </a></li>
                    <?php endif; ?>
                    <?php if ($dmca_to_footer_menu == '1'): ?>
                        <li><a class="text-base text-gray-500 hover:text-pink-500"
                                href="<?php echo base_url('dmca.html') ?>">
                                <?php echo trans('dmca'); ?>
                            </a></li>
                    <?php endif; ?>
                    <?php if ($contact_to_footer_menu == '1'): ?>
                        <li><a class="text-base text-gray-500 hover:text-pink-500"
                                href="<?php echo base_url('contact-us.html') ?>">
                                <?php echo trans('contact_us'); ?>
                            </a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Footer Area -->