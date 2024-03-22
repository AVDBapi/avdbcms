<section>
    <div class="mb-3 md:mb-6">
        <h1 class="text-uppercase">
            <?php echo trans('star'); ?>:
            <?php echo $star_name; ?>
        </h1>
    </div>

    <!-- Secondary Section -->
    <div id="section-opt">
        <div class="mb-4">
            <!-- All Movies -->
            <?php if ($total_rows > 0): ?>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-5">
                    <?php foreach ($all_published_videos as $videos): ?>
                        <?php include ('thumbnail.php'); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <!-- End All Movies -->
        </div>
        <?php echo $links; ?>
    </div>
    <!-- Secondary Section -->
</section>