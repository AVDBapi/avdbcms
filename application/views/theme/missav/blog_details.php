<?php
    $theme_dir          =   'theme/default/';
    $assets_dir         =   'assets/theme/default/';
?>

<!-- Breadcrumb -->
<div id="title-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="page-title">
                    <h1 class="text-uppercase">
                        <?php echo $post_details->post_title; ?>
                    </h1>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12 text-right">
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo base_url();?>"><i class="fi ion-ios-home"></i><?php echo trans('home'); ?></a>
                    </li>
                    <li><a href="<?php echo base_url('blog');?>"><i class="fi ion-edit"></i><?php echo trans('blog'); ?></a></li>
                    <li class="active">
                        <?php echo $post_details->slug; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb -->


<div id="post-listing">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">
                <div class="movie-details-container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="blog-detail-img">
                                <img class="img-responsive" src="<?php echo $post_details->image_link; ?>" alt="<?php echo $post_details->post_title; ?>">
                            </div>
                            <div>
                                <h1 class="blog-title">
                                    <?php echo $post_details->post_title; ?>
                                </h1>
                            </div>
                            <div class="post-video-info">
                                <div class="row">
                                    <div class="col-md-6"><span class="by-in"><?php echo trans('by'); ?></span>
                                        <a href="#"><?php echo $this->common_model->get_name_by_id($post_details->user_id);?></a>
                                        <span>&#47;</span>
                                        <span class="by-in"> In</span>
                                        <?php $category=explode(',', $post_details->category_id);
                                            foreach ($category as $category):
                                        ?>
                                        <a href="<?php echo base_url().'blog/category/'.$this->common_model->get_slug_by_category_id($category).'.html'; ?>">
                                            <?php echo $this->common_model->get_category_name_by_id($category);?>
                                        </a>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <span><?php echo date('d M Y',strtotime($post_details->post_at));?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="movie-details-text">
                                <?php echo $post_details->content; ?>
                                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                    <div class="addthis_inline_share_toolbox_yl99 m-t-30 m-b-10" data-url="<?php echo base_url().'blog/'.$post_details->slug.'.html';?>" data-title="Watch & Download <?php echo $post_details->post_title;?>"></div>
                                    <!-- Addthis Social tool -->
                            </div>
                            <div class="similler-movie">
                                <?php $this->load->view($theme_dir.'comments',array('PAGE_URL' => base_url('blog/'.$post_details->slug.'.html'),'PAGE_IDENTIFIER'=>'post_'.$post_details->posts_id)); ?>
                            </div>
                            <div class="similler-movie">
                                <div class="movie-heading overflow-hidden">
                                    <span><?php echo trans('related_blog'); ?></span>
                                    <div class="disable-bottom-line"></div>
                                </div>
                                <div class="row">
                                    <!-- All post -->
                                    <?php
                                        $category_id = explode(',', $post_details->category_id);
                                        $related_posts = $this->common_model->related_posts($category_id[0]);
                                        foreach ($related_posts as $posts) :?>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="post-list-container">
                                                <div class="movie-img">
                                                    <img class="img-responsive" src="<?php echo $posts->image_link; ?>" alt="video image">
                                                </div>
                                                <div class="post-video-info">
                                                    <p class="post-video-aut-name">
                                                        <span class="by-in">By</span>
                                                        <a href="#"><?php echo $this->common_model->get_name_by_id($posts->user_id);?></a>
                                                        <span>&#47;</span>
                                                        <span class="by-in"> In</span>
                                                        <?php $category=explode(',', $posts->category_id);
                                                            foreach ($category as $category):
                                                        ?>
                                                        <a href="<?php echo base_url().'blog/'.$category; ?>">
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
                                                    <a href="<?php echo  base_url().'blog/'.$posts->slug.'.html'; ?>" class="btn btn-success pull-right">Read More<i class="fa fa-angle-double-right m-l-10" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <!-- End All post -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view($theme_dir.'blog_sidebar'); ?>   
        </div>
    </div>
</div>

<!-- Secondary Section -->