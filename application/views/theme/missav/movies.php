<section>
    <?php if ($this->common_model->get_ads_status('movie_header') == '1'): ?>
        <!-- header ads -->
        <div id="ads" style="padding: 20px 0px;text-align: center;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <?php echo $this->common_model->get_ads('movie_header'); ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- header ads -->
    <?php endif; ?>
    <!-- Secondary Section -->
    <div id="section-opt">
        <div class="mb-6">
            <div class="relative mb-3">
                <div class="font-semibold flex items-center justify-between">
                    <?php echo trans('categories'); ?>
                    <button class="see-more font-normal text-gray-300 hover:text-gray-100 inline-flex items-center">
                        <span class="capitalize">see more</span>
                        <i class="fa-solid fa-caret-right ml-1"></i>
                    </button>
                </div>
                <ul class="genres-checkbox flex-wrap mt-3 hidden">
                    <?php foreach ($this->genre_model->genres() as $genre): ?>
                        <li class="m-1 modern-Checkbox">
                            <input type="checkbox" name="check_category" onclick="check_category(this)"
                                class="common_selector genre sr-only" id="genre-<?php echo $genre['genre_id'] ?>"
                                value="<?php echo $genre['genre_id'] ?>">
                            <label class="cursor-pointer text-sm" for="genre-<?php echo $genre['genre_id'] ?>">
                                <?php echo $genre['name'] ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="relative">
                <div class="font-semibold">
                    <?php echo trans('sort_by'); ?>
                </div>
                <ul class="flex flex-wrap mt-2 text-sm">
                    <li class="modern-Checkbox">
                        <input type="checkbox" name="check_sort" onclick="check_sort(this)"
                            class="common_selector sort sr-only" id="asc" value="asc">
                        <label class="cursor-pointer" for="asc">
                            <?php echo trans('asc'); ?>
                        </label>
                    </li>
                    <li class="modern-Checkbox">
                        <input type="checkbox" name="check_sort" onclick="check_sort(this)"
                            class="common_selector sort sr-only" id="desc" value="desc">
                        <label class="cursor-pointer" for="desc">
                            <?php echo trans('desc'); ?>
                        </label>
                    </li>
                    <li class="modern-Checkbox">
                        <input type="checkbox" name="check_sort" onclick="check_sort(this)"
                            class="common_selector sort sr-only" id="view" value="total_view">
                        <label class="cursor-pointer" for="view">
                            <?php echo trans('views'); ?>
                        </label>
                    </li>
                    <li class="modern-Checkbox">
                        <input type="checkbox" name="check_sort" onclick="check_sort(this)"
                            class="common_selector sort sr-only" id="rating" value="rating">
                        <label class="cursor-pointer" for="rating">
                            <?php echo trans('rating'); ?>
                        </label>
                    </li>
                    <li class="modern-Checkbox">
                        <input type="checkbox" name="check_sort" onclick="check_sort(this)"
                            class="common_selector sort sr-only" id="release" value="release">
                        <label class="cursor-pointer" for="release">
                            <?php echo trans('release'); ?>
                        </label>
                    </li>
                    <li class="modern-Checkbox">
                        <input type="checkbox" name="check_sort" onclick="check_sort(this)"
                            class="common_selector sort sr-only" id="az" value="az">
                        <label class="cursor-pointer" for="az">
                            <?php echo trans('a-z'); ?>
                        </label>
                    </li>
                    <li class="modern-Checkbox">
                        <input type="checkbox" name="check_sort" onclick="check_sort(this)"
                            class="common_selector sort sr-only" id="za" value="za">
                        <label class="cursor-pointer" for="za">
                            <?php echo trans('z-a'); ?>
                        </label>
                    </li>
                    <li class="modern-Checkbox">
                        <input type="checkbox" name="check_sort" onclick="check_sort(this)"
                            class="common_selector sort sr-only" id="random" value="rand">
                        <label class="cursor-pointer" for="random">
                            <?php echo trans('random'); ?>
                        </label>
                    </li>
                </ul>
            </div>
        </div>

        <!-- All Movies -->
        <div class="latest-movie movie-opt" id="latest-movie">
            <div class="pagination-container-top text-center my-3 md:my-5" id="pagination_link1"></div>
            <div class="movie-container"></div>
            <div class="pagination-container text-center my-3 md:my-5" id="pagination_link2"></div>
        </div>
    </div>
</section>

<script>
    function check_category(checkbox) {
        var checkboxes = document.getElementsByName('check_category')
        checkboxes.forEach((item) => {
            if (item !== checkbox) item.checked = false
        })
    }

    function check_sort(checkbox) {
        var checkboxes = document.getElementsByName('check_sort')
        checkboxes.forEach((item) => {
            if (item !== checkbox) item.checked = false
        })
    }

    function onlyOne(checkbox) {
        var checkboxes = document.getElementsByName('check')
        checkboxes.forEach((item) => {
            if (item !== checkbox) item.checked = false
        })
    }

    $(document).ready(function () {
        filter_data(1);
        function filter_data(page) {
            $('.movie-container').html("<div id='loader'> </div>");
            var action = 'fetch_data';
            var minimum_rating = $('#hidden_minimum_rating').val();
            var maximum_rating = $('#hidden_maximum_rating').val();
            var category = get_filter('genre');
            var country = get_filter('country');
            var language = get_filter('language');
            var sort = get_filter('sort');
            $.ajax({
                url: "<?php echo base_url('filter_movies/'); ?>" + page,
                method: "POST",
                dataType: "JSON",
                data: {
                    "action": action,
                    "minimum_rating": minimum_rating,
                    "maximum_rating": maximum_rating,
                    "category": category[0],
                    "country": country[0],
                    "language": language[0],
                    "sort": sort[0],
                    "page": page
                },
                success: function (data) {
                    if (data.movie_list != '' && data.movie_list != null) {
                        $('.movie-container').html(data.movie_list);
                    } else {
                        $('.movie-container').html("<?php echo "<center><h3>" . trans('no_movie_found') . "</h3></center>"; ?>");
                    }
                    $('#pagination_link1').html(data.pagination_link);
                    $('#pagination_link2').html(data.pagination_link);
                    $('html, body').animate({
                        scrollTop: $("#latest-movie").offset().top
                    }, 1000)
                }
            });
        }
        function get_filter(class_name) {
            var filter = [];
            $('.' + class_name + ':checked').each(function () {
                filter.push($(this).val());
            });
            return filter;
        }
        $(document).on('click', '.pagination li a', function (event) {
            event.preventDefault();
            var page = $(this).data('ci-pagination-page');
            filter_data(page);
        });
        $('.common_selector').click(function () {
            filter_data(1);
        });
        $('.see-more').on('click', function (e) {
            e.preventDefault();
            $('.genres-checkbox').toggleClass('hidden');
            $('.genres-checkbox').toggleClass('flex');
            $('.see-more i').toggleClass('fa-caret-right');
            $('.see-more i').toggleClass('fa-caret-down');
            if ($('.see-more span').html() == 'see more') {
                $('.see-more span').html('see less');
            }else {
                $('.see-more span').html('see more');
            }
        });
    });

</script>