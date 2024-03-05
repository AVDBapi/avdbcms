    <?php echo form_open(base_url() . 'admin/seo_setting/update/', array('class' => 'form-horizontal group-border-dashed', 'enctype' => 'multipart/form-data')); ?>
    <div class="card">
      <div class="row">
        <!-- panel  -->
        <div class="panel panel-border panel-primary col-md-6">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo trans('basic_seo'); ?></h3>
          </div>
          <div class="panel-body">
            <!-- panel  -->
            <div class="alert alert-info col-sm-12 col-md-offset-3">
              <p><strong><?php echo trans('note'); ?>: </strong><?php echo trans('leave_blank_if_you_not_want_to_use_any_feature'); ?></p>
            </div>

            <div class="form-group row">
              <label class=" col-sm-4 control-label"><?php echo trans('xml_sitemap_url'); ?>:</label>
              <div class="col-sm-8">
              <a href="<?php echo base_url('sitemap.xml') ?>" target="_blank"><?php echo base_url('sitemap.xml') ?></a><br><br>
              <a href="<?php echo base_url('admin/generator_sitemap/'); ?>" class="btn btn-primary btn-sm"><?php echo trans('update_sitemap');?></a>
              </div>
            </div>
            <div class="form-group">
              <label class=" col-sm-12 control-label"><?php echo trans('author_name'); ?></label>
              <div class="col-sm-12">
                <input type="text" name="author" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'author'))->row()->value; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class=" col-sm-12 control-label"><?php echo trans('google_analytics_id'); ?></label>
              <div class="col-sm-12">
                <input type="text" name="google_analytics_id" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'google_analytics_id'))->row()->value; ?>">
              </div>
            </div>
          </div>
        </div>

        <div class="panel panel-border panel-primary col-md-6">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo trans('home_page_seo'); ?></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label class=" col-sm-12 control-label"><?php echo trans('seo_title'); ?></label>
              <div class="col-sm-12">
                <input type="text" name="home_page_seo_title" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'home_page_seo_title'))->row()->value; ?>">
              </div>
            </div>

            <div class="form-group">
              <label class=" col-sm-12 control-label"><?php echo trans('seo_keyword'); ?></label>
              <div class="col-sm-12">
                <input type="text" name="focus_keyword" class="form-control" id="focus_keyword" value="<?php echo $this->db->get_where('config', array('title' => 'focus_keyword'))->row()->value; ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3"><?php echo trans('seo_meta_description'); ?></label>
              <div class="col-sm-12">
                <textarea class="wysihtml5 form-control" name="meta_description" id="footer-1" rows="5"><?php echo $this->db->get_where('config', array('title' => 'meta_description'))->row()->value; ?></textarea>
              </div>
            </div>


          </div>
        </div>

        <div class="panel panel-border panel-primary col-md-6">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo trans('movie_page_seo'); ?></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label class=" col-sm-12 control-label"><?php echo trans('seo_title'); ?></label>
              <div class="col-sm-12">
                <input type="text" name="movie_page_seo_title" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'movie_page_seo_title'))->row()->value; ?>">
              </div>
            </div>

            <div class="form-group">
              <label class=" col-sm-12 control-label"><?php echo trans('seo_keyword'); ?></label>
              <div class="col-sm-12">
                <input type="text" name="movie_page_focus_keyword" class="form-control" id="movie_page_focus_keyword" value="<?php echo $this->db->get_where('config', array('title' => 'movie_page_focus_keyword'))->row()->value; ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-12"><?php echo trans('seo_meta_description'); ?></label>
              <div class="col-sm-12">
                <textarea class="wysihtml5 form-control" name="movie_page_meta_description" id="footer-1" rows="5"><?php echo $this->db->get_where('config', array('title' => 'movie_page_meta_description'))->row()->value; ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="panel panel-border panel-primary col-md-6">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo trans('tv_series_page_seo'); ?></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label class="col-sm-12 control-label"><?php echo trans('seo_title'); ?></label>
              <div class="col-sm-12">
                <input type="text" value="<?php echo $this->db->get_where('config', array('title' => 'tv_series_title'))->row()->value; ?>" name="tv_series_title" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12 control-label"><?php echo trans('seo_keyword'); ?></label>
              <div class="col-sm-12">
                <input type="text" value="<?php echo $this->db->get_where('config', array('title' => 'tv_series_keyword'))->row()->value; ?>" id="tv_series_keyword" name="tv_series_keyword" class="form-control" />
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-12 control-label"><?php echo trans('seo_meta_description'); ?></label>
              <div class="col-sm-12">
                <textarea class="wysihtml5 form-control" name="tv_series_meta_description" id="description" rows="5">
                <?php echo $this->db->get_where('config', array('title' => 'tv_series_meta_description'))->row()->value; ?>
              </textarea>
              </div>
            </div>
          </div>
        </div>

        <div class="panel panel-border panel-primary col-md-6">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo trans('live_tv_page_seo'); ?></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label class="control-label"><?php echo trans('seo_title'); ?></label>
              <input type="text" value="<?php echo $this->db->get_where('config', array('title' => 'live_tv_title'))->row()->value; ?>" name="live_tv_title" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label"><?php echo trans('seo_keyword'); ?></label>
              <input type="text" id="live_tv_keyword" value="<?php echo $this->db->get_where('config', array('title' => 'live_tv_keyword'))->row()->value; ?>" id="live_tv_keyword" name="live_tv_keyword" class="form-control" />
            </div>
            <div class="form-group">
              <label class="control-label"><?php echo trans('seo_meta_description'); ?></label>
              <textarea class="wysihtml5 form-control" name="live_tv_meta_description" id="description" rows="5">
                <?php echo $this->db->get_where('config', array('title' => 'live_tv_meta_description'))->row()->value; ?>
              </textarea>
            </div>
          </div>
        </div>



        <div class="panel panel-border panel-primary col-md-6">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo trans('blog_page_seo'); ?></h3>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <label class=" col-sm-12 control-label"><?php echo trans('seo_title'); ?></label>
              <div class="col-sm-12">
                <input type="text" name="blog_title" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'blog_title'))->row()->value; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class=" col-sm-12 control-label"><?php echo trans('seo_keyword'); ?></label>
              <div class="col-sm-12">
                <input type="text" name="blog_keyword" id="blog_keyword" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'blog_keyword'))->row()->value; ?>">
              </div>
            </div>
            <div class="form-group">
              <label class=" col-sm-12 control-label"><?php echo trans('seo_meta_description'); ?></label>
              <div class="col-sm-12">
                <textarea type="text" rows="5" name="blog_meta_description" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'blog_meta_description'))->row()->value; ?>"></textarea>
              </div>
            </div>

          </div>
        </div>

        <div class="panel panel-border panel-primary col-md-12">
          <div class="panel-heading">
            <h3 class="panel-title"><?php echo trans('social_setting'); ?></h3>
          </div>
          <div class="panel-body">
            <div class="form-group row">
              <label class="control-label col-md-3"><?php echo trans('social_share_(_addThis)'); ?></label>
              <div class="col-sm-6">
                <select class="form-control m-bot15" name="social_share_enable">
                  <option value="1" <?php if ($this->db->get_where('config', array('title' => 'social_share_enable'))->row()->value == '1') {
                                      echo 'selected';
                                    } ?>><?php echo trans('enable'); ?></option>
                  <option value="0" <?php if ($this->db->get_where('config', array('title' => 'social_share_enable'))->row()->value == '0') {
                                      echo 'selected';
                                    } ?>><?php echo trans('disable'); ?></option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class=" col-sm-3 control-label"><?php echo trans('facebook_url'); ?></label>
              <div class="col-sm-6">
                <input type="text" name="facebook_url" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'facebook_url'))->row()->value; ?>">

              </div>
            </div>

            <div class="form-group row">
              <label class=" col-sm-3 control-label"><?php echo trans('twitter_url'); ?></label>
              <div class="col-sm-6">
                <input type="text" name="twitter_url" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'twitter_url'))->row()->value; ?>">

              </div>
            </div>

            <div class="form-group row">
              <label class=" col-sm-3 control-label"><?php echo trans('linkedin_url'); ?></label>
              <div class="col-sm-6">
                <input type="text" name="linkedin_url" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'linkedin_url'))->row()->value; ?>">

              </div>
            </div>

            <div class="form-group row">
              <label class=" col-sm-3 control-label"><?php echo trans('vimeo_url'); ?></label>
              <div class="col-sm-6">
                <input type="text" name="vimeo_url" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'vimeo_url'))->row()->value; ?>">

              </div>
            </div>

            <div class="form-group row">
              <label class=" col-sm-3 control-label"><?php echo trans('youtube_url'); ?></label>
              <div class="col-sm-6">
                <input type="text" name="youtube_url" class="form-control" value="<?php echo $this->db->get_where('config', array('title' => 'youtube_url'))->row()->value; ?>">
              </div>
            </div>


            <div class="col-sm-offset-3 col-sm-12 m-t-15 pull-right">
              <button type="submit" class="btn btn-sm btn-primary"><span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo trans('save_changes'); ?> </button>
            </div>
            <br><br>
            <?php echo form_close(); ?>
          </div>
        </div>

      </div>
    </div>

    <style type="text/css">
      .bootstrap-tagsinput .badge {
        ;
        background-color: #009688;
        border: 1px solid #035d54;
      }
    </style>
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script>
      jQuery(document).ready(function() {
        $('#tv_series_keyword').tagsinput();
        $('#focus_keyword').tagsinput();
        $('#live_tv_keyword').tagsinput();
        $('#movie_page_focus_keyword').tagsinput();
        $('#blog_keyword').tagsinput();
      });
    </script>