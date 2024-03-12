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
    <div class="col-md-4">
        <div class="panel panel-border panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo trans('import_movie_from_avdb'); ?>
                </h3>
            </div>
            <div class="panel-body">
                <div class="input-group mb-3">
                    <input type="number" class="form-control" id="avdb_id" placeholder="Enter AVDB ID. Ex: 141052">
                    <div class="input-group-append" id="button-area">
                        <button class="btn btn-outline-primary" id="import_btn" type="button">
                            <?php echo trans('fetch'); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-border panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <?php echo trans('crawl_movies_from_avdb'); ?>
                </h3>
            </div>
            <form id="get_movies_form" class="form-horizontal group-border-dashed mb-3">
                <div class="panel-body">
                    <div class="input-group">
                        <div class="form-group">
                            <label class=" control-label">
                                <?php echo trans('crawl_page_from'); ?>
                            </label>
                            <input type="number" min="1" name="crawl_page_from" id="crawl_page_from"
                                class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class=" control-label">
                                <?php echo trans('crawl_page_to'); ?>
                            </label>
                            <input type="number" min="1" name="crawl_page_to" id="crawl_page_to" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="crawl_page" class="btn btn-primary waves-effect mr-3">
                            <?php echo trans('crawl_page'); ?>
                        </button>
                        <button type="button" id="crawl_today" class="btn btn-success waves-effect">
                            <?php echo trans('crawl_today'); ?>
                        </button>
                        <button type="button" id="crawl_all" class="btn btn-primary waves-effect">
                            <?php echo trans('crawl_all'); ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-8">
        <h4 class="text-center panel-title">Video Type List</h4>
        <p>Movies list</p>
        <div><textarea class="col" name="movies" id="movies" rows="10" readonly></textarea></div>
        <hr>
        <p>Results</p>
        <div><textarea class="col" name="result" id="result" rows="10" readonly></textarea></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        const btnCrawlId = $("button#import_btn");
        const btnCrawlPages = $("button#crawl_page");
        const btnCrawlToday = $("button#crawl_today");
        const btnCrawlAll = $("button#crawl_all");
        const divResults = $("#result");
        let remainPageList = [];

        btnCrawlId.on("click", function(e) {
            e.preventDefault();
            let id = $("input#avdb_id").val();
            if (id === ''|| id === undefined) {
                alert("Please enter the avdb movie id");
                return false;
            }
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'admin/crawl_avdb_by_id/'; ?>",
                data: {id: id},
                dataType: "json",
                beforeSend: function () {
                    disableAllBtn();
                    $("textarea#movies").val();
                },
                success: function (response) {
                    if (response.status == 'fail') {
                        alert("Movie not found! Please enter correct id or contact admin.");
                        return false;
                    }
                    let text = $("textarea#result").val();
                    text += response.msg + '\n';
                    $("textarea#result").val(text);
                    enableAllBtn();
                }
            });
        });

        $("#get_movies_form").submit(function (e) {
            e.preventDefault();
            let pageStart = $("input#crawl_page_from").val();
            let pageEnd = $("input#crawl_page_to").val();
            let pageList = [];
            for (let i = pageStart; i <= pageEnd; i++) {
                pageList.push(i);
            }
            crawl_movies_page(pageList);
        });
        btnCrawlToday.on("click", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'admin/crawl_avdb/crawl_today/'; ?>",
                dataType: "json",
                beforeSend: function () {
                    disableAllBtn();
                    $("textarea#movies").val();
                },
                success: function (response) {
                    if (response.status == 'success') {
                        crawl_movies_page(response.pages, '&h=24');
                    } else {
                        alert("Something went wrong!");
                        return false;
                    }
                },
            });
        });
        btnCrawlAll.on("click", function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'admin/crawl_avdb/crawl_all/'; ?>",
                dataType: "json",
                beforeSend: function () {
                    disableAllBtn();
                    $("textarea#movies").val();
                },
                success: function (response) {
                    if (response.status == 'success') {
                        crawl_movies_page(response.pages);
                    } else {
                        alert("Something went wrong!");
                        return false;
                    }
                },
            });
        });
        const crawl_movies_page = (pageList, params = '') => {
            if (pageList.length == 0) {
                enableAllBtn();
                remainPageList = [];
                return;
            }
            let currentPage = pageList.shift();
            remainPageList = pageList;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'admin/crawl_avdb/crawl_page/'; ?>",
                data: {page: currentPage, params: params},
                beforeSend: function () {
                    disableAllBtn();
                    $("textarea#movies").val();
                },
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.status == 'success') {
                        let text = '';
                        let ids = [];
                        for (let i = 0; i < response.movies.length; i++) {
                            ids.push(response.movies[i]['id']);
                            text += 'ID: ' + response.movies[i]['id'] + ' CODE: ' + response.movies[i]['code'] + '\n';
                        }
                        $("textarea#movies").val(text);
                        crawl_movie_by_id(ids);
                    }
                },
            });
        };
        const crawl_movie_by_id = (ids) => {
            let id = ids.shift();
            if (id == null) {
                crawl_movies_page(remainPageList);
                return;
            }
            $.ajax({
                type: "POST",
                url: "<?php echo base_url() . 'admin/crawl_avdb_by_id/'; ?>",
                data: {id: id},
                dataType: "json",
                success: function (response) {
                    let text = $("textarea#result").val();
                    if (response.status == "success") {
                        text += response.msg + '\n';
                    } else {
                        text += "ID: "+id+" : Crawl Error\n";
                    }
                    $("textarea#result").val(text);
                    crawl_movie_by_id(ids);
                }
            });
        };
        const disableAllBtn = () => {
            btnCrawlId.prop("disabled", true);
            btnCrawlPages.prop("disabled", true);
            btnCrawlToday.prop("disabled", true);
            btnCrawlAll.prop("disabled", true);
        };
        const enableAllBtn = () => {
            btnCrawlId.prop("disabled", false);
            btnCrawlPages.prop("disabled", false);
            btnCrawlToday.prop("disabled", false);
            btnCrawlAll.prop("disabled", false);
        };
    });
</script>