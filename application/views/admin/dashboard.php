<div class="row">
  <div class="col-md-3">
    <div class="widget-small primary"><i class="icon fa fa-video-camera fa-3x"></i>
      <div class="info">
        <h4><?php echo trans('movies'); ?></h4>
        <p><b class="counter"><?php echo $this->db->get_where('videos', array('publication' => '1', 'is_tvseries' => '0'))->num_rows(); ?></b></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small info"><i class="icon fa fa-video-camera fa-3x"></i>
      <div class="info">
        <h4><?php echo trans('tv_series'); ?></h4>
        <p><b class="counter"><?php echo $this->db->get_where('videos', array('publication' => '1', 'is_tvseries' => '1'))->num_rows(); ?></b></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small warning"><i class="icon fa fa-tv fa-3x"></i>
      <div class="info">
        <h4><?php echo trans('live_tv'); ?></h4>
        <p><b class="counter"><?php echo $this->db->get_where('live_tv', array('publish' => '1'))->num_rows(); ?></b></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small danger"><i class="icon fa fa-star fa-3x"></i>
      <div class="info">
        <h4><?php echo trans('stars'); ?></h4>
        <p><b class="counter"><?php echo $this->db->get('star')->num_rows(); ?></b></p>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <div class="widget-small primary coloured-icon"><i class="icon fa fa-flag fa-3x"></i>
      <div class="info">
        <h4><?php echo trans('countries'); ?></h4>
        <p><b class="counter"><?php echo count($this->db->get('country')->result_array()); ?></b></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small info coloured-icon"><i class="icon fa fa-file-text-o fa-3x"></i>
      <div class="info">
        <h4><?php echo trans('page'); ?></h4>
        <p><b class="counter"><?php echo $this->db->get_where('page', array('publication' => '1'))->num_rows(); ?></b></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small warning coloured-icon"><i class="icon fa fa-pencil-square-o fa-3x"></i>
      <div class="info">
        <h4><?php echo trans('posts'); ?></h4>
        <p><b class="counter"><?php echo $this->db->get_where('posts', array('publication' => '1'))->num_rows(); ?></b></p>
      </div>
    </div>
  </div>
  <div class="col-md-3">
    <div class="widget-small danger coloured-icon"><i class="icon fa fa-users fa-3x"></i>
      <div class="info">
        <h4><?php echo trans('register_user'); ?></h4>
        <p><b class="counter"><?php echo $this->db->get('user')->num_rows(); ?></b></p>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('recent_comments'); ?></h3>
        </div>
        <div class="panel-body">
          <table id="datatable-fixed-header" class="table table-striped table-bordered success">
            <thead>
              <tr>
                <th><?php echo trans('name'); ?></th>
                <th><?php echo trans('video'); ?></th>
                <th><?php echo trans('comments'); ?></th>
                <th><?php echo trans('comments_at'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php


              $this->db->LIMIT('5');
              $this->db->order_by('comment_at', 'desc');
              $comments = $this->db->get('comments')->result_array();
              foreach ($comments as $comment) : ?>
                <tr>
                  <td><?php echo $this->common_model->get_name_by_id($comment['user_id']); ?></td>
                  <td><?php echo $this->common_model->get_video_title_by_id($comment['video_id']); ?></td>
                  <td><?php echo $comment['comment']; ?></td>
                  <td><?php echo $comment['comment_at']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('most_popular_videos'); ?></h3>
        </div>
        <div class="panel-body">
          <table id="datatable-fixed-header" class="table table-striped table-bordered success">
            <thead>
              <tr>
                <th><?php echo trans('title'); ?></th>
                <th><?php echo trans('release'); ?></th>
                <th><?php echo trans('total_view'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $this->db->LIMIT('5');
              $this->db->order_by('total_view', 'desc');
              $videos = $this->db->get('videos')->result_array();
              foreach ($videos as $video) : ?>
                <tr>
                  <td><a href="<?php echo base_url() . 'watch/' . $video['slug'] . '.html'; ?>" target="_blank"><?php echo $video['title']; ?></a></td>
                  <td><a href="<?php echo base_url() . 'watch/' . $video['slug'] . '.html'; ?>" target="_blank"><?php echo $video['release']; ?></a></td>
                  <td><a href="<?php echo base_url() . 'watch/' . $video['slug'] . '.html'; ?>" target="_blank"><?php echo $video['total_view']; ?></a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-sm-6">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('top_rated_videos'); ?></h3>
        </div>
        <div class="panel-body">
          <table id="datatable-fixed-header" class="table table-striped table-bordered success">
            <thead>
              <tr>
                <th><?php echo trans('title'); ?></th>
                <th><?php echo trans('release'); ?></th>
                <th><?php echo trans('total_view'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $this->db->LIMIT('5');
              $this->db->order_by('total_rating', 'desc');
              $videos = $this->db->get('videos')->result_array();
              foreach ($videos as $video) : ?>
                <tr>
                  <td><a href="<?php echo base_url() . 'watch/' . $video['slug'] . '.html'; ?>" target="_blank"><?php echo $video['title']; ?></a></td>
                  <td><a href="<?php echo base_url() . 'watch/' . $video['slug'] . '.html'; ?>" target="_blank"><?php echo $video['release']; ?></a></td>
                  <td><a href="<?php echo base_url() . 'watch/' . $video['slug'] . '.html'; ?>" target="_blank"><?php echo $video['total_rating']; ?></a></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('recent_post'); ?></h3>
        </div>
        <div class="panel-body">
          <table id="datatable-fixed-header" class="table table-striped table-bordered success">
            <thead>
              <tr>
                <th><?php echo trans('title'); ?></th>
                <th><?php echo trans('post_at'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $this->db->LIMIT('5');
              $this->db->order_by('posts_id', 'desc');
              $posts = $this->db->get('posts')->result_array();
              foreach ($posts as $post) : ?>
                <tr>
                  <td><?php echo substr($post['post_title'], 0, 45) . '..'; ?></td>
                  <td><?php echo $post['post_at']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="panel panel-border panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo trans('recent_subscriber'); ?></h3>
        </div>
        <div class="panel-body">
          <table id="datatable-fixed-header" class="table table-striped table-bordered success">
            <thead>
              <tr>
                <th><?php echo trans('name'); ?></th>
                <th><?php echo trans('email'); ?></th>
                <th><?php echo trans('subscribe_at'); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $this->db->LIMIT('5');
              $this->db->order_by('user_id', 'desc');
              $subscribers = $this->db->get('user')->result_array();
              foreach ($subscribers as $subscriber) : ?>
                <tr>
                  <td><?php echo $subscriber['name']; ?></td>
                  <td><?php echo $subscriber['email']; ?></td>
                  <td><?php echo $subscriber['join_date']; ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div>

    <script src="<?php echo base_url(); ?>assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/counterup/jquery.counterup.min.js"></script>
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        $('.counter').counterUp({
          delay: 10,
          time: 1000
        });
      });
    </script>