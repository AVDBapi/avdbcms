<div class="card">
  <div class="row">
    <div class="col-sm-12">
        <div class="btn-group dropdown pull-right">
          <button type="button" class="btn btn-primary btn-sm waves-effect waves-light text-capital">
          <?php
            switch ($type) {
              case 'published':
                echo 'PUBLISHED';
                break;
              case 'unpublished':
                echo 'UNPUBLISHED';
                break;                
              default:
                echo 'FILTER';
                break;
            }
            ?>
          </button>
          <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
          <ul class="dropdown-menu" role="menu">
            <li><a class="dropdown-item" href="<?php echo base_url().'admin/posts/published'?>"><?php echo trans('published'); ?></a></li>
            <li><a class="dropdown-item" href="<?php echo base_url().'admin/posts/unpublished'?>"><?php echo trans('unpublished'); ?></a></li>
            <li><a class="dropdown-item" href="<?php echo base_url().'admin/posts/'?>"><?php echo trans('all_posts'); ?></a></li>
          </ul>
        </div>
        <a href="<?php echo base_url() . 'admin/posts_add';?>" class="btn btn-sm btn-primary waves-effect waves-light"><span class="btn-label"><i class="fa fa-plus"></i></span><?php echo trans('add_post'); ?></a> <br>
        <br>
        <table id="datatable" class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>#</th>
              <th><?php echo trans('title'); ?></th>
              <th><?php echo trans('post_category'); ?></th>
              <th><?php echo trans('status'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $sl = 1;                                
            switch ($type) {
              case 'published':
                $this->db->order_by('posts_id','DESC');
                $posts=$this->db->get_where('posts', array('publication' => '1'))->result_array();
                break;
              case 'unpublished':
                $this->db->order_by('posts_id','DESC');
                $posts=$this->db->get_where('posts', array('publication' => '0'))->result_array();
                break;
              default:
                  $this->db->order_by('posts_id','DESC');
                  $posts=$this->db->get('posts')->result_array();                  
                  break;
            }                                
            foreach ($posts as $posts):                     

            ?>
            <tr id='row_<?php echo $posts['posts_id'];?>'>                
              <td><div class="btn-group">
                  <button type="button" class="btn btn-white btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a class="dropdown-item" target="_blank" href="<?php echo base_url() . 'blog/'. $posts['slug'];?>"><?php echo trans('preview'); ?></a></li>
                    <li><a class="dropdown-item"  href="<?php echo base_url() . 'admin/posts_edit/'. $posts['posts_id'];?>"><?php echo trans('edit_post'); ?></a></li>
                    <li><a class="dropdown-item" title="<?php echo trans('delete'); ?>" href="#" onclick="delete_row(<?php echo " 'posts' ".','.$posts['posts_id'];?>)" class="delete"><?php echo trans('delete'); ?></a> </li>
                  </ul>
                </div>
              </td>
                <td><?php echo $sl++;?></td>
              <td><strong><?php echo $posts['post_title'];?></strong></td>                
              <td><?php
                    $categories= explode(',', $posts['category_id']);
                    foreach ($categories as $category) {
                        $category_name = $this->common_model->get_category_name($category);
                        echo '<span class="label label-primary label-xs">'.$category_name.'</span>&nbsp;';
                    }
                  ?>
              </td>
              <td><?php
                      if($posts['publication']=='1'){
                          echo '<span class="label label-primary label-xs">Published</span>';
                      }
                      else{
                          echo '<span class="label label-warning label-mini">Unublished</span>';
                      }
                  ?>                      
              </td>
            </tr>
            <?php endforeach;?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

<script type="text/javascript" src="<?php echo base_url() ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $('form').parsley();
    });
</script> 

<!-- date picker--> 
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script> 
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> 
<!-- date picker--> 
<!-- file select--> 
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-filestyle/src/bootstrap-filestyle.min.js" type="text/javascript"></script> 
<!-- file select--> 
<!-- select2--> 
<script src="<?php echo base_url() ?>assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" type="text/javascript"></script> 
<script src="<?php echo base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script> 
<!-- select2--> 
