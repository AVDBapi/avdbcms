<?php
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
?>

<ul class="flex items-center gap-x-4 flex-1 justify-center">
    <li><a href="<?php echo base_url(); ?>">
            <?php echo trans('home'); ?>
        </a></li>

    <?php
    $featured_genres = $this->common_model->get_features_genres(6);
    foreach ($featured_genres as $genre): ?>
        <li class="">
            <a href="<?php echo $this->genre_model->get_genre_url_by_id($genre['genre_id']);?>">
                <?php echo $genre['name'] ?>
            </a>
        </li>
    <?php endforeach; ?>

    <li><a href="<?php echo base_url('movies.html') ?>">
            <?php echo trans('movies'); ?>
        </a></li>

    <?php if ($privacy_policy_to_primary_menu == '1'): ?>
        <li><a href="<?php echo base_url('privacy-policy.html') ?>">
                <?php echo trans('privacy_policy'); ?>
            </a></li>
    <?php endif; ?>
    <?php if ($dmca_to_primary_menu == '1'): ?>
        <li><a href="<?php echo base_url('dmca.html') ?>">
                <?php echo trans('dmca'); ?>
            </a></li>
    <?php endif; ?>
    <?php if ($contact_to_primary_menu == '1'): ?>
        <li><a href="<?php echo base_url('contact-us.html') ?>">
                <?php echo trans('contact'); ?>
            </a></li>
    <?php endif; ?>
</ul>