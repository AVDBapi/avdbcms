<!-- Breadcrumb -->
<div id="title-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="page-title">
                    <h1 class="text-uppercase"><?php echo '"'.$search_keyword.'" search results'; ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->

<!-- Secondary Section -->
<div id="section-opt">
    <div class="container">
        <div class="row">
            <!-- All Movies -->
            <?php if($total_rows>0){
                if($total_rows > 24){
                echo $links;
            }
            ?>
            <div class="col-md-12 col-sm-12">
                <div class="latest-movie movie-opt">
                    <div class="row clean-preset">
                        <div class="movie-container">
                            <?php foreach ($all_published_videos as $videos) :?>
                            <div class="col-md-2 col-sm-3 col-xs-6">
                                <?php include('thumbnail.php'); ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End All Movies -->
            <?php }else{
                echo '<h4>Nothing found by "'.$search_keyword.'"</h4>';
            } ?>
        </div>
        <?php if($total_rows > 24){
                        echo $links;
                    }
        ?>
        
    </div>
</div>
<!-- Secondary Section -->