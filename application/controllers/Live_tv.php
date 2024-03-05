<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ovoo-Movie & Video Stremaing CMS Pro
 * ----------------------------- OVOO -----------------------------
 * -------------- Movie & Video Stremaing CMS Pro -----------------
 * -------- Professional video content management system ----------
 *
 * @package     OVOO-Movie & Video Stremaing CMS Pro
 * @author      Abdul Mannan/Spa Green Creative
 * @copyright   Copyright (c) 2014 - 2017 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/

class Live_tv extends Home_Core_Controller {
	public function __construct(){
		parent::__construct();
		
	}

  public function index() {
		$data['all_published_slider']	= $this->common_model->all_published_slider();
		$data['new_videos']				= $this->common_model->new_published_videos();
		$data['latest_videos']			= $this->common_model->latest_published_videos();
		$data['new_tv_series']			= $this->common_model->new_published_tv_series();
		$data['latest_tv_series']		= $this->common_model->latest_published_tv_series();		
		$data['title'] 					= $this->db->get_where('config' , array('title' =>'home_page_seo_title'))->row()->value;
		// seo
		$data['title']				= $this->db->get_where('config' , array('title' =>'live_tv_title'))->row()->value;
		$data['meta_description']	= $this->db->get_where('config' , array('title' =>'live_tv_meta_description'))->row()->value;
		$data['focus_keyword']		= $this->db->get_where('config' , array('title' =>'live_tv_keyword'))->row()->value;
		$data['canonical']			= base_url('live-tv.html');
		// end seo
		$data['page_name']				= 'live_tv';
		// Start Pagination 
	    $this->load->library("pagination");
	    $total_channel                = $this->common_model->channel_record_count();
	    $config                     = array();
	    $config["base_url"]         = base_url() . "live_tv/index";
	    $config["total_rows"]       = $total_channel;
	    $config["per_page"]         = 20;
	    $config["uri_segment"]      = 3;
	    $config['full_tag_open']    = '<div class="pagination-container text-center"><ul class ="pagination">';
	    $config['full_tag_close']   = '</ul></div><!--pagination-->';
	    $config['first_link']       = '«';
	    $config['first_tag_open']   = '<li>';
	    $config['first_tag_close']  = '</li>';
	    $config['last_link']        = '»';
	    $config['last_tag_open']    = '<li>';
	    $config['last_tag_close']   = '</li>';
	    $config['next_link']        = '&rarr;';
	    $config['next_tag_open']    = '<li>';
	    $config['next_tag_close']   = '</li>';
	    $config['prev_link']        = '&larr;';
	    $config['prev_tag_open']    = '<li>';
	    $config['prev_tag_close']   = '</li>';
	    $config['cur_tag_open']     = '<li class="active"><a href="#">';
	    $config['cur_tag_close']    = '</a><div class="pagination-hvr"></div></li>';
	    $config['num_tag_open']     = '<li>';
	    $config['num_tag_close']    = '<div class="pagination-hvr"></div></li>';
	    $config['suffix']           = '.html'; 
	    $config['use_page_numbers'] = TRUE; 
	    // End Pagination 

	    $this->pagination->initialize($config);
	    $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
	    $data["all_published_channels"] = $this->common_model->all_published_channels(20, $page);
	    $data["links"] = $this->pagination->create_links();
	    $data['total_rows']=$total_channel;

		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}

	public function category($slug){
		if ($slug == '' || $slug ==NULL) {        
            redirect('notfound');            
        }else if(!$this->live_tv_model->live_tv_category_is_published($slug)){
            redirect('notfound');
        }else {
            $data['category_info']          = $this->live_tv_model->get_live_tv_category_by_slug($slug);
            $data['channels']          		= $this->live_tv_model->get_live_tv_by_category_id($data['category_info'][0]['live_tv_category_id']);
            // seo
			$data['title']					= $this->db->get_where('config' , array('title' =>'live_tv_title'))->row()->value;
			$data['meta_description']		= $this->db->get_where('config' , array('title' =>'live_tv_meta_description'))->row()->value;
			$data['focus_keyword']			= $this->db->get_where('config' , array('title' =>'live_tv_keyword'))->row()->value;
			$data['canonical']				= base_url('live-tv/category/'.$slug.'.html');
			// end seo
            $data['slug']                   = $slug;
            $data['page_name']              = 'live_tv_category';   
            $this->load->view('theme/'.$this->active_theme.'/index',$data);          
        }
	}
  
	public function watch($slug){
		if ($slug == '' || $slug ==NULL) {        
            redirect('notfound');            
        }else if(!$this->live_tv_model->live_tv_is_published($slug)){
            redirect('notfound');
        }else {
        	$data['watch_tv']               = $this->live_tv_model->get_live_tv_details_by_slug($slug);
            $accessibility                  = $this->subscription_model->check_live_tv_accessibility($data['watch_tv']->live_tv_id);
            if($accessibility == "allowed"):
	            $data['watch_tv']               = $this->live_tv_model->get_live_tv_details_by_slug($slug);
	            // seo
				$data['title']					= !empty(trim($data['watch_tv']->seo_title)) ? $data['watch_tv']->seo_title : $data['watch_tv']->tv_name;
				$data['meta_description']		= !empty(trim(strip_tags($data['watch_tv']->meta_description))) ? strip_tags($data['watch_tv']->meta_description) : strip_tags($data['watch_tv']->description);
				$data['focus_keyword']			= $data['watch_tv']->focus_keyword;
				$data['canonical']				= base_url('live-tv/'.$data['watch_tv']->slug.'.html');
				// end seo
				// opengraph for social
	            $data['og_title']               = !empty(trim($data['watch_tv']->seo_title)) ? $data['watch_tv']->seo_title : $data['watch_tv']->tv_name;
	            $data['og_url']                 = base_url('live-tv/'.$data['watch_tv']->slug.'.html');
	            $data['og_description']         = !empty(trim($data['watch_tv']->meta_description)) ? $data['watch_tv']->meta_description : $data['watch_tv']->description;
	            $data['og_image_url']           = $this->live_tv_model->get_tv_poster($data['watch_tv']->poster);
	            // end opengraph
	            $data['slug']                   = $slug;
	            $data['page_name']              = 'watch_tv';
	            $data['latest_videos']          = $this->common_model->latest_published_videos();
	            $data['latest_tv_series']       = $this->common_model->latest_published_tv_series();    
	            $this->load->view('theme/'.$this->active_theme.'/index',$data);
	        elseif($accessibility =="login_required"):
                $this->session->set_flashdata('login_error', 'You must login to access premium movie & Tv Channel.');
                redirect(base_url() .'user/login', 'refresh');
            elseif($accessibility =="denied"):
                $this->session->set_flashdata('error', 'Please Purchase a membership to access premium movies & Tv Channels.');
                redirect(base_url('subscription/upgrade'), 'refresh');
            endif;           
        }
	}
}
