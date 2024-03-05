<?php
$tmdb_language      =   $this->db->get_where('config', array('title' => 'tmdb_language'))->row()->value;
$default_quality    =   $this->db->get_where('config', array('title' => 'default_quality'))->row()->value;

?>

<style type="text/css">
    .p-a {
        padding: 10px;
    }

    .bootstrap-tagsinput .badge {
        background-color: #009688;
        border: 1px solid #035d54;
    }

    button.close {
        padding: 0px;
    }
</style>
<div class="row">
    <div class="col-lg-6 offset-md-3 ">
        <div class="panel panel-border panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo trans('import_movies_tvshow_from_tmdb'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="input-group mb-3">
                    <select class="form-control" name="lang" id="lang" style="max-width: 170px;">
                        <?php
                        $languages = $this->db->get('languages_iso')->result_array();
                        foreach ($languages as $language) :

                            ?>
                            <option value="<?php echo $language['iso'] ?>" <?php if ($tmdb_language == $language['iso']) : echo "selected";
                                                                                endif; ?>><?php echo $language['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" class="form-control" id="imdb_id" placeholder="Enter TMDB ID. Ex: 141052" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append" id="button-area">
                        <button class="btn btn-outline-primary" id="import_btn" type="button" id="button-addon2"><?php echo trans('fetch'); ?></button>
                    </div>
                </div>
                <small class="form-text text-muted" id=""><a href="https://youtu.be/DZrv95huYUk" target="_blank"><?php echo trans('tutorial'); ?> | </a> <?php echo trans('get_tmdb_id_from_here'); ?>: <a href="https://www.themoviedb.org/movie/" target="_blank">TheMovieDB.org.</a> </small>
                <div id="result" class="m-t-15">
                    <div class="alert alert-info"><strong><?php echo trans('note'); ?>:</strong><?php echo trans('actors_directors_and_writers_photo_will_import_by_cron'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo form_open(base_url() . 'admin/tvseries/add/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
<div class="row">
    <div class="col-md-6">
        <div class="card cta cta--featured p-a">
            <div class="card-block">
                <h3 class="card-title no-margin-top"><?php echo trans('movie_info'); ?></h3>
            </div>
            <span class="header-line"></span>
            <div class="card-block">
                <input type="hidden" name="imdbid" id="imdbid">
                <div class="form-group">
                    <label class=" control-label"><?php echo trans('title'); ?></label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('slug'); ?> (<?php echo base_url('watch/slug'); ?>)</label>
                    <input type="text" id="slug" name="slug" class="form-control input-sm" required>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('description'); ?></label>
                    <textarea class="wysihtml5 form-control" name="description" id="description" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('actor'); ?></label>
                    <select class="form-control" name="actor[]" id="actor" multiple>

                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('director'); ?></label>
                    <select class="form-control" name="director[]" multiple="multiple" id="director">
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('writer'); ?></label>
                    <select class="form-control" name="writer[]" multiple="multiple" id="writer">
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('imdb_rating'); ?></label>
                    <input type="text" name="rating" id="rating" class="form-control">
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('release_date'); ?></label>
                    <div class="input-group">
                        <input type="text" name="release" id="release_date" class="form-control" value="<?php echo date('Y-m-d') ?>">
                        <span class="input-group-addon bg-custom b-0 text-white"><i class="fa fa-calendar" aria-hidden="true"></i></span> </div>
                    <!-- input-group -->
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('country'); ?></label>
                    <select class="form-control select2" name="country[]" multiple="multiple" id="country">
                        <optgroup label="Select Country">
                            <?php $country = $this->db->get('country')->result_array();
                            foreach ($country as $v_country) : ?>
                                <option value="<?php echo $v_country['country_id']; ?>"><?php echo $v_country['name']; ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('genre'); ?></label>
                    <select class="form-control select2" name="genre[]" multiple="multiple" id="genre">
                        <?php $genre = $this->db->get('genre')->result_array();
                        foreach ($genre as $v_genre) : ?>
                            <option value="<?php echo $v_genre['genre_id']; ?>"><?php echo $v_genre['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('language'); ?></label>
                    <select class="form-control select2" name="language[]" multiple="multiple" id="language">
                        <?php $language = $this->db->get('language')->result_array();
                        foreach ($language as $v_language) : ?>
                            <option value="<?php echo $v_language['language_id']; ?>"><?php echo $v_language['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('video_type'); ?></label>
                    <select class="form-control select2" name="video_type[]" multiple="multiple" id="video_type">
                        <?php $video_types = $this->db->get('video_type')->result_array();
                        foreach ($video_types as $video_type) : ?>
                            <option value="<?php echo $video_type['video_type_id']; ?>" <?php if ($video_type['video_type'] == "Movie") {
                                                                                                echo "readonly selected";
                                                                                            } ?>><?php echo $video_type['video_type']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('runtime'); ?></label>
                    <input type="text" name="runtime" id="runtime" class="form-control">
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('video_quality'); ?></label>
                    <select class="form-control m-bot15" name="video_quality">
                        <?php $quality = $this->db->get_where('quality', array('status' => '1'))->result_array();
                        foreach ($quality as $quality) : ?>
                            <option value="<?php echo $quality['quality'] ?>" <?php if ($default_quality == $quality['quality']) : echo "selected";
                                                                                    endif; ?>><?php echo $quality['quality'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('publication'); ?></label>
                    <div class="toggle">
                        <label>
                            <input type="checkbox" name="publication" checked><span class="button-indecator"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('enable_download'); ?></label><br>
                    <div class="toggle">
                        <label>
                            <input type="checkbox" name="enable_download"><span class="button-indecator"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label">Free/Paid</label>
                    <select  class="form-control"  name="is_paid">
                      <option value="0" selected>Free</option>
                      <option value="1">Paid</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class=" control-label">Trailer URL(YouTube Only)</label>
                    <input type="url" name="trailler_youtube_source"  id="trailler_youtube_source" class="form-control">
                </div> 

            <br><br>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card cta cta--featured p-a">
            <div class="card-block">
                <h3 class="card-title no-margin-top"><?php echo trans('poster'); ?>, <?php echo trans('thumbnail'); ?> & <?php echo trans('seo'); ?></h3>
            </div>
            <span class="header-line"></span>
            <div class="card-block">
                <div class="form-group">
                    <label class="control-label"><?php echo trans('thumbnail'); ?></label>
                    <div class="profile-info-name text-center"> <img id="thumb_image" src="<?php echo base_url() . 'uploads/default_image/thumbnail.jpg'; ?>" width="150" class="img-thumbnail" alt=""> </div>
                    <br>
                    <div id="thumbnail_content">
                        <input type="file" id="thumbnail_file" onchange="showImg(this);" name="thumbnail" class="filestyle" data-input="false" accept="image/*"></div><br>
                    <p class="btn btn-white" id="thumb_link" href="#"><span class="btn-label"><i class="fa fa-link"></i></span>
                        <?php echo trans('link') ?>
                    </p>
                    <p class="btn btn-white" id="thumb_file" href="#"><span class="btn-label"><i class="fa fa-file-o"></i></span>
                        <?php echo trans('file') ?>
                    </p>

                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('poster'); ?></label>
                    <div class="profile-info-name text-center"> <img id="poster_image" src="<?php echo base_url() . 'uploads/default_image/poster.jpg'; ?>" width="350" class="img-thumbnail" alt=""> </div>
                    <br>
                    <div id="poster_content">
                        <input type="file" id="poster_file" onchange="showImg2(this);" name="poster_file" class="filestyle" data-input="false" accept="image/*"></div><br>
                    <p class="btn btn-white" id="poster_link" href="#"><span class="btn-label"><i class="fa fa-link"></i></span>
                        <?php echo trans('link') ?>
                    </p>
                    <p class="btn btn-white" id="poster_file_btn" href="#"><span class="btn-label"><i class="fa fa-file-o"></i></span>
                        <?php echo trans('file') ?>
                    </p>

                </div>
                <h3 class="card-title"><?php echo trans('seo_and_marketing'); ?></h3>
                <div class="form-group">
                    <label class=" control-label"><?php echo trans('seo_title'); ?></label>
                    <input type="text" name="seo_title" id="seo_title" class="form-control">
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('meta_description'); ?></label>
                    <textarea class="wysihtml5 form-control" name="meta_description" id="meta_description" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('focus_keyword'); ?></label><br>
                    <input type="text" name="focus_keyword" id="focus_keyword" class="form-control"><br>
                    <p><?php echo trans('use_comma_to_separate_keyword'); ?></p>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('tags'); ?></label><br>
                    <input type="text" name="tags" id="tags" class="form-control"><br>
                    <p><?php echo trans('use_comma_to_separate_tags'); ?></p>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo trans('send_email_newslatter_to_subscriber'); ?></label>
                    <div class="toggle">
                        <label>
                            <input type="checkbox" name="email_notify"><span class="button-indecator"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo trans('send_push_notification_to_subscriber'); ?></label>
                    <div class="toggle">
                        <label>
                            <input type="checkbox" name="push_notify"><span class="button-indecator"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="offset-md-9 col-sm-3 m-t-15 pull-right">
                        <button type="submit" class="btn btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('create'); ?> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php echo form_close(); ?>


<!-- <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script> -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.form.min.js"></script>
<script>
    jQuery(document).ready(function() {
        //$(".select2").select2();
        $('form').parsley();
        $('#release_date').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true
        });
        $(":file").filestyle({
            input: false
        });
    });
</script>
<!--instant image dispaly-->
<script type="text/javascript">
    function showImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#thumb_image')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<script type="text/javascript">
    function showImg2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#poster_image')
                    .attr('src', e.target.result)
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<!--end instant image dispaly-->



<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script>


<script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/moment/moment.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/summernote/dist/summernote.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date.js"></script>


<script>
    jQuery(document).ready(function() {
        $('#country').select2({
            placeholder: 'Select Country'
        });
        $('#genre').select2({
            placeholder: 'Select Genre'
        });
        $('#language').select2({
            placeholder: 'Select Language'
        });
        $('#video_type').select2({
            placeholder: 'Select Video Type'
        });
        $('#focus_keyword').tagsinput();
        $('#tags').tagsinput();
        $('#thumb_link').click(function() {
            $('#thumbnail_content').html('<input type="text" name="thumb_link" class="form-control">');
        });
        $('#thumb_file').click(function() {
            $('#thumbnail_content').html('<input type="file" id="thumbnail_file" onchange="showImg(this);" name="thumbnail" class="filestyle" data-input="false" accept="image/*"></div>');
            $(":file").filestyle({
                input: false
            });
        });

        $('#poster_link').click(function() {
            $('#poster_content').html('<input type="text" name="poster_link" class="form-control">');
        });
        $('#poster_file_btn').click(function() {
            $('#poster_content').html('<input type="file" id="poster_file" onchange="showImg2(this);" name="poster_file" class="filestyle" data-input="false" accept="image/*"></div>');
            $(":file").filestyle({
                input: false
            });
        });

        $('#description').summernote({
            height: 200, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        $(document).on('click', '#import_btn', function() {
            $('#result').html('');
            var error = false;
            var id = $("#imdb_id").val();
            if (id == '' || id == null) {
                error = true;
            }
            var lang = $("#lang option:selected").val();
            if (!error) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() . "admin/import_movie"; ?>',
                    data: {
                        "id": id,
                        "from": "tv",
                        "lang": lang
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $("#button-area").html('<button class="btn btn-primary" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...</button>');
                        //$("#import_btn").html('.....');
                    },
                    success: function(response) {
                        var imdb_status = response.imdb_status;
                        var imdbid = response.imdbid;
                        var title = response.title;
                        var plot = response.plot;
                        var runtime = response.runtime;
                        var country = JSON.parse("[" + response.country + "]");
                        var genre = JSON.parse("[" + response.genre + "]");
                        var rating = response.rating;;
                        var release = response.release;
                        var thumbnail = response.thumbnail;
                        var poster = response.poster;
                        var trailler_youtube_source         = response.trailler_youtube_source;
                        if (imdb_status == 'success') {
                            // actor
                            $('#actor').select2({
                                data: response.actor
                            })
                            $("#actor > option").prop("selected", "selected");
                            $("#actor").trigger("change");
                            // director
                            $('#director').select2({
                                data: response.director
                            })
                            $("#director > option").prop("selected", "selected");
                            $("#director").trigger("change");
                            // writer
                            $('#writer').select2({
                                data: response.writer
                            })
                            $("#writer > option").prop("selected", "selected");
                            $("#writer").trigger("change");

                            $('#result').html('<div class="alert alert-success alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Data imported successfully.</div>');
                            $("#title").val(title);
                            //slug
                            title = title.toLowerCase();
                            title = title.replace(/[^\w ]+/g, '');
                            title = title.replace(/ +/g, '-');
                            $("#slug").val(title);
                            $("#imdbid").val(imdbid);
                            $("#description").code('<p>' + plot + '</p>');
                            $("#runtime").val(runtime);
                            $("#country").val(country).trigger('change');
                            $("#genre").val(genre).trigger('change');
                            $("#rating").val(rating);
                            $("#release_date").datepicker("setDate", release);
                            $('#thumbnail_content').html('<input type="text" name="thumb_link" value="' + thumbnail + '" class="form-control">');
                            $('#thumb_image').attr('src', thumbnail);
                            $('#poster_content').html('<input type="text" name="poster_link" value="' + poster + '" class="form-control">');
                            $('#poster_image').attr('src', poster);
                            $("#trailler_youtube_source").val(trailler_youtube_source);
                            $("#button-area").html('<button class="btn btn-outline-primary" id="import_btn" type="button" id="button-addon2">FETCH</button>');
                        } else {
                            $('#result').html('<div class="alert alert-danger alert-dismissable m-t-15"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>No data found in database..</div>');
                            $("#button-area").html('<button class="btn btn-outline-primary" id="import_btn" type="button" id="button-addon2">FETCH</button>');
                        }
                    }
                });
            } else {
                alert('Please input IMDb/TMDB ID');
            }
        });
    });
</script>

<script>
    $("#title").keyup(function() {
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^\w ]+/g, '');
        Text = Text.replace(/ +/g, '-');
        $("#slug").val(Text);
    });
</script>

<script type="text/javascript">
    $('#actor').select2({
        placeholder: 'Select Actor',
        minimumInputLength: 2,
        ajax: {
            url: '<?= base_url('admin/load_stars') ?>',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
</script>

<script type="text/javascript">
    $('#director').select2({
        placeholder: 'Select Director',
        minimumInputLength: 2,
        ajax: {
            url: '<?= base_url('admin/load_stars') ?>',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
</script>

<script type="text/javascript">
    $("#lang").select2();
    $('#writer').select2({
        placeholder: 'Select Writer',
        minimumInputLength: 2,
        ajax: {
            url: '<?= base_url('admin/load_stars') ?>',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: data
                };
            },
            cache: true
        }
    });
</script>