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

 
class Tvseries extends Home_Core_Controller{
    public function __construct(){
        parent::__construct();
    }
    
    public function index($slug=''){
        $tv_series_publish                =   $this->db->get_where('config' , array('title'=>'tv_series_publish'))->row()->value;        
    	if($tv_series_publish =='1' && $slug !='' && $slug !=NULL):
            $data['page_details']= $this->common_model->get_page_details_by_slug($slug);
            $data['title'] = $data['page_details']->page_title;
            $data['focus_keyword'] = $data['page_details']->focus_keyword;
            $data['meta_description'] = $data['page_details']->meta_description;
            $data['page_name']='page';
            $this->load->view('theme/'.$this->active_theme.'/index',$data);
        else:
            redirect('error', 'refresh');
        endif;      
    }

    public function home(){
        $tv_series_publish    =   $this->db->get_where('config' , array('title'=>'tv_series_publish'))->row()->value;
        if($tv_series_publish =='1'):
            $this->load->library("pagination");        
            $config = array();
            $config["base_url"] = base_url() . "tvseries/home";
            $config["total_rows"] = $this->common_model->tv_series_record_count();
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
            $config['suffix']=  '.html'; 
      

            $this->pagination->initialize($config);
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $data["all_published_videos"]   = $this->common_model->fetch_tv_series($config["per_page"], $page);
            $data["links"]                  = $this->pagination->create_links();
            $data['total_rows']             = $config["total_rows"];
            // seo
            $data['title']              = $this->db->get_where('config' , array('title' =>'tv_series_title'))->row()->value;
            $data['meta_description']   = $this->db->get_where('config' , array('title' =>'tv_series_meta_description'))->row()->value;
            $data['focus_keyword']      = $this->db->get_where('config' , array('title' =>'tv_series_keyword'))->row()->value;
            $data['canonical']          = base_url('tv-series.html');
            // end seo
            $data['page_name']              = 'tv_series';
            $this->load->view('theme/'.$this->active_theme.'/index',$data);
        else:
            redirect('error', 'refresh');
        endif;
    } 


    public function watch($slug='',$param1='',$param2=''){
        $data['videos_id']                  = $this->common_model->get_videos_id_by_slug($slug);
        $tv_series_publish                  = $this->db->get_where('config' , array('title'=>'tv_series_publish'))->row()->value;
        $video_is_published                 = $this->common_model->is_video_published($data['videos_id']);       
        if($tv_series_publish =='1' && $slug !='' && $slug !=NULL && $video_is_published):
            $this->common_model->watch_count_by_slug($slug);
            $data['watch_videos']           = $this->common_model->get_videos_by_slug($slug);
            $data['title']                  = $data['watch_videos']->title;
            $data['focus_keyword']          = $data['watch_videos']->focus_keyword;
            $data['meta_description']       = $data['watch_videos']->meta_description;
            $data['download_links']         = $this->db->get_where('download_link', array("videos_id"=>$data['videos_id']))->result_array();
            $data['total_download_links']   = count($data['download_links']);
            $data['slug']                   = $slug;
            $data['param1']                 = $param1;
            $data['param2']                 = $param2;
            $data['page_name']              = 'tvseries_watch';
            $this->load->view('theme/'.$this->active_theme.'/index',$data);           
        else:
            redirect('error', 'refresh');
        endif;
    }
}

