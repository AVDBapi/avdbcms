<?php $star_per_page = 30; ?>
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

<section>
    <!-- Secondary Section -->
    <div id="section-opt">
        <div class="mb-6 text-center">
            <h3 class="text-lg md:text-2xl font-semibold capitalize">
                <?php echo trans('popular_stars'); ?>
            </h3>
        </div>
        <!-- All Movies -->
        <?php if ($total_rows > 0) { ?>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-5 text-center">
                <?php foreach ($stars as $star): ?>
                    <a class="flex flex-col items-center justify-center group"
                        href="<?php echo base_url() . 'star/' . $this->common_model->get_star_slug_by_id($star['star_id']); ?>">
                        <img class="rounded-full w-28 h-28 object-cover"
                            src="<?php echo $this->common_model->get_image_url('star', $star['star_id']) ?>"
                            alt="<?php echo $star['star_name'] ?>">
                        <div class="my-2 group-hover:text-pink-600">
                            <?php echo $star['star_name'] ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            <!-- End All Movies -->
        </div>
        <?php if ($total_rows > $star_per_page) {
            echo $links;
        }
        } else {
            echo '<center><h3>' . trans("no_movie_found") . '</h3></center>';
        } ?>

    </div>
    </div>
    <!-- Secondary Section -->
</section>