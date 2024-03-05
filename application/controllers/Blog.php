<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Ovoo-Movie & Video Streaming CMS Pro
 * ----------------------------- OVOO -----------------------------
 * -------------- Movie & Video Streaming CMS Pro -----------------
 * -------- Professional video content management system ----------
 *
 * @package     OVOO-Movie & Video Streaming CMS Pro
 * @author      Abdul Mannan/Spa Green Creative
 * @copyright   Copyright (c) 2014 - 2017 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/
 

class Blog extends Home_Core_Controller { 
	public function __construct(){
		parent::__construct();
	}

	public function index(){
    	$blog_enable                =   $this->db->get_where('config' , array('title'=>'blog_enable'))->row()->value;
    	if($blog_enable =='1'):
			$config = array();
			$config["base_url"] = base_url() . "blog";
			$config["total_rows"] = $this->common_model->fetch_blog_post_record_count();
			$config["per_page"] = 12;
			$config["uri_segment"] = 2;
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
			$config['use_page_numbers'] = TRUE;	  

			$this->pagination->initialize($config);
			$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
			$data["all_published_posts"] = $this->common_model->fetch_blog_post($config["per_page"], $page);
			$data["links"] = $this->pagination->create_links();
			$data['total_rows']=$config["total_rows"];
			// seo
			$data['title']				= $this->db->get_where('config' , array('title' =>'blog_title'))->row()->value;
			$data['meta_description']	= $this->db->get_where('config' , array('title' =>'blog_meta_description'))->row()->value;
			$data['focus_keyword']		= $this->db->get_where('config' , array('title' =>'blog_keyword'))->row()->value;
			$data['canonical']			= base_url('blog.html');
			// end seo
			$data['page_name']='blog';
			$this->load->view('theme/'.$this->active_theme.'/index',$data);
		else:
			redirect('error', 'refresh');
		endif;
	}

	public function details($slug=''){
    	$blog_enable                =   $this->db->get_where('config' , array('title'=>'blog_enable'))->row()->value;		
		$post = $this->common_model->post_is_exist($slug);
		if ($slug != '' && $slug !=NULL && $post && $blog_enable=='1'):
            $data['post_details'] = $this->common_model->get_posts_by_slug($slug);
            $data['page_name'] = 'blog_details';
            $data['title'] = $data['post_details']->post_title;
            $data['focus_keyword'] = $data['post_details']->focus_keyword;
            $data['meta_description'] = $data['post_details']->meta_description;
            // seo
			$data['title']					= !empty(trim($data['post_details']->seo_title)) ? $data['post_details']->seo_title : $data['post_details']->post_title;
			$data['meta_description']		= $data['post_details']->meta_description;
			$data['focus_keyword']			= $data['post_details']->focus_keyword;
			$data['canonical']				= base_url('blog/'.$data['post_details']->slug.'.html');
			// end seo
			// opengraph for social
            $data['og_title']               = !empty(trim($data['post_details']->seo_title)) ? $data['post_details']->seo_title : $data['post_details']->post_title;
            $data['og_url']                 = base_url('blog/'.$data['post_details']->slug.'.html');
            $data['og_description']         = $data['post_details']->meta_description;
            $data['og_image_url']           = $data['post_details']->image_link;
            // end opengraph
            $this->load->view('theme/'.$this->active_theme.'/index',$data);
        else:
        	redirect('error', 'refresh');
        endif;
	}

    public function category($slug=''){
		if ($slug == '') {
            redirect('error');           
		}
		$config = array();
		$config["base_url"] = base_url() . "blog/category/".$slug;
		$config["total_rows"] = $this->common_model->fetch_blog_post_by_category_record_count($slug);
		$config["per_page"] = 10;
		$config["uri_segment"] = 4;
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

		$config['suffix']=      '.html'; 

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["all_published_posts"] = $this->common_model->fetch_blog_post_by_category($config["per_page"], $page, $slug);
		$data["links"] = $this->pagination->create_links();
		$data['total_rows']=$config["total_rows"];
		$data['page_name']='blog';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
		//var_dump($data);
    }


    public function author($slug=''){
		if ($slug == '') {
            redirect('error');           
		}

		$config = array();
		$config["base_url"] 		= base_url() . "blog/author/".$slug;
		$config["total_rows"] 		= $this->common_model->fetch_blog_post_by_author_record_count($slug);
		$config["per_page"] 		= 10;
		$config["uri_segment"] 		= 4;
		$config['full_tag_open'] 	= '<div class="pagination-container text-center"><ul class ="pagination">';
		$config['full_tag_close'] 	= '</ul></div><!--pagination-->';

		$config['first_link'] 		= '«';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';

		$config['last_link'] 		= '»';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';

		$config['next_link'] 		= '&rarr;';
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';

		$config['prev_link'] 		= '&larr;';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';

		$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
		$config['cur_tag_close'] 	= '</a><div class="pagination-hvr"></div></li>';

		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '<div class="pagination-hvr"></div></li>';

		$config['suffix']			= '.html'; 

		$this->pagination->initialize($config);
		$page 							= ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		$data["all_published_posts"] 	= $this->common_model->fetch_blog_post_by_author($config["per_page"], $page, $slug);
		$data["links"] 					= $this->pagination->create_links();
		$data['total_rows']				= $config["total_rows"];
		$data['title'] 					= 'Watch movies & TV-Series online';
		$data['page_name']				= 'blog';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
    }
}