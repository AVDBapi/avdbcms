<?php   $about_us_enable            =   $this->db->get_where('config' , array('title'=>'about_us_enable'))->row()->value;
        $about_us_to_footer_menu    =   $this->db->get_where('config' , array('title'=>'about_us_to_footer_menu'))->row()->value;
        $site_name                  =   $this->db->get_where('config' , array('title'=>'site_name'))->row()->value;
        $contact_to_footer_menu     =   $this->db->get_where('config' , array('title' =>'contact_to_footer_menu'))->row()->value; 
        $tv_series_pin_footer_menu  =   $this->db->get_where('config' , array('title' =>'tv_series_pin_footer_menu'))->row()->value; 
        $live_tv_pin_footer_menu    =   $this->db->get_where('config' , array('title' =>'live_tv_pin_footer_menu'))->row()->value;
        $privacy_policy_to_footer_menu  =   $this->db->get_where('config' , array('title'=>'privacy_policy_to_footer_menu'))->row()->value;
        $dmca_to_footer_menu            =   $this->db->get_where('config' , array('title'=>'dmca_to_footer_menu'))->row()->value;
?>

<!-- copyright -->
<div id="copyright">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 text-left">
                <p> <?php echo trans('copyright_text'); ?></p>
            </div>
            <div class="col-sm-6 text-right">
                <ul class="footer-list">
                    <?php $all_video_type_on_footer_menu= $this->common_model->all_video_type_on_footer_menu();
                                            foreach ($all_video_type_on_footer_menu as $video_type):                                                
                    ?>
                    <li><a href="<?php echo base_url().'type/'.$video_type->slug?>"><?php echo $video_type->video_type;?></a></li>
                <?php endforeach; ?>
                <?php $all_page_on_footer_menu= $this->common_model->all_page_on_footer_menu();
                        foreach ($all_page_on_footer_menu as $pages):                                                
                    ?>
                    <li><a href="<?php echo base_url().'page/'.$pages->slug.'.html';?>"><?php echo $pages->page_title?></a></li>
                <?php endforeach; ?>
                <?php if($about_us_enable =='1' && $about_us_to_footer_menu =='1'):?>
                    <li><a href="<?php echo base_url('about-us.html')?>"><?php echo trans('about_us'); ?></a></li>
                <?php endif; ?>
                <?php if($live_tv_pin_footer_menu == '1'): ?>
                    <li><a href="<?php echo base_url('live-tv.html')?>"><?php echo trans('live_tv'); ?></a></li>
                <?php endif; ?>
                <?php if($tv_series_pin_footer_menu == '1'): ?>
                    <li><a href="<?php echo base_url('tv-series.html')?>"><?php echo trans('tv_series'); ?></a></li>
                <?php endif; ?>
                <?php if($privacy_policy_to_footer_menu == '1'): ?>            
                  <li><a href="<?php echo base_url('privacy-policy.html')?>"><?php echo trans('privacy_policy'); ?></a></li>
                <?php endif; ?>
                <?php if($dmca_to_footer_menu == '1'): ?>            
                  <li><a href="<?php echo base_url('dmca.html')?>"><?php echo trans('dmca'); ?></a></li>
                <?php endif; ?> 
                <?php if($contact_to_footer_menu == '1'): ?>
                    <li><a href="<?php echo base_url('contact-us.html')?>"><?php echo trans('contact_us'); ?></a></li>
                <?php endif; ?>                  
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- copyright -->