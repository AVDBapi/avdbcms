<div class="card">
  <div class="row">
    <div class="col-sm-12">
      <div class="btn-group dropdown pull-right">
        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light text-capital">
          <?php
          // 0-Unapproved, 1 -Approved, 2-Spam, 3-Trash
          switch ($type) {
            case 'approved':
              echo 'Approved';
              break;
            case 'unapproved':
              echo 'Unapproved';
              break;
            case 'spam':
              echo 'Spam';
              break;
            case 'trash':
              echo 'Trash';
              break;
            case 'draft':
              echo 'Draft';
              break;
            default:
              echo 'FILTER';
              break;
          }
          ?>
        </button>
        <button type="button" class="btn btn-primary dropdown-toggle waves-effect waves-light btn-sm" data-toggle="dropdown" aria-expanded="false"><i class="caret"></i></button>
        <ul class="dropdown-menu" role="menu">
          <li> <a href="<?php echo base_url() . 'admin/comments/approved' ?>"><?php echo trans('approved'); ?></a></li>
          <li><a href="<?php echo base_url() . 'admin/comments/unapproved' ?>"><?php echo trans('unapproved'); ?></a></li>
          <li><a href="<?php echo base_url() . 'admin/comments/trash' ?>"><?php echo trans('trash'); ?></a></li>
          <li><a href="<?php echo base_url() . 'admin/comments/spam' ?>"><?php echo trans('spam'); ?></a></li>
          <li><a href="<?php echo base_url() . 'admin/comments/' ?>"><?php echo trans('all'); ?></a></li>
        </ul>
      </div>
      <br><br>
      <table id="datatable" class="table table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>#</th>
            <th><?php echo trans('author'); ?></th>
            <th><?php echo trans('comment'); ?></th>
            <th><?php echo trans('in_response_to'); ?></th>
            <th><?php echo trans('submitted_on'); ?></th>
            <th><?php echo trans('status'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php $sl = 1;
          // 0-Unapproved, 1 -Approved, 2-Spam, 3-Trash                                
          switch ($type) {
            case 'approved':
              $this->db->order_by('comments_id', 'DESC');
              $comments = $this->db->get_where('comments', array('publication' => '1'))->result_array();
              break;
            case 'unapproved':
              $this->db->order_by('comments_id', 'DESC');
              $comments = $this->db->get_where('comments', array('publication' => '0'))->result_array();
              break;
            case 'trash':
              $this->db->order_by('comments_id', 'DESC');
              $comments = $this->db->get_where('comments', array('publication' => '3'))->result_array();
              break;
            case 'spam':
              $this->db->order_by('comments_id', 'DESC');
              $comments = $this->db->get_where('comments', array('publication' => '2'))->result_array();
              break;
            default:
              $this->db->order_by('comments_id', 'DESC');
              $comments = $this->db->get('comments')->result_array();
              break;
          }
          foreach ($comments as $comments) :

            ?>
              <tr id='row_<?php echo $comments['comments_id']; ?>'>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-white btn-xs dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a data-toggle="modal" data-target="#mymodal" data-id="<?php echo base_url() . 'admin/view_modal/comments_edit/' . $comments['comments_id'] . '/movie'; ?>" id="menu" title="<?php echo trans('edit'); ?>"><?php echo trans('edit_comments'); ?></a>
                      <li><a title="<?php echo trans('delete'); ?>" href="#" onclick="delete_row(<?php echo " 'comments' " . ',' . $comments['comments_id']; ?>)" class="delete"><?php echo trans('delete'); ?></a> </li>
                    </ul>
                  </div>
                </td>
                <td><?php echo $sl++; ?></td>
                <td>
                  <img src="<?php echo $this->common_model->get_img('user', $comments['user_id']) . '?' . time(); ?>" class="img-circle " alt="photo" height="30">
                  <strong><?php echo $this->common_model->get_name_by_id($comments['user_id']); ?></strong><br>
                </td>
                <td> <?php echo $comments['comment']; ?></td>
                <td><?php echo $this->common_model->get_title_by_videos_id($comments['video_id']); ?></td>
                <td><?php echo $comments['comment_at']; ?></td>
                <td>
                  <?php
                    // 0-Unapproved, 1 -Approved, 2-Spam, 3-Trash
                    if ($comments['publication'] == '1') {
                      echo '<span class="label label-success label-xs">Approved</span>';
                    } else if ($comments['publication'] == '0') {
                      echo '<span class="label label-primary label-xs">Unapproved</span>';
                    } else if ($comments['publication'] == '3') {
                      echo '<span class="label label-danger label-xs">Trash</span>';
                    } else if ($comments['publication'] == '2') {
                      echo '<span class="label label-warning label-xs">Spam</span>';
                    } else {
                      echo '<span class="label label-warning label-mini">Spam</span>';
                    }
                    ?>
                </td>
              </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>




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