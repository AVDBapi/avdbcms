<div class="col-md-3 col-sm-4 ">
    <div class="row">
        <div class="col-md-12 m-b-10">
            <?php echo $this->common_model->get_ads('sidebar'); ?>  
        </div>
    </div>
    <div class="sidebar">
        <div class="sidebar-movie most-liked">
            <h1 class="sidebar-title"><?php echo trans('category'); ?></h1>
            <ul class="post-category-list list-unstyled">
            <?php   
                    $post_categories =   $this->db->get('post_category')->result();         
                        foreach ($post_categories as $post_category):
            ?>

            <li><a href="<?php echo base_url().'blog/category/'.$post_category->slug.'.html'; ?>"><?php echo $post_category->category; ?></a></li>

            <?php endforeach ?>
            </ul>
        </div>
        <div class="sidebar-movie most-viewed">
            <h1 class="sidebar-title"><?php echo trans('recent_post'); ?></h1>
            <?php
                    $most_rated_posts =   $this->db->get_where('posts', array('publication'=> '1'), 5)->result();         
                        foreach ($most_rated_posts as $most_rated_post):
            ?>

            <div class="media">
                <div class="media-left"> <img src="<?php echo $most_rated_post->image_link;?>" alt="<?php echo $most_rated_post->post_title;?>" width="40"> </div>
                <div class="media-body">
                    <h1><a href="<?php echo base_url('blog/'.$most_rated_post->slug).'.html';?>"><?php echo $most_rated_post->post_title;?></a></h1>
                    
                </div>
            </div>

            <?php endforeach ?>
        </div>

        <div class="google_add m-b-10">
        	<?php echo $this->common_model->get_ads('sidebar'); ?>  
        </div>


    </div>
</div>