<?php 
    $admob_ads_enable               =   $this->db->get_where('config' , array('title' => 'admob_ads_enable'))->row()->value;
    $admob_publisher_id             =   $this->db->get_where('config' , array('title' => 'admob_publisher_id'))->row()->value;
    $admob_app_id                   =   $this->db->get_where('config' , array('title' => 'admob_app_id'))->row()->value;
    $admob_banner_ads_id            =   $this->db->get_where('config' , array('title' => 'admob_banner_ads_id'))->row()->value;
    $admob_interstitial_ads_id      =   $this->db->get_where('config' , array('title' => 'admob_interstitial_ads_id'))->row()->value;
 ?>
 <?php echo form_open(base_url() . 'admin/admob_setting/update/' , array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data'));?>
<div class="card">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-border panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Admob Setting</h3>
                </div>

                <div class="form-group row">
                    <label class="control-label col-sm-3 ">Admob Enable</label>
                    <div class="col-sm-6">
                      <div class="toggle">
                        <label>
                          <input type="checkbox" name="admob_ads_enable" <?php if($admob_ads_enable =='1'){ echo 'checked';} ?>><span class="button-indecator"></span>
                        </label>
                      </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Publisher ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_publisher_id;?>" data-parsley-minlength="16" name="admob_publisher_id" class="form-control" required  />
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob APP ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_app_id;?>" data-parsley-minlength="16" name="admob_app_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Banner Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_banner_ads_id;?>" data-parsley-minlength="16" name="admob_banner_ads_id" class="form-control" required  />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 control-label">Admob Interstitial Ads ID</label>
                    <div class="col-sm-3">
                      <input type="text"  value="<?php echo $admob_interstitial_ads_id;?>" data-parsley-minlength="16" name="admob_interstitial_ads_id" class="form-control" required  />
                    </div>
                </div>


                <div class="col-sm-offset-3 col-sm-9 m-t-15">
                    <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span>save changes </button>
                </div>

            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/parsleyjs/dist/parsley.min.js"></script> 
<script type="text/javascript">
  $(document).ready(function() {
    $('form').parsley();
  });
</script> 