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

<ul class="hidden md:flex items-center gap-x-4 flex-1 justify-center ">
    <li><a href="<?php echo base_url(); ?>">
            <?php echo trans('home'); ?>
        </a></li>

    <?php
    $featured_genres = $this->common_model->get_features_genres(6);
    foreach ($featured_genres as $genre): ?>
        <li class="">
            <a href="<?php echo $this->genre_model->get_genre_url_by_id($genre['genre_id']); ?>">
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
    <?php $languages = $this->language_model->get_languages(); if(count($languages) > 1): ?>
    <!-- language switch -->
    <li class="ml-4 relative">
        <div id="showLang" class="flex items-center justify-center cursor-pointer">
            <i class="fa-solid fa-language mr-1 text-amber-500"></i>
            <?php echo $this->language_model->language_by_id($this->session->userdata('active_language_id')); ?>
        </div>
        <ul id="langList" class="z-50 absolute hidden right-0 mt-2 rounded-md w-40 bg-neutral-300 text-gray-700 p-1">
            <?php
                foreach ($languages as $language) : ?>
                <li class="mb-1 hover:text-amber-500"><a class="dropdown-item" href="<?php echo base_url('language/language_switch/').$language->short_form; ?>"><?php echo $language->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </li>
    <!-- END language -->
    <?php endif; ?>
</ul>
<div class="flex items-center md:hidden relative">
    <div class="relative mr-3">
        <div id="showLang_m" class="flex items-center justify-center cursor-pointer">
            <i class="fa-solid fa-language mr-1 text-amber-500"></i>
            <?php echo $this->language_model->language_by_id($this->session->userdata('active_language_id')); ?>
        </div>
        <ul id="langList_m" class="z-50 absolute hidden right-0 mt-2 rounded-md w-40 bg-neutral-300 text-gray-700 p-1">
            <?php
                foreach ($languages as $language) : ?>
                <li class="mb-1 hover:text-amber-500"><a class="dropdown-item" href="<?php echo base_url('language/language_switch/').$language->short_form; ?>"><?php echo $language->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <button id="showMenu"><i class="fa-solid fa-bars"></i></button>
    <div id="menu" class="z-50 absolute right-0 mt-2 w-56 rounded-md shadow-lg hidden">
        <div class="rounded-md shadow-sm bg-neutral-300 text-gray-700">
            <ul class="py-1">
                <li>
                    <a href="<?php echo base_url(); ?>"
                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-900">
                        <?php echo trans('home'); ?>
                    </a>
                </li>
                <?php
                $featured_genres = $this->common_model->get_features_genres(6);
                foreach ($featured_genres as $genre):
                    ?>
                    <li>
                        <a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-900"
                            href="<?php echo $this->genre_model->get_genre_url_by_id($genre['genre_id']); ?>">
                            <?php echo $genre['name'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li><a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-900"
                        href="<?php echo base_url('movies.html') ?>">
                        <?php echo trans('movies'); ?>
                    </a></li>

                <?php if ($privacy_policy_to_primary_menu == '1'): ?>
                    <li><a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-900"
                            href="<?php echo base_url('privacy-policy.html') ?>">
                            <?php echo trans('privacy_policy'); ?>
                        </a></li>
                <?php endif; ?>
                <?php if ($dmca_to_primary_menu == '1'): ?>
                    <li><a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-900"
                            href="<?php echo base_url('dmca.html') ?>">
                            <?php echo trans('dmca'); ?>
                        </a></li>
                <?php endif; ?>
                <?php if ($contact_to_primary_menu == '1'): ?>
                    <li><a class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:text-gray-900"
                            href="<?php echo base_url('contact-us.html') ?>">
                            <?php echo trans('contact'); ?>
                        </a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#showMenu").on("click", (e) => {
            $("#menu").toggleClass('hidden');
        });
        $("#showLang").on("click", (e) => {
            $("#langList").toggleClass('hidden');
        });
        $("#showLang_m").on("click", (e) => {
            $("#langList_m").toggleClass('hidden');
        });
    });
</script>