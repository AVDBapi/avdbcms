<div class="card">
  <div class="row">
    <div class="col-sm-12">
      <div class="table-responsive">
        <?php echo form_open('admin/save_phrases'); ?>
        <input type="hidden" name="id" class="form-control" value="<?php echo $language->id; ?>">
        <input type="hidden" id="lang_folder" class="form-control" value="<?php echo $language->folder_name; ?>">
        <table class="table table-bordered table-striped dataTable">
          <thead>
            <tr role="row">
              <th>#</th>
              <th><?php echo trans('phrase'); ?></th>
              <th><?php echo trans('label'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $count = 1; ?>
            <?php foreach ($phrases as $item) : ?>
              <tr class="tr-phrase">
                <td style="width: 50px;"><?php echo $count; ?></td>
                <td style="width: 40%;"><input type="text" name="phrase[]" class="form-control" value="<?php echo $item["phrase"]; ?>" readonly></td>
                <td style="width: 60%;"><input type="text" name="label[]" class="form-control" value="<?php echo $item["label"]; ?>"></td>
              </tr>
              <?php $count++; ?>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="col-sm-12 m-t-30">
          <div class="row">
            <div class="pull-right">
              <a href="<?php echo base_url('admin/language_setting'); ?>" class="btn btn-danger m-r-5"><?php echo trans('back'); ?></a>
              <button type="submit" class="btn btn-primary"><?php echo trans('save_changes'); ?></button>
            </div>
          </div>
        </div>
        <?php echo form_close(); ?>
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