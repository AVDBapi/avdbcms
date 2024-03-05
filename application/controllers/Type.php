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
 

class Type extends Home_Core_Controller {
	public function __construct(){
		parent::__construct();
	}

	public function index($slug=''){
		$type = $this->common_model->type_is_exist($slug);
        if ($slug !='' && $slug !=NULL && $type) {
			$config = array();
			$config["base_url"] = base_url() . "type/".$slug;
			$config["total_rows"] = $this->common_model->fetch_video_type_video_by_slug_record_count($slug);
			$config["per_page"] = 24;
			$config["uri_segment"] = 3;
			$config['full_tag_open'] = '<div class="pagination-container text-center"><ul class ="pagination">';
			$config['full_tag_close'] = '</ul></div><!--pagination-->';

			$config['first_link'] = '«';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';

			$config['last_link'] = '»';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';

			$config['next_link'] = '&rarr;';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';

			$config['prev_link'] = '&larr;';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';

			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['cur_tag_close'] = '</a><div class="pagination-hvr"></div></li>';

			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '<div class="pagination-hvr"></div></li>';

			$config['suffix']= 	'.html'; 

			$this->pagination->initialize($config);
			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["all_published_videos"] = $this->common_model->fetch_video_type_video_by_slug($config["per_page"], $page, $slug);
			$data["links"] = $this->pagination->create_links();
			$data['total_rows']=$config["total_rows"];
			$data['type_name']=$slug;
			$data['title'] = 'Watch '.$slug.' movies & TV-Series online';
			$data['page_name']='type';
			$this->load->view('theme/'.$this->active_theme.'/index',$data);
		}else{
            redirect('error', 'refresh');
        }
	}

}