<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * OVOO - Live TV & Movie Portal CMS with Membership System
 * ---------------------- OVOO --------------------
 * ------- Live TV & Movie Portal CMS --------
 *
 * @package     OVOO - Live TV & Movie Portal CMS with Membership System
 * @author      SpaGreen Creative
 * @copyright   Copyright (c) 2014 - 2022 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/

class Admin extends Admin_Core_Controller {   
    
    function __construct() {
        parent::__construct();
        $this->load->model('common_model');
        $this->load->model('email_model');
        $this->load->database();
        //cache controlling
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");        
    }
    
    //default index function, redirects to login/dashboard 
    public function index(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('admin_is_login') == 1)
            redirect(base_url() . 'admin/dashboard', 'refresh');
    }
    
    //dashboard
    function dashboard(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
		/* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '1');
        /* end menu active/inactive section*/
        $data['page_name']             = 'dashboard';
        $data['page_title']            = trans('admin_dashboard');
        $this->load->view('admin/index', $data);		
			
    }


    //  country
    function country($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // start menu active/inactive section
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '2');
        // end menu active/inactive section
        
        if ($param1 == 'add') {
            demo_check();
            $data['name']           = $this->input->post('name');
            $data['description']    = $this->input->post('description');
            $data['slug']           = url_title($this->input->post('name'), 'dash', TRUE);
            $data['publication']    = $this->input->post('publication');          
            
            $this->db->insert('country', $data);
            if($this->input->post('image_link')!=''){ 
                $image_source           =   $this->input->post('image_link');
                $save_to                =   'uploads/country/'.$insert_id.'.png';           
                $this->common_model->grab_image($image_source,$save_to);
            }
            if(isset($_FILES['image']) && $_FILES['image']['name']!=''){
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/country/'.$insert_id.'.png');
            }
            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
            
        if ($param1 == 'update') {
            demo_check();
            $data['name']           = $this->input->post('name');
            $data['description']    = $this->input->post('description');
            $data['slug']           = url_title($this->input->post('name'), 'dash', TRUE);
            $data['publication']    = $this->input->post('publication');

            $this->db->where('country_id', $param2);
            $this->db->update('country', $data);
            if($this->input->post('image_link')!=''){
                $image_source           =   $this->input->post('image_link');
                $save_to                =   'uploads/country/'.$param2.'.png';           
                $this->common_model->grab_image($image_source,$save_to);
            }
            if(isset($_FILES['image']) && $_FILES['image']['name']!=''){
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/country/'.$param2.'.png');
            }

            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }        
        $data['page_name']          = 'country_manage';
        $data['page_title']         = trans('country_management');
        $data['countries']          = $this->db->get('country')->result_array(); 
        $this->load->view('admin/index', $data);
    }

    // genre
    function genre($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '3');
        /* end menu active/inactive section*/ 
        
        if ($param1 == 'add') {
            demo_check();
            $data['name']           = $this->input->post('name');
            $data['description']    = $this->input->post('description');
            $data['slug']           = url_title($this->input->post('name'), 'dash', TRUE);
            $data['featured']       = $this->input->post('featured');          
            $data['publication']    = $this->input->post('publication');          
            
            $this->db->insert('genre', $data);
            if($this->input->post('image_link')!=''){ 
                $image_source           =   $this->input->post('image_link');
                $save_to                =   'uploads/genre/'.$insert_id.'.png';           
                $this->common_model->grab_image($image_source,$save_to);
            }
            if(isset($_FILES['image']) && $_FILES['image']['name']!=''){
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/genre/'.$insert_id.'.png');
            }
            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
            
        if ($param1 == 'update') {
            demo_check();
            $data['name']           = $this->input->post('name');
            $data['description']    = $this->input->post('description');
            $data['slug']           = url_title($this->input->post('name'), 'dash', TRUE);
            $data['featured']       = $this->input->post('featured');
            $data['publication']    = $this->input->post('publication');

            $this->db->where('genre_id', $param2);
            $this->db->update('genre', $data);
            if($this->input->post('image_link')!=''){
                $image_source           =   $this->input->post('image_link');
                $save_to                =   'uploads/genre/'.$param2.'.png';           
                $this->common_model->grab_image($image_source,$save_to);
            }
            if(isset($_FILES['image']) && $_FILES['image']['name']!=''){
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/genre/'.$param2.'.png');
            }
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }        
        $data['page_name']          = 'genre_manage';
        $data['page_title']         = trans('genre_manage');
        $data['genres']             = $this->db->get('genre')->result_array(); 
        $this->load->view('admin/index', $data);
    }

    // langauge
    function movie_language($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '333');
        /* end menu active/inactive section*/

        if ($param1 == 'add') {
            demo_check();
            $data['name']           = $this->input->post('name');
            $data['description']    = $this->input->post('description');
            $data['slug']           = url_title($this->input->post('name'), 'dash', TRUE);
            $data['publication']    = $this->input->post('publication');

            $this->db->insert('language', $data);
            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }

        if ($param1 == 'update') {
            demo_check();
            $data['name']           = $this->input->post('name');
            $data['description']    = $this->input->post('description');
            $data['slug']           = url_title($this->input->post('name'), 'dash', TRUE);
            $data['publication']    = $this->input->post('publication');

            $this->db->where('language_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }
        $data['page_name']          = 'langauge_manage';
        $data['page_title']         = trans('langauge_manage');
        $data['lists']              = $this->db->get('language')->result_array();
        $this->load->view('admin/index', $data);
    }

    // slider setting
    function slider_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '5');
            /* end menu active/inactive section*/
        if ($param1 == 'update') {
            demo_check();
            $slider_type  = $this->input->post('slider_type');

            // update slider type
            $data['value']    =   $slider_type;
            $this->db->where('title' , 'slider_type');
            $this->db->update('config' , $data);

            // update slider fullwide
            $data['value']    =   $this->input->post('slider_fullwide');
            $this->db->where('title' , 'slider_fullwide');
            $this->db->update('config' , $data);

            // update slider height
            $data['value']    =   $this->input->post('slider_height');
            $this->db->where('title' , 'slider_height');
            $this->db->update('config' , $data);

            // update slider border radius
            $data['value']    =   $this->input->post('slider_border_radius');
            $this->db->where('title' , 'slider_border_radius');
            $this->db->update('config' , $data);

            // update slider arrow
            $data['value']    =   $this->input->post('slider_arrow');
            $this->db->where('title' , 'slider_arrow');
            $this->db->update('config' , $data);

            // update slider bullet
            $data['value']    =   $this->input->post('slider_bullet');
            $this->db->where('title' , 'slider_bullet');
            $this->db->update('config' , $data);

            if($slider_type=='movie'){                
                $data['value'] =   $this->input->post('total_movie_in_slider');
                $this->db->where('title' , 'total_movie_in_slider');
                $this->db->update('config' , $data);
            }
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());          
        }
        $data['page_name']      = 'slider_setting';
        $data['page_title']     = trans('slider_setting');
        $this->load->view('admin/index', $data);
    }

    // slider
    function slider($param1 = '', $param2 = ''){
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '4'); 
        
        if ($param1 == 'add') {
            demo_check();
            $data['title']              =   $this->input->post('title');
            $data['description']        =   $this->input->post('description');
            $data['order']              =   $this->input->post('order');
            $data['action_type']        =   $this->input->post('action_type');
            $data['action_btn_text']    =   $this->input->post('action_btn_text');
            $data['image_link']         =   base_url().'uploads/no_image.jpg';

            if($data['action_type'] == 'movie'):
                $data['action_id']        =   $this->input->post('movie_id');
            elseif($data['action_type'] == 'tvseries'):
                $data['action_id']        =   $this->input->post('tvseries_id');
            elseif($data['action_type'] == 'tv'):
                $data['action_id']        =   $this->input->post('tv_id');
            elseif($data['action_type'] == 'external_browser' || $data['action_type'] == 'webview'):
                $data['action_url']       =   $this->input->post('action_url');
            endif;


            if($this->input->post('image_link')!=''){                
                $data['image_link']     =   $this->input->post('image_link');
            } 

            $data['slug']               =   url_title($this->input->post('title'), 'dash', TRUE);
            $data['publication']        =   $this->input->post('publication');          
            
            $this->db->insert('slider', $data);
            $insert_id = $this->db->insert_id();
            if(isset($_FILES['image']) && $_FILES['image']['name']!=''){
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/sliders/slider-'.$insert_id.'.jpg');
                $data['image_link']     =       base_url().'uploads/sliders/slider-'.$insert_id.'.jpg';
            }
            $this->db->where('slider_id', $insert_id);
            $this->db->update('slider', $data);
            
            $this->session->set_flashdata('success', 'Slider added successed');
            redirect($this->agent->referrer());
        }
           
        if ($param1 == 'update') {
            demo_check();
            $data['title']              =   $this->input->post('title');
            $data['description']        =   $this->input->post('description');
            $data['order']              =   $this->input->post('order');
            $data['action_type']        =   $this->input->post('action_type');
            $data['action_btn_text']    =   $this->input->post('action_btn_text');

            if($data['action_type'] == 'movie'):
                $data['action_id']        =   $this->input->post('movie_id');
            elseif($data['action_type'] == 'tvseries'):
                $data['action_id']        =   $this->input->post('tvseries_id');
            elseif($data['action_type'] == 'tv'):
                $data['action_id']        =   $this->input->post('tv_id');
            elseif($data['action_type'] == 'external_browser' || $data['action_type'] == 'webview'):
                $data['action_url']       =   $this->input->post('action_url');
            endif;

            
            if($this->input->post('image_link')!=''){                
                $data['image_link']  = $this->input->post('image_link');
            }

            if(isset($_FILES['image']) && $_FILES['image']['name']!=''){
                move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/sliders/slider-'.$param2.'.jpg');
                $data['image_link']     =       base_url().'uploads/sliders/slider-'.$param2.'.jpg';
            }
            $data['slug']               = url_title($this->input->post('title'), 'dash', TRUE);
            $data['publication']        = $this->input->post('publication');

            $this->db->where('slider_id', $param2);
            $this->db->update('slider', $data);
            $this->session->set_flashdata('success', 'Slider update successed.');
            redirect($this->agent->referrer());
        }        
        $data['page_name']      = 'slider_manage';
        $data['page_title']     = 'Slider Management';
        $this->db->order_by('order',"DESC");
        $data['sliders']        = $this->db->get('slider')->result_array(); 
        $this->load->view('admin/index', $data);
    }
    // add videos or movies 
    function videos_add(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // start menu active/inactive section
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '6');
        // end menu active/inactive section
        $data['page_name']      = 'videos_add';
        $data['page_title']     = trans('videos_add'); 
        $this->load->view('admin/index', $data);
    }

    // edit videos or movies 
    function videos_edit($param1='',$param2=''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '6');
            /* end menu active/inactive section*/
            $data['param1']         = $param1;
            $data['param2']         = $param2;
            $data['page_name']      = 'videos_edit';
            $data['page_title']     = trans('video_edit').' | '.$this->common_model->get_title_by_videos_id($param1);
            $this->load->view('admin/index', $data);
    }

    // add,edit videos or movies 
    function videos($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '8'); 
        if ($param1 == 'add') {
            demo_check();
            $data['imdbid']                 = $this->input->post('imdbid');          
            $data['title']                  = $this->input->post('title');
            $data['seo_title']              = $this->input->post('seo_title');
            $data['description']            = $this->input->post('description');
            $data['is_paid']                = $this->input->post('is_paid');            
            $data['trailler_youtube_source']= $this->input->post('trailler_youtube_source');            
            $actors                         = $this->input->post('actor');            
            $directors                      = $this->input->post('director');            
            $writers                        = $this->input->post('writer');            
            $countries                      = $this->input->post('country');
            $genres                         = $this->input->post('genre');
            $languages                        = $this->input->post('language');
            $video_types                    = $this->input->post('video_type');
            if($actors !='' && $actors !=NULL){
                $data['stars']              = implode(',',$actors);
            }
            if($directors !='' && $directors !=NULL){
                $data['director']           = implode(',',$directors);
            }
            if($writers !='' && $writers !=NULL){
                $data['writer']             = implode(',',$writers);
            }
            if($countries !='' && $countries !=NULL){
                $data['country']            = implode(',',$countries);
            }
            if($genres !='' && $genres !=NULL){
                $data['genre']              = implode(',',$genres);
            }
            if($languages !='' && $languages !=NULL){
                $data['language']              = implode(',',$languages);
            }
            if($video_types !='' && $video_types !=NULL){
                $data['video_type']              = implode(',',$video_types);
            }

            $data['imdb_rating']        = $this->input->post('rating');
            $data['release']            = $this->input->post('release');
            
            
            $data['runtime']            = $this->input->post('runtime');
            $data['video_quality']      = $this->input->post('video_quality');
            $data['publication']        = '0';
            if(isset($_POST['publication'])) {
                $data['publication']    = '1';
            }
            
            $data['enable_download']    = '0';
            if(isset($_POST['enable_download'])) {
                $data['enable_download']    = '1';
            }            
            
            $data['focus_keyword']      = $this->input->post('focus_keyword');
            $data['meta_description']   = $this->input->post('meta_description');
            $data['tags']               = $this->input->post('tags');       
                        
            $this->db->insert('videos', $data);
            $insert_id = $this->db->insert_id();
            $slug                       = url_title($this->input->post('slug'), 'dash', TRUE);
            $slug_num                   = $this->common_model->slug_num('videos',$slug);
            if($slug_num > 0){
                $slug= $slug.'-'.$insert_id;
            }
            $data_update['slug']        = $slug;            
            if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name']!=''){
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/video_thumb/'.$insert_id.'.jpg');                
            }

            if(isset($_FILES['poster_file']) && $_FILES['poster_file']['name']!=''){
                move_uploaded_file($_FILES['poster_file']['tmp_name'], 'uploads/poster_image/'.$insert_id.'.jpg');                                
            }

            if($this->input->post('thumb_link')!=''){ 
                $image_source           =   $this->input->post('thumb_link');
                $save_to                =   'uploads/video_thumb/'.$insert_id.'.jpg';           
                $this->common_model->grab_image($image_source,$save_to);
            }

            if($this->input->post('poster_link')!=''){ 
                $image_source       =   $this->input->post('poster_link');
                $save_to            =   'uploads/poster_image/'.$insert_id.'.jpg';           
                $this->common_model->grab_image($image_source,$save_to);
            }

            $this->db->where('videos_id', $insert_id);
            $this->db->update('videos', $data_update);
            
            // email newslater
            if(isset($_POST['email_notify'])) {
                $this->load->model('email_model');
                $this->email_model->create_newslater_cron($insert_id);
            }
            // push notification
            if(isset($_POST['push_notify'])) {
                $this->load->model('notify_model');
                $this->notify_model->send_push_notification($insert_id);
            }           
            $this->session->set_flashdata('success', trans('add_success'));
            redirect(base_url() . 'admin/file_and_download/'.$insert_id, 'refresh');
        }
        else if ($param1 == 'update') {
            demo_check();
            $data['imdbid']                 = $this->input->post('imdbid');          
            $data['title']                  = $this->input->post('title');
            $data['seo_title']              = $this->input->post('seo_title');
            $data['description']            = $this->input->post('description');
            $data['is_paid']                = $this->input->post('is_paid');
            $data['trailler_youtube_source']= $this->input->post('trailler_youtube_source');            
            $actors                         = $this->input->post('actor');            
            $directors                      = $this->input->post('director');            
            $writers                        = $this->input->post('writer');            
            $countries                      = $this->input->post('country');            
            $genres                         = $this->input->post('genre');
            $languages                        = $this->input->post('language');
            $video_types                    = $this->input->post('video_type');
            if($actors !='' && $actors !=NULL){
                $data['stars']              = implode(',',$actors);
            }
            if($directors !='' && $directors !=NULL){
                $data['director']           = implode(',',$directors);
            }
            if($writers !='' && $writers !=NULL){
                $data['writer']             = implode(',',$writers);
            }
            if($countries !='' && $countries !=NULL){
                $data['country']            = implode(',',$countries);
            }
            if($genres !='' && $genres !=NULL){
                $data['genre']              = implode(',',$genres);
            }
            if($languages !='' && $languages !=NULL){
                $data['language']              = implode(',',$languages);
            }
            if($video_types !='' && $video_types !=NULL){
                $data['video_type']              = implode(',',$video_types);
            }           
            
            $data['imdb_rating']        = $this->input->post('rating');
            $data['release']            = $this->input->post('release');            
            $data['runtime']            = $this->input->post('runtime');
            $data['video_quality']      = $this->input->post('video_quality');
            $publication                = $this->input->post('publication');
            if($publication =='on'){
                $data['publication'] = '1';
            }else{
                $data['publication'] = '0';
            }

            $enable_download                = $this->input->post('enable_download');
            if($enable_download =='on'){
                $data['enable_download'] = '1';
            }else{
                $data['enable_download'] = '0';
            }

            $data['focus_keyword']      = $this->input->post('focus_keyword');
            $data['meta_description']   = $this->input->post('meta_description');
            $data['tags']               = $this->input->post('tags');
            $this->db->where('videos_id', $param2);
            $this->db->update('videos', $data);
            $this->db->where('videos_id', $param2);

            $slug                       = url_title($this->input->post('slug'), 'dash', TRUE);
            $slug_num                   = $this->common_model->slug_num('videos',$slug);
            if($slug_num > 1){
                $slug= $slug.'-'.$param2;
            }
            $data_update['slug']               = $slug;            
            if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name']!=''){
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/video_thumb/'.$param2.'.jpg');                
            }

            if(isset($_FILES['poster_file']) && $_FILES['poster_file']['name']!=''){
                move_uploaded_file($_FILES['poster_file']['tmp_name'], 'uploads/poster_image/'.$param2.'.jpg');                                
            }

            if($this->input->post('thumb_link')!=''){ 
                $image_source =$this->input->post('thumb_link');
                $save_to = 'uploads/video_thumb/'.$param2.'.jpg';           
                $this->common_model->grab_image($image_source,$save_to);
            }

            if($this->input->post('poster_link')!=''){ 
                $image_source =$this->input->post('poster_link');
                $save_to = 'uploads/poster_image/'.$param2.'.jpg';           
                $this->common_model->grab_image($image_source,$save_to);
            }

            $this->db->where('videos_id', $param2);
            $this->db->update('videos', $data_update);
            // email newslater
            if(isset($_POST['email_notify'])) {
                $this->load->model('email_model');
                $this->email_model->create_newslater_cron($param2);
            }
            // push notification
            if(isset($_POST['push_notify'])) {
                $this->load->model('notify_model');
                $this->notify_model->send_push_notification($param2);
            }
            $this->session->set_flashdata('success', trans('update_success'));
            redirect(base_url() . 'admin/videos_edit/'.$param2, 'refresh');
            //redirect($this->agent->referrer());
        }
        // filter
        $title          = $this->input->get('title');
        $release        = $this->input->get('release');
        $publication    = $this->input->get('publication');
        $filter = array();
        $filter['is_tvseries '] = 0;
        $search_string = '';
        if($title !="" && $title !=NULL){
            $filter['title '] = $title;
            $search_string.= 'title='.$title.'&';
            $data['title'] = $title;
        }
        if($release !="" && $release !=NULL){
            $filter['release'] = $release;
            $search_string.= 'release='.$release.'&';
            $data['release'] = $release;
        }
        if($publication !="" && $publication !=NULL){
            $filter['publication'] = $publication;
            $search_string.= '&&publication='.$publication;
            $data['publication'] = $publication;            

        }
        $total_rows = $this->common_model->get_videos_num_rows($filter);
        // page
        $config                     = $this->common_model->pagination();
        $config["base_url"]         = base_url() . "admin/videos?".$search_string;
        $config["total_rows"]       = $total_rows;
        $config["per_page"]         = 10;
        $config["uri_segment"]      = 3;          
        //$config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE; 
        $this->pagination->initialize($config);
        $data['last_row_num']       = $this->uri->segment(3);
        $page                       = $this->input->get('per_page');//($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
        $data["videos"]             = $this->common_model->get_videos($filter,$config["per_page"], $page);
        $data["links"]              = $this->pagination->create_links();
        $data['total_rows']         = $config["total_rows"];
        $data['page_name']          = 'videos_manage';
        $data['page_title']         = trans('videos_manage');             
        $this->load->view('admin/index', $data);
    }



    // add videos or movies 
    function tvseries_add(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // start menu active/inactive section
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '29');
        // end menu active/inactive section
        $data['page_name']      = 'tvseries_add';
        $data['page_title']     = trans('tvseries_add'); 
        $this->load->view('admin/index', $data);
    }

    // edit videos or movies 
    function tvseries_edit($param1='',$param2=''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '29');
            /* end menu active/inactive section*/


            $data['param1']         = $param1;
            $data['param2']         = $param2;
            $data['page_name']      = 'tvseries_edit';
            $data['page_title']     = trans('tvseries_edit');
            $this->load->view('admin/index', $data);
    }

     // add,edit videos or movies 
    function tvseries($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '30');            
        
        if ($param1 == 'add') {
            demo_check();
            $data['imdbid']             = $this->input->post('imdbid');          
            $data['title']              = $this->input->post('title');
            $data['seo_title']          = $this->input->post('seo_title');
            $data['description']        = $this->input->post('description');
            $data['is_paid']            = $this->input->post('is_paid');
            $data['trailler_youtube_source']= $this->input->post('trailler_youtube_source'); 
            $actors                     = $this->input->post('actor');            
            $directors                  = $this->input->post('director');            
            $writers                    = $this->input->post('writer');            
            $countries                  = $this->input->post('country');            
            $genres                     = $this->input->post('genre');
            $languages                  = $this->input->post('language');
            $video_types                = $this->input->post('video_type');
            if($actors !='' && $actors !=NULL){
                $data['stars']              = implode(',',$actors);
            }
            if($directors !='' && $directors !=NULL){
                $data['director']           = implode(',',$directors);
            }
            if($writers !='' && $writers !=NULL){
                $data['writer']             = implode(',',$writers);
            }
            if($countries !='' && $countries !=NULL){
                $data['country']            = implode(',',$countries);
            }
            if($genres !='' && $genres !=NULL){
                $data['genre']              = implode(',',$genres);
            }
            if($languages !='' && $languages !=NULL){
                $data['language']              = implode(',',$languages);
            }
            if($video_types !='' && $video_types !=NULL){
                $data['video_type']              = implode(',',$video_types);
            }

            $data['imdb_rating']        = $this->input->post('rating');
            $data['release']            = $this->input->post('release');
            $data['is_tvseries']        = '1';
            $data['runtime']            = $this->input->post('runtime');
            $data['video_quality']      = $this->input->post('video_quality');
            $data['publication']        = '0';
            if(isset($_POST['publication'])) {
                $data['publication']    = '1';
            }
            
            $data['enable_download']    = '0';
            if(isset($_POST['enable_download'])) {
                $data['enable_download']    = '1';
            }
            $data['focus_keyword']      = $this->input->post('focus_keyword');
            $data['meta_description']   = $this->input->post('meta_description');
            $data['tags']               = $this->input->post('tags');       
                        
            $this->db->insert('videos', $data);
            $insert_id = $this->db->insert_id();
            $slug                       = url_title($this->input->post('slug'), 'dash', TRUE);
            $slug_num                   = $this->common_model->slug_num('videos',$slug);
            if($slug_num > 0){
                $slug= $slug.'-'.$insert_id;
            }
            $data_update['slug']               = $slug;            
            if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name']!=''){
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/video_thumb/'.$insert_id.'.jpg');                
            }

            if(isset($_FILES['poster_file']) && $_FILES['poster_file']['name']!=''){
                move_uploaded_file($_FILES['poster_file']['tmp_name'], 'uploads/poster_image/'.$insert_id.'.jpg');                                
            }

            if($this->input->post('thumb_link')!=''){ 
                $image_source =$this->input->post('thumb_link');
                $save_to = 'uploads/video_thumb/'.$insert_id.'.jpg';           
                $this->common_model->grab_image($image_source,$save_to);
            }

            if($this->input->post('poster_link')!=''){ 
                $image_source =$this->input->post('poster_link');
                $save_to = 'uploads/poster_image/'.$insert_id.'.jpg';           
                $this->common_model->grab_image($image_source,$save_to);
            }

            $this->db->where('videos_id', $insert_id);
            $this->db->update('videos', $data_update);
            // email newslater
            if(isset($_POST['email_notify'])) {
                $this->load->model('email_model');
                $this->email_model->create_newslater_cron($insert_id);
            }
            // push notification
            if(isset($_POST['push_notify'])) {
                $this->load->model('notify_model');
                $this->notify_model->send_push_notification($insert_id);
            }
            $this->session->set_flashdata('success', trans('add_success'));
            redirect(base_url() . 'admin/seasons_manage/'.$insert_id, 'refresh');
        }
        else if ($param1 == 'update') {
            demo_check();
            $data['imdbid']             = $this->input->post('imdbid');          
            $data['title']              = $this->input->post('title');
            $data['seo_title']          = $this->input->post('seo_title');
            $data['description']        = $this->input->post('description');
            $data['is_paid']            = $this->input->post('is_paid');
            $data['trailler_youtube_source']= $this->input->post('trailler_youtube_source'); 
            $actors                     = $this->input->post('actor');            
            $directors                  = $this->input->post('director');            
            $writers                    = $this->input->post('writer');            
            $countries                  = $this->input->post('country');            
            $genres                     = $this->input->post('genre');
            $languages                  = $this->input->post('language');
            $video_types                = $this->input->post('video_type');
            if($actors !='' && $actors !=NULL){
                $data['stars']              = implode(',',$actors);
            }
            if($directors !='' && $directors !=NULL){
                $data['director']           = implode(',',$directors);
            }
            if($writers !='' && $writers !=NULL){
                $data['writer']             = implode(',',$writers);
            }
            if($countries !='' && $countries !=NULL){
                $data['country']            = implode(',',$countries);
            }
            if($genres !='' && $genres !=NULL){
                $data['genre']              = implode(',',$genres);
            }
            if($languages !='' && $languages !=NULL){
                $data['language']              = implode(',',$languages);
            }
            if($video_types !='' && $video_types !=NULL){
                $data['video_type']              = implode(',',$video_types);
            }
            $data['imdb_rating']        = $this->input->post('rating');
            $data['release']            = $this->input->post('release');
            $data['is_tvseries']        = '1';
            $data['runtime']            = $this->input->post('runtime');
            $data['video_quality']      = $this->input->post('video_quality');
            $publication = $this->input->post('publication');
            if($publication =='on'){
                $data['publication'] = '1';
            }else{
                $data['publication'] = '0';
            }
            $enable_download            = $this->input->post('enable_download');
            if($enable_download =='on'){
                $data['enable_download'] = '1';
            }else{
                $data['enable_download'] = '0';
            }            
            $data['focus_keyword']      = $this->input->post('focus_keyword');
            $data['meta_description']   = $this->input->post('meta_description');
            $data['tags']               = $this->input->post('tags');
            //var_dump($data);
            $this->db->where('videos_id', $param2);
            $this->db->update('videos', $data);
            $this->db->where('videos_id', $param2);

            $slug                       = url_title($this->input->post('slug'), 'dash', TRUE);
            $slug_num                   = $this->common_model->slug_num('videos',$slug);
            if($slug_num > 1){
                $slug= $slug.'-'.$param2;
            }
            $data_update['slug']               = $slug;            
            if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name']!=''){
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/video_thumb/'.$param2.'.jpg');                
            }

            if(isset($_FILES['poster_file']) && $_FILES['poster_file']['name']!=''){
                move_uploaded_file($_FILES['poster_file']['tmp_name'], 'uploads/poster_image/'.$param2.'.jpg');                                
            }

            if($this->input->post('thumb_link')!=''){ 
                $image_source =$this->input->post('thumb_link');
                $save_to = 'uploads/video_thumb/'.$param2.'.jpg';           
                //$this->common_model->grab_image($image_source,$save_to);
                $cron_data['type']       = "image";       
                $cron_data['action']     = "download";       
                $cron_data['image_url']  = $image_source;       
                $cron_data['save_to']    = $save_to;
                $this->db->insert('cron',$cron_data);
            }

            if($this->input->post('poster_link')!=''){ 
                $image_source =$this->input->post('poster_link');
                $save_to = 'uploads/poster_image/'.$param2.'.jpg';           
                $this->common_model->grab_image($image_source,$save_to);
            }

            $this->db->where('videos_id', $param2);
            $this->db->update('videos', $data_update);
            // email newslater
            if(isset($_POST['email_notify'])) {
                $this->load->model('email_model');
                $this->email_model->create_newslater_cron($param2);
            }
            // push notification
            if(isset($_POST['push_notify'])) {
                $this->load->model('notify_model');
                $this->notify_model->send_push_notification($param2);
            }

            $this->session->set_flashdata('success', trans('add_success'));
            redirect(base_url() . 'admin/tvseries_edit/'.$param2, 'refresh');
            //redirect($this->agent->referrer());
        }
        // filter
        $title          = $this->input->get('title');
        $release        = $this->input->get('release');
        $publication    = $this->input->get('publication');
        $filter = array();
        $filter['is_tvseries '] = 1;
        $search_string = '';
        if($title !="" && $title !=NULL){
            $filter['title '] = $title;
            $search_string.= 'title='.$title.'&';
            $data['title'] = $title;
        }
        if($release !="" && $release !=NULL){
            $filter['release'] = $release;
            $search_string.= 'release='.$release.'&';
            $data['release'] = $release;
        }
        if($publication !="" && $publication !=NULL){
            $filter['publication'] = $publication;
            $search_string.= '&&publication='.$publication;
            $data['publication'] = $publication;            

        }
        $total_rows = $this->common_model->get_videos_num_rows($filter);
        //var_dump($total_rows,$filter);
        // page
        //$config                         =   array();
        $config                         =   $this->common_model->pagination();
        $config["base_url"]             =   base_url() . "admin/tvseries?".$search_string;
        $config["total_rows"]           =   $total_rows;
        $config["per_page"]             =   10;
        $config["uri_segment"]          =   3;
         
        //$config['use_page_numbers'] = TRUE;
        $config['page_query_string']    =  TRUE;      

        $this->pagination->initialize($config);
        $data['last_row_num']           =   $this->uri->segment(3);
        $page                           =   $this->input->get('per_page');//($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
        $data["videos"]                 =   $this->common_model->get_videos($filter,10, $page);
        $data["links"]                  =   $this->pagination->create_links();
        //var_dump($data["links"]);
        $data['total_rows']             =   $total_rows;
        $data['page_name']              =   'tvseries_manage';
        $data['page_title']             =   trans('tvseries_manage');
        $this->load->view('admin/index', $data);
    }

    function seasons_manage($param1='',$param2=''){
        //$this->common_model->clear_cache();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '30');
            /* end menu active/inactive section*/
        if ($param1 == 'add') {
            demo_check();
            $data['videos_id']         = $this->input->post('videos_id');
            $data['seasons_name']      = $this->input->post('seasons_name');            
            $data['order']             = $this->input->post('order');            
            
            $this->db->insert('seasons', $data);
            $this->session->set_flashdata('success', trans('add_success'));
            redirect(base_url() . 'admin/seasons_manage/'.$data['videos_id'], 'refresh');
        }
        if ($param1 == 'update') {
            demo_check();
            $data['videos_id']         = $this->input->post('videos_id');
            $data['seasons_name']      = $this->input->post('seasons_name');
            $data['order']             = $this->input->post('order'); 
            
            $this->db->where('seasons_id', $param2);
            $this->db->update('seasons', $data);
            $this->session->set_flashdata('success', trans('update_success'));
            redirect(base_url() . 'admin/seasons_manage/'.$data['videos_id'], 'refresh');
        }
        if ($param1 == 'change_order') {
            demo_check();
            $videos_id           = $this->input->post('videos_id');
            $seasons_ids         = $this->input->post('seasons_id');
            $orders              = $this->input->post('order');
            $i=0;
            for($i=0; $i<sizeof($orders); $i++):
                $data['order'] = $orders[$i];
                $this->db->where('seasons_id', $seasons_ids[$i]);
                $this->db->update('seasons', $data);
            endfor;
            $this->session->set_flashdata('success', trans('update_success'));
            redirect(base_url() . 'admin/seasons_manage/'.$videos_id, 'refresh');
        }
        $data['param1']         = $param1;
        $data['param2']         = $param2;
        $data['slug']           = $this->common_model->get_slug_by_videos_id($param1);
        $data['page_name']      = 'seasons_manage';
        $data['page_title']     = $this->common_model->get_title_by_videos_id($param1);
        $this->load->view('admin/index', $data);
    }

    function episodes_manage($param1='',$param2=''){
        //$this->common_model->clear_cache();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '30');
        /* end menu active/inactive section*/
        if ($param1 == 'change_order'):
            demo_check();
            $videos_id           = $this->input->post('videos_id');
            $episodes_ids        = $this->input->post('episodes_id');
            $orders              = $this->input->post('order');
            $i=0;
            for($i=0; $i<sizeof($orders); $i++):
                $data['order'] = $orders[$i];
                $this->db->where('episodes_id', $episodes_ids[$i]);
                $this->db->update('episodes', $data);
            endfor;
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        elseif ($param1 == 'edit'):
            $data['param1']         = $param1;
            $data['param2']         = $param2;
            $data['page_name']      = 'episode_edit';
            $data['page_title']     = trans('edit_episode').' for '.$this->common_model->get_title_by_videos_id($param1);
            $data['episode_info']   = $this->common_model->get_single_episode_details_by_id($param2);
            $this->load->view('admin/index', $data);
        else:
            $data['param1']         = $param1;
            $data['param2']         = $param2;
            $data['slug']           = $this->common_model->get_slug_by_videos_id($param1);
            $data['page_name']      = 'episodes_manage';
            $data['page_title']     = trans('episodes_for').' '.$this->common_model->get_title_by_videos_id($param1).' '.$this->common_model->get__seasons_name_by_id($param2);
            $this->load->view('admin/index', $data);
        endif;
    }

    function episodes_download($param1='',$param2=''){
        //$this->common_model->clear_cache();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '30');
        /* end menu active/inactive section*/
        if ($param1 == 'edit'):
            $data['param1']         = $param1;
            $data['param2']         = $param2;
            $data['page_name']      = 'episode_edit';
            $data['page_title']     = trans('edit_episode').' for '.$this->common_model->get_title_by_videos_id($param1);
            $data['episode_info']   = $this->common_model->get_single_episode_details_by_id($param2);
            $this->load->view('admin/index', $data);
        else:
            $data['param1']         = $param1;
            $data['param2']         = $param2;
            $data['slug']           = $this->common_model->get_slug_by_videos_id($param1);
            $data['page_name']      = 'episode_download';
            $data['page_title']     = "Download | ".$this->common_model->get_title_by_videos_id($param1).' '.$this->common_model->get__seasons_name_by_id($param2);
            $this->load->view('admin/index', $data);
        endif;
    }

    function episode_download_link(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        demo_check();

        $this->form_validation->set_rules('videos_id', 'videos_id', 'required');
        $this->form_validation->set_rules('season_id', 'season_id', 'required');
        $this->form_validation->set_rules('link_title', 'Link Title', 'required|min_length[2]');
        $this->form_validation->set_rules('file_size', 'File Size', 'required|min_length[2]');
        $this->form_validation->set_rules('resolution', 'Resolution', 'required|min_length[2]');
        $this->form_validation->set_rules('in_app_download', 'Download Type', 'required');
        $this->form_validation->set_rules('download_url', 'Download URL', 'required');
        if ($this->form_validation->run() == FALSE):
            $this->session->set_flashdata('error',strip_tags(json_encode(validation_errors())));
        else:
            $data['videos_id']          = $this->input->post("videos_id");            
            $data['season_id']          = $this->input->post("season_id");            
            $data['link_title']         = $this->input->post("link_title");
            $data['file_size']          = $this->input->post("file_size");
            $data['resolution']         = $this->input->post("resolution");
            $data['download_url']       = $this->input->post("download_url");
            $data['in_app_download']    = $this->input->post("in_app_download");
            $this->db->insert('episode_download_link',$data);
            $this->session->set_flashdata('success', 'Key create successed.');
        endif;
        redirect($this->agent->referrer());    
    }




    function file_and_download($param1 = '', $param2 = ''){
    if ($this->session->userdata('admin_is_login') != 1)
        redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '8');
        /* end menu active/inactive section*/
        if ($param1 == 'update') {
            demo_check();
            $video_id = $param2;
            $file_type= 'upload';
            $video_file_type    = $this->input->post('video_file_type');
            $video_file         = $this->input->post('video_file');
            $link_name          = $this->input->post('link_name');
            $link               = $this->input->post('link');            
            $this->db->where('videos_id', $video_id);
            $this->db->delete('video_file');
            for($i=0;$i<sizeof($video_file_type);$i++){                
                $file_data['videos_id']     = $video_id;
                $file_data['file_source']   = $video_file_type[$i];
                $file_data['source_type']   = 'link';
                if($video_file_type[$i]     == 'upload'){
                   $file_data['source_type'] = $this->common_model->get_extension($video_file[$i]);
                   copy('uploads/temp/'.$video_file[$i], 'uploads/videos/'.$video_file[$i]);
                }
                $file_data['file_url'] = $video_file[$i];
                $this->db->insert('video_file', $file_data);
                //var_dump($file_data);
            }
            $this->db->where('videos_id', $video_id);
            $this->db->delete('download_link');
            for($i=0;$i<sizeof($link);$i++){
                $download_data['videos_id'] = $video_id;
                $download_data['link_name'] = $link_name[$i];
                $download_data['link']      = $link[$i];
            }
        }
        if ($param1 == 'change_order'):
            demo_check();
            $videos_id           = $this->input->post('videos_id');
            $video_file_ids      = $this->input->post('video_file_id');
            $orders              = $this->input->post('order');
            $i=0;
            for($i=0; $i<sizeof($orders); $i++):
                $data['order'] = $orders[$i];
                $this->db->where('video_file_id', $video_file_ids[$i]);
                $this->db->update('video_file', $data);
            endfor;
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        endif;
        if ($param1 == 'edit'):
            $data['param1']         = $param1;
            $data['param2']         = $param2;
            $data['page_name']      = 'video_file_edit';
            $data['page_title']     = trans('edit_video_file');
            $data['video_file_info']= $this->common_model->get_single_video_file_details_by_id($param2);
            $this->load->view('admin/index', $data);
        else:
            $data['param1']         = $param1;
            $data['param2']         = $param2;
            $data['slug']           = $this->common_model->get_slug_by_videos_id($param1);
            $data['page_name']      = 'file_and_download';
            $data['page_title']     = trans('file_and_download').' | '.$this->common_model->get_title_by_videos_id($param1);
            $this->load->view('admin/index', $data);
        endif;
    }
    // subtitles
    function subtitle($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        demo_check();

        $video_file_id              = $this->input->post('video_file_id');
        $videos_id                  = $this->input->post('videos_id');
        $language                   = $this->input->post('language');
        $srclang                    = $this->common_model->get_srclang($language);
        $kind                       = $this->input->post('kind');
        $vtt_file                   = $this->input->post('vtt_file');
        $vtt_url                    = $this->input->post('vtt_url');
        $is_subtitle                = FALSE;

        if(isset($_FILES['vtt_file']) && $_FILES['vtt_file']['name']!=''){
            $ext = $this->common_model->get_extension($_FILES['vtt_file']['name']);
            if($ext =='vtt')
                $is_subtitle        = TRUE;
            $subtitle_path          = 'uploads/subtitles/'.$videos_id.'_'.$video_file_id.'_'.$this->generate_random_string().'.vtt';
            move_uploaded_file($_FILES['vtt_file']['tmp_name'], $subtitle_path);
            $data['src']            = base_url().$subtitle_path;                               
        }else if(isset($vtt_url) && $vtt_url !=''){
            $data['src']            = $vtt_url;
            $is_subtitle            = TRUE;
        }
        if($is_subtitle){          
            $data['video_file_id']  = $video_file_id;
            $data['videos_id']      = $videos_id;
            $data['language']       = $language;
            $data['kind']           = $kind;
            $data['srclang']        = $srclang;
            $this->db->insert('subtitle', $data);
            $this->session->set_flashdata('success', trans('add_success'));
            redirect(base_url() . 'admin/file_and_download/'.$videos_id, 'refresh'); 
        }else{
            $this->session->set_flashdata('error', trans('vtt_support_only'));
            redirect(base_url() . 'admin/file_and_download/'.$videos_id, 'refresh'); 
        }
    }

    // tvseries subtitles
    function tvseries_subtitle($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        demo_check();

        $episodes_id                = $this->input->post('episodes_id');
        $videos_id                  = $this->input->post('videos_id');
        $seasons_id                 = $this->input->post('seasons_id');
        $language                   = $this->input->post('language');
        $srclang                    = $this->common_model->get_srclang($language);
        $kind                       = $this->input->post('kind');
        $vtt_file                   = $this->input->post('vtt_file');
        $vtt_url                    = $this->input->post('vtt_url');
        $is_subtitle                = FALSE;

        if(isset($_FILES['vtt_file']) && $_FILES['vtt_file']['name']!=''){
            $ext = $this->common_model->get_extension($_FILES['vtt_file']['name']);
            if($ext =='vtt')
                $is_subtitle        = TRUE;
            $subtitle_path          = 'uploads/subtitles/'.$videos_id.'_'.$episodes_id.'_'.$this->generate_random_string().'.vtt';
            move_uploaded_file($_FILES['vtt_file']['tmp_name'], $subtitle_path);
            $data['src']            = base_url().$subtitle_path;                               
        }else if(isset($vtt_url) && $vtt_url !=''){
            $data['src']            = $vtt_url;
            $is_subtitle            = TRUE;
        }
        if($is_subtitle){          
            $data['episodes_id']    = $episodes_id;
            $data['videos_id']      = $videos_id;
            $data['language']       = $language;
            $data['kind']           = $kind;
            $data['srclang']        = $srclang;
            $this->db->insert('tvseries_subtitle', $data);
            $this->session->set_flashdata('success', trans('add_success'));
            redirect(base_url() . 'admin/episodes_manage/'.$videos_id.'/'.$seasons_id, 'refresh'); 
        }else{
            $this->session->set_flashdata('error', trans('vtt_support_only'));      
            redirect(base_url() . 'admin/episodes_manage/'.$videos_id.'/'.$seasons_id, 'refresh'); 
        }
    }

    // videos or movies types
    function video_type($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '9');
            /* end menu active/inactive section*/ 
        
        if ($param1 == 'add') {
            demo_check();
            
            $data['video_type']             = $this->input->post('video_type');
            $data['video_type_desc']        = $this->input->post('video_type_desc');
            $data['primary_menu']           = $this->input->post('primary_menu');
            $data['footer_menu']            = $this->input->post('footer_menu');           
            
            $this->db->insert('video_type', $data);

            $insert_id                      = $this->db->insert_id();
            $slug                           = url_title($this->input->post('video_type'), 'dash', TRUE);
            $slug_num                       = $this->common_model->slug_num('video_type',$slug);
            if($slug_num > 0){
                $slug= $slug.'-'.$insert_id;
            }
            $data_update['slug']               = $slug;
            $this->db->where('video_type_id', $insert_id);
            $this->db->update('video_type', $data_update);

            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
        if ($param1 == 'update') {
            demo_check();
            
            $data['video_type']             = $this->input->post('video_type');
            $data['video_type_desc']        = $this->input->post('video_type_desc');
            $data['primary_menu']           = $this->input->post('primary_menu');
            $data['footer_menu']            = $this->input->post('footer_menu');            
            $this->db->where('video_type_id', $param2);
            $this->db->update('video_type', $data);
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }      
        
            $data['page_name']              = 'video_type_manage';
            $data['page_title']             = 'Videos Type Management';
            $data['video_types']            = $this->db->get('video_type')->result_array();             
            $this->load->view('admin/index', $data);


    }
    // videos or movies types
    function video_quality($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '24');
            /* end menu active/inactive section*/ 
        
        if ($param1 == 'add') {
            demo_check();
            $data['quality']                = $this->input->post('quality');
            $data['description']            = $this->input->post('description');            
            
            $this->db->insert('quality', $data);
            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
        if ($param1 == 'update') {
            demo_check();
            $data['quality']                = $this->input->post('quality');
            $data['description']            = $this->input->post('description'); 
            
            $this->db->where('quality_id', $param2);
            $this->db->update('quality', $data);
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }
        $data['page_name']                  = 'video_quality_manage';
        $data['page_title']                 = trans('video_quality_manage');
        $data['quality']                    = $this->db->get('quality')->result_array();             
        $this->load->view('admin/index', $data);
    }

    // live tv
    function manage_live_tv($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '26');
            /* end menu active/inactive section*/ 

        if ($param1 == 'new') {
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '35');
            /* end menu active/inactive section*/

            $data['page_name']              = 'live_tv_add';
            $data['page_title']             = trans('live_tv_add');
            $this->load->view('admin/index', $data);
        }        
        else if ($param1 == 'edit') {
            $data['page_name']              =   'live_tv_edit';
            $data['page_title']             =   trans('live_tv_edit');
            $data['param2']                 =   $param2;
            $data['live_tvs']               = $this->db->get_where('live_tv' , array('live_tv_id' => $param2) )->result_array(); 
            $this->load->view('admin/index', $data);
        }        
        else if ($param1 == 'add') {
            demo_check();
            $data['tv_name']                = $this->input->post('tv_name');
            $data['seo_title']              = $this->input->post('seo_title');
            $data['slug']                   = $this->common_model->generate_slug('live_tv',$this->input->post('tv_name'));
            $data['stream_from']            = $this->input->post('stream_from');
            $data['stream_label']           = $this->input->post('stream_label');
            $data['stream_url']             = $this->input->post('stream_url');   
            $data['description']            = $this->input->post('description');
            $data['is_paid']                = $this->input->post('is_paid');  
            $data['focus_keyword']          = $this->input->post('focus_keyword');   
            $data['meta_description']       = $this->input->post('meta_description');   
            $data['tags']                   = $this->input->post('tags');
            $data['live_tv_category_id']    = $this->input->post('live_tv_category_id');
            $publish                        = $this->input->post('publish');
            $featured                       = $this->input->post('featured');
            if($publish =='on'){
                $data['publish']            = '1';
            }else{
                $data['publish']            = '0';
            }

            if($featured =='on'){
                $data['featured']           = '1';
            }else{
                $data['featured']           = '0';
            }

            $this->db->insert('live_tv', $data);
            $insert_id = $this->db->insert_id();
            if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name']!=''){
                $extention                  = '.'.$this->common_model->get_extension($_FILES['poster']['name']);
                $file_name                  = $data['slug'].$extention;
                $file_path                  = 'uploads/tv_image/sm/'.$file_name;                
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], $file_path);
                $data_update['thumbnail']   = $file_name;
                $this->db->where('live_tv_id', $insert_id);
                $this->db->update('live_tv', $data_update);
            }

            if(isset($_FILES['poster']) && $_FILES['poster']['name']!=''){
                $extention                  = '.'.$this->common_model->get_extension($_FILES['poster']['name']);
                $file_name                  = $data['slug'].$extention;
                $file_path                  = 'uploads/tv_image/'.$file_name;                
                move_uploaded_file($_FILES['poster']['tmp_name'], $file_path);
                $data_update['poster']      = $file_name;
                $this->db->where('live_tv_id', $insert_id);
                $this->db->update('live_tv', $data_update);
            }
            $data1['source']                = $this->input->post('stream_from1');
            $data1['label']                 = $this->input->post('stream_label1');
            $data1['url']                   = $this->input->post('stream_url1');
            $data1['quality']               = 'SD';
            $data1['stream_key']            = $this->generate_random_string();
            $data1['live_tv_id']            = $insert_id;
            $data1['url_for']               = 'opt1';
            $this->db->insert('live_tv_url', $data1);

            $data2['source']                = $this->input->post('stream_from2');
            $data2['label']                 = $this->input->post('stream_label2');
            $data2['url']                   = $this->input->post('stream_url2');
            $data2['quality']               = 'LQ';
            $data2['stream_key']            = $this->generate_random_string();
            $data2['live_tv_id']            = $insert_id;
            $data2['url_for']               = 'opt2';
            $this->db->insert('live_tv_url', $data2);

            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
        else if ($param1 == 'update') {
            demo_check();
            $data['tv_name']                = $this->input->post('tv_name');
            $data['seo_title']              = $this->input->post('seo_title');
            $data['slug']                   = $this->common_model->regenerate_slug('live_tv',$param2,$this->input->post('tv_name'));
            $data['stream_from']            = $this->input->post('stream_from');
            $data['stream_label']           = $this->input->post('stream_label');
            $data['stream_url']             = $this->input->post('stream_url');   
            $data['description']            = $this->input->post('description');
            $data['is_paid']                = $this->input->post('is_paid');   
            $data['focus_keyword']          = $this->input->post('focus_keyword');   
            $data['meta_description']       = $this->input->post('meta_description');   
            $data['tags']                   = $this->input->post('tags');
            $data['live_tv_category_id']    = $this->input->post('live_tv_category_id');
            $publish                        = $this->input->post('publish');
            $featured                       = $this->input->post('featured');
            if($publish =='on'){
                $data['publish']            = '1';
            }else{
                $data['publish']            = '0';
            }

            if($featured =='on'){
                $data['featured']           = '1';
            }else{
                $data['featured']           = '0';
            }

            $this->db->where('live_tv_id', $param2);
            $this->db->update('live_tv', $data);
            if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name']!=''){
                $extention                  = '.'.$this->common_model->get_extension($_FILES['poster']['name']);
                $file_name                  = $data['slug'].$extention;
                $file_path                  = 'uploads/tv_image/sm/'.$file_name;                
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], $file_path);
                $data_update['thumbnail']   = $file_name;
                $this->db->where('live_tv_id', $param2);
                $this->db->update('live_tv', $data_update);
            }

            if(isset($_FILES['poster']) && $_FILES['poster']['name']!=''){
                $extention                  = '.'.$this->common_model->get_extension($_FILES['poster']['name']);
                $file_name                  = $data['slug'].$extention;
                $file_path                  = 'uploads/tv_image/'.$file_name;                
                move_uploaded_file($_FILES['poster']['tmp_name'], $file_path);
                $data_update['poster']      = $file_name;
                $this->db->where('live_tv_id', $param2);
                $this->db->update('live_tv', $data_update);
            }
            
            $this->db->where('live_tv_id', $param2);
            $this->db->delete('live_tv_url');
            $data1['source']                = $this->input->post('stream_from1');
            $data1['label']                 = $this->input->post('stream_label1');
            $data1['url']                   = $this->input->post('stream_url1');
            $data1['quality']               = 'SD';
            $data1['stream_key']            = $this->generate_random_string();
            $data1['live_tv_id']            = $param2;
            $data1['url_for']               = 'opt1';
            $this->db->insert('live_tv_url', $data1);

            $data2['source']                = $this->input->post('stream_from2');
            $data2['label']                 = $this->input->post('stream_label2');
            $data2['url']                   = $this->input->post('stream_url2');
            $data2['quality']               = 'LQ';
            $data2['stream_key']            = $this->generate_random_string();
            $data2['live_tv_id']            = $param2;
            $data2['url_for']               = 'opt2';
            $this->db->insert('live_tv_url', $data2);


            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }else{

            $name           = $this->input->get('name');
            $search_string = '';
            if($name !="" && $name !=NULL){
                $filter['name '] = $name;
                $search_string.= 'name='.$name;
                $data['name'] = $name;
            }
            $total_rows     = $this->common_model->get_user_num_rows($name);
            // page
            $config                     = $this->common_model->pagination();
            $config["base_url"]         = base_url() . "admin/manage_user?".$search_string;



            $total_rows                     = $this->live_tv_model->num_live_tv($name);
            $config                         = $this->common_model->pagination();
            $config["base_url"]             = base_url() . "admin/manage_live_tv?".$search_string;
            $config["total_rows"]           = $total_rows;
            $config["per_page"]             = 10;
            $config["uri_segment"]          = 3;  
            //$config['use_page_numbers']   = TRUE;
            $config['page_query_string']    = TRUE;    

            $this->pagination->initialize($config);
            $data['last_row_num']           =   $this->uri->segment(3);
            $page                           =   $this->input->get('per_page');//($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
            $data["tvs"]                    =   $this->live_tv_model->get_live_tvs($config["per_page"], $page,$name);
            $data["links"]                  =   $this->pagination->create_links();
            $data['total_rows']             =   $config["total_rows"];
            $data['page_name']              =   'live_tv_manage';
            $data['page_title']             =   trans('live_tv_manage');
            $this->load->view('admin/index', $data);
        }
    }

    // live tv category
    function live_tv_category($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '39');
            /* end menu active/inactive section*/ 
        
        if ($param1 == 'add') {
            demo_check();
            $data['live_tv_category']             = $this->input->post('live_tv_category');
            $data['live_tv_category_desc']        = $this->input->post('live_tv_category_desc');      
            $data['slug']                         = url_title($this->input->post('live_tv_category'), 'dash', TRUE);     
            
            $this->db->insert('live_tv_category', $data);

            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
        if ($param1 == 'update') {
            demo_check();
            
            $data['live_tv_category']             = $this->input->post('live_tv_category');
            $data['live_tv_category_desc']        = $this->input->post('live_tv_category_desc');           
            $this->db->where('live_tv_category_id', $param2);
            $this->db->update('live_tv_category', $data);
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }
        
        $data['page_name']                      = 'live_tv_category_manage';
        $data['page_title']                     = trans('live_tv_category_manage');
        $data['live_tv_categories']             = $this->db->get('live_tv_category')->result_array();             
        $this->load->view('admin/index', $data);
    }
    function live_tv_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '27');
        /* end menu active/inactive section*/
        if ($param1 == 'update') {
            demo_check();
            $publish = $this->input->post('live_tv_publish');
            if($publish =='on'){
                $data['value'] = '1';
                $this->db->where('title' , 'live_tv_publish');
                 $this->db->update('config' , $data);
            }else{
                $data['value'] = '0';
                 $this->db->where('title' , 'live_tv_publish');
                 $this->db->update('config' , $data);
            }

            $live_tv_pin_primary_menu = $this->input->post('live_tv_pin_primary_menu');
            if($live_tv_pin_primary_menu =='on'){
                $data['value'] = '1';
                $this->db->where('title' , 'live_tv_pin_primary_menu');
                 $this->db->update('config' , $data);
            }else{
                $data['value'] = '0';
                 $this->db->where('title' , 'live_tv_pin_primary_menu');
                 $this->db->update('config' , $data);
             }

             $live_tv_pin_footer_menu = $this->input->post('live_tv_pin_footer_menu');
            if($live_tv_pin_footer_menu =='on'){
                $data['value'] = '1';
                $this->db->where('title' , 'live_tv_pin_footer_menu');
                 $this->db->update('config' , $data);
            }else{
                $data['value'] = '0';
                 $this->db->where('title' , 'live_tv_pin_footer_menu');
                 $this->db->update('config' , $data);
             } 
             $this->session->set_flashdata('success', trans('update_success'));          
             redirect($this->agent->referrer());
        } 

        $data['page_name']      = 'live_tv_setting';
        $data['page_title']     = trans('live_tv_setting'); 
        $this->load->view('admin/index', $data);
    }

    // videos or movies types
    function comments($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '31');
            /* end menu active/inactive section*/ 
        if ($param1 == 'update_movie') {
            demo_check();
            $data['comment']             = $this->input->post('comment');
            $data['publication']        = $this->input->post('publication');                        
            $this->db->where('comments_id', $param2);
            $this->db->update('comments', $data);
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }else if ($param1 == 'update_post') {
            demo_check();
            $data['comment']             = $this->input->post('comment');
            $data['publication']        = $this->input->post('publication');                        
            $this->db->where('post_comments_id', $param2);
            $this->db->update('post_comments', $data);
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }else if($param1 == 'post_comments'){
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '33');
            if($param2 != '' && $param2!=NULL ){
                $data['type']      = $param2;
            }
            else{
                $data['type']      = '';
            }     
        
            $data['page_name']      = 'post_comments_manage';
            $data['page_title']     = 'Post Comments Management';             
            $this->load->view('admin/index', $data);
        }else{
            if($param1 != '' && $param1!=NULL ){
                $data['type']      = $param1;
            }
            else{
                $data['type']      = '';
            }     
        
            $data['page_name']      = 'comments_manage';
            $data['page_title']     = trans('comments_manage');            
            $this->load->view('admin/index', $data);
        }
    }

    function comments_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '32');
            /* end menu active/inactive section*/
        if ($param1 == 'update') {
            demo_check();
            $data['value'] = $this->input->post('comments_method');
            $this->db->where('title' , 'comments_method');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('comments_approval');
            $this->db->where('title' , 'comments_approval');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('facebook_comment_appid');
            $this->db->where('title' , 'facebook_comment_appid');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('disqus_short_name');
            $this->db->where('title' , 'disqus_short_name');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());                       
        }
        $data['page_name']      = 'comments_setting';
        $data['page_title']     = trans('comments_setting');
        $this->load->view('admin/index', $data);
    }



    // add custom page
    function pages_add(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '10');
            /* end menu active/inactive section*/


            $data['page_name']      = 'pages_add';
            $data['page_title']     = trans('pages_add'); 
            $this->load->view('admin/index', $data);
    }
    // edit custom page
    function pages_edit($param1='',$param2=''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '10');
        /* end menu active/inactive section*/

        $data['param1']         = $param1;
        $data['param2']         = $param2;
        $data['page_name']      = 'pages_edit';
        $data['page_title']     = trans('pages_edit');
        $this->load->view('admin/index', $data);
    }

    // add,update custom page
    function pages($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '11');
            /* end menu active/inactive section*/          
        
        if ($param1 == 'add') {
            demo_check();
            $data['page_title']         = $this->input->post('page_title');
            $data['seo_title']          = $this->input->post('seo_title');
            $data['content']            = $this->input->post('content');
            $data['primary_menu']       = $this->input->post('primary_menu');
            $data['footer_menu']        = $this->input->post('footer_menu');
            $data['focus_keyword']      = $this->input->post('focus_keyword');
            $data['meta_description']   = $this->input->post('meta_description');
            $data['publication']        = $this->input->post('publication');
            
            $this->db->insert('page', $data);
            $insert_id = $this->db->insert_id();

            $slug                       = url_title($this->input->post('slug'), 'dash', TRUE);
            $slug_num                   = $this->common_model->slug_num('page',$slug);
            if($slug_num > 0){
                $slug= $slug.'-'.$insert_id;
            }
            $data['slug']               = $slug;
            $this->db->where('page_id', $insert_id);
            $this->db->update('page', $data);

            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
        else if ($param1 == 'update') {
            demo_check();
            $slug                       = url_title($this->input->post('slug'), 'dash', TRUE);           
            $data['page_title']         = $this->input->post('page_title');
            $data['seo_title']          = $this->input->post('seo_title');
            $data['content']            = $this->input->post('content');
            $data['primary_menu']       = $this->input->post('primary_menu');
            $data['footer_menu']        = $this->input->post('footer_menu');
            $data['focus_keyword']      = $this->input->post('focus_keyword');
            $data['meta_description']   = $this->input->post('meta_description');                      
            $data['slug']               = $slug;
            $data['publication']        = $this->input->post('publication');      


            $this->db->where('page_id', $param2);
            $this->db->update('page', $data);

            $slug_num                 = $this->common_model->slug_num('page',$slug);
            if($slug_num > 1){
                $slug= $slug.'-'.$param2;
            }
            $data['slug']               = $slug;
            $this->db->where('page_id', $param2);
            $this->db->update('page', $data);

            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }
        else{
            if($param1 != '' && $param1!=NULL ){
                $data['type']      = $param1;
            }
            else{
                $data['type']      = '';
            }
        }        
        $data['page_name']      = 'pages_manage';
        $data['page_title']     = trans('pages_manage');          
        $this->load->view('admin/index', $data);
    }

    // add blog post

    function posts_add(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '12');
            /* end menu active/inactive section*/


            $data['page_name']      = 'posts_add';
            $data['page_title']     = trans('posts_add'); 
            $this->load->view('admin/index', $data);
    }
    // edit blog post
    function posts_edit($param1='',$param2=''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '12');
            /* end menu active/inactive section*/


            $data['param1']         = $param1;
            $data['param2']         = $param2;
            $data['page_name']      = 'posts_edit';
            $data['page_title']     = trans('posts_edit');
            $this->load->view('admin/index', $data);
    }

    // add,update blog post
    function posts($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '13');
            /* end menu active/inactive section*/   
        
        if ($param1 == 'add') {
            demo_check();
            $data['post_title']                 = $this->input->post('post_title');
            $data['seo_title']                  = $this->input->post('seo_title');
            $data['content']                    = $this->input->post('content');
            $data['focus_keyword']              = $this->input->post('focus_keyword');
            $data['meta_description']           = $this->input->post('meta_description');
            $data['category_id']                = implode(',',$this->input->post('category_id'));
            $data['publication']                = $this->input->post('publication');
            if($this->input->post('thumb_link')!=''){                
                $data['image_link']     = $this->input->post('thumb_link');
            }     

            
            $this->db->insert('posts', $data);
            $insert_id = $this->db->insert_id();          

            $slug                       = url_title($this->input->post('slug'), 'dash', TRUE);
            $slug_num                   = $this->common_model->slug_num('videos',$slug);
            if($slug_num > 0){
                $slug= $slug.'-'.$insert_id;
            }
            $data['slug']               = $slug;
            if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name']!=''){
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/post_thumb/'.$slug.'.jpg');
                $data['image_link']     = base_url().'uploads/post_thumb/'.$slug.'.jpg';
                $source                 = 'uploads/post_thumb/'.$slug.'.jpg';
                $destination            = 'uploads/post_thumb/small/'.$slug.'.jpg';
                $this->common_model->create_small_thumbnail($source, $destination, "150","150");
            }
            $this->db->where('posts_id', $insert_id);
            $this->db->update('posts', $data);
            
            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
        else if ($param1 == 'update') {
            demo_check();
            $data['post_title']                 = $this->input->post('post_title');
            $data['seo_title']                  = $this->input->post('seo_title');
            $data['content']                    = $this->input->post('content');
            $data['focus_keyword']              = $this->input->post('focus_keyword');
            $data['meta_description']           = $this->input->post('meta_description');
            $data['category_id']                = implode(',',$this->input->post('category_id'));
            $data['publication']                = $this->input->post('publication');
            if($this->input->post('thumb_link')!=''){                
                $data['image_link']     = $this->input->post('thumb_link');
            }
            $this->db->where('posts_id', $param2);
            $this->db->update('posts', $data);
            $slug                       = url_title($this->input->post('slug'), 'dash', TRUE);
            $slug_num                   = $this->common_model->slug_num('videos',$slug);
            if($slug_num > 1){
                $slug= $slug.'-'.$param2;
            }
            $data['slug']            = $slug;
            if(isset($_FILES['thumbnail']) && $_FILES['thumbnail']['name']!=''){
                move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/post_thumb/'.$slug.'.jpg');
                $data['image_link']     = base_url().'uploads/post_thumb/'.$slug.'.jpg';
                $source='uploads/post_thumb/'.$slug.'.jpg';
                $destination='uploads/post_thumb/small/'.$slug.'.jpg';
                $this->common_model->create_small_thumbnail($source, $destination, "150","150");
            }
            $this->db->where('posts_id', $param2);
            $this->db->update('posts', $data);


            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }
        else{
            if($param1 != '' && $param1!=NULL ){
                $data['type']      = $param1;
            }
            else{
                $data['type']      = '';
            }
        }        
        $data['page_name']      = 'posts_manage';
        $data['page_title']     = trans('');          
        $this->load->view('admin/index', $data);


    }
    // post category
    function post_category($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '14');
            /* end menu active/inactive section*/   
        
        if ($param1 == 'add') {
            demo_check();
            
            $data['category']             = $this->input->post('category');
            $data['category_desc']        = $this->input->post('category_desc'); 
            $slug                         = url_title($this->input->post('category'), 'dash', TRUE);
            $slug_num                     = $this->common_model->slug_num('post_category',$slug);
            if($slug_num > 0){
                $slug= $slug.'-'.$param2;
            }
            $data_update['slug']               = $slug;          
            
            $this->db->insert('post_category', $data);
            $insert_id                    = $this->db->insert_id();
            $slug                         = url_title($this->input->post('category'), 'dash', TRUE);
            $slug_num                     = $this->common_model->slug_num('post_category',$slug);
            if($slug_num > 0){
                $slug= $slug.'-'.$insert_id;
            }
            $data_update['slug']               = $slug;
            $this->db->where('post_category_id', $insert_id);
            $this->db->update('post_category', $data_update);

            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
        if ($param1 == 'update') {
            demo_check();
            
            $data['category']             = $this->input->post('category');
            $data['category_desc']        = $this->input->post('category_desc');
            $slug                         = url_title($this->input->post('category'), 'dash', TRUE);
            $slug_num                     = $this->common_model->slug_num('post_category',$slug);
            if($slug_num > 0){
                $slug= $slug.'-'.$param2;
            }
            $data['slug']                 = $slug;
            
            $this->db->where('post_category_id', $param2);
            $this->db->update('post_category', $data);
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }  
        
            $data['page_name']          = 'post_category_manage';
            $data['page_title']         = trans('post_category_manage');
            $data['post_categories']    = $this->db->get('post_category')->result_array();             
            $this->load->view('admin/index', $data);
    }

    // users
    function manage_user($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '15');
            /* end menu active/inactive section*/ 

            /* add new access */   
        
        if ($param1 == 'add') {
            demo_check();
            $data['name']           = $this->input->post('name');
            // $data['username']       = $this->input->post('username');
            $data['password']       = md5($this->input->post('password'));
            $data['email']          = $this->input->post('email');
            $data['role']           = $this->input->post('role');           
            
            $this->db->insert('user', $data);
            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
        if ($param1 == 'update') {
            demo_check();
            $data['name']           = $this->input->post('name');
            // $data['username']       = $this->input->post('username');
            if($this->input->post('password')!='' || $this->input->post('password')!=NULL){
                $data['password']   = md5($this->input->post('password'));
            }
            
            $data['email']          = $this->input->post('email');
            $data['role']           = $this->input->post('role');

            $this->db->where('user_id', $param2);
            $this->db->update('user', $data);
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }        
        $name           = $this->input->get('name');
        $search_string = '';
        if($name !="" && $name !=NULL){
            $filter['name '] = $name;
            $search_string.= 'name='.$name;
            $data['name'] = $name;
        }
        $total_rows     = $this->common_model->get_user_num_rows($name);
        // page
        $config                     = $this->common_model->pagination();
        $config["base_url"]         = base_url() . "admin/manage_user?".$search_string;
        $config["total_rows"]       = $total_rows;
        $config["per_page"]         = 15;
        $config["uri_segment"]      = 3;          
        //$config['use_page_numbers'] = TRUE;
        $config['page_query_string']= TRUE; 
        $this->pagination->initialize($config);
        $data['last_row_num']       =  $this->uri->segment(3);
        $page                       = ($this->input->get('per_page') !="" || $this->input->get('per_page') !=NULL) ? $this->input->get('per_page') : 0;//($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
        $data["users"]              = $this->common_model->get_users($name,$config["per_page"], $page);
        $data["links"]              = $this->pagination->create_links();
        $data['total_rows']         = $config["total_rows"];
        $data['page_name']          = 'user_manage';
        $data['page_title']         = 'User Management';             
        $this->load->view('admin/index', $data);
    }

    // users
    function manage_star($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '25');
        /* end menu active/inactive section*/  
        
        if ($param1 == 'add') {
            demo_check();
            $star_name                      = trim($this->input->post('star_name'));
            if($this->db->get_where('star',array('star_name'=>$star_name))->num_rows() > 0){
                $this->session->set_flashdata('error', 'Star Already exist.');
                redirect($this->agent->referrer());
            }else{
                $data['star_name']              = $star_name;
                $data['slug']                   = $this->common_model->get_seo_url($star_name);
                $data['star_type']              = $this->input->post('star_type');
                $data['star_desc']              = $this->input->post('star_desc');   
                $this->db->insert('star', $data);
                $insert_id = $this->db->insert_id();
                if(isset($_FILES['photo']) && $_FILES['photo']['name']!=''){
                    move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/star_image/'.$insert_id.'.jpg');
                }
            }
            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
        if ($param1 == 'update') {
            demo_check();
            $star_name                          = trim($this->input->post('star_name'));
            if($this->db->get_where('star',array('star_name'=>$star_name))->num_rows() > 1){
                $this->session->set_flashdata('error', 'Duplicate Star exist.');
                redirect($this->agent->referrer());
            }else{
                $data['star_name']              = $star_name;
                $data['slug']                   = $this->common_model->get_seo_url($star_name);
                $data['star_type']              = $this->input->post('star_type');
                $data['star_desc']              = $this->input->post('star_desc');
                $this->db->where('star_id', $param2);
                $this->db->update('star', $data);
                if(isset($_FILES['photo']) && $_FILES['photo']['name']!=''){
                    move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/star_image/'.$param2.'.jpg');
                }
                $this->session->set_flashdata('success', trans('update_success'));
                redirect($this->agent->referrer());
            }            
        }
        $config = $this->common_model->pagination();
        $config["base_url"]                     = base_url() . "admin/manage_star";
        $config["total_rows"]                   = $this->db->get_where('star', array('status'=>'1'))->num_rows();
        $config["per_page"]                     = 20;
        $config["uri_segment"]                  = 3;     

        $this->pagination->initialize($config);
        $data['last_row_num']                   = $this->uri->segment(3);
        $page                                   = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;   
        $data["stars"]                          = $this->common_model->get_stars($config["per_page"], $page);
        $data["links"]                          = $this->pagination->create_links();
        $data['total_rows']                     = $config["total_rows"];
        $data['page_name']                      = 'star_manage';
        $data['page_title']                     = trans('star_manage');
        $this->load->view('admin/index', $data);
    }

    function tv_series_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '28');
        /* end menu active/inactive section*/
        if ($param1 == 'update') {
            demo_check();
            $publish = $this->input->post('tv_series_publish');
            if($publish =='on'){
                $data['value'] = '1';
                $this->db->where('title' , 'tv_series_publish');
                 $this->db->update('config' , $data);
            }else{
                $data['value'] = '0';
                 $this->db->where('title' , 'tv_series_publish');
                 $this->db->update('config' , $data);
             }

             $tv_series_pin_primary_menu = $this->input->post('tv_series_pin_primary_menu');
            if($tv_series_pin_primary_menu =='on'){
                $data['value'] = '1';
                $this->db->where('title' , 'tv_series_pin_primary_menu');
                 $this->db->update('config' , $data);
            }else{
                $data['value'] = '0';
                 $this->db->where('title' , 'tv_series_pin_primary_menu');
                 $this->db->update('config' , $data);
             }

             $tv_series_pin_footer_menu = $this->input->post('tv_series_pin_footer_menu');
            if($tv_series_pin_footer_menu =='on'){
                $data['value'] = '1';
                $this->db->where('title' , 'tv_series_pin_footer_menu');
                 $this->db->update('config' , $data);
            }else{
                $data['value'] = '0';
                 $this->db->where('title' , 'tv_series_pin_footer_menu');
                 $this->db->update('config' , $data);
             }

            $data['value'] = $this->input->post('season_order');
            $this->db->where('title' , 'season_order');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('episode_order');
            $this->db->where('title' , 'episode_order');
            $this->db->update('config' , $data);

             $this->session->set_flashdata('success', trans('setting_update_success'));           
             redirect($this->agent->referrer());
        } 

        $data['page_name']      = 'tv_series_setting';
        $data['page_title']     = trans('tv_series_setting'); 
        $this->load->view('admin/index', $data);
    }
    // android setting
    function android_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '40');
        /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();

            $data['value'] = "grid";
            if($this->input->post('app_menu') == "vertical")
            $data['value'] = "vertical";
            $this->db->where('title' , 'app_menu');
            $this->db->update('config' , $data);

            $data['value'] = "true";
            if($this->input->post('app_program_guide_enable') == "false")
            $data['value'] = "false";
            $this->db->where('title' , 'app_program_guide_enable');
            $this->db->update('config' , $data);

            $data['value'] = "false";
            if($this->input->post('app_mandatory_login') == "true")
            $data['value'] = "true";
            $this->db->where('title' , 'app_mandatory_login');
            $this->db->update('config' , $data);

            $data['value'] = "false";
            if($this->input->post('genre_visible') == "true")
            $data['value'] = "true";
            $this->db->where('title' , 'genre_visible');
            $this->db->update('config' , $data);

            $data['value'] = "false";
            if($this->input->post('country_visible') == "true")
            $data['value'] = "true";
            $this->db->where('title' , 'country_visible');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('apk_version_name');
             $this->db->where('title' , 'apk_version_name');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('apk_version_code');
             $this->db->where('title' , 'apk_version_code');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('apk_whats_new');
             $this->db->where('title' , 'apk_whats_new');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('latest_apk_url');
             $this->db->where('title' , 'latest_apk_url');
             $this->db->update('config' , $data);

            $apk_update_is_skipable = $this->input->post('apk_update_is_skipable');
            if($apk_update_is_skipable =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'apk_update_is_skipable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'apk_update_is_skipable');
                 $this->db->update('config' , $data);
            endif;


            $this->session->set_flashdata('success', trans('setting_update_success'));           
            redirect($this->agent->referrer());
        }
        $data['page_name']      = 'android_setting';
        $data['page_title']     = trans('android_setting');
        $this->load->view('admin/index', $data);
    }


    // system setting
    function system_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '160');
            /* end menu active/inactive section*/

            if ($param1 == 'update') {
             demo_check();

             $purchase_code = $this->input->post('purchase_code');
             if(strpos($purchase_code, '*') === false):
                $data['value'] = $purchase_code;
                 $this->db->where('title' , 'purchase_code');
                 $this->db->update('config' , $data);
             endif;

             $data['value'] = $this->input->post('active_theme');
             $this->db->where('title' , 'active_theme');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('timezone');
             $this->db->where('title' , 'timezone');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('site_name');
             $this->db->where('title' , 'site_name');
             $this->db->update('config' , $data);
             
             $data['value'] = $this->input->post('site_url');
             $this->db->where('title' , 'site_url');
             $this->db->update('config' , $data);
             
             $data['value'] = $this->input->post('system_email');
             $this->db->where('title' , 'system_email');
             $this->db->update('config' , $data);
             
             $data['value'] = $this->input->post('business_address');
             $this->db->where('title' , 'business_address');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('business_phone');
             $this->db->where('title' , 'business_phone');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('contact_email');
             $this->db->where('title' , 'contact_email');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('registration_enable');
             $this->db->where('title' , 'registration_enable');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('frontend_login_enable');
             $this->db->where('title' , 'frontend_login_enable');
             $this->db->update('config' , $data); 

             $data['value'] = $this->input->post('blog_enable');
             $this->db->where('title' , 'blog_enable');
             $this->db->update('config' , $data);
             // country menu
             $country_to_primary_menu = $this->input->post('country_to_primary_menu');
            if($country_to_primary_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'country_to_primary_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'country_to_primary_menu');
                 $this->db->update('config' , $data);
            endif;
            //genre menu
            $genre_to_primary_menu = $this->input->post('genre_to_primary_menu');
            if($genre_to_primary_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'genre_to_primary_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'genre_to_primary_menu');
                 $this->db->update('config' , $data);
            endif;

            //release menu
            $release_to_primary_menu = $this->input->post('release_to_primary_menu');
            if($release_to_primary_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'release_to_primary_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'release_to_primary_menu');
                 $this->db->update('config' , $data);
            endif;

            //contact menu
            $contact_to_primary_menu = $this->input->post('contact_to_primary_menu');
            if($contact_to_primary_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'contact_to_primary_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'contact_to_primary_menu');
                 $this->db->update('config' , $data);
            endif;

            $contact_to_footer_menu = $this->input->post('contact_to_footer_menu');
            if($contact_to_footer_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'contact_to_footer_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'contact_to_footer_menu');
                 $this->db->update('config' , $data);
            endif;


            $az_to_primary_menu = $this->input->post('az_to_primary_menu');
            if($az_to_primary_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'az_to_primary_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'az_to_primary_menu');
                 $this->db->update('config' , $data);
            endif;

            $az_to_footer_menu = $this->input->post('az_to_footer_menu');
            if($az_to_footer_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'az_to_footer_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'az_to_footer_menu');
                 $this->db->update('config' , $data);
            endif;


            //star image
            $show_star_image = $this->input->post('show_star_image');
            if($show_star_image =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'show_star_image');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'show_star_image');
                 $this->db->update('config' , $data);
            endif;
             // movie report
            $movie_report_enable = $this->input->post('movie_report_enable');
            if($movie_report_enable =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'movie_report_enable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'movie_report_enable');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('movie_report_email');
             $this->db->where('title' , 'movie_report_email');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('movie_report_note');
             $this->db->where('title' , 'movie_report_note');
             $this->db->update('config' , $data);

            //movie request
            $movie_request_enable = $this->input->post('movie_request_enable');
            if($movie_request_enable =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'movie_request_enable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'movie_request_enable');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('movie_request_email');
             $this->db->where('title' , 'movie_request_email');
             $this->db->update('config' , $data);


            //recaptcha_enable
            $recaptcha_enable = $this->input->post('recaptcha_enable');
            if($recaptcha_enable =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'recaptcha_enable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'recaptcha_enable');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('recaptcha_site_key');
            $this->db->where('title' , 'recaptcha_site_key');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('recaptcha_secret_key');
            $this->db->where('title' , 'recaptcha_secret_key');
            $this->db->update('config' , $data);


            $this->session->set_flashdata('success', trans('setting_update_success'));           
            redirect($this->agent->referrer());
        }
        $data['page_name']      = 'system_setting';
        $data['page_title']     = trans('system_setting');
        $this->load->view('admin/index', $data);
    }

    // API setting
    function api_setting($param1 = '', $param2 = ''){
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '162');
            /* end menu active/inactive section*/
        if ($param1 == 'update_legacy_api') {
             demo_check();
             $data['value'] = $this->input->post('mobile_apps_api_secret_key');
             $this->db->where('title' , 'mobile_apps_api_secret_key');
             $this->db->update('config' , $data);
             $this->session->set_flashdata('success', 'Setting update successed.');           
             redirect($this->agent->referrer());
        }
        if($param1 == 'create_key'):
            demo_check();
            $this->form_validation->set_rules('label', 'Label', 'required|min_length[4]');
            if ($this->form_validation->run() == FALSE):
                $this->session->set_flashdata('error',strip_tags(json_encode(validation_errors())));
            else:
                $data['label'] = $this->input->post('label');
                $data['key']            = $this->generate_random_string(16);
                $data['level']          = 1;
                $data['date_created']   = time();
                $this->db->insert('keys',$data);
                $this->session->set_flashdata('success', 'Key create successed.');
            endif;
            redirect($this->agent->referrer());
        endif;
        if($param1 == 'update_key'):
            demo_check();
            if($param2 !='' && $param2 !=NULL):
                $data['label'] = $this->input->post('label');
                $this->form_validation->set_rules('label', 'Label', 'required|min_length[4]'); 
                if ($this->form_validation->run() == FALSE):
                    $this->session->set_flashdata('error',strip_tags(json_encode(validation_errors())));
                else:               
                    $query = $this->db->get_where('keys',array('id'=>$param2));
                    if($query->num_rows() > 0):
                        $this->db->where('id',$param2);
                        $this->db->update('keys',$data);
                        $this->session->set_flashdata('success', 'Label update successed.');
                    else:
                       $this->session->set_flashdata('error', 'Invalid ID.');
                    endif;
                endif;
            else:
                $this->session->set_flashdata('error', 'ID Is required.'); 
            endif;
            redirect($this->agent->referrer());
        endif;


        if($param1 == 'delete_key'):
            demo_check();
            if($param2 !='' && $param2 !=NULL):
                if($this->db->get_where('keys',array('id'=>$param2))->num_rows() > 0):
                    $this->db->where('id',$param2);
                    $this->db->delete('keys');
                    $this->session->set_flashdata('success', 'Key delete successed.');
                else:
                    $this->session->set_flashdata('error', 'ID not found.');
                endif; 
            else:
                $this->session->set_flashdata('error', 'ID Is required.'); 
            endif;
            redirect($this->agent->referrer());
        endif;

        if($param1 == 'create_authentication'):
            demo_check();
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|is_unique[rest_logins.username]');
            if ($this->form_validation->run() == FALSE):
                $this->session->set_flashdata('error',strip_tags(json_encode(validation_errors())));
            else:
                $data['username'] = $this->input->post('username');
                $data['password']      = $this->generate_random_password(16);
                $this->db->insert('rest_logins',$data);
                $this->session->set_flashdata('success', 'Authentication create successed.');
            endif;
            redirect($this->agent->referrer());
        endif;

        if($param1 == 'update_authentication'):
            demo_check();
            if($param2 !='' && $param2 !=NULL):
                $data['username'] = $this->input->post('username');
                $data['password'] = $this->input->post('password');
                $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]');
                $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]'); 
                if ($this->form_validation->run() == FALSE):
                    $this->session->set_flashdata('error',strip_tags(json_encode(validation_errors())));
                else:               
                    $query = $this->db->get_where('rest_logins',array('id !='=>$param2,'username'=>$data['username']));
                    if($query->num_rows() > 0):
                        $this->session->set_flashdata('error', 'Username already exist.Please choose another username.');
                    else:
                        $query = $this->db->get_where('rest_logins',array('id'=>$param2));
                        if($query->num_rows() > 0):
                            $this->db->where('id',$param2);
                            $this->db->update('rest_logins',$data);
                            $this->session->set_flashdata('success', 'Label update successed.');
                        else:
                           $this->session->set_flashdata('error', 'Invalid ID.');
                        endif;
                        $this->db->update('rest_logins',$data);
                        $this->session->set_flashdata('success', 'Authentication update successed.');
                    endif;
                endif;
            else:
                $this->session->set_flashdata('error', 'ID Is required.'); 
            endif;
            redirect($this->agent->referrer());
        endif;

        if($param1 == 'delete_authentication'):
            demo_check();
            if($param2 !='' && $param2 !=NULL):
                if($this->db->get_where('rest_logins',array('id'=>$param2))->num_rows() > 0):
                    $this->db->where('id',$param2);
                    $this->db->delete('rest_logins');
                    $this->session->set_flashdata('success', 'Authentication delete successed.');
                else:
                    $this->session->set_flashdata('error', 'ID not found.');
                endif; 
            else:
                $this->session->set_flashdata('error', 'ID Is required.'); 
            endif;
            redirect($this->agent->referrer());
        endif;

        $data['page_name']      = 'api_setting';
        $data['page_title']     = 'API Setting';
        $data['key']           = $this->db->get('keys')->first_row();
        $data['rest_logins']    = $this->db->get('rest_logins')->result_array();
        $this->load->view('admin/index', $data);
    }


    function update($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '161');
        /* end menu active/inactive section*/
        $data['page_name']      = 'update';
        $data['page_title']     = trans('system_updater');
        $this->load->view('admin/index', $data);
    }


    // theme options
    function theme_options($param1 = '', $param2 = ''){

        // echo "<pre>";
        // print_r($this->input->post());
        // exit();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '16');
            /* end menu active/inactive section*/

       if ($param1 == 'update') {
             demo_check();

             $data['value'] = $this->input->post('map_api');
             $this->db->where('title' , 'map_api');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('map_lat');
             $this->db->where('title' , 'map_lat');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('map_lng');
             $this->db->where('title' , 'map_lng');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('front_end_theme');
             $this->db->where('title' , 'front_end_theme');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('landing_page_enable');
             $this->db->where('title' , 'landing_page_enable');
             $this->db->update('config' , $data);                         

             $data['value'] = $this->input->post('dark_theme');
             $this->db->where('title' , 'dark_theme');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('preloader_disable');
             $this->db->where('title' , 'preloader_disable');
             $this->db->update('config' , $data);

            $data['value'] = $this->input->post('bg_img_disable');
            $this->db->where('title' , 'bg_img_disable');
            $this->db->update('config' , $data);

             $data['value'] = $this->input->post('header_templete');
             $this->db->where('title' , 'header_templete');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('footer_templete');
             $this->db->where('title' , 'footer_templete');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('movie_page_slider');
             $this->db->where('title' , 'movie_page_slider');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('tv_series_page_slider');
             $this->db->where('title' , 'tv_series_page_slider');
             $this->db->update('config' , $data);

            // landing page background image
            if (isset($_FILES['landing_page_image']['name']) && !empty($_FILES['landing_page_image']['name'])):
                $config['upload_path']          = './uploads/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 0;
                $config['file_name']            = 'landing_bg_'.uniqid();
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('landing_page_image')):
                    $uploadData                 = $this->upload->data();                    
                    $file_name                  = $uploadData['file_name'];
                    $file_ext                   = $uploadData['file_ext'];

                    $data['value']              = $file_name;
                    $this->db->where('title' , 'landing_bg');
                    $this->db->update('config' , $data);
                    $this->session->set_flashdata('success', trans('setting_update_success')); 
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());                
                endif;
            endif;
            // landing page background image
            if (isset($_FILES['bg_image']['name']) && !empty($_FILES['bg_image']['name'])):
                $config['upload_path']          = './uploads/bg/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 0;
                $config['file_name']            = 'bg_'.uniqid();
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('bg_image')):
                    $uploadData                 = $this->upload->data();
                    $file_name                  = $uploadData['file_name'];
                    $file_ext                   = $uploadData['file_ext'];

                    $data['value']              = $file_name;
                    $this->db->where('title' , 'bg_image');
                    $this->db->update('config' , $data);
                    $this->session->set_flashdata('success', trans('setting_update_success'));
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                endif;
            endif;

            $this->session->set_flashdata('success', trans('setting_update_success'));           
            redirect($this->agent->referrer());
        }

        $data['homepage_sections']      = $this->db->get('homepage_sections')->result_array();
        

        $data['page_name']      = 'theme_options';
        $data['page_title']     = trans('theme_options');
        // $this->load->view('admin/'.$this->active_theme.'/index',$data);
        $this->load->view('admin/index', $data);
    }

    public function section($param1 = '', $param2 = '')
    {
      if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '3');
        /* end menu active/inactive section*/ 
        
        if ($param1 == 'add') {
            demo_check();
            $data['title']           = $this->input->post('title');
            $data['content_type']    = $this->input->post('content_type');
            $data['order']           = $this->input->post('order');

            if($this->input->post('content_type') == 'genre'):
            $data['genre_id']        = $this->input->post('genre');
            endif;              
            
            $this->db->insert('homepage_sections', $data);
            
            $this->session->set_flashdata('success', trans('add_success'));
            redirect($this->agent->referrer());
        }
            
        if ($param1 == 'update') {
            demo_check();
            $data['title']           = $this->input->post('title');
            $data['content_type']    = $this->input->post('content_type');
            $data['order']           = $this->input->post('order');

            if($this->input->post('content_type') == 'genre'):
            $data['genre_id']        = $this->input->post('genre');
            else:
            $data['genre_id']        = NULL;
            endif;

            $this->db->where('id', $param2);
            $this->db->update('homepage_sections', $data);

            
            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }      
        redirect(base_url() . 'admin/theme_options', 'refresh');  
    }

    function regenerate_mobile_secret_key(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        demo_check();
        $data['value'] = $this->generate_random_string(24);
        $this->db->where('title' , 'mobile_apps_api_secret_key');
        $this->db->update('config' , $data);

        $this->session->set_flashdata('success', trans('setting_update_success'));           
        redirect($this->agent->referrer());
    }
    function regenerate_cron_key(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        demo_check();
        $data['value'] = $this->generate_random_string(24);
        $this->db->where('title' , 'cron_key');
        $this->db->update('config' , $data);
        $this->session->set_flashdata('success', trans('setting_update_success'));            
        redirect(base_url() . 'admin/cron_setting/', 'refresh');
    }

    // player setting
    function player_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '34');
            /* end menu active/inactive section*/

            if ($param1 == 'update') {
                demo_check();
             

             $data['value'] = $this->input->post('player_color_skin');
             $this->db->where('title' , 'player_color_skin');
             $this->db->update('config' , $data);

             $data['value'] = '0';
             if(!empty($this->input->post('player_volume_remember')) && $this->input->post('player_volume_remember') !='' && $this->input->post('player_volume_remember') !=NULL){
                $data['value'] = $this->input->post('player_volume_remember');
             }                
             $this->db->where('title' , 'player_volume_remember');
             $this->db->update('config' , $data);

             $data['value'] = '0';
             if(!empty($this->input->post('player_watermark')) && $this->input->post('player_watermark') !='' && $this->input->post('player_watermark') !=NULL){
                $data['value'] = $this->input->post('player_watermark');
            }
             $this->db->where('title' , 'player_watermark');
             $this->db->update('config' , $data);

            if(!empty($_FILES['player_watermark_logo']) && $_FILES['player_watermark_logo']['name']!=''){
                move_uploaded_file($_FILES['player_watermark_logo']['tmp_name'], 'uploads/watermark_logo.'.$this->common_model->get_extension($_FILES['player_watermark_logo']['name']));
                $data['value'] = 'uploads/watermark_logo.'.$this->common_model->get_extension($_FILES['player_watermark_logo']['name']);
                $this->db->where('title' , 'player_watermark_logo');
                $this->db->update('config' , $data);
            }
             
             $data['value'] = $this->input->post('player_watermark_url');
             $this->db->where('title' , 'player_watermark_url');
             $this->db->update('config' , $data);
             
             $data['value'] = $this->input->post('player_share');
             $this->db->where('title' , 'player_share');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('player_share_fb_id');
             $this->db->where('title' , 'player_share_fb_id');
             $this->db->update('config' , $data);

             $data['value'] = '0';
             if(!empty($this->input->post('player_seek_button')) && $this->input->post('player_seek_button') !='' && $this->input->post('player_seek_button') !=NULL){
                $data['value'] = $this->input->post('player_seek_button');
            }
             $this->db->where('title' , 'player_seek_button');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('player_seek_forward');
             $this->db->where('title' , 'player_seek_forward');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('player_seek_back');
             $this->db->where('title' , 'player_seek_back');
             $this->db->update('config' , $data);
             
             $this->session->set_flashdata('success', trans('setting_update_success'));            
             //redirect(base_url() . 'admin/player_setting/', 'refresh');
        }
            $data['page_name']      = 'player_setting';
            $data['page_title']     = trans('player_setting');
            $this->load->view('admin/index', $data);
    }

    // general setting
    function email_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '17');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();
            $protocol = $this->input->post('protocol');            
            if($protocol=='smtp')
            {
                $data['value'] = $this->input->post('protocol');
                $this->db->where('title' , 'protocol');
                $this->db->update('config' , $data);

                $data['value'] = $this->input->post('smtp_host');
                $this->db->where('title' , 'smtp_host');
                $this->db->update('config' , $data);

                $data['value'] = $this->input->post('smtp_user');
                $this->db->where('title' , 'smtp_user');
                $this->db->update('config' , $data);


                $data['value'] = $this->input->post('smtp_pass');
                $this->db->where('title' , 'smtp_pass');
                $this->db->update('config' , $data);

                $data['value'] = $this->input->post('smtp_port');
                $this->db->where('title' , 'smtp_port');
                $this->db->update('config' , $data);

                $data['value'] = $this->input->post('smtp_crypto');
                $this->db->where('title' , 'smtp_crypto');
                $this->db->update('config' , $data); 
            }
            else if($protocol=='sendmail')
            {
                $data['value'] = $this->input->post('protocol');
                $this->db->where('title' , 'protocol');
                $this->db->update('config' , $data);

                $data['value'] = $this->input->post('mailpath');
                $this->db->where('title' , 'mailpath');
                $this->db->update('config' , $data);
            }

             $data['value'] = $this->input->post('contact_email');
             $this->db->where('title' , 'contact_email');
             $this->db->update('config' , $data);

             $this->session->set_flashdata('success', trans('setting_update_success'));            
             redirect($this->agent->referrer());
        }
            $data['page_name']      = 'email_setting';
            $data['page_title']     = trans('email_setting');
            $this->load->view('admin/index', $data);
    }


    // logo setting
    function logo_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '18');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();
            // logo
            if (isset($_FILES['website_logo']['name']) && !empty($_FILES['website_logo']['name'])):
                $config['upload_path']          = './uploads/system_logo/';
                $config['allowed_types']        = 'jpg|png';
                $config['max_size']             = 512;
                $config['max_width']            = 512;
                $config['max_height']           = 512;
                $config['file_name']            = 'logo_'.uniqid();
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('website_logo')):
                    $uploadData                 = $this->upload->data();                    
                    $file_name                  = $uploadData['file_name'];
                    $file_ext                   = $uploadData['file_ext'];

                    $data['value']              = $file_name;
                    $this->db->where('title' , 'logo');
                    $this->db->update('config' , $data);
                    $this->session->set_flashdata('success', trans('setting_update_success')); 
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());                
                endif;
            endif;
            // favicon
            if (isset($_FILES['website_favicon']['name']) && !empty($_FILES['website_favicon']['name'])):
                $config['upload_path']          = './uploads/system_logo/';
                $config['allowed_types']        = 'jpg|png|ico';
                $config['max_size']             = 200;
                $config['max_width']            = 512;
                $config['max_height']           = 512;
                $config['file_name']            = 'favicon_'.uniqid();
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('website_favicon')):
                    $uploadData                 = $this->upload->data();                    
                    $file_name                  = $uploadData['file_name'];
                    $file_ext                   = $uploadData['file_ext'];

                    $data['value']              = $file_name;
                    $this->db->where('title' , 'favicon');
                    $this->db->update('config' , $data);
                    $this->session->set_flashdata('success', trans('setting_update_success')); 
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());                
                endif;
            endif;
            
            redirect($this->agent->referrer());
        }

            $data['page_name']      = 'logo_setting';
            $data['page_title']     = trans('logo_setting');
            $this->load->view('admin/index', $data);
    }

    //footer setting
    function footer_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '19');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();
            $data['value'] = $this->input->post('footer1_title');
            $this->db->where('title' , 'footer1_title');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('footer1_content');
            $this->db->where('title' , 'footer1_content');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('footer2_title');
            $this->db->where('title' , 'footer2_title');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('footer2_content');
            $this->db->where('title' , 'footer2_content');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('footer3_title');
            $this->db->where('title' , 'footer3_title');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('footer3_content');
            $this->db->where('title' , 'footer3_content');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('copyright_text');
            $this->db->where('title' , 'copyright_text');
            $this->db->update('config' , $data);


            $this->session->set_flashdata('success', trans('setting_update_success')); 
            redirect($this->agent->referrer());
        }

            $data['page_name']      = 'footer_setting';
            $data['page_title']     = trans('footer_setting');
            $this->load->view('admin/index', $data);
    }
    //seo setting
    function seo_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '20');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();
            $data['value'] = $this->input->post('author');
            $this->db->where('title' , 'author');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('home_page_seo_title');
            $this->db->where('title' , 'home_page_seo_title');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('focus_keyword');
            $this->db->where('title' , 'focus_keyword');
            $this->db->update('config' , $data);


            $data['value'] = $this->input->post('meta_description');
            $this->db->where('title' , 'meta_description');
            $this->db->update('config' , $data);


            // movie page
            $data['value'] = $this->input->post('movie_page_seo_title');
            $this->db->where('title' , 'movie_page_seo_title');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('movie_page_focus_keyword');
            $this->db->where('title' , 'movie_page_focus_keyword');
            $this->db->update('config' , $data);


            $data['value'] = $this->input->post('movie_page_meta_description');
            $this->db->where('title' , 'movie_page_meta_description');
            $this->db->update('config' , $data);


            $data['value'] = $this->input->post('google_analytics_id');
            $this->db->where('title' , 'google_analytics_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('blog_title');
             $this->db->where('title' , 'blog_title');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('blog_meta_description');
             $this->db->where('title' , 'blog_meta_description');
             $this->db->update('config' , $data);

             $data['value'] = $this->input->post('blog_keyword');
             $this->db->where('title' , 'blog_keyword');
             $this->db->update('config' , $data);

            $data['value'] = $this->input->post('social_share_enable');
            $this->db->where('title' , 'social_share_enable');
            $this->db->update('config' , $data);            

            $data['value'] = $this->input->post('facebook_url');
            $this->db->where('title' , 'facebook_url');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('twitter_url');
            $this->db->where('title' , 'twitter_url');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('linkedin_url');
            $this->db->where('title' , 'linkedin_url');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('vimeo_url');
            $this->db->where('title' , 'vimeo_url');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('youtube_url');
            $this->db->where('title' , 'youtube_url');
            $this->db->update('config' , $data);

            // tv series
            $data['value'] = $this->input->post('tv_series_title');
            $this->db->where('title' , 'tv_series_title');
            $this->db->update('config' , $data);
             
            $data['value'] = $this->input->post('tv_series_keyword');
            $this->db->where('title' , 'tv_series_keyword');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('tv_series_meta_description');
            $this->db->where('title' , 'tv_series_meta_description');
            $this->db->update('config' , $data);

            // live tv
            $data['value'] = $this->input->post('live_tv_title');
            $this->db->where('title' , 'live_tv_title');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('live_tv_meta_description');
            $this->db->where('title' , 'live_tv_meta_description');
            $this->db->update('config' , $data);
             
            $data['value'] = $this->input->post('live_tv_keyword');
            $this->db->where('title' , 'live_tv_keyword');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', trans('setting_update_success')); 
            redirect($this->agent->referrer());
        }

            $data['page_name']      = 'seo_setting';
            $data['page_title']     = trans('seo_setting');
            $this->load->view('admin/index', $data);
    }


    //copyright_privacy setting
    function copyright_privacy($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '350');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();
            $privacy_policy_to_primary_menu = $this->input->post('privacy_policy_to_primary_menu');
            if($privacy_policy_to_primary_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'privacy_policy_to_primary_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'privacy_policy_to_primary_menu');
                 $this->db->update('config' , $data);
            endif;

            $privacy_policy_to_footer_menu = $this->input->post('privacy_policy_to_footer_menu');
            if($privacy_policy_to_footer_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'privacy_policy_to_footer_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'privacy_policy_to_footer_menu');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('privacy_policy_content');
            $this->db->where('title' , 'privacy_policy_content');
            $this->db->update('config' , $data);


            $dmca_to_primary_menu = $this->input->post('dmca_to_primary_menu');
            if($dmca_to_primary_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'dmca_to_primary_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'dmca_to_primary_menu');
                 $this->db->update('config' , $data);
            endif;

            $dmca_to_footer_menu = $this->input->post('dmca_to_footer_menu');
            if($dmca_to_footer_menu =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'dmca_to_footer_menu');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'dmca_to_footer_menu');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('dmca_content');
            $this->db->where('title' , 'dmca_content');
            $this->db->update('config' , $data);



            $disclaimer_text_enable = $this->input->post('disclaimer_text_enable');
            if($disclaimer_text_enable =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'disclaimer_text_enable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'disclaimer_text_enable');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('disclaimer_text');
            $this->db->where('title' , 'disclaimer_text');
            $this->db->update('config' , $data);

            

            $this->session->set_flashdata('success', trans('setting_update_success')); 
            redirect($this->agent->referrer());
        }
        $data['page_name']      = 'copyright_privacy';
        $data['page_title']     = trans('copyright_privacy');
        $this->load->view('admin/index', $data);
    }

    function push_notification_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '36');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();
            $data['value'] = $this->input->post('push_notification_enable');
            $this->db->where('title' , 'push_notification_enable');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('onesignal_appid');
            $this->db->where('title' , 'onesignal_appid');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('onesignal_api_keys');
            $this->db->where('title' , 'onesignal_api_keys');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('onesignal_actionmessage');
            $this->db->where('title' , 'onesignal_actionmessage');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('onesignal_acceptbuttontext');
            $this->db->where('title' , 'onesignal_acceptbuttontext');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('onesignal_cancelbuttontext');
            $this->db->where('title' , 'onesignal_cancelbuttontext');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', trans('setting_update_success')); 
            redirect($this->agent->referrer());
        }
        $data['page_name']      = 'push_notification_setting';
        $data['page_title']     = trans('push_notification_setting');
        $this->load->view('admin/index', $data);
    }

    function send_web_notification($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            // active menu session
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '371');
            /* end menu active/inactive section*/

        if ($param1 == 'send') {
            demo_check();
            $data['message']            = $this->input->post("message");
            $data['url']                = $this->input->post("url");
            $data['headings']           = $this->input->post("headings");
            $data['icon']               = $this->input->post("icon");         
            $data['img']                = $this->input->post("img");
            $this->load->model('notify_model');
            $this->notify_model->send_web_notification($data);
            $this->session->set_flashdata('success', trans('notification_send_success'));
            redirect($this->agent->referrer());
        }
        $data['page_name']              = 'send_web_notification';
        $data['page_title']             = trans('send_web_notification');
        $this->load->view('admin/index', $data);
    }

    function send_movie_tvseries_notification($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            // active menu session
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '370');
            /* end menu active/inactive section*/

        if ($param1 == 'send'):
            demo_check();
            $videos_id                  = $this->input->post("videos_id");
            if(!empty($videos_id) && $videos_id !='' && $videos_id !=NULL && is_numeric($videos_id)):
                $verify                 = $this->common_model->verify_movie_tvseries_id($videos_id);
                if($verify):
                    $data['message']    = $this->input->post("message");
                    $data['headings']   = $this->input->post("headings");
                    $data['icon']       = $this->input->post("icon");         
                    $data['img']        = $this->input->post("img");
                    $data['id']         = $videos_id;
                    $this->load->model('notify_model');
                    $this->notify_model->send_movie_tvseries_notification($data);
                    $this->session->set_flashdata('success', trans('notification_send_success'));                    
                else:
                $this->session->set_flashdata('error', 'Movie ID not found.');
                endif;
            else:
                $this->session->set_flashdata('error', 'Invalid movie ID');
            endif;
            redirect($this->agent->referrer());
        endif;
        $data['page_name']      = 'send_movie_tvseries_notification';
        $data['page_title']     = trans('send_movie_tvseries_notification');
        $this->load->view('admin/index', $data);
    }

    function send_live_tv_notification($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            // active menu session
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '37');
            /* end menu active/inactive section*/

        if ($param1 == 'send'):
            demo_check();
            $live_tv_id                  = $this->input->post("live_tv_id");
            if(!empty($live_tv_id) && $live_tv_id !='' && $live_tv_id !=NULL && is_numeric($live_tv_id)):
                $verify                 = $this->common_model->verify_live_tv_id($live_tv_id);
                if($verify):
                    $data['message']    = $this->input->post("message");
                    $data['headings']   = $this->input->post("headings");
                    $data['icon']       = $this->input->post("icon");         
                    $data['img']        = $this->input->post("img");
                    $data['id']         = $live_tv_id;
                    $this->load->model('notify_model');
                    $this->notify_model->send_live_tv_notification($data);
                    $this->session->set_flashdata('success', trans('notification_send_success'));                   
                else:
                $this->session->set_flashdata('error', trans('movie_id_not_found'));
                endif;
            else:
                $this->session->set_flashdata('error', trans('invalid_movie_id'));
            endif;
            redirect($this->agent->referrer());
        endif;
        $data['page_name']      = 'send_live_tv_notification';
        $data['page_title']     = trans('send_live_tv_notification');
        $this->load->view('admin/index', $data);
    }

    function send_movie_notification($type='',$videos_id = '',$param2=''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '37');
            /* end menu active/inactive section*/
        demo_check();
        if(!empty($videos_id) && $videos_id !='' && $videos_id !=NULL && is_numeric($videos_id)):
            $verify                 = $this->common_model->verify_movie_tvseries_id($videos_id);
            if($verify):
                if($type == 'email'):
                    $this->load->model('email_model');
                    $this->email_model->create_newslater_cron($videos_id);
                    $this->session->set_flashdata('success', trans('newsletter_send_success')); 
                else:
                    $this->load->model('notify_model');
                    $this->notify_model->send_push_notification($videos_id);
                    $this->session->set_flashdata('success', trans('notification_send_success')); 
                endif;
            else:
                $this->session->set_flashdata('error', trans('movie_id_not_found'));
            endif;
        else:
            $this->session->set_flashdata('error', trans('invalid_movie_id'));
        endif;
        if($param2 == 'tv'):
            redirect($this->agent->referrer());
        else:
            redirect($this->agent->referrer());
        endif;
    }

    //seo setting
    function social_login_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '22');
            /* end menu active/inactive section*/

        if ($param1 == 'update_facebook') {
            demo_check();
            $facebook_login_enable = $this->input->post('facebook_login_enable');
            if($facebook_login_enable ==''){
                $data['value'] = '0';
            }else{
               $data['value'] = $facebook_login_enable;
            }
            $this->db->where('title' , 'facebook_login_enable');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('facebook_app_id');
            $this->db->where('title' , 'facebook_app_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('facebook_app_secret');
            $this->db->where('title' , 'facebook_app_secret');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('facebook_graph_version');
            $this->db->where('title' , 'facebook_graph_version');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', trans('setting_update_success')); 
            redirect($this->agent->referrer());
        }
        if ($param1 == 'update_google') {
            demo_check();
            $google_login_enable = $this->input->post('google_login_enable');
            if($google_login_enable ==''){
                $data['value'] = '0';
            }else{
               $data['value'] = $google_login_enable;
            }
            $this->db->where('title' , 'google_login_enable');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('google_application_name');
            $this->db->where('title' , 'google_application_name');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('google_client_id');
            $this->db->where('title' , 'google_client_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('google_client_secret');
            $this->db->where('title' , 'google_client_secret');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('google_redirect_uri');
            $this->db->where('title' , 'google_redirect_uri');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', trans('setting_update_success')); 
            redirect($this->agent->referrer());
        }
        $data['page_name']      = 'social_login_setting';
        $data['page_title']     = trans('social_login_setting');
        $this->load->view('admin/index', $data);
    }

    //tmdb setting
    function tmdb_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '80');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();
            $data['value'] = $this->input->post('tmbd_api_key');
            $this->db->where('title' , 'tmbd_api_key');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('tmdb_language');
            $this->db->where('title' , 'tmdb_language');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('tmdb_image_import_by_cron');
            $this->db->where('title' , 'tmdb_image_import_by_cron');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', trans('update_success'));
            redirect($this->agent->referrer());
        }
        $data['page_name']      = 'tmdb_setting';
        $data['page_title']     = trans('tmdb_setting');
        $this->load->view('admin/index', $data);
    }


    //ads setting
    function ad_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '21');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();
            $ads_type = $this->input->post('ads_type');
            if($ads_type =='0'){
                $data['enable']     = '0';
                $this->db->where('ads_id' , $param2);
                $this->db->update('ads' , $data);
            }
            else{
                if ($ads_type=='image') {
                    //$data['ads_image_url']         = base_url().'uploads/no_image.jpg';
                    if(isset($_FILES['ads_image']) && $_FILES['ads_image']['name']!=''){
                        move_uploaded_file($_FILES['ads_image']['tmp_name'], 'uploads/ads/'.$param2.'.jpg');
                        $data['ads_image_url']     = base_url().'uploads/ads/'.$param2.'.jpg';
                    }
                    if($this->input->post('ads_image_url')!=''){                
                        $data['ads_image_url']  = $this->input->post('ads_image_url');
                    }
                    if($this->input->post('ads_url')!=''){                
                        $data['ads_url']  = $this->input->post('ads_url');
                    }
                    $data['enable']     = '1';
                    $data['ads_type']   = 'image';
                    $this->db->where('ads_id' , $param2);
                    $this->db->update('ads' , $data);
                }else if ($ads_type=='code') {
                    $data['enable']     = '1';
                    $data['ads_type']   = 'code';                   
                    $data['ads_code']   = $this->input->post('ads_code');
                    $this->db->where('ads_id' , $param2);
                    $this->db->update('ads' , $data);
                }else{
                    $data['enable']     = '0';
                    $this->db->where('ads_id' , $param2);
                    $this->db->update('ads' , $data);
                }
            }
			$this->session->set_flashdata('success', trans('setting_update_success')); 
            redirect($this->agent->referrer());
        }
        if($param1=="edit"){
            $data['ads_info']    = $this->common_model->get_single_ads($param2);
            $data['page_name']      = 'ad_edit';
            $data['ads_id']         = $param2;
            $data['page_title']     = 'Edit Ads';
            $this->load->view('admin/index', $data);
        }else{
            $data['page_name']      = 'ad_setting';
            $data['page_title']     = trans('ad_setting');
            $this->load->view('admin/index', $data);
        }        
	}

    function test_mail(){
        demo_check();
        $email  =    $this->input->post('email');
        if($email !=''){
            $this->load->model('email_model');
            if($this->email_model->test_mail($email)){
                $this->session->set_flashdata('success', trans('mail_setup_perfect'));
                redirect($this->agent->referrer());
            }else{
                $this->session->set_flashdata('error', trans('mail_setup_error'));
                redirect($this->agent->referrer());
            }
        }        
        $this->session->set_flashdata('error', trans('enter_valid_email'));
        redirect($this->agent->referrer());
        
    }

	// database backup and restore management
    function backup_restore($operation = '', $type = ''){

        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '23');
            /* end menu active/inactive section*/   
        
        if ($operation == 'create') {
            demo_check();
            $this->common_model->create_backup();
            $this->session->set_flashdata('success', trans('backup_created'));
            redirect($this->agent->referrer());
        }
        if ($operation == 'download') {
            demo_check();
            $this->load->helper('download');
            $file = FCPATH.'db_backup/'.$type;
            force_download($file,NULL);
        }
        if ($operation == 'delete') {
            demo_check();
            $this->load->helper('file');
            $path_to_file = 'db_backup/'.$type;
            if(unlink($path_to_file)) {
                $this->session->set_flashdata('success', trans('deleted'));
                redirect($this->agent->referrer());
            }
            else {
                $this->session->set_flashdata('error', trans('file_not_found'));
                redirect($this->agent->referrer());
            }
        }
        if ($operation == 'restore') {
            demo_check();
            $this->common_model->restore_backup();
            $this->session->set_flashdata('success', trans('backup_restored'));
            redirect($this->agent->referrer());
        }
        
            $data['page_info']  = 'Create backup / restore from backup';
            $data['page_name']  = 'backup_restore';
            $data['page_title'] = trans('backup_restore');
            $this->load->view('admin/index', $data);
    }

    function view_modal($page_name = '' , $param2 = '' , $param3 = '', $param4 = ''){
            $account_type       =   $this->session->userdata('login_type');
            $data['genres']      = $this->db->get('genre')->result_array();

            $data['param2']     =   $param2;
            $data['param3']     =   $param3;
            $data['param4']     =   $param4;
            $this->load->view('admin/'.$page_name.'.php' ,$data);        
        
    }

    //profile
	function manage_profile(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '12');
            /* end menu active/inactive section*/
            $data['page_name']      = 'manage_profile';
            $data['page_title']     = trans('manage_profile');
            $data['profile_info']   = $this->db->get_where('user', array(
            'user_id' => $this->session->userdata('user_id')))->result_array();
            $this->load->view('admin/index', $data);
    }

    // profile
    function profile($param1 = '', $param2 = '', $param3 = ''){
        /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '12');
            /* end menu active/inactive section*/
            $user_id=$this->session->userdata('user_id');
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($param1 == 'update') {
            demo_check();
            $data['name']  = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            
            $this->db->where('user_id', $user_id);
            $this->db->update('user', $data);
            $this->common_model->clear_cache();
            move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/user_image/' .$user_id.'.jpg');
            $this->common_model->clear_cache();
            $this->session->set_flashdata('success', trans('profile_info_updated'));
            redirect($this->agent->referrer());
        }
        if ($param1 == 'change_password'){
            demo_check();
            $password               = md5($this->input->post('password'));
            $new_password           = md5($this->input->post('new_password'));
            $retype_new_password    = md5($this->input->post('retype_new_password'));
            
            $current_password       = $this->db->get_where('user', array(
                'user_id' => $this->session->userdata('user_id')
            ))->row()->password;
            
            if ($current_password == $password && $new_password == $retype_new_password) {
                $this->db->where('user_id', $this->session->userdata('user_id'));
                $this->db->update('user', array(
                    'password' => $new_password
                ));
                $this->session->set_flashdata('success', trans('password_changed'));
            }
            elseif ($current_password !=$password ){
                $this->session->set_flashdata('error', trans('old_password_wrong'));

            } else {
                $this->session->set_flashdata('error', trans('password_not_match'));
            }
            redirect($this->agent->referrer());
        }
    }

    //universal delete function
    function delete_record(){
        $response           = array();
        if(is_demo()):
            $response['status']  = 'error';
            $response['message'] = 'Action not allow on demo';
        else:
            $row_id             = $this->input->post('row_id');
            $table_name         = $this->input->post('table_name');
            if($table_name == 'homepage_sections'):
                $table_row_id       ='id';
            else:
                $table_row_id       =$table_name.'_id';
            endif;
            $this->db->where($table_row_id , $row_id);
            $query=$this->db->delete($table_name);
            if($query==true):
                $response['status']  = 'success';
                $response['message'] = trans('delete_success');
            else:
                $response['status']  = 'error';
                $response['message'] = trans('delete_fail');
            endif;
        endif;
        echo json_encode($response);        
    }

    //universal delete function
    function update_status(){
        $response               = array();
        if(is_demo()):
            $response['status']  = 'error';
            $response['message'] = 'Action not allow on demo';
        else:
            $table                  = $this->input->post('table');
            $primary_key            = $this->input->post('primary_key');
            $primary_key_value      = $this->input->post('primary_key_value');
            $column                 = $this->input->post('column');
            $value                  = $this->input->post('value');
            $table_name             = $this->input->post('table_name');
            //table exist
            if ($this->db->table_exists($table)):
                //column exist
                if ($this->db->field_exists($column, $table)):
                    //row exist
                    if($this->db->get_where($table,array($primary_key => $primary_key_value))->num_rows() >0):
                        $data[$column] = $value;
                        $this->db->where($primary_key,$primary_key_value);
                        if($this->db->update($table,$data)):
                            $response['status']  = 'success';
                            $response['message'] = trans('update_success');
                        else:
                            $response['status']  = 'error';
                            $response['message'] = trans('update_fail');
                        endif;
                    else:
                        $response['status']  = 'error';
                        $response['message'] = trans('row_not_found');
                    endif;
                else:
                    $response['status']  = 'error';
                    $response['message'] = trans('column_not_found');
                endif;
            else:
                $response['status']  = 'error';
                $response['message'] = trans('table_not_found');
            endif;
        endif;
        echo json_encode($response);
    }

    //complete import function
    function complete_import(){
        $response                   = array();
        if(is_demo()):
            $response['status']  = 'error';
            $response['message'] = 'Action not allow on demo';
        else:
            $id                         =   trim($_POST["tmdb_id"]);
            $from                       =   $_POST["to"];
            $this->load->model('tmdb_model');
            if($from=='tv'){
                $result = $this->tmdb_model->import_tvseries_info($id);
            }else{
                $result = $this->tmdb_model->import_movie_info($id);
            }
            if($result):
                $response['status']         = 'success';
                $response['message']        = trans('import_success');
            else:
                $response['status']         = 'error';
                $response['message']        = trans('import_fail');
            endif;
        endif;
        echo json_encode($response);        
    }  

    //imdb import
    function import_movie(){
        $response                   = array();        
        $id                         = trim($this->input->post("id"));
        $from                       = $this->input->post("from");
        $lang                       = $this->input->post("lang");
        
        // $id = 464052;
        // $from ='movie';
        // $lang = 'en';
        $response['submitted_data'] = $_POST;
        $this->load->model('tmdb_model');
        if($from=='tv'){
            $data = $this->tmdb_model->get_tvseries_info($id,$lang);            
        }else{
            $data = $this->tmdb_model->get_movie_info($id,$lang);            
        }
        //var_dump($data);      
        if(isset($data['status']) && $data['status']=='success'){
            $response['imdb_status']    = 'success';
            $response['imdbid']         = $data['imdbid'];
            $response['title']          = $data['title'];
            $response['plot']           = $data['plot'];
            $response['runtime']        = $data['runtime'];
            $response['actor']          = $this->common_model->get_star_ids_for_movie_import('actor',$data['actor']);
            $response['director']       = $this->common_model->get_star_ids_for_movie_import('director',$data['director']);
            $response['writer']         = $this->common_model->get_star_ids_for_movie_import('writer',$data['writer']);
            $response['country']        = $this->country_model->get_country_ids($data['country']);
            $response['genre']          = $this->genre_model->get_genre_ids($data['genre']);
            $response['rating']         = $data['rating'];
            $response['release']        = $data['release'];
            $response['thumbnail']      = $data['thumbnail'];
            $response['poster']         = $data['poster'];
            $response['trailler_youtube_source']         = $data['trailler_youtube_source'];
            $response['response']       = 'yes';
        }
        else{
            $response['imdb_status']    = 'fail';
            $response['title']          = '';
            $response['plot']           = '';
            $response['runtime']        = '';
            $response['actor']          = '';
            $response['director']       = '';
            $response['writer']         = '';
            $response['country']        = '';
            $response['genre']          = '';
            $response['rating']         = '';
            $response['release']        = '';
            $response['thumbnail']      = '';
            $response['poster']         = '';
            $response['response']       = 'no';
        }
        echo json_encode($response);
    }

    function fetch_actor_from_tmdb(){
        demo_check();
        $response                   = array();        
        $id                         =   trim($_POST["id"]);
        $from                       =   $_POST["from"];
        $response['submitted_data'] = $_POST;
        $this->load->model('tmdb_model');
        if($from=='tv'){
            $data = $this->tmdb_model->get_tvshow_actor_info($id);
        }else{
            $data = $this->tmdb_model->get_movie_actor_info($id);
        }
        $this->session->set_flashdata('success', $data.' '.trans('start_imported'));
        redirect($this->agent->referrer());
    }

    function download_link(){
        demo_check();

        $this->form_validation->set_rules('videos_id', 'videos_id', 'required');
        $this->form_validation->set_rules('link_title', 'Link Title', 'required|min_length[2]');
        $this->form_validation->set_rules('file_size', 'File Size', 'required|min_length[2]');
        $this->form_validation->set_rules('resolution', 'Resolution', 'required|min_length[2]');
        $this->form_validation->set_rules('in_app_download', 'Download Type', 'required');
        $this->form_validation->set_rules('download_url', 'Download URL', 'required');
        if ($this->form_validation->run() == FALSE):
            $this->session->set_flashdata('error',strip_tags(json_encode(validation_errors())));
        else:
            $data['videos_id']          = $this->input->post("videos_id");            
            $data['link_title']         = $this->input->post("link_title");
            $data['file_size']          = $this->input->post("file_size");
            $data['resolution']         = $this->input->post("resolution");
            $data['download_url']       = $this->input->post("download_url");
            $data['in_app_download']    = $this->input->post("in_app_download");
            $this->db->insert('download_link',$data);
            $this->session->set_flashdata('success', trans("add_success"));
        endif;
        redirect($this->agent->referrer());
    }
    function video_file(){
        $response = array();
        $file_data['videos_id']         = $_POST["videos_id"];            
        $file_data['file_source']       = $_POST["type"];
        $file_data['file_url']          = $_POST["url"];
        $file_data['source_type']       = 'link';
        $file_data['stream_key']        = $this->generate_random_string();
        $this->db->insert('video_file', $file_data);
        $response['row_id']             = $this->db->insert_id();
        $response['post_status']        = "success";
        $response['type']               = $_POST["type"];
        $response['url']                = $_POST["url"];         
        $response['watch_url']          = base_url('watch/').$this->common_model->get_slug_by_videos_id($_POST["videos_id"]).'.html?key='.$file_data['stream_key'];         
        echo json_encode($response);    
    }

    function episodes_url(){
        $response                       = array();
        $datetime                       = date("Y-m-d H:i:s");
        $file_data['videos_id']         = $_POST["videos_id"];
        $file_data['seasons_id']        = $_POST["seasons_id"];
        $file_data['episodes_name']     = $_POST["episodes_name"];            
        $file_data['file_source']       = $_POST["type"];
        $file_data['file_url']          = $_POST["url"];
        $file_data['date_added']        = $datetime;
        $file_data['stream_key']        = $this->generate_random_string();
        $file_data['source_type']       = 'link';
        $this->db->insert('episodes', $file_data);
        $response['row_id']             = $this->db->insert_id();
        $response['post_status']        = "success";
        $response['type']               = $_POST["type"];
        $response['url']                = $_POST["url"];         
        $response['episodes_name']      = $_POST["episodes_name"];

        // update videos
        $videos_data['last_ep_added']   = $datetime;
        $this->db->where('videos_id',$_POST["videos_id"]);
        $this->db->update('videos',$videos_data);

        echo json_encode($response);    
    }
    // rating
    function rating(){
        $response                   = array();            
        $rate                       = $_POST["rate"];
        $video_id                   = $_POST["video_id"];
        $post_status                = $this->post_rating( $rate , $video_id);
        $response['post_status']    = $post_status; 
        $response['rate']           = $rate; 
        $response['video_id']       = $video_id; 
        echo json_encode($response);    
    }
    // post rating
    function post_rating( $rate , $video_id){

        $ip=$_SERVER['REMOTE_ADDR'];

        $verify_data = array(
                            'video_id'      => $video_id,                             
                            'ip'            => $ip                                                    
                            );

        $data = array(
                      'video_id'            => $video_id,
                      'rating'              => $rate,                             
                       'ip'                 => $ip                                                   
                    );

        $query = $this->db->get_where('rating' , $verify_data);        
            $rating = $query->result_array();
            $num_row = $query->num_rows();
            if($num_row>0){        
                $this->db->where($verify_data);
				$this->db->update('rating', $data);
			}
            else{                
                $this->db->insert('rating', $data);
                $current_rating =$this->db->get_where('videos' , array('videos_id'=>$video_id))->row()->total_rating;
				$rating=$current_rating+1;
				$this->db->where('videos_id', $video_id);
				$this->db->update('videos', array('total_rating' => $rating));                
            }
           return "success"; 
        }

        //movie importer
    function movie_importer(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '7');
        /* end menu active/inactive section*/
        $data['page_name']  = 'movie_importer';
        $data['page_title'] = 'Movie Search & Import';
        $type               = $this->input->post('type');
        $page               = $this->input->post('page');
        $year               = $this->input->post('year');
        if(!empty($type) && $type !=NULL):
            $this->load->model('tmdb_model');
            if($type =="movies_by_title"):
                $search_data    = $this->tmdb_model->get_movies_by_title($this->input->post('title'));
                $content_type   = "movie";
            elseif($type =="popular_movies"):
                $search_data    = $this->tmdb_model->get_popular_movies($page);
                $content_type   = "movie";
            elseif($type =="top_rated_movies"):
                $search_data    = $this->tmdb_model->get_top_rated_movies($page);
                $content_type   = "movie";
            elseif($type =="upcoming_movies"):
                $search_data    = $this->tmdb_model->get_upcoming_movies($page);
                $content_type   = "movie";
            elseif($type =="movies_by_year"):
                $search_data    = $this->tmdb_model->get_movies_by_year($year,$page);
                $content_type   = "movie";
            elseif($type =="tvshows_by_title"):
                $search_data    = $this->tmdb_model->get_tvshows_by_title($this->input->post('title'));
                $content_type   = "tvshow";
            elseif($type =="popular_tvshows"):
                $search_data    = $this->tmdb_model->get_popular_tvshows($page);
                $content_type   = "tvshow";
            elseif($type =="top_rated_tvshows"):
                $search_data    = $this->tmdb_model->get_top_rated_tvshows($page);
                $content_type   = "tvshow";
            elseif($type =="upcoming_tvshows"):
                $search_data    = $this->tmdb_model->get_upcoming_tvshows($page);
                $content_type   = "tvshow";
            elseif($type =="tvshows_by_year"):
                $search_data    = $this->tmdb_model->get_tvshows_by_year($year,$page);
                $content_type   = "tvshow";
            endif;
            if(isset($search_data['error_message'])):
                $data['error_message'] = $search_data['error_message'];
            else:
                $data['movies'] = $search_data;
            endif;
            $data['title']          = $this->input->post('title');
            $data['content_type']   = $content_type;
            $data['type']           = $type;
            $data['page']           = $page;
            $data['year']           = $year;
        endif;
        $this->load->view('admin/index', $data);
    }
    


    function cron_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '78');
        /* end menu active/inactive section*/

        if($param1=='update'):
            demo_check();
            $data['value'] = $this->input->post('cron_key');
            $this->db->where('title' , 'cron_key');
            $this->db->update('config' , $data);
             // db backup on/off
             $backup_schedule = $this->input->post('backup_schedule');
             if($backup_schedule =='1'):
                $data['value'] = '1';
                $this->db->where('title' , 'backup_schedule');
                $this->db->update('config' , $data);
            elseif($backup_schedule =='7'):
                $data['value'] = '7';
                $this->db->where('title' , 'backup_schedule');
                $this->db->update('config' , $data);
            else:
                $data['value'] = '30';
                $this->db->where('title' , 'backup_schedule');
                $this->db->update('config' , $data);
            endif;

             $db_backup = $this->input->post('db_backup');
            if($db_backup =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'db_backup');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'db_backup');
                 $this->db->update('config' , $data);
            endif;
            $this->session->set_flashdata('success', trans('cron_setting_success'));
            redirect($this->agent->referrer());
        endif;

        $data['page_name']  = 'manage_cron';
        $data['page_title'] = trans('cron_setting');
        $this->load->view('admin/index', $data);
    }

    public function movie_upload(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');

        demo_check();

        $videos_id                  = $this->input->post('videos_id');
        $label                      = $this->input->post('label');
        $order                      = $this->input->post('order');
        $source                     = $this->input->post('source');
        // validation rule
        $this->form_validation->set_rules('videos_id', trans('video_id'), 'trim|required');
        $this->form_validation->set_rules('label', trans('episode_name'), 'trim|required');
        $this->form_validation->set_rules('source', trans('source'), 'trim|required');

        //  data
        $data['videos_id']      = $videos_id;
        $data['label']          = $label;
        $data['order']          = $order;
        $data['stream_key']     = $this->generate_random_string();
        $insert_status          = FALSE;

        if($source == 'upload'):
            if($this->form_validation->run() == FALSE):
                $this->session->set_flashdata('error', validation_errors());
            else:
                //upload configuration
                $NewFileName                = $videos_id.'-'.uniqid(); //new file name
                $config['upload_path']      = 'uploads/videos/';
                $config['allowed_types']    = 'mp4|webm|mkv|m3u8';
                $config['file_name']        = $NewFileName;
                $config['max_size']         = 0;
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('videofile')):
                    $uploadData             = $this->upload->data();                    
                    $file_name              = $uploadData['file_name'];
                    $file_ext               = $uploadData['file_ext'];
                    $file_ext               = str_replace('.','',$file_ext); 

                    $data['file_source']    = $file_ext;
                    $data['source_type']    = 'upload';                    
                    $data['file_url']       = base_url().'uploads/videos/'.$file_name;
                    
                    $this->db->insert('video_file', $data);
                    $insert_id              = $this->db->insert_id();
                    $insert_status          = TRUE;
                    $this->session->set_flashdata('success', trans('video_add_success'));
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    
                endif;
            endif;
        else:            
            $data['file_source']       = $source;
            $data['file_url']          = $this->input->post('url');
            $data['source_type']       = 'link';
            $this->form_validation->set_rules('url', trans('url'), 'trim|required');
            if($this->form_validation->run() == FALSE):
                $this->session->set_flashdata('error', validation_errors());
            else:
                $this->db->insert('video_file', $data);
                $insert_id              = $this->db->insert_id();
                $insert_status          = TRUE;
                $this->session->set_flashdata('success', trans('video_add_success'));
            endif;
        endif;
        redirect($this->agent->referrer());
    }
    public function movie_file_update($video_file_id=""){
        demo_check();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');

        $videos_id                  = $this->input->post('videos_id');
        $label                      = $this->input->post('label');
        $order                      = $this->input->post('order');
        $source                     = $this->input->post('source');
        // validation rule
        $this->form_validation->set_rules('videos_id', trans('video_id'), 'trim|required');
        $this->form_validation->set_rules('label', trans('episode_name'), 'trim|required');
        $this->form_validation->set_rules('source', trans('source'), 'trim|required');

        //  data
        $data['videos_id']      = $videos_id;
        $data['label']          = $label;
        $data['order']          = $order;

        if($source == 'upload'):
            if($this->form_validation->run() == FALSE):
                $this->session->set_flashdata('error', validation_errors());
            else:
                //upload configuration
                $NewFileName                = $videos_id.'-'.uniqid(); //new file name
                $config['upload_path']      = 'uploads/videos/';
                $config['allowed_types']    = 'mp4|webm|mkv|m3u8';
                $config['file_name']        = $NewFileName;
                $config['max_size']         = 0;
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('videofile')):
                    $uploadData             = $this->upload->data();                    
                    $file_name              = $uploadData['file_name'];
                    $file_ext               = $uploadData['file_ext'];
                    $file_ext               = str_replace('.','',$file_ext); 

                    $data['file_source']    = $file_ext;
                    $data['source_type']    = 'upload';                    
                    $data['file_url']       = base_url().'uploads/videos/'.$file_name;
                    
                    
                    $this->db->where('video_file_id',$video_file_id);
                    $this->db->update('video_file', $data);
                    $this->session->set_flashdata('success', trans('video_update_success'));
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    
                endif;
            endif;
        else:            
            $data['file_source']       = $source;
            $data['file_url']          = $this->input->post('url');
            $data['source_type']       = 'link';
            $this->form_validation->set_rules('url', trans('url'), 'trim|required');
            if($this->form_validation->run() == FALSE):
                $this->session->set_flashdata('error', validation_errors());
            else:
                $this->db->where('video_file_id',$video_file_id);
                $this->db->update('video_file', $data);
                $this->session->set_flashdata('success', trans('video_update_success'));
            endif;
        endif;
        redirect($this->agent->referrer());
    }
    public function episodes_upload(){
        demo_check();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        $videos_id                  = $this->input->post('videos_id');
        $seasons_id                 = $this->input->post('seasons_id');
        $episodes_name              = $this->input->post('episodes_name');
        $order                      = $this->input->post('order');
        $source                     = $this->input->post('source');
        // validation rule
        $this->form_validation->set_rules('videos_id', trans('video_id'), 'trim|required');
        $this->form_validation->set_rules('seasons_id', trans('seasons_id'), 'trim|required');
        $this->form_validation->set_rules('episodes_name', trans('episode_name'), 'trim|required');
        $this->form_validation->set_rules('source', trans('source'), 'trim|required');

        //  data
        $data['videos_id']      = $videos_id;
        $data['seasons_id']     = $seasons_id;
        $data['episodes_name']  = $episodes_name;
        $data['order']          = $order;
        $datetime               = date("Y-m-d H:i:s");
        $data['date_added']     = $datetime;
        $data2['last_ep_added'] = $datetime;
        $data['stream_key']     = $this->generate_random_string();
        $insert_status          = FALSE;

        if($source == 'upload'):
            if($this->form_validation->run() == FALSE):
                $this->session->set_flashdata('error', validation_errors());
            else:
                //upload configuration
                $NewFileName                = $videos_id.'-'.$seasons_id.'-'.uniqid(); //new file name
                $config['upload_path']      = 'uploads/videos/';
                $config['allowed_types']    = 'mp4|webm|mkv|m3u8';
                $config['file_name']        = $NewFileName;
                $config['max_size']         = 0;
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('videofile')):
                    $uploadData             = $this->upload->data();                    
                    $file_name              = $uploadData['file_name'];
                    $file_ext               = $uploadData['file_ext'];
                    $file_ext               = str_replace('.','',$file_ext); 

                    $data['file_source']    = $file_ext;
                    $data['source_type']    = 'upload';                    
                    $data['file_url']       = base_url().'uploads/videos/'.$file_name;
                    
                    $this->db->insert('episodes', $data);
                    $insert_id              = $this->db->insert_id();
                    $insert_status          = TRUE;
                    // update episode update time
                    $this->db->where('videos_id',$videos_id);
                    $this->db->update('videos',$data2);
                    $this->session->set_flashdata('success', trans('episode_add_success'));
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    
                endif;
            endif;
        else:            
            $data['file_source']       = $source;
            $data['file_url']          = $this->input->post('url');
            $data['source_type']       = 'link';
            $this->form_validation->set_rules('url', trans('url'), 'trim|required');
            if($this->form_validation->run() == FALSE):
                $this->session->set_flashdata('error', validation_errors());
            else:
                $this->db->insert('episodes', $data);
                $insert_id              = $this->db->insert_id();
                $insert_status          = TRUE;
                // update episode update time
                $this->db->where('videos_id',$videos_id);
                $this->db->update('videos',$data2);
                $this->session->set_flashdata('success', trans('episode_add_success'));
            endif;
        endif;
        // upload thumbnail
        if (!empty($_FILES['thumbnail']['name'])):
            if($insert_status):                
                $image_name                 = $insert_id.'.jpg';
                $config['upload_path']      = 'uploads/episodes/';
                $config['allowed_types']    = 'jpg|png|jpeg';
                $config['file_name']        = $image_name;
                $config['max_size']         = 0;
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);
                //upload file to directory
                if(!$this->upload->do_upload('thumbnail')):
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                endif;
            endif;
        endif;
        redirect($this->agent->referrer());
    }
    public function episodes_update($episodes_id=""){
        demo_check();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        $videos_id                  = $this->input->post('videos_id');
        $seasons_id                 = $this->input->post('seasons_id');
        $episodes_name              = $this->input->post('episodes_name');
        $order                      = $this->input->post('order');
        $source                     = $this->input->post('source');
        // validation rule
        $this->form_validation->set_rules('videos_id', trans('video_id'), 'trim|required');
        $this->form_validation->set_rules('seasons_id', trans('seasons_id'), 'trim|required');
        $this->form_validation->set_rules('episodes_name', trans('episode_name'), 'trim|required');
        $this->form_validation->set_rules('source', trans('source'), 'trim|required');

        //  data
        $data['videos_id']      = $videos_id;
        $data['seasons_id']     = $seasons_id;
        $data['episodes_name']  = $episodes_name;
        $data['order']          = $order;

        if($source == 'upload'):
            if($this->form_validation->run() == FALSE):
                $this->session->set_flashdata('error', validation_errors());
            else:
                //upload configuration
                $NewFileName                = $videos_id.'-'.$seasons_id.'-'.uniqid(); //new file name
                $config['upload_path']      = 'uploads/videos/';
                $config['allowed_types']    = 'mp4|webm|mkv|m3u8';
                $config['file_name']        = $NewFileName;
                $config['max_size']         = 0;
                //$this->load->library('upload', $config);
                $this->upload->initialize($config);
                //upload file to directory
                if($this->upload->do_upload('videofile')):
                    $uploadData             = $this->upload->data();                    
                    $file_name              = $uploadData['file_name'];
                    $file_ext               = $uploadData['file_ext'];
                    $file_ext               = str_replace('.','',$file_ext); 

                    $data['file_source']    = $file_ext;
                    $data['source_type']    = 'upload';                    
                    $data['file_url']       = base_url().'uploads/videos/'.$file_name;

                    $this->db->where('episodes_id',$episodes_id);                    
                    $this->db->update('episodes', $data);
                    $this->session->set_flashdata('success', trans('episode_update_success'));
                else:
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    
                endif;
            endif;
        else:            
            $data['file_source']       = $source;
            $data['file_url']          = $this->input->post('url');
            $data['source_type']       = 'link';
            $this->form_validation->set_rules('url', trans('url'), 'trim|required');
            if($this->form_validation->run() == FALSE):
                $this->session->set_flashdata('error', validation_errors());
            else:
                $this->db->where('episodes_id',$episodes_id);                    
                $this->db->update('episodes', $data);
                $this->session->set_flashdata('success', trans('episode_update_success'));
            endif;
        endif;
        // upload thumbnail
        if (!empty($_FILES['thumbnail']['name'])):                
            $image_name                 = $episodes_id.'.jpg';
            $config['upload_path']      = 'uploads/episodes/';
            $config['allowed_types']    = 'jpg|png|jpeg';
            $config['file_name']        = $image_name;
            $config['max_size']         = 0;
            $config['overwrite']        = TRUE;
            $this->upload->initialize($config);
            //upload file to directory
            if(!$this->upload->do_upload('thumbnail')):
                $this->session->set_flashdata('error', $this->upload->display_errors());
            endif;
        endif;
        redirect($this->agent->referrer());
    }

    public function load_stars(){
        $q                  = $this->input->get('q');
        $users_arr          = [];
        $this->db->limit(50);
        $this->db->like('star_name',$q,'both');
        $stars          = $this->db->get('star')->result_array();
        foreach( $stars as $star){
            $userid         = $star['star_id'];
            $name           = $star['star_name'];
            $users_arr[]    = ["id" => $userid, "text" => $name];
        }
        echo json_encode($users_arr);
    }

    public function load_movie(){
        $q                          = $this->input->get('q');
        $users_arr                  = [];
        $this->db->limit(50);
        $this->db->where('is_tvseries !=','1');
        $this->db->like('title',$q,'both');
        $stars                      = $this->db->get('videos')->result_array();
        foreach( $stars as $star){
            $videos_id         = $star['videos_id'];
            $title           = $star['title'];
            $users_arr[]    = ["id" => $videos_id, "text" => $title];
        }
        echo json_encode($users_arr);
    }

    public function load_tvseries(){
        $q                          = $this->input->get('q');
        $users_arr                  = [];
        $this->db->limit(50);
        $this->db->where('is_tvseries','1');
        $this->db->like('title',$q,'both');
        $stars                      = $this->db->get('videos')->result_array();
        foreach( $stars as $star){
            $videos_id         = $star['videos_id'];
            $title           = $star['title'];
            $users_arr[]    = ["id" => $videos_id, "text" => $title];
        }
        echo json_encode($users_arr);
    }

    public function load_tv_channel(){
        $q                          = $this->input->get('q');
        $users_arr                  = [];
        $this->db->limit(50);
        $this->db->where('is_tvseries','1');
        $this->db->like('title',$q,'both');
        $stars                      = $this->db->get('videos')->result_array();
        foreach( $stars as $star){
            $videos_id         = $star['videos_id'];
            $title           = $star['title'];
            $users_arr[]    = ["id" => $videos_id, "text" => $title];
        }
        echo json_encode($users_arr);
    }

    function generate_random_string($length=12) {
      $str = "";
        $characters = array_merge(range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    function generate_random_password($length=12) {
      $str                  = "";
        $characters         = array_merge(range('a','z'), range('0','9'),range('~','|'));
        $max                = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    function regenerate_stream_key($length=12) {
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');

        $video_files = $this->db->get('video_file')->result_array();
        foreach ($video_files as $video_file):
            $data['stream_key'] = $this->generate_random_string();
            $this->db->where('video_file_id',$video_file['video_file_id']);
            $this->db->update('video_file', $data);
        endforeach;
        $episodes = $this->db->get('episodes')->result_array();
        foreach ($episodes as $episode):
            $data['stream_key'] = $this->generate_random_string();
            $this->db->where('episodes_id',$episode['episodes_id']);
            $this->db->update('episodes', $data);
        endforeach;
        redirect($this->agent->referrer());
    }

    function texti(){
        $id="60708";
        $this->load->model('tmdb_model');
        $result = $this->tmdb_model->import_tvseries_info($id);
        var_dump($result);
    }

    function admob_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '79');

        if($param1=='update'):
            demo_check();
            $admob_ads_enable = $this->input->post('admob_ads_enable');
            if($admob_ads_enable =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'admob_ads_enable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'admob_ads_enable');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('admob_publisher_id');
            $this->db->where('title' , 'admob_publisher_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_app_id');
            $this->db->where('title' , 'admob_app_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_banner_ads_id');
            $this->db->where('title' , 'admob_banner_ads_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_interstitial_ads_id');
            $this->db->where('title' , 'admob_interstitial_ads_id');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', trans('admob_setting_change'));
            redirect($this->agent->referrer());
        endif;
        $data['page_name']  = 'admob_setting';
        $data['page_title'] = trans('admob_setting');
        $this->load->view('admin/index', $data);
    }

    function mobile_ads_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '79');

        if($param1=='update'):
            demo_check();

            $data['value'] = $this->input->post('reward_ad');
            $this->db->where('title' , 'reward_ad');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('reward_ad_id');
            $this->db->where('title' , 'reward_ad_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('banner_ad');
            $this->db->where('title' , 'banner_ad');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('banner_ad_id');
            $this->db->where('title' , 'banner_ad_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('interstitial_ad');
            $this->db->where('title' , 'interstitial_ad');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('interstitial_ad_id');
            $this->db->where('title' , 'interstitial_ad_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('native_ad');
            $this->db->where('title' , 'native_ad');
            $this->db->update('config' , $data);


            $data['value'] = $this->input->post('native_ad_id');
            $this->db->where('title' , 'native_ad_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_publisher_id');
            $this->db->where('title' , 'admob_publisher_id');
            $this->db->update('config' , $data);


            $unity_test_mode = $this->input->post('unity_test_mode');
            if($unity_test_mode =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'unity_test_mode');
                $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                $this->db->where('title' , 'unity_test_mode');
                $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('unity_android_game_id');
            $this->db->where('title' , 'unity_android_game_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('unity_ios_game_id');
            $this->db->where('title' , 'unity_ios_game_id');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', 'Ads Setting changed.');
            redirect($this->agent->referrer());
        endif;
        $data['page_name']  = 'mobile_ads_setting';
        $data['page_title'] = 'Mobile Ads Setting';
        $this->load->view('admin/index', $data);
    }
    function mobile_ads_setting_legacy($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '79');

        if($param1=='update'):
            demo_check();
            $mobile_ads_enable = $this->input->post('mobile_ads_enable');
            if($mobile_ads_enable =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'mobile_ads_enable');
                $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                $this->db->where('title' , 'mobile_ads_enable');
                $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('mobile_ads_network');
            $this->db->where('title' , 'mobile_ads_network');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_app_id');
            $this->db->where('title' , 'admob_app_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_publisher_id');
            $this->db->where('title' , 'admob_publisher_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_banner_ads_id');
            $this->db->where('title' , 'admob_banner_ads_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_interstitial_ads_id');
            $this->db->where('title' , 'admob_interstitial_ads_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('admob_native_ads_id');
            $this->db->where('title' , 'admob_native_ads_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('fan_native_ads_placement_id');
            $this->db->where('title' , 'fan_native_ads_placement_id');
            $this->db->update('config' , $data);


            $data['value'] = $this->input->post('fan_banner_ads_placement_id');
            $this->db->where('title' , 'fan_banner_ads_placement_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('fan_interstitial_ads_placement_id');
            $this->db->where('title' , 'fan_interstitial_ads_placement_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('fan_native_ads_placement_id');
            $this->db->where('title' , 'fan_native_ads_placement_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('startapp_app_id');
            $this->db->where('title' , 'startapp_app_id');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', 'Ads Setting changed.');
            redirect($this->agent->referrer());
        endif;
        $data['page_name']  = 'mobile_ads_setting_legacy';
        $data['page_title'] = 'Mobile Ads Setting';
        $this->load->view('admin/index', $data);
    }


    function ima_ads_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '80');

        if($param1=='update'):
            demo_check();
            $preroll_ads_enable = $this->input->post('preroll_ads_enable');
            if($preroll_ads_enable =='on'):
                $data['value'] = '1';
                $this->db->where('title' , 'preroll_ads_enable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = '0';
                 $this->db->where('title' , 'preroll_ads_enable');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('preroll_ads_video');
            $this->db->where('title' , 'preroll_ads_video');
            $this->db->update('config' , $data);

            $this->session->set_flashdata('success', trans('ima_ads_setting_changed'));
            redirect($this->agent->referrer());
        endif;
        $data['page_name']  = 'ima_ads_setting';
        $data['page_title'] = trans('ima_ads_setting');
        $this->load->view('admin/index', $data);
    }

    function language_setting($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '179');
        /* end menu active/inactive section*/
        $this->load->model('language_model');
        if($param1=='change_default'):
            demo_check();
            $d = array(
                'site_lang' => $this->input->post('site_lang', true),
            );            
            $lang = $this->language_model->get_language($d["site_lang"]);
            if (!empty($lang)):
                $data['value'] = $d["site_lang"];
                $this->db->where('title' , 'active_language_id');
                $this->db->update('config' , $data);
            endif;
            $this->session->set_flashdata('success', trans('language_change'));
            redirect($this->agent->referrer());
        endif;

        if($param1=='add_language'):
            demo_check();
            //validate
            $this->form_validation->set_rules('name', 'Name', 'required|xss_clean|max_length[200]');
            if ($this->form_validation->run() === false):
                $this->session->set_flashdata('error', validation_errors());
                redirect($this->agent->referrer());
            else:
                if ($this->language_model->add_language()):
                    $this->session->set_flashdata('success', trans('language_added'));
                    redirect($this->agent->referrer());
                else:
                    $this->session->set_flashdata('error', trans('language_add_fail'));
                    redirect($this->agent->referrer());
                endif;
            endif;
        endif;

        $data['page_name']  = 'languages';
        $data['page_title'] = trans('language_setting');
        $this->load->model('language_model');
        $data["languages"] = $this->language_model->get_languages();
        $this->load->view('admin/index', $data);
    }


    function language_edit($param1 = '', $param2 = ''){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        /* start menu active/inactive section*/
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '79');
        /* end menu active/inactive section*/
        $this->load->model('language_model');

        if($param1=='update'):
            demo_check();
            //validate
            $this->form_validation->set_rules('name', 'Name', 'required|xss_clean|max_length[200]');
            $id = $this->input->post('id', true);
            if ($this->form_validation->run() === false):
                $this->session->set_flashdata('error', validation_errors());
                redirect($this->agent->referrer());
            else:
                if ($this->language_model->update_language($id)):
                    $this->session->set_flashdata('success', trans('language_added'));
                    redirect($this->agent->referrer());
                else:
                    $this->session->set_flashdata('error', trans('language_add_fail'));
                    redirect($this->agent->referrer());
                endif;
            endif;
        endif;

        $data['language'] = $this->language_model->get_language($param1);
        if (empty($data['language'])) {
            redirect($this->agent->referrer());
        }

        $data['page_name']  = 'language_edit';
        $data['page_title'] = trans('language_edit');
        $this->load->model('language_model');
        $data["languages"] = $this->language_model->get_languages();
        $this->load->view('admin/index', $data);
    }
    public function delete_language(){
        $response                       = array();
        if(is_demo()):
            $id                             = $this->input->post('id');
            if($this->language_model->delete_language($id)):
                $response['status']     = 'success';
                $response['message']    = trans('delete_success');
            else:
                $response['status']     = 'error';
                $response['message']    = trans('delete_fail');
            endif;
        else:
            $response['status']     = 'error';
            $response['message']    = 'Action not allow on demo';
        endif;
        echo json_encode($response);
    }

    public function update_phrases($id)
    {
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');

        //get language
        $data['language'] = $this->language_model->get_language($id);

        if (empty($data['language'])) {
            redirect($this->agent->referrer());
        }
        $data["phrases"] = $this->language_model->get_phrases($data['language']->folder_name);
        $this->session->unset_userdata('phrases');
        $this->session->set_userdata("phrases", $data["phrases"]);
        $data['page_name']  = 'phrases';
        $data['page_title'] = trans('phrase_edit');
        $this->load->view('admin/index', $data);
    } 

    public function save_phrases()
    {
        demo_check();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        $id = $this->input->post("id");
        $data['language'] = $this->language_model->get_language($id);

        if (empty($data['language'])) {
            redirect($this->agent->referrer());
        }

        $phrases = $this->input->post(array('phrase'));
        $labels = $this->input->post(array('label'));
        ini_set("upload_max_filesize","2048M");
        ini_set("post_max_size","256M");
        ini_set("max_execution_time","300");
        ini_set("max_input_time","300");
        ini_set("memory_limit","2048M");
        if($this->language_model->update_language_file($data['language']->folder_name, $phrases, $labels)):
            $this->session->set_flashdata('success', trans('update_success'));
        else:
            $this->session->set_flashdata('error', trans('update_fail'));
        endif;
        sleep(3);        
        redirect($this->agent->referrer());
    }
    public function generator_sitemap(){
        demo_check();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        if($this->common_model->generator_sitemap()):
            $this->session->set_flashdata('success', trans('update_success'));
        else:
            $this->session->set_flashdata('error', trans('update_fail'));
        endif;
        redirect($this->agent->referrer());
    }
    public function get_single_movie_details_by_id(){
        $response                       = array();
        $id                             = $this->input->post('videos_id');
        $this->db->where('videos_id', $id);
        $movie                          =   $this->db->get('videos')->row();        
        $response['videos_id']          = $movie->videos_id;
        $response['title']              = $movie->title;
        $response['description']        = strip_tags($movie->description);
        $response['thumbnail_url']      = $this->common_model->get_video_thumb_url($movie->videos_id);
        $response['poster_url']         = $this->common_model->get_video_poster_url($movie->videos_id);
        echo json_encode($response);
    }
    public function get_single_tv_details_by_id(){
        $response                       = array();
        $id                             = $this->input->post('live_tv_id');
        $this->db->where('live_tv_id', $id);
        $tv                             =   $this->db->get('live_tv')->row();        
        $response['live_tv_id']         = $tv->live_tv_id;
        $response['title']              = $tv->tv_name;
        $response['description']        = strip_tags($tv->description);        
        $response['thumbnail_url']      = $this->live_tv_model->get_tv_thumbnail($tv->thumbnail);
        $response['poster_url']         = $this->live_tv_model->get_tv_poster($tv->poster);    
        echo json_encode($response);
    }
    public function get_movie_by_search_title(){
        $q                          = $this->input->get('q');
        $movies                     = [];
        $this->db->limit(50);
        $this->db->like('title',$q,'both');
        $videos                      = $this->db->get('videos')->result_array();
        foreach( $videos as $video){
            $videos_id          = $video['videos_id'];
            $title              = $video['title'];
            $movies[]           = ["id" => $videos_id, "text" => $title];
        }
        echo json_encode($movies);
    }

    public function get_live_tv_by_search_title(){
        $q                          = $this->input->get('q');
        $movies                     = [];
        $this->db->limit(50);
        $this->db->like('tv_name',$q,'both');
        $live_tvs                      = $this->db->get('live_tv')->result_array();
        foreach( $live_tvs as $live_tv){
            $live_tv_id          = $live_tv['live_tv_id'];
            $title              = $live_tv['tv_name'];
            $movies[]           = ["id" => $live_tv_id, "text" => $title];
        }
        echo json_encode($movies);
    }

    public function get_transaction_details(){
        $data = "";
        $subscription_id        = $this->input->post('subscription_id');
        $this->db->where('subscription_id',$subscription_id);
        $query                  = $this->db->get('subscription');
        if($query->num_rows()> 0):
            if($this->common_model->is_json($query->first_row()->payment_info,TRUE)):
                $payment_info   = json_decode($query->first_row()->payment_info);
                $data           = $this->common_model->jsonToTable($payment_info);
            else:
                $data = $query->first_row()->payment_info;
            endif;
        endif;
        echo $data;
    }
    public function api_test(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        $key = $this->db->get_where('keys')->first_row()->key;
        echo "<h3>This is REST API</h3>";
        echo "<p> use postman for testing API <a href='https://www.postman.com/downloads/'>Download Postman</a></p>";
        echo "<p>Use this URL for testing: <a target='_blank' href='".base_url('rest-api/v100/test?API-KEY=').$key."'>".base_url('rest-api/v100/test?API-KEY=').$key."</a>";
        echo "<p>Add this key to header: 'API-KEY' &amp; value: ".$key;
    }

    function upgate_api_key($param1=''){
        demo_check();
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');
        if($param1 !="" && $param1 !=NULL):
            $query = $this->db->get_where('keys',array('id'=>$param1));
            if($query->num_rows() >0):
                $data['key'] = $this->generate_random_string(24);
                $this->db->where("id",$param1);
                $this->db->update('keys',$data);
                $this->session->set_flashdata('success', 'New key create and save successed.');
            endif;
        endif;
        redirect($this->agent->referrer());
    }

    // movie request
    function request_manage($param1 = '', $param2 = ''){
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '4001');
        if ($param1 == 'update') {
            demo_check();
            $data['name']           = $this->input->post('name');
            $data['movie_name']     = $this->input->post('movie_name');
            $data['email']          = $this->input->post('email');
            $data['status']         = $this->input->post('status');

            $this->db->where('request_id', $param2);
            $this->db->update('request', $data);
            $this->session->set_flashdata('success', 'User update successed.');
            redirect(base_url() . 'admin/request_manage/', 'refresh');
        }
        $total_rows                 = $this->db->get('request')->num_rows();
        // page
        $config                     = $this->common_model->pagination();
        $config["base_url"]         = base_url() . "admin/request_manage";
        $config["total_rows"]       = $total_rows;
        $config["per_page"]         = 15;
        $config["uri_segment"]      = 3;
        //$config['use_page_numbers'] = TRUE;
        $config['page_query_string']= TRUE;
        $this->pagination->initialize($config);
        $data['last_row_num']       =  $this->uri->segment(3);
        $page                       = ($this->input->get('per_page') !="" || $this->input->get('per_page') !=NULL) ? $this->input->get('per_page') : 0;//($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["requests"]              = $this->common_model->get_request($config["per_page"], $page);
        $data["links"]              = $this->pagination->create_links();
        $data['total_rows']         = $config["total_rows"];
        $data['page_name']          = 'request_manage';
        $data['page_title']         = 'Request Manage';
        $this->load->view('admin/index', $data);
    }

    // movie request
    function report_manage($param1 = '', $param2 = ''){
        // active menu session
        $this->session->unset_userdata('active_menu');
        $this->session->set_userdata('active_menu', '4002');
        if ($param1 == 'update') {
            $data['issue']           = $this->input->post('issue');
            $data['status']         = $this->input->post('status');

            $this->db->where('report_id', $param2);
            $this->db->update('report', $data);
            $this->session->set_flashdata('success', 'User update successed.');
            redirect(base_url() . 'admin/report_manage/', 'refresh');
        }
        $total_rows     = $this->db->get('report')->num_rows();
        // page
        $config                     = $this->common_model->pagination();
        $config["base_url"]         = base_url() . "admin/report_manage";
        $config["total_rows"]       = $total_rows;
        $config["per_page"]         = 15;
        $config["uri_segment"]      = 3;
        $config['page_query_string']= TRUE;
        $this->pagination->initialize($config);
        $data['last_row_num']       =  $this->uri->segment(3);
        $page                       = ($this->input->get('per_page') !="" || $this->input->get('per_page') !=NULL) ? $this->input->get('per_page') : 0;//($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["reports"]              = $this->common_model->get_report($config["per_page"], $page);
        $data["links"]              = $this->pagination->create_links();
        $data['total_rows']         = $config["total_rows"];
        $data['page_name']          = 'report_manage';
        $data['page_title']         = 'Report Manage';
        $this->load->view('admin/index', $data);
    }



     
}