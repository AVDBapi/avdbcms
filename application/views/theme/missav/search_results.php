<!-- Breadcrumb -->
<h1 class="text-center text-2xl mb-6">
    <?php echo '"' . $search_keyword . '" search results'; ?>
</h1>
<!-- End Breadcrumb -->

<!-- Secondary Section -->
<div id="section-opt">
    <!-- All Movies -->
    <?php if ($total_rows > 0) {
        if ($total_rows > 24) {
            echo $links;
        }
        ?>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5 mt-6">
            <?php foreach ($all_published_videos as $videos): ?>
                <?php include ('thumbnail.php'); ?>
            <?php endforeach; ?>
        </div>
        <!-- End All Movies -->
    <?php } else {
        echo '<h4>Nothing found by "' . $search_keyword . '"</h4>';
    } ?>
    <?php if ($total_rows > 24) {
        echo $links;
    }
    ?>
</div>
<!-- Secondary Section -->