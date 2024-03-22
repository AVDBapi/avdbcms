<section>
    <div class="py-16 px-4 max-w-xl mx-auto">
        <form class="w-full" method="get" action="<?php echo base_url('search'); ?>">
            <div class="flex items-center">
                <input type="text" name="q" autocomplete="off" id="search-input" placeholder="Search.."
                    class="w-8/12 p-3 rounded-l-md text-gray-700 placeholder:text-gray-400 border-none outline-none">
                <button class="w-4/12 flex items-center justify-center rounded-r-md bg-neutral-200 text-gray-600 p-3 border-l" type="submit">
                    <i class="fa fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>

    <?php if ($this->common_model->get_ads_status('home_header') == '1'): ?>
        <!-- header ads -->
        <div id="ads" style="padding: 20px 0px;text-align: center;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <?php echo $this->common_model->get_ads('home_header'); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- header ads -->
    <?php endif; ?>
    <div id="section-opt" class="">
        <div class="flex items-center justify-between pt-10 pb-6">
            <span class="text-2xl md:text-3xl leading-7 font-bold">
                <?php echo trans('movie_suggestion'); ?>
            </span>
            <a href="<?php echo base_url(); ?>movies.html" class="text-xs md:text-sm text-red-600 hover:text-red-500">
                <?php echo trans('view_more'); ?> »
            </a>
        </div>
        <div id="hot" class="tab-content">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
                <?php $hot_videos = $this->common_model->get_hot_videos(); ?>
                <?php foreach ($hot_videos as $videos): ?>
                    <?php include ('thumbnail.php'); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="section-opt">
        <div class="flex items-center justify-between pt-10 pb-6">
            <span class="text-2xl md:text-3xl leading-7 font-bold">
                <?php echo trans('latest_movies'); ?>
            </span>
            <a href="<?php echo base_url('movies.html') ?>" class="text-xs md:text-sm text-red-600 hover:text-red-500">
                <?php echo trans('view_more'); ?> »
            </a>
        </div>
        <div id="hot" class="tab-content">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
                <?php $latest_published_videos = $this->common_model->latest_published_videos(12); ?>
                <?php foreach ($latest_published_videos as $videos): ?>
                    <?php include ('thumbnail.php'); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="section-opt">
        <div class="flex items-center justify-between pt-10 pb-6">
            <span class="text-2xl md:text-3xl leading-7 font-bold">
                <?php echo trans('latest_tv_series'); ?>
            </span>
            <a href="<?php echo base_url('tv-series.html') ?>" class="text-xs md:text-sm text-red-600 hover:text-red-500">
                <?php echo trans('view_more'); ?> »
            </a>
        </div>
        <div id="hot" class="tab-content">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
                <?php $latest_published_videos = $this->common_model->latest_published_tv_series(12); ?>
                <?php foreach ($latest_published_videos as $videos) : ?>
                    <?php include ('thumbnail.php'); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php
        $featured_genres = $this->common_model->get_features_genres(6);
        foreach ($featured_genres as $genre) :
    ?>
    <div id="section-opt">
        <div class="flex items-center justify-between pt-10 pb-6">
            <span class="text-2xl md:text-3xl leading-7 font-bold">
                <?php echo trans($genre['name']); ?>
            </span>
            <a href="<?php echo base_url('genre/'.$genre['slug'].'.html'); ?>" class="text-xs md:text-sm text-red-600 hover:text-red-500">
                <?php echo trans('view_more'); ?> »
            </a>
        </div>
        <div id="hot" class="tab-content">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
                <?php $genre_videos = $this->genre_model->get_video_by_genre_id($genre['genre_id'], 12); ?>
                <?php foreach ($genre_videos as $videos): ?>
                    <?php include ('thumbnail.php'); ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</section>

<!-- bootstrap menu -->
<script>
    $('.search_tools').click(function () {
        $(".search").toggleClass('open');
        if ($(".search").hasClass("open")) {
            $(this).html('<a href="#"><span class="fa fa-close"></span></a>');
        } else {
            $(this).html('<a href="#"><span class="fa fa-search"></span></a>');
        }
    });
</script>
<!-- bootstrap menu -->
<!-- typehead search  -->
<script type="text/javascript">
    $(document).ready(function () {
        $("#search-input").autocomplete({
            source: "<?php echo base_url(); ?>/home/autocompleteajax",
            focus: function (event, ui) {
                return false;
            },
            select: function (event, ui) {
                window.location.href = ui.item.url;
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
            var inner_html = '<a href="' + item.url + '" ><div class="list_item_container"><div class="image"><img src="' + item.image + '" ></div><div class="th-title"><b>' + item.title + '</b></div></div></a>';
            return $("<li></li>").data("item.autocomplete", item).append(inner_html).appendTo(ul);
        };
    });
</script>
<script src="<?php echo base_url('assets/theme/default/'); ?>swiper/js/swiper.min.js"></script>