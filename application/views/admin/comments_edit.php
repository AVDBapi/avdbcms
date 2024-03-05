<?php
if ($param3 == "movie") {
    $comments    = $this->db->get_where('comments', array('comments_id' => $param2))->result_array();
    echo form_open(base_url() . 'admin/comments/update_movie/' . $param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));
} else if ($param3 == "post") {
    $comments    = $this->db->get_where('post_comments', array('post_comments_id' => $param2))->result_array();
    echo form_open(base_url() . 'admin/comments/update_post/' . $param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));
}
foreach ($comments as $row) :
    ?><h4 class="text-center"><?php echo trans('edit_comments'); ?></h4>
    <hr>
    <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo trans('comments'); ?></label>
        <div class="col-sm-6">
            <textarea name="comment" rows="5" class="form-control" placeholder="<?php echo trans('enter_user_full_name'); ?>"><?php echo $row['comment']; ?></textarea>
        </div>
        <!-- End col-6 -->
    </div>
    <!-- end form group -->

    <div class="form-group">
        <label class="col-sm-3 control-label"><?php echo trans('action'); ?></label>
        <div class="col-sm-6 ">
            <select class="form-control" name="publication" required>
                <option value="1" <?php if ($row['publication'] == "1") {
                                            echo "selected";
                                        } ?>><?php echo trans('approved'); ?></option>
                <option value="0" <?php if ($row['publication'] == "0") {
                                            echo "selected";
                                        } ?>><?php echo trans('unapproved'); ?></option>
                <option value="2" <?php if ($row['publication'] == "2") {
                                            echo "selected";
                                        } ?>><?php echo trans('mark_as_spam'); ?></option>
                <option value="3" <?php if ($row['publication'] == "3") {
                                            echo "selected";
                                        } ?>><?php echo trans('move_to_trash'); ?></option>
            </select>
        </div>
        <!-- End col-6 -->
    </div>
    <!-- end form -group -->

<?php endforeach; ?>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
        <button type="submit" class="btn btn-sm btn-primary waves-effect"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save'); ?> </button>
        <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans('close'); ?> </button>
    </div>
    <!-- End col-6 -->
</div>
<!-- end form -group -->
</form>
<script>
    jQuery(document).ready(function() {
        $(".select2").select2();
        $('form').parsley();

    });
</script>