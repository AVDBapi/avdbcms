<?php
$languages   = $this->db->get_where('language', array('language_id' => $param2))->result_array();
foreach ($languages as $row) :
    ?>
    <?php echo form_open(base_url() . 'admin/movie_language/update/' . $param2, array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>

    <h4 class="text-center"><?php echo trans('language_edit'); ?></h4>
    <hr>

    <div class="form-group">
        <label class=" col-sm-3 control-label"><?php echo trans('name'); ?></label>
        <div class="col-sm-12">
            <input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3"><?php echo trans('description'); ?></label>
        <div class="col-sm-12">
            <textarea class="wysihtml5 form-control" name="description" rows="10"><?php echo $row['description']; ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-md-3"><?php echo trans('publication'); ?></label>
        <div class="col-sm-12">
            <select class="form-control m-bot15" name="publication">
                <option value="1" <?php if ($row['publication'] == '1') {
                                            echo 'selected';
                                        } ?>><?php echo trans('published'); ?></option>
                <option value="0" <?php if ($row['publication'] == '0') {
                                            echo 'selected';
                                        } ?>><?php echo trans('unpublished'); ?></option>
            </select>
        </div>
    </div>

<?php endforeach; ?>
<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9 m-t-15">
        <button type="submit" class="btn btn-sm btn-primary waves-effect"> <span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save'); ?> </button>
        <button type="" class="btn btn-sm btn-white m-l-5 waves-effect" data-dismiss="modal"><?php echo trans('close'); ?> </button>
    </div>
</div>
</form>
<script>
    jQuery(document).ready(function() {
        $('form').parsley();

    });
</script>