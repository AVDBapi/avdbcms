<section class="inner-banner-section banner-section bg-overlay-black <?php echo (ovoo_config('bg_img_disable')=='1')? '':'bg_img'; ?>">
    <!-- Breadcrumb -->
    <div id="title-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-9 col-sm-8 col-xs-12">
                    <div class="page-title">
                        <h1 class="text-uppercase">
                        <?php echo trans('find_movie_by_year'); ?>
                        </h1>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12 text-right">
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i><?php echo trans('home'); ?></a>
                        </li>
                        <li class="active"><?php echo trans('years'); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->
    <!-- Main Section -->
    <div id="section-opt">
        <div class="container">
            <div class="row">
                
                <?php $current_year = date("Y");
                $end_year = $current_year - 108;
                for($i=$current_year;$i>$end_year;$i--): ?>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-1 m-t-10 m-b-10"><a class="btn btn-lg btn-success" href="<?php echo base_url('year/'.$i.'.html'); ?>"><?php echo $i; ?></a></div>
                <?php endfor; ?>
                
            </div>
        </div>
    </div>
</section>