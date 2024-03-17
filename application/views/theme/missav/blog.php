
<?php if($this->common_model->get_ads_status('blog_header')=='1'): ?>
<!-- header ads -->
<div id="ads" style="padding: 20px 0px;text-align: center;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <?php echo $this->common_model->get_ads('blog_header'); ?>
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
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="page-title">
                    <h1 class="text-uppercase"><?php echo trans('our_blog'); ?></h1>
                </div>
            </div>
            <div class="col-md-3 col-sm-4 col-xs-12 text-right">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i><?php echo trans('home'); ?></a>
                    </li>
                    <li class="active"><?php echo trans('blog'); ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->


<div id="post-listing">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12">
            <?php if($total_rows > 0){ ?>
                <div class="row clean-preset">
                    <div class="movie-container">
                        <!-- Single post -->
                        <?php foreach ($all_published_posts as $posts) :?>
                        <div class="col-md-6 col-sm-6">
                            <div class="post-list-container">
                                <div class="movie-img">
                                    <img class="img-responsive" src="<?php echo $posts->image_link; ?>" alt="video image">
                                </div>
                                <div class="post-video-info">
                                    <p class="post-video-aut-name">
                                        <span class="by-in"><?php echo trans('by'); ?></span>
                                        <a href="<?php echo base_url().'blog/author/'.$this->common_model->get_slug_by_user_id($posts->user_id).'.html';?>"><?php echo $this->common_model->get_name_by_id($posts->user_id);?></a>
                                        <span>&#47;</span>
                                        <span class="by-in"> In</span>
                                        <?php $category=explode(',', $posts->category_id);
                                            foreach ($category as $category):
                                        ?>
                                        <a href="<?php echo base_url().'blog/category/'.$this->common_model->get_slug_by_category_id($category).'.html'; ?>">
                                            <?php echo $this->common_model->get_category_name_by_id($category);?>
                                        </a>
                                        <?php endforeach; ?>
                                        </p>
                                        <p class="blog-movie-desc text-right">
                                            <span><?php echo $this->common_model->time_ago($posts->post_at);?></span>
                                            <span>&#47;</span>
                                            <span><?php echo $this->common_model->post_comments_record_count_by_id($posts->posts_id);?> <i class="fa fa-commenting-o"></i></span>
                                        </p>
                                </div>
                                <div class="post-text">
                                    <div class="sm-heading">
                                        <a href="<?php echo  base_url().'blog/'.$posts->slug.'.html'; ?>">
                                            <h2>
                                                <?php echo $posts->post_title;?>
                                            </h2>
                                        </a>
                                    </div>
                                    <?php 
                                        $html = strip_tags($posts->content);
                                        $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
                                        $html = mb_substr($html, 0, 100, 'UTF-8');
                                        $html .= "…";
                                     ?>
                                    <p>
                                        <?php echo $html;?>
                                    </p>
                                    <a href="<?php echo  base_url().'blog/'.$posts->slug.'.html'; ?>" class="btn btn-success btn-sm pull-right">Read More<i class="fa fa-angle-double-right m-l-10" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <!-- End Single post -->
                    </div>
                </div>
                <?php }else{ echo '<h2>No post found..</h2>';} ?>
                <?php if($total_rows > 12){ echo $links; } ?>
            </div>
            <?php include('blog_sidebar.php'); ?>            
        </div>
    </div>
</div>

<!-- Secondary Section -->