<section class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
    <?php if($this->common_model->get_ads_status('tv_header')=='1'): ?>
    <!-- header ads -->
    <div id="ads" style="padding: 20px 0px;text-align: center;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <?php echo $this->common_model->get_ads('tv_header'); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- header ads -->
    <?php endif; ?>
    <!-- Breadcrumb -->
    <div id="title-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <div class="page-title">
                        <h1 class="text-uppercase"><?php echo trans('watch_tv_series'); ?></h1>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 text-right">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i><?php echo trans('home'); ?></a>
                        </li>
                        <li class="active"><?php echo trans('tv_series'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Secondary Section -->

    <div class="mobile-gen">
        <div id="section-opt">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseMobile" aria-expanded="false" aria-controls="collapseMobile"><?php echo trans('browse_categories'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="section-opt">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                  <div class="" id="collapseMobile">
                    <div class="card card-body">
                      <div class="movies-list-wrap mlw-latestmovie">
                        <div class="ml-title">
                          <span class="pull-left title"><?php echo trans('imdb_rating'); ?></span>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                      <div class="container">
                        <input type="hidden" id="hidden_minimum_rating" value="0">
                        <input type="hidden" id="hidden_maximum_rating" value="10">
                        <h4 class="rating" id="rating_show"><?php echo trans('rating'); ?>: 0 - 10 </h4>
                        <div id="rating_range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                          <div class="ui-slider-range ui-corner-all ui-widget-header" style="left: 0%; width: 100%;"></div>
                          <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span>
                          <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span>
                        </div>
                      </div>
                      <br>
                      <div class="movies-list-wrap mlw-latestmovie">
                        <div class="ml-title">
                          <span class="pull-left title"><?php echo trans('sort_by'); ?></span>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                      <ul class="inline">                        
                        <li class="modern-Checkbox">
                          <input type="checkbox" name="check_sort" onclick="check_sort(this)" class="common_selector sort" id="asc" value="asc">
                          <label for="asc"><?php echo trans('asc'); ?></label>
                        </li>
                        <li class="modern-Checkbox">
                          <input type="checkbox" name="check_sort" onclick="check_sort(this)" class="common_selector sort" id="desc" value="desc">
                          <label for="desc"><?php echo trans('desc'); ?></label>
                        </li>
                        <li class="modern-Checkbox">
                          <input type="checkbox" name="check_sort" onclick="check_sort(this)" class="common_selector sort" id="view" value="total_view">
                          <label for="view"><?php echo trans('views'); ?></label>
                        </li>
                        <li class="modern-Checkbox">
                          <input type="checkbox" name="check_sort" onclick="check_sort(this)" class="common_selector sort" id="rating" value="rating">
                          <label for="rating"><?php echo trans('rating'); ?></label>
                        </li>
                        <li class="modern-Checkbox">
                          <input type="checkbox" name="check_sort" onclick="check_sort(this)" class="common_selector sort" id="release" value="release">
                          <label for="release"><?php echo trans('release'); ?></label>
                        </li>
                        <li class="modern-Checkbox">
                          <input type="checkbox" name="check_sort" onclick="check_sort(this)" class="common_selector sort" id="az" value="az">
                          <label for="az"><?php echo trans('a-z'); ?></label>
                        </li>
                        <li class="modern-Checkbox">
                          <input type="checkbox" name="check_sort" onclick="check_sort(this)" class="common_selector sort" id="za" value="za">
                          <label for="za"><?php echo trans('z-a'); ?></label>
                        </li>
                        <li class="modern-Checkbox">
                          <input type="checkbox" name="check_sort" onclick="check_sort(this)" class="common_selector sort" id="random" value="rand">
                          <label for="random"><?php echo trans('random'); ?></label>
                        </li>
                      </ul>
                      <br>
                      <div class="movies-list-wrap mlw-latestmovie">
                        <div class="ml-title">
                          <span class="pull-left title"><?php echo trans('categories'); ?></span>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                      <ul class="inline">
                        <?php foreach($this->genre_model->genres() as $genre): ?>
                            <li class="modern-Checkbox">
                              <input type="checkbox" name="check_category" onclick="check_category(this)" class="common_selector genre" id="genre-<?php echo $genre['genre_id'] ?>" value="<?php echo $genre['genre_id'] ?>">
                              <label for="genre-<?php echo $genre['genre_id'] ?>"><?php echo $genre['name'] ?></label>
                            </li>
                        <?php endforeach; ?>                        
                      </ul>
                      <div class="movies-list-wrap mlw-latestmovie">
                        <div class="ml-title">
                          <span class="pull-left title"><?php echo trans('languages'); ?></span>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                      <ul class="inline">
                        <?php foreach($this->db->get_where('language',array('publication'=>'1'))->result_array() as $language): ?>
                            <li class="modern-Checkbox">
                              <input type="checkbox" name="check_language" onclick="check_language(this)" class="common_selector language" id="lan-<?php echo $language['language_id'] ?>" value="<?php echo $language['language_id'] ?>">
                              <label for="lan-<?php echo $language['language_id'] ?>"><?php echo $language['name'] ?></label>
                            </li>
                        <?php endforeach; ?>
                        <li class="modern-Checkbox">
                          <input type="checkbox" name="check_language" onclick="check_language(this)" class="common_selector language" id="others" value="99999999">
                          <label for="others"><?php echo trans('others'); ?></label>
                        </li>
                      </ul>
                      <div class="movies-list-wrap mlw-latestmovie">
                        <div class="ml-title">
                          <span class="pull-left title"><?php echo trans('countries'); ?></span>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                      <ul class="inline">
                        <?php foreach($this->country_model->countries() as $country): ?>
                            <li class="modern-Checkbox">
                              <input type="checkbox" name="check_country" onclick="check_country(this)" class="common_selector country" id="country-<?php echo $country['country_id'] ?>" value="<?php echo $country['country_id'] ?>">
                              <label for="country-<?php echo $country['country_id'] ?>"><?php echo $country['name'] ?></label>
                            </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                </div>
                <!-- All Movies -->
                <div class="col-md-9 col-sm-11 col-xs-12">
                    <div class="latest-movie movie-opt">
                        <div class="row clean-preset">
                            <div class="pagination-container-top text-center" id="pagination_link1"></div>
                            <div class="movie-container"></div>
                            <br><br><br>
                            <div class="pagination-container text-center" id="pagination_link2"></div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</section>



<script type="text/javascript">
    $(document).ready(function() {
        var $window = $(window);
        function checkWidth() {
            if ($window.width() > 991) {
                $('#collapseMobile').removeClass('collapse');
            }else{
              $('#collapseMobile').addClass('collapse');
            };
        }
        checkWidth();
        $(window).resize(checkWidth);
    });
</script>
<script >
    function check_category(checkbox) {
        var checkboxes = document.getElementsByName('check_category')
        checkboxes.forEach((item) => {
            if (item !== checkbox) item.checked = false
        })
    }
    function check_country(checkbox) {
        var checkboxes = document.getElementsByName('check_country')
        checkboxes.forEach((item) => {
            if (item !== checkbox) item.checked = false
        })
    }

    function check_language(checkbox) {
        var checkboxes = document.getElementsByName('check_language')
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


    $(document).ready(function() {
        filter_data(1);
        function filter_data(page) {
            $('.movie-container').html("<div id='loader'> </div>");
            var action          = 'fetch_data';
            var minimum_rating  = $('#hidden_minimum_rating').val();
            var maximum_rating  = $('#hidden_maximum_rating').val();
            var category        = get_filter('genre');
            var country         = get_filter('country');
            var language        = get_filter('language');
            var sort            = get_filter('sort');
            // console.log(action+minimum_rating+maximum_rating+category+country+language+sort+page);
            $.ajax({
                url: "<?php echo base_url('filter_tvseries/'); ?>" + page,
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
                success: function(data) {
                    if(data.movie_list !='' && data.movie_list !=null){
                        $('.movie-container').html(data.movie_list);
                    }else{
                        $('.movie-container').html("<?php echo "<center><h3>".trans('no_movie_found')."</h3></center>"; ?>");
                    }                  
                    $('#pagination_link1').html(data.pagination_link);
                    $('#pagination_link2').html(data.pagination_link);
                    //console.log(data.inputs);
                    //console.log(data.last_query);
                    $('.lazy').lazy();
                    if (window.innerWidth > 400) {
                        $('[data-toggle="popover"]').popover({
                            placement: 'auto',
                            boundary: 'window',
                            trigger: 'hover',
                            delay: {
                                "show": 1000
                            },
                            html: true,
                            container: 'body'
                        });
                    } else {
                        $('[data-toggle="popover"]').popover({
                            placement: 'auto',
                            boundary: 'window',
                            trigger: 'click',
                            html: true,
                            container: 'body'
                        });
                    }
                }
            });
        }


        function get_filter(class_name) {
            var filter = [];
            $('.' + class_name + ':checked').each(function() {
                filter.push($(this).val());
            });
            return filter;
        }

        $(document).on('click', '.pagination li a', function(event) {
            event.preventDefault();
            var page = $(this).data('ci-pagination-page');
            filter_data(page);
        });


        $('.common_selector').click(function() {
            filter_data(1);
        });


        $('#rating_range').slider({
            range: true,
            min: 1,
            max: 9.9,
            values: [1, 9.9],
            step: 0.1,
            stop: function(event, ui) {
                $('#rating_show').html('Rating:' + ' ' + ui.values[0] + ' - ' + ui.values[1]);
                $('#hidden_minimum_rating').val(ui.values[0]);
                $('#hidden_maximum_rating').val(ui.values[1]);
                filter_data(1);
            }
        });
    });

</script>