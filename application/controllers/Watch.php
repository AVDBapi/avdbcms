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

 
class Watch extends Home_Core_Controller{
    public function index($slug='',$param1='',$param2=''){
        $error = $this->common_model->check_movie_accessability($slug);
        if($error == FALSE):            
            $data['videos_id']              = $this->common_model->get_videos_id_by_slug($slug);
            $accessibility                  = $this->subscription_model->check_video_accessibility($data['videos_id']);
            if($accessibility == "allowed"):
                $this->common_model->watch_count_by_slug($data['videos_id']);
                $data['watch_videos']           = $this->common_model->get_videos_by_slug($slug);
                if($data['watch_videos']->is_tvseries == '1'):
                    $data['download_links']         = $this->db->get_where('episode_download_link', array("videos_id"=>$data['videos_id']))->result_array();
                else:
                    $data['download_links']         = $this->db->get_where('download_link', array("videos_id"=>$data['videos_id']))->result_array();
                endif;
                $data['total_download_links']   = count($data['download_links']);
                $data['video_files']            = $this->db->get_where('video_file', array('videos_id'=> $data['videos_id']))->result_array();
                $data['total_video_files']      = count($data['video_files']);
                $data['total_episodes']         = $this->db->get_where('episodes', array('videos_id'=> $data['videos_id']))->num_rows();
                $data['slug']                   = $slug;
                $data['param1']                 = $param1;
                $data['param2']                 = $param2;
                $data['page_name']              = 'watch';
                // opengraph for social
                $data['og_title']               = !empty(strip_tags($data['watch_videos']->seo_title ?? "")) ? $data['watch_videos']->seo_title : $data['watch_videos']->title;
                $data['og_url']                 = base_url('watch/'.$data['watch_videos']->slug.'.html');
                $data['og_description']         = !empty(strip_tags($data['watch_videos']->meta_description ?? "")) ? strip_tags($data['watch_videos']->meta_description ?? "") : strip_tags($data['watch_videos']->description ?? "");
                $data['og_image_url']           = $this->common_model->get_video_thumb_url($data['watch_videos']->videos_id);
                // end opengraph

                // seo
                $data['title']                  = !empty(strip_tags($data['watch_videos']->seo_title ?? "")) ? $data['watch_videos']->seo_title : $data['watch_videos']->title;
                $data['meta_description']       = !empty(strip_tags($data['watch_videos']->meta_description ? :"")) ? strip_tags($data['watch_videos']->meta_description) : strip_tags($data['watch_videos']->description ?? "");
                $data['focus_keyword']          = $data['watch_videos']->focus_keyword;
                $data['canonical']              = base_url('watch/'.$data['watch_videos']->slug.'.html');
                // end seo
                //$this->load->view('front_end/index', $data);
                $this->load->view('theme/'.$this->active_theme.'/index',$data);
            elseif($accessibility =="login_required"):
                $this->session->set_flashdata('login_error', 'You must login to access premium movie & Tv Channel.');
                redirect(base_url() .'user/login', 'refresh');
            elseif($accessibility =="denied"):
                $this->session->set_flashdata('error', 'Please Purchase a membership to access premium movies & Tv Channels.');
                redirect(base_url('subscription/upgrade'), 'refresh');
            endif;

        else:
            redirect('notfound');
        endif;
    }

}