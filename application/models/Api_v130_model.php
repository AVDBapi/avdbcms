<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * OXOO - Android Live TV & Movie Portal App
 * ---------------------- OXOO --------------------
 * ------- Android Live TV & Movie Portal App --------
 * - Live tv channel & movie management system -
 *
 * @package     OXOO - Android Live TV & Movie Portal App
 * @author      Abdul Mannan/Spa Green Creative
 * @copyright   Copyright (c) 2014 - 2019 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/
 

class Api_v130_model extends CI_Model {
    public  $default_limit  =   24;
    
    function __construct()
    {
        parent::__construct();
        

    }
        /* clear cache*/    
    function clear_cache()
    {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

    public function check_mobile_apps_api_secret_key($api_secret_key=''){
        $result                         =   FALSE;
        $mobile_apps_api_secret_key     =   $this->db->get_where('config' , array('title'=>'mobile_apps_api_secret_key'))->row()->value;
        if($mobile_apps_api_secret_key == $api_secret_key):
            $result     =  TRUE;
        endif;
        return $result;
    }

    public function get_slider() {
        $response['slider_type']        =   $this->db->get_where('config' , array('title'=>'slider_type'))->row()->value;
        $response['slide']              =   array();
        if($response['slider_type'] == 'image'):
            if($this->db->get_where('slider',array('publication'=>'1'))->num_rows()==0)
                $response['slider_type']        = "disable";
            $response['slide']           =   $this->get_all_slide();
        elseif($response['slider_type'] == 'movie'):
            $response['slide']           =   $this->get_movies_for_slider();
        elseif($response['slider_type'] == 'tv'):
            $response['slide']           =   $this->get_tv_for_slider();
        endif;
        return $response;
    }

     // get slide
    public function get_all_slide($limit=''){
        $response       = array();
        $this->db->order_by("order","DESC");
        $slides         =   $this->db->get('slider')->result_array();
        $i              =   0;
        foreach ($slides as $slide):
            $response[$i]['id']                         = $slide['slider_id'];
            $response[$i]['title']                      = $slide['title'];
            $response[$i]['description']                = $slide['description'];
            $response[$i]['image_link']                 = $slide['image_link'];
            $response[$i]['slug']                       = $slide['slug'];
            $response[$i]['action_type']                = $slide['action_type'];
            $response[$i]['action_btn_text']            = $slide['action_btn_text'];
            $response[$i]['action_id']                  = $slide['action_id'];
            $response[$i]['action_url']                 = $slide['action_url'];
            $i++;
        endforeach;
        return $response;
    }

    // get latest movie
    public function get_movies_for_slider($limit=''){
        $response       = array();
        $limit          = 5;
        $db_limit       = (int)$this->db->get_where('config' , array('title'=>'total_movie_in_slider'))->row()->value;
        if(is_integer($db_limit)):
            if($db_limit >0):
                $limit = $db_limit;
            endif;
        endif;
        $this->db->limit($limit);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['id']                         = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['image_link']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['action_type']                = 'movie';
            if($video['is_tvseries'] == '1'):
                $response[$i]['action_type']                = 'tvseries';
            endif;
            $response[$i]['action_btn_text']            = 'Play';
            $response[$i]['action_id']                  = $video['videos_id'];
            $response[$i]['action_url']                 = "";
            $i++;
        endforeach;
        return $response;
    }

    // get latest movie
    public function get_tv_for_slider($limit=''){
        $response       = array();
        $limit          = 5;
        $db_limit       = (int)$this->db->get_where('config' , array('title'=>'total_movie_in_slider'))->row()->value;
        if(is_integer($db_limit)):
            if($db_limit >0):
                $limit = $db_limit;
            endif;
        endif;
        $this->db->limit($limit);
        $this->db->where('publish', '1');
        $this->db->order_by("live_tv_id","DESC");
        $live_tvs  =   $this->db->get('live_tv')->result_array();
        $i              =   0;
        foreach ($live_tvs as $live_tv):
            $response[$i]['id']                         = $live_tv['live_tv_id'];
            $response[$i]['title']                      = $live_tv['tv_name'];
            $response[$i]['description']                = strip_tags($live_tv['description']);
            $response[$i]['image_link']                 = $this->live_tv_model->get_tv_poster($live_tv['poster']); 
            $response[$i]['slug']                       = $live_tv['slug'];
            $response[$i]['action_type']                = 'tv';
            $response[$i]['action_btn_text']            = 'Watch Now';
            $response[$i]['action_id']                  = $live_tv['live_tv_id'];
            $response[$i]['action_url']                 = "";
            $i++;
        endforeach;
        return $response;
    }




    public function get_home_content(){
        $response = array();
        
        $i              =   0;
        
        // slider
        $response[$i]['id']                     = $i;
        $response[$i]['type']                   = 'slider';
        $response[$i]['title']                  = "Slider";
        $response[$i]['description']            = "Movie slider";
        $response[$i]['slug']                   = "";
        $response[$i]['url']                    = "";
        $response[$i]['content']                = $this->get_movies_for_slider_for_home();
        $i++;
        
        // latest tv channel
        $response[$i]['id']                     = $i;
        $response[$i]['type']                   = 'tv';
        $response[$i]['title']                  = "featured tv channels";
        $response[$i]['description']            = "";
        $response[$i]['slug']                   = "";
        $response[$i]['url']                    = "";
        $response[$i]['content']                = $this->get_featured_tv_channel_for_home();
        $i++;        
        // latest movie
       $response[$i]['id']                      = $i;
        $response[$i]['type']                   = 'movie';
        $response[$i]['title']                  = "latest Movie";
        $response[$i]['description']            = "";
        $response[$i]['slug']                   = "";
        $response[$i]['url']                    = "";
        $response[$i]['content']                = $this->get_latest_movies_for_home();
        $i++;
        
        // latest tvseries
        $response[$i]['id']                     = $i;
        $response[$i]['type']                   = 'tvseries';
        $response[$i]['title']                  = "latest TVSeries";
        $response[$i]['description']            = "";
        $response[$i]['slug']                   = "";
        $response[$i]['url']                    = "";
        $response[$i]['content']                = $this->get_latest_tvseries_for_home();
        $i++;
        
        // features genre
        $this->db->where('publication', '1');
        $this->db->where('featured', '1');
        $this->db->order_by("genre_id","ASC");
        $genres         =   $this->db->get('genre')->result_array();
        foreach ($genres as $genre):
            if($this->movie_found_by_genre_id($genre['genre_id'])):
                $response[$i]['id']                     = $genre['genre_id'];
                $response[$i]['type']                   = 'movie';
                $response[$i]['title']                  = $genre['name'];
                $response[$i]['description']            = strip_tags($genre['description']);
                $response[$i]['slug']                   = $genre['slug'];
                $response[$i]['url']                    = '';
                $response[$i]['content']                = $this->get_movie_tvseries_by_genre_id_for_home($genre['genre_id']);
                $i++;
            endif;
        endforeach;
        return $response;
    }
    
    // get slider
    public function get_movies_for_slider_for_home($limit=''){
        $response       = array();
        $limit          = 5;
        $db_limit       = (int)$this->db->get_where('config' , array('title'=>'total_movie_in_slider'))->row()->value;
        if(is_integer($db_limit)):
            if($db_limit >0):
                $limit = $db_limit;
            endif;
        endif;
        $this->db->limit($limit);
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries !=', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['id']                         = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['is_tvseries']                = $video['is_tvseries'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $response[$i]['stream_from']                = '';
            $response[$i]['stream_label']               = '';
            $response[$i]['stream_url']                 = $this->get_now_playing_card_video_preview_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }
    
    public function get_featured_tv_channel_for_home($page=''){
        $this->load->model('live_tv_model');
        $response = array();
        $this->db->limit($this->default_limit);
        $this->db->where('publish', '1');
        $this->db->where('featured', '1');
        $this->db->order_by("live_tv_id","DESC");
        $tvs            =   $this->db->get('live_tv')->result_array();
        $i              =   0;
        foreach ($tvs as $tv):
            $response[$i]['id']                             = $tv['live_tv_id'];
            $response[$i]['title']                          = $tv['tv_name'];
            $response[$i]['description']                    = strip_tags($tv['description']);
            $response[$i]['slug']                           = $tv['slug'];
            $response[$i]['is_paid']                        = $tv['is_paid'];
            $response[$i]['is_tvseries']                    = '0';
            $response[$i]['release']                        = '2000';
            $response[$i]['runtime']                        = '00';
            $response[$i]['video_quality']                  = 'HD';
            $response[$i]['thumbnail_url']                  = $this->live_tv_model->get_tv_thumbnail($tv['thumbnail']);
            $response[$i]['poster_url']                     = $this->live_tv_model->get_tv_poster($tv['poster']);
            $response[$i]['stream_from']                    = $tv['stream_from'];
            $response[$i]['stream_label']                   = $tv['stream_label'];
            $response[$i]['stream_url']                     = $tv['stream_url'];
            $i++;
        endforeach;
        return $response;
    }

    
    
     // get latest movie for home
    public function get_latest_movies_for_home($limit=''){
        $response       = array();
        $this->db->limit($this->default_limit);
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries !=', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['id']                         = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['is_tvseries']                = $video['is_tvseries'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $response[$i]['stream_from']                = '';
            $response[$i]['stream_label']               = '';
            $response[$i]['stream_url']                 = $this->get_now_playing_card_video_preview_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }
    
     // get latest tvseries for home
    public function get_latest_tvseries_for_home($limit=''){
        $response       = array();
        $this->db->limit($this->default_limit);
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['is_tvseries']                = $video['is_tvseries'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $response[$i]['stream_from']                = '';
            $response[$i]['stream_label']               = '';
            $response[$i]['stream_url']                 = $this->get_now_playing_card_video_preview_url($video['videos_id'],true);
            $i++;
        endforeach;
        return $response;
    }
    public function get_movie_tvseries_by_genre_id_for_home($genre_id='',$page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        //$this->db->where('genere_id', $genere_id);
        $this->db->where('publication', '1');
        //$this->db->where('is_tvseries !=', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['id']                         = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['is_tvseries']                = $video['is_tvseries'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $response[$i]['stream_from']                = '';
            $response[$i]['stream_label']               = '';
            $response[$i]['stream_url']                 = $this->get_now_playing_card_video_preview_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }



    /***** 
    movie section start here
    *****/

    // get latest movie
    public function get_latest_movies($limit=''){
        $response       = array();
        if(!empty($limit) && $limit !='' && $limit !=NULL && is_numeric($limit)):
            $this->db->limit($limit);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries !=', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['release']                    = '2000';
            $response[$i]['is_paid']                    = $video['is_paid'];
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }

    


    public function get_movies($page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries !=', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['release']                    = '2000';
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['is_tvseries']                = '0';
            if($video['is_tvseries'] == '1')
                $response[$i]['is_tvseries']            = '1';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_content_by_genre_id($genre_id='',$page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['is_tvseries']                = '0';
            if($video['is_tvseries'] =='1')
                $response[$i]['is_tvseries']            = '1';
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }


    public function content_by_country_id($country_id='',$page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where("find_in_set(".$country_id.",country) >",0);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['is_tvseries']                = '0';
            if($video['is_tvseries'] =='1')
                $response[$i]['is_tvseries']            = '1';
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }

    public function content_by_star_id($star_id='',$page=''){
        $this->update_star_view_count($star_id);
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where("find_in_set(".$star_id.",stars) >",0);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['is_tvseries']                = '0';
            if($video['is_tvseries'] =='1')
                $response[$i]['is_tvseries']            = '1';
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }

    public function update_star_view_count($star_id){
        $view   = (int)$this->db->get_where('star',array('star_id'=>$star_id))->first_row()->view+1;
        $this->db->where('star_id',$star_id);
        $this->db->update('star',array("view"=>$view));
        return true;
    }




    public function get_single_movie_details_by_id($id=''){
        $response                   = array();
        $this->db->where('videos_id', $id);
        $movie                      =   $this->db->get('videos')->row();        
        $response['videos_id']                  = $movie->videos_id;
        $response['title']                      = $movie->title;
        $response['description']                = strip_tags($movie->description);
        $response['slug']                       = $movie->slug;
        $response['release']                    = $movie->release;
        $response['runtime']                    = $movie->runtime;
        $response['video_quality']              = $movie->video_quality;
        $response['is_tvseries']                = '0';
        $response['is_paid']                    = $movie->is_paid;
        $response['enable_download']            = '0';
        $response['download_links']             = array();
        if($movie->enable_download == '1'):
            $response['enable_download']        = '1';
            $response['download_links']         = $this->get_all_download_links($movie->videos_id);
        endif;
        $response['thumbnail_url']              = $this->common_model->get_video_thumb_url($movie->videos_id);
        $response['poster_url']                 = $this->common_model->get_video_poster_url($movie->videos_id);        
        $response['videos']                     = $this->get_all_video_by_movie_id($movie->videos_id);      
        $response['genre']                      = $this->genre_details_generator($movie->genre);      
        $response['country']                    = $this->country_details_generator($movie->country);
        $director                               = $this->star_details_generator($movie->director);   
        $writer                                 = $this->star_details_generator($movie->writer);   
        $actor                                  = $this->star_details_generator($movie->stars);   
        $response['director']                   = $director;     
        $response['writer']                     = $writer;      
        $response['cast']                       = $actor;      
        $response['cast_and_crew']              = array_merge($director,$writer,$actor);   
        $response['trailler_youtube_source']    = $movie->trailler_youtube_source;   
        $response['related_movie']              = $this->get_related_movie($movie->videos_id,trim($movie->genre),trim($movie->country));
        return $response;
    }

    function get_all_download_links($videos_id){
        $response   =   array();
        $this->db->where('videos_id',$videos_id);
        $this->db->order_by('in_app_download',"DESC");
        $query      = $this->db->get('download_link');
        if($query->num_rows() > 0):
            $links  = $query->result_array();
            $i      =   0;
            foreach ($links as $video):
                $response[$i]['download_link_id']                   = $video['download_link_id'];
                $response[$i]['label']                              = strtoupper($video['link_title']);
                $response[$i]['videos_id']                          = $video['videos_id'];
                $response[$i]['resolution']                         = $video['resolution'];
                $response[$i]['file_size']                          = $video['file_size'];
                $response[$i]['download_url']                       = $video['download_url'];
                $response[$i]['in_app_download']                    = ($video['in_app_download']=='1') ? true : false;
                $i++;
            endforeach;
        endif;
        return $response;
    }

     function get_all_video_by_movie_id($videos_id){
        $response   =   array();
        $this->db->order_by('order', $this->video_file_order());
        $this->db->where('videos_id',$videos_id);
        $query      = $this->db->get('video_file');
        if($query->num_rows() > 0):
            $videos = $query->result_array();
            $i      =   0;
            foreach ($videos as $video):
                $response[$i]['video_file_id']                  = $video['video_file_id'];
                $response[$i]['label']                          = strtoupper($video['label']);
                $response[$i]['stream_key']                     = $video['stream_key'];
                $response[$i]['file_type']                      = $video['file_source'];
                $response[$i]['file_url']                       = $video['file_url'];
                $response[$i]['subtitle']                       = $this->get_all_movie_subtitle($video['video_file_id']);
                if($video['file_source'] =='gdrive'):
                    $response[$i]['file_type']          = 'embed';
                    //$response[$i]['label']              = 'GOOGLE';
                elseif($video['file_source'] =='amazone'):
                    $response[$i]['file_type']          = 'mp4';
                elseif($video['file_source'] =='m3u8'):
                    $response[$i]['file_type']          = 'hls';
                elseif($video['file_source'] =='vimeo'):
                    $response[$i]['file_type']          = 'embed';
                    $response[$i]['file_url']           = str_replace('vimeo','player.vimeo',$video['file_url']);
                    $response[$i]['file_url']           = str_replace('.com/','.com/video/',$response[$i]['file_url']);
                endif;
                $i++;
            endforeach;
        endif;
        return $response;
    }

    function get_all_movie_subtitle($video_file_id){
        $response   =   array();
        $this->db->where('video_file_id',$video_file_id);
        $query      = $this->db->get('subtitle');
        if($query->num_rows() > 0):
            $subtitles  = $query->result_array();
            $i      =   0;
            foreach ($subtitles as $subtitle):
                $response[$i]['subtitle_id']            = $subtitle['subtitle_id'];
                $response[$i]['videos_id']              = $subtitle['videos_id'];
                $response[$i]['video_file_id']          = $subtitle['video_file_id'];
                $response[$i]['language']               = $subtitle['language'];
                $response[$i]['kind']                   = $subtitle['kind'];
                $response[$i]['url']                    = $subtitle['src'];
                $response[$i]['srclang']                = $subtitle['srclang'];
                $i++;
            endforeach;
        endif;
        return $response;
    }

    


    function get_related_movie($videos_id='',$genre_ids='',$country_ids=''){
        $response   =   array();
        $this->db->where('videos_id !=',$videos_id);
        $this->db->where('is_tvseries !=','1');
        $this->db->where('publication','1');
        $this->db->limit($this->default_limit);
        $i          =   0;
        if(($genre_ids !="" && $genre_ids !=NULL) || ($country_ids !="" && $country_ids !=NULL)):
            $this->db->group_start();
            if($genre_ids !="" && $genre_ids !=NULL):
                $genres     =   explode(',', $genre_ids);
                foreach ($genres as $genre_id):
                    if($i > 0):
                        $this->db->or_where("FIND_IN_SET($genre_id,genre)>0");
                    else:
                        $this->db->where("FIND_IN_SET($genre_id,genre)>0");
                    endif;
                    $i++;
                endforeach;
            endif;

            if($country_ids !="" && $country_ids !=NULL):
                $countries     =   explode(',', $country_ids);
                foreach ($countries as $country):
                    if($i > 0):
                        $this->db->or_where("FIND_IN_SET($country,country)>0");
                    else:
                        $this->db->where("FIND_IN_SET($country,country)>0");
                    endif;
                    $i++;
                endforeach;
            endif;
            $this->db->group_end();
        endif;

        $i          = 0;
        $movies     = $this->db->get('videos')->result_array();
        foreach ($movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['genre']                      = $video['genre'];
            $response[$i]['country']                    = $video['country'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['is_tvseries']                = $video['is_tvseries'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }





    /***** 
    movie section end here
    *****/


    /***** 
    tvseries section start here
    *****/

    // get latest movies
    public function get_latest_tvseries($limit=''){
        $response       = array();
        if(!empty($limit) && $limit !='' && $limit !=NULL && is_numeric($limit)):
            $this->db->limit($limit);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_tvseries  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_tvseries as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }


    public function get_tvseries($page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_tvseries  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_tvseries as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }


    public function get_tvseries_by_country_id($country_id='',$page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where("find_in_set(".$country_id.",country) >",0);
        //$this->db->where('genere_id', $genere_id);
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_tvseries  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_tvseries as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_single_tvseries_details_by_id($id=''){
        $response                   = array();
        $this->db->where('videos_id', $id);
        $movie                                  = $this->db->get('videos')->row();        
        $response['videos_id']                  = $movie->videos_id;
        $response['title']                      = $movie->title;
        $response['description']                = strip_tags($movie->description);
        $response['slug']                       = $movie->slug;
        $response['release']                    = $movie->release;
        $response['runtime']                    = $movie->runtime;
        $response['video_quality']              = $movie->video_quality;
        $response['is_tvseries']                = '1';
        $response['is_paid']                    = $movie->is_paid;
        $response['enable_download']            = $movie->enable_download;        
        $response['thumbnail_url']              = $this->common_model->get_video_thumb_url($movie->videos_id);
        $response['poster_url']                 = $this->common_model->get_video_poster_url($movie->videos_id);        
        //$response['videos']                     = $this->get_all_video_by_movie_id($movie->videos_id);
        $response['genre']                      = $this->genre_details_generator($movie->genre);      
        $response['country']                    = $this->country_details_generator($movie->country);      
        $director                               = $this->star_details_generator($movie->director);   
        $writer                                 = $this->star_details_generator($movie->writer);   
        $actor                                  = $this->star_details_generator($movie->stars);   
        $response['director']                   = $director;     
        $response['writer']                     = $writer;      
        $response['cast']                       = $actor;      
        $response['cast_and_crew']              = array_merge($director,$writer,$actor);
        $response['trailler_youtube_source']    = $movie->trailler_youtube_source;      
        $response['season']                     = $this->get_season_episode($movie->videos_id,$movie->enable_download);      
        $response['related_tvseries']           = $this->get_related_tvseries($movie->videos_id,trim($movie->genre),trim($movie->country));     
        return $response;
    }

    function get_season_episode($videos_id='',$enable_download='0'){
        $response   =   array();
        $this->db->order_by('order', $this->season_order());
        $this->db->where('videos_id',$videos_id);
        $query      =   $this->db->get('seasons');
        if($query->num_rows() > 0):
            $seasons = $query->result_array();
            $i              =   0;
            foreach ($seasons as $season):
                $response[$i]['seasons_id']     = $season['seasons_id'];
                $response[$i]['seasons_name']   = $season['seasons_name'];
                $response[$i]['episodes']       = $this->get_episodes_with_all_video_by_movie_id($season['seasons_id']);
                $response[$i]['enable_download']= '0';
                $response[$i]['download_links'] = array();
                if($enable_download == '1'):
                    $response[$i]['enable_download']        = $enable_download;
                    $response[$i]['download_links']         = $this->get_all_episode_download_links($videos_id,$season['seasons_id']);
                endif;
                $i++;
            endforeach;
        endif;
        return $response;
    }

    function get_all_episode_download_links($videos_id,$seasons_id){
        $response   =   array();
        $this->db->where('videos_id',$videos_id);
        $this->db->where('season_id',$seasons_id);
        $this->db->order_by('in_app_download',"DESC");
        $query      = $this->db->get('episode_download_link');
        if($query->num_rows() > 0):
            $links  = $query->result_array();
            $i      =   0;
            foreach ($links as $video):
                $response[$i]['download_link_id']                   = $video['episode_download_link_id'];
                $response[$i]['label']                              = strtoupper($video['link_title']);
                $response[$i]['videos_id']                          = $video['videos_id'];
                $response[$i]['resolution']                         = $video['resolution'];
                $response[$i]['file_size']                          = $video['file_size'];
                $response[$i]['download_url']                       = $video['download_url'];
                $response[$i]['in_app_download']                    = ($video['in_app_download']=='1') ? true : false;
                $i++;
            endforeach;
        endif;
        return $response;
    }




    function get_episodes_with_all_video_by_movie_id($seasons_id){
        $response   =   array();
        $this->db->order_by('order', $this->episode_order());
        $this->db->where('seasons_id',$seasons_id);
        $query      = $this->db->get('episodes');
        if($query->num_rows() > 0):
            $episodes   =   $query->result_array();
            $i          =   0;
            foreach ($episodes as $episode):
                $response[$i]['episodes_id']     = $episode['episodes_id'];
                $response[$i]['episodes_name']   = $episode['episodes_name'];
                $response[$i]['stream_key']      = $episode['stream_key'];
                $response[$i]['file_type']       = $episode['file_source'];
                $response[$i]['image_url']       = $this->common_model->get_episode_image_url($episode['videos_id'],$episode['episodes_id']);
                $response[$i]['file_url']        = $episode['file_url'];
                $response[$i]['subtitle']        = $this->get_all_tvseries_subtitle($episode['episodes_id']);
                if($episode['file_source'] =='gdrive'):
                    $response[$i]['file_type']          = 'embed';
                elseif($episode['file_source'] =='amazone'):
                    $response[$i]['file_type']          = 'mp4';
                elseif($episode['file_source'] =='m3u8'):
                    $response[$i]['file_type']          = 'hls';
                elseif($episode['file_source'] =='vimeo'):
                    $response[$i]['file_type']          = 'embed';
                    $response[$i]['file_url']           = str_replace('vimeo','player.vimeo',$episode['file_url']);
                    $response[$i]['file_url']           = str_replace('.com/','.com/video/',$response[$i]['file_url']);
                endif;
                $i++;
            endforeach;
        endif;
        return $response;
    }

    function get_all_tvseries_subtitle($episodes_id){
        $response   =   array();
        $this->db->where('episodes_id',$episodes_id);
        $query      = $this->db->get('tvseries_subtitle');
        if($query->num_rows() > 0):
            $subtitles  = $query->result_array();
            $i      =   0;
            foreach ($subtitles as $subtitle):
                $response[$i]['subtitle_id']            = $subtitle['tvseries_subtitle_id'];
                $response[$i]['videos_id']              = $subtitle['videos_id'];
                $response[$i]['episodes_id']            = $subtitle['episodes_id'];
                $response[$i]['language']               = $subtitle['language'];
                $response[$i]['kind']                   = $subtitle['kind'];
                $response[$i]['url']                    = $subtitle['src'];
                $response[$i]['srclang']                = $subtitle['srclang'];
                $i++;
            endforeach;
        endif;
        return $response;
    }


    function get_related_tvseries($videos_id='',$genre_ids='',$country_ids=''){
        $response   =   array();
        $this->db->where('videos_id !=',$videos_id);
        $this->db->where('is_tvseries','1');
        $this->db->where('publication','1');
        $this->db->limit($this->default_limit);
        $i          =   0;
        if(($genre_ids !="" && $genre_ids !=NULL) || ($country_ids !="" && $country_ids !=NULL)):
            $this->db->group_start();
            if($genre_ids !="" && $genre_ids !=NULL):
                $genres     =   explode(',', $genre_ids);
                foreach ($genres as $genre_id):
                    if($i > 0):
                        $this->db->or_where("FIND_IN_SET($genre_id,genre)>0");
                    else:
                        $this->db->where("FIND_IN_SET($genre_id,genre)>0");
                    endif;
                    $i++;
                endforeach;
            endif;

            if($country_ids !="" && $country_ids !=NULL):
                $countries     =   explode(',', $country_ids);
                foreach ($countries as $country):
                    if($i > 0):
                        $this->db->or_where("FIND_IN_SET($country,country)>0");
                    else:
                        $this->db->where("FIND_IN_SET($country,country)>0");
                    endif;
                    $i++;
                endforeach;
            endif;
            $this->db->group_end();
        endif;

        $i          = 0;
        $movies     = $this->db->get('videos')->result_array();
        foreach ($movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['genre']                      = $video['genre'];
            $response[$i]['country']                    = $video['country'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['release']                    = '2000';
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['is_tvseries']                = $video['is_tvseries'];
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }




    /***** 
    tvseries section end here
    *****/

    public function verify_movie_tvseries_id($id='')
    {
        //var_dump($id);
        $result =   FALSE;
        $rows   =   $this->db->get_where('videos', array('videos_id' => $id))->num_rows();
        if($rows >    0):
            $result =   TRUE;
        endif;
        return $result;
    }


    public function verify_genre_id($genre_id='')
    {
        $result =   FALSE;
        $rows   =   $this->db->get_where('genre', array('genre_id' => $genre_id))->num_rows();
        if($rows >    0):
            $result =   TRUE;
        endif;
        return $result;
    }

    public function verify_country_id($country_id='')
    {
        $result =   FALSE;
        $rows   =   $this->db->get_where('country', array('country_id' => $country_id))->num_rows();
        if($rows >    0):
            $result =   TRUE;
        endif;
        return $result;
    }

    public function verify_star_id($star_id='')
    {
        $result =   FALSE;
        $rows   =   $this->db->get_where('star', array('star_id' => $star_id))->num_rows();
        if($rows >    0):
            $result =   TRUE;
        endif;
        return $result;
    }

    public function get_popular_stars(){
        $response = array();
        $this->db->limit($this->default_limit);
        $this->db->where('status', '1');
        $this->db->order_by("view","DESC");
        $stars          =   $this->db->get('star')->result_array();
        $i              =   0;
        foreach ($stars as $star):
            $response[$i]['star_id']                        = $star['star_id'];
            $response[$i]['star_name']                          = $star['star_name'];
            $response[$i]['image_url']                      = $this->get_star_image_url($star['star_id']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_all_country(){
        $response = array();
        $this->db->where('publication', '1');
        $this->db->order_by("country_id","ASC");
        $countries      =   $this->db->get('country')->result_array();
        $i              =   0;
        foreach ($countries as $country):
            $response[$i]['country_id']             = $country['country_id'];
            $response[$i]['name']                   = $country['name'];
            $response[$i]['description']            = strip_tags($country['description']);
            $response[$i]['slug']                   = $country['slug'];
            $response[$i]['url']                    = base_url('country/'.$country['slug'].'.html');
            $response[$i]['image_url']              = $this->common_model->get_country_image_url($country['country_id']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_all_genre(){
        $response = array();
        $this->db->where('publication', '1');
        $this->db->order_by("genre_id","ASC");
        $genres         =   $this->db->get('genre')->result_array();
        $i              =   0;
        foreach ($genres as $genre):
            $response[$i]['genre_id']               = $genre['genre_id'];
            $response[$i]['name']                   = $genre['name'];
            $response[$i]['description']            = strip_tags($genre['description']);
            $response[$i]['slug']                   = $genre['slug'];
            $response[$i]['url']                    = base_url('genre/'.$genre['slug'].'.html');
            $response[$i]['image_url']              = $this->common_model->get_genre_image_url($genre['genre_id']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_featured_tv_channel($page=''){
        $this->load->model('live_tv_model');
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where('publish', '1');
        $this->db->where('featured', '1');
        $this->db->order_by("live_tv_id","DESC");
        $tvs            =   $this->db->get('live_tv')->result_array();
        $i              =   0;
        foreach ($tvs as $tv):
            $response[$i]['live_tv_id']                     = $tv['live_tv_id'];
            $response[$i]['tv_name']                        = $tv['tv_name'];
            $response[$i]['is_paid']                        = $tv['is_paid'];
            $response[$i]['description']                    = strip_tags($tv['description']);
            $response[$i]['slug']                           = $tv['slug'];
            $response[$i]['stream_from']                    = $tv['stream_from'];
            $response[$i]['stream_label']                   = $tv['stream_label'];
            $response[$i]['stream_url']                     = $tv['stream_url'];
            $response[$i]['thumbnail_url']                  = $this->live_tv_model->get_tv_thumbnail($tv['thumbnail']);
            $response[$i]['poster_url']                     = $this->live_tv_model->get_tv_poster($tv['poster']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_all_tv_channel($page=''){
        $this->load->model('live_tv_model');
        $response = array();
        $this->db->where('publish', '1');
        $this->db->where('featured', '1');
        $this->db->order_by("live_tv_id","DESC");
        $tvs            =   $this->db->get('live_tv')->result_array();
        $i              =   0;
        foreach ($tvs as $tv):
            $response[$i]['live_tv_id']                     = $tv['live_tv_id'];
            $response[$i]['tv_name']                        = $tv['tv_name'];
            $response[$i]['is_paid']                        = $tv['is_paid'];
            $response[$i]['description']                    = strip_tags($tv['description']);
            $response[$i]['slug']                           = $tv['slug'];
            $response[$i]['stream_from']                    = $tv['stream_from'];
            $response[$i]['stream_label']                   = $tv['stream_label'];
            $response[$i]['stream_url']                     = $tv['stream_url'];
            $response[$i]['thumbnail_url']                  = $this->live_tv_model->get_tv_thumbnail($tv['thumbnail']);
            $response[$i]['poster_url']                     = $this->live_tv_model->get_tv_poster($tv['poster']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_tv_channel($limit=''){
        $this->load->model('live_tv_model');
        $response = array();
        if(!empty($limit) && $limit !='' && $limit !=NULL && is_numeric($limit)):
            //$offset = ((int)$limit *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($limit);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where('publish', '1');
        //$this->db->where('featured', '1');
        $this->db->order_by("live_tv_id","DESC");
        $tvs            =   $this->db->get('live_tv')->result_array();
        $i              =   0;
        foreach ($tvs as $tv):
            $response[$i]['live_tv_id']                     = $tv['live_tv_id'];
            $response[$i]['tv_name']                        = $tv['tv_name'];
            $response[$i]['is_paid']                        = $tv['is_paid'];
            $response[$i]['description']                    = strip_tags($tv['description']);
            $response[$i]['slug']                           = $tv['slug'];
            $response[$i]['stream_from']                    = $tv['stream_from'];
            $response[$i]['stream_label']                   = $tv['stream_label'];
            $response[$i]['stream_url']                     = $tv['stream_url'];
            $response[$i]['thumbnail_url']                  = $this->live_tv_model->get_tv_thumbnail($tv['thumbnail']);
            $response[$i]['poster_url']                     = $this->live_tv_model->get_tv_poster($tv['poster']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_all_tv_channel_category(){
        $response = array();
        $this->load->model('live_tv_model');        
        $this->db->where('status', '1');
        $this->db->order_by("live_tv_category_id","DESC");
        $tv_categories  =   $this->db->get('live_tv_category')->result_array();
        return $tv_categories;
    }

    public function get_all_tv_channel_by_category(){
        $response = array();
        $this->load->model('live_tv_model');        
        $this->db->where('status', '1');
        $this->db->order_by("live_tv_category_id","DESC");
        $tv_categories  =   $this->db->get('live_tv_category')->result_array();
        $i              =   0;
        foreach ($tv_categories as $tv_category):
            if($this->channel_found_by_category_id($tv_category['live_tv_category_id'])):
                $response[$i]['live_tv_category_id']            = $tv_category['live_tv_category_id'];
                $response[$i]['title']                          = $tv_category['live_tv_category'];
                $response[$i]['description']                    = strip_tags($tv_category['live_tv_category_desc']);
                $response[$i]['channels']                       = $this->get_all_tv_channel_by_category_id($tv_category['live_tv_category_id']);
                $i++;
            endif;
        endforeach;
        return $response;
    }
    public function channel_found_by_category_id($id=''){
        $result = false;
        $query = $this->db->get_where('live_tv',array('publish'=>'1','live_tv_category_id'=>$id));
        if($query->num_rows() > 0):
            $result = true;
        endif;
        return $result;
    }

    public function get_all_tv_channel_by_category_id($id=''){
        $this->load->model('live_tv_model');
        $response = array();
        $this->db->where('publish', '1');
        $this->db->where('live_tv_category_id', $id);
        $this->db->order_by("live_tv_id","DESC");
        $tvs            =   $this->db->get('live_tv')->result_array();
        $i              =   0;
        foreach ($tvs as $tv):
            $response[$i]['live_tv_id']                     = $tv['live_tv_id'];
            $response[$i]['tv_name']                        = $tv['tv_name'];
            $response[$i]['is_paid']                        = $tv['is_paid'];
            $response[$i]['description']                    = strip_tags($tv['description']);
            $response[$i]['slug']                           = $tv['slug'];
            $response[$i]['stream_from']                    = $tv['stream_from'];
            $response[$i]['stream_label']                   = $tv['stream_label'];
            $response[$i]['stream_url']                     = $tv['stream_url'];
            $response[$i]['thumbnail_url']                  = $this->live_tv_model->get_tv_thumbnail($tv['thumbnail']);
            $response[$i]['poster_url']                     = $this->live_tv_model->get_tv_poster($tv['poster']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_tv_channel_by_category_id($id='',$page=''){
        $this->load->model('live_tv_model');
        $response = array();
        if(!empty($limit) && $limit !='' && $limit !=NULL && is_numeric($limit)):
            $offset = ((int)$limit *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where('publish', '1');
        $this->db->where('live_tv_category_id', $id);
        //$this->db->where('featured', '1');
        $this->db->order_by("live_tv_id","DESC");
        $tvs            =   $this->db->get('live_tv')->result_array();
        $i              =   0;
        foreach ($tvs as $tv):
            $response[$i]['live_tv_id']                     = $tv['live_tv_id'];
            $response[$i]['tv_name']                        = $tv['tv_name'];
            $response[$i]['is_paid']                        = $tv['is_paid'];
            $response[$i]['description']                    = strip_tags($tv['description']);
            $response[$i]['slug']                           = $tv['slug'];
            $response[$i]['stream_from']                    = $tv['stream_from'];
            $response[$i]['stream_label']                   = $tv['stream_label'];
            $response[$i]['stream_url']                     = $tv['stream_url'];
            $response[$i]['thumbnail_url']                  = $this->live_tv_model->get_tv_thumbnail($tv['thumbnail']);
            $response[$i]['poster_url']                     = $this->live_tv_model->get_tv_poster($tv['poster']);
            $i++;
        endforeach;
        return $response;
    }


    public function get_single_tv_details_by_id($id=''){
        $response                       = array();
        $this->db->where('live_tv_id', $id);
        $tv                             =   $this->db->get('live_tv')->row();        
        $response['live_tv_id']     = $tv->live_tv_id;
        $response['tv_name']        = $tv->tv_name;
        $response['is_paid']        = $tv->is_paid;
        $response['description']    = strip_tags($tv->description);
        $response['is_paid']        = $tv->is_paid;
        $response['slug']           = $tv->slug;
        $response['stream_from']    = $tv->stream_from;
        $response['stream_label']   = strtoupper($tv->stream_label);
        $response['stream_url']     = $tv->stream_url;
//        if($tv->stream_from =='youtube'):
//            $response['stream_url']     = str_replace('watch?v=','embed/',$tv->stream_url);
//        else
       if($tv->stream_from =='m3u8' || $tv->stream_from =='hls'):
                $response['stream_from'] = 'hls';
        elseif($tv->stream_from =='rtmp' || $tv->stream_from =='RTMP'):
                $response['stream_from'] = 'rtmp';
        endif;        
        $response['thumbnail_url']                  = $this->live_tv_model->get_tv_thumbnail($tv->thumbnail);
        $response['poster_url']                     = $this->live_tv_model->get_tv_poster($tv->poster);      
        $response['additional_media_source']        = $this->get_aditional_media_source($tv->live_tv_id);      
        $response['all_tv_channel']                 = $this->get_all_tv_channel();    
        $response['current_program_title']          = "Regular Program";
        $response['current_program_time']           = "00:00";
        $response['program_guide']                  = array();    
        return $response;
    }



    function get_cunnent_program_info($data=''){
        $current_program_title  = 'Regular Program';
        $current_program_time   = date("H:i",floor(time() / (15 * 60)) * (15 * 60));
        $current_program = $this->get_current_program();
        if(sizeof($current_program) > 0):
            $current_program_title   = $current_program[0]['title'];
            $current_program_time   = date("H:i",strtotime($current_program[0]['time']));
        endif;
        if($data =='time'):
            return $current_program_time;
        else:
            return $current_program_title;
        endif;
    }

    function get_current_program(){
        $response = array();
        $this->db->limit(1);
        $this->db->order_by('time','DESC');
        $this->db->where('date',date('Y-m-d'));
        $this->db->where('time <=',date('H:i:s'));
        $this->db->where('time >=',date("H:i:s", time() - 3600));
        $query = $this->db->get('live_tv_program_guide');
        if($query->num_rows() > 0)
            $response = $query->result_array();
        return $response;
    }

    function get_aditional_media_source($live_tv_id=''){
        $response   =   array();
        $this->db->where('live_tv_id',$live_tv_id);
        $this->db->where('url !=','');
        $query = $this->db->get('live_tv_url');
        if($query->num_rows() > 0):
            $live_tv_urls   =   $query->result_array();
            $i          =   0;
            foreach ($live_tv_urls as $live_tv_url):
                $response[$i]['live_tv_id']         = $live_tv_url['live_tv_url_id'];
                $response[$i]['stream_key']         = $live_tv_url['stream_key'];
                $response[$i]['source']             = $live_tv_url['source'];
                $response[$i]['label']              = strtoupper($live_tv_url['label']);
                $response[$i]['url']                = $live_tv_url['url'];
                if($live_tv_url['source'] =='youtube'):
                    $response[$i]['source']  = 'embed';
                    $response[$i]['url']     = str_replace('watch?v=','embed/',$live_tv_url['url']);
                elseif($live_tv_url['source'] =='m3u8' || $live_tv_url['source'] =='hls'):
                    $response[$i]['source']  = 'hls';
                elseif($live_tv_url['source'] =='rtmp' || $live_tv_url['source'] =='RTMP'):
                    $response[$i]['source']  = 'rtmp';
                endif;
                $i++;
            endforeach;
        endif;
        return $response;
    }

    function get_all_program_guide_by_tv_td($live_tv_id=''){
        $response   =   array();
        $this->db->where('status','1');
        $this->db->where('live_tv_id',$live_tv_id);
        $this->db->where('date',date('Y-m-d'));
        $this->db->order_by('time','ASC');
        $query = $this->db->get('live_tv_program_guide');
        if($query->num_rows() > 0):
            $guides   =   $query->result_array();
            $i          =   0;
            foreach ($guides as $guide):
                $program_status = 'upcomming';
                if($guide['time'] < date('H:i:s')):
                    $program_status = 'onaired';
                endif;
                $response[$i]['id']                 = $guide['live_tv_program_guide_id'];
                $response[$i]['title']              = $guide['title'];
                $response[$i]['program_status']     = $program_status;
                $response[$i]['time']               = date("H:i", strtotime($guide['time']));
                $response[$i]['video_url']          = $guide['video_url'];
                $i++;
            endforeach;
        endif;
        return $response;
    }


    public function verify_live_tv_category_id($live_tv_category_id='')
    {
        $result =   FALSE;
        $rows   =   $this->db->get_where('live_tv_category', array('live_tv_category_id' => $live_tv_category_id))->num_rows();
        if($rows >    0):
            $result =   TRUE;
        endif;
        return $result;
    }

    public function verify_tv_id($id='')
    {
        $result =   FALSE;
        $rows   =   $this->db->get_where('live_tv', array('live_tv_id' => $id))->num_rows();
        if($rows >    0):
            $result =   TRUE;
        endif;
        return $result;
    }



    


    // validate login  function
    function validate_user($email   =   '' , $password   =  ''){
        $result = FALSE;
        $credential    =   array(  'email' => $email , 'password' => $password );
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            //$this->db->where($credential);
            //$this->db->update('user', array('last_login' => date('Y-m-d H:i:s')));
            $result = TRUE;
        endif;    
        return $result;      
    }


    // validate login  function
    function validate_user_by_phone_no($phone   =   ''){
        $result = FALSE;
        $credential    =   array('phone' => $phone );
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $result = TRUE;
        endif;    
        return $result;      
    }

    // validate login  function
    function validate_user_by_uid($uid   =   ''){
        $result = FALSE;
        $credential    =   array('firebase_auth_uid' => $uid );
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $result = TRUE;
        endif;    
        return $result;      
    }

    function check_password_set_status($user_id){
        $user_info = $this->db->get_where('user' , array('user_id' => $user_id ))->row();
        if($user_info->firebase_auth_uid == NULL || $user_info->firebase_auth_uid ==""):
            return TRUE;
        endif;

        if($user_info->is_password_set =='1'):
            return TRUE;
        else:
            return FALSE;
        endif;      
    }

    // validate login  function
    function validate_user_by_id_password($user_id='' , $password=''){
        $result = FALSE;
        $credential    =   array(  'user_id' => $user_id , 'password' => $password );
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $this->db->where($credential);
            $result = TRUE;
        endif;   
        return $result;      
    }


    function validate_user_by_id_firebase_auth_uid($user_id,$firebase_auth_uid){
        $result = FALSE;
        $credential    =   array(  'user_id' => $user_id , 'firebase_auth_uid' => $firebase_auth_uid );
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $this->db->where($credential);
            $result = TRUE;
        endif;   
        return $result;      
    }


    // validate login  function
    function validate_user_by_id($user_id   =   ''){
        $result = FALSE;
        $credential    =   array(  'user_id' => $user_id);
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $result = TRUE;
        endif;    
        return $result;      
    }


    // validate login  function
    function validate_user_by_email($email   =   ''){
        $result = FALSE;
        $credential    =   array(  'email' => $email);
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $this->db->where($credential);
            $result = TRUE;
        endif;    
        return $result;      
    }

    // get user info  function
    function get_user_info($email   =   '' , $password   =  ''){
        $credential    =   array(  'email' => $email , 'password' => $password );
        $result = $this->db->get_where('user' , $credential)->row();   
        return $result;     
    }

    // get user info  function
    function get_user_info_by_phone_no($phone   =   ''){
        $credential    =   array(  'phone' => $phone);
        $result = $this->db->get_where('user' , $credential)->row();   
        return $result;     
    }

    // get user info  function
    function get_user_info_by_uid($uid   =   ''){
        $credential    =   array(  'firebase_auth_uid' => $uid);
        $result = $this->db->get_where('user' , $credential)->row();   
        return $result;     
    }


    // get user info  function
    function get_user_info_by_user_id($user_id=''){
        //$credential     =   array(  'user_id' => $user_id );
        $this->db->where('user_id', $user_id);
        $result         = $this->db->get('user')->row();   
        return $result;     
    }

    // get user info  function
    function get_user_info_by_email($email   =   ''){
        $credential    =   array(  'email' => $email );
        $result = $this->db->get_where('user' , $credential)->row();   
        return $result;     
    }


    // get user info  function
    function create_user($name='',$email   =   '' , $password   =  ''){
        //$credential    =   array(  'email' => $email , 'password' => $password );
        $data['name']           = $name;
        $data['username']       = $email;
        $data['email']          = $email;
        $data['password']       = $password;
        $data['role']           = 'subscriber';
        $data['join_date']      = date('Y-m-d H:i:s');
        $data['last_login']     = date('Y-m-d H:i:s');
        $this->db->insert('user', $data);
        $user_id                = $this->db->insert_id();
        $this->api_subscription_model->create_trial_subscription($user_id);
        return TRUE;     
    }


    // get user info  function
    function create_user_by_firebase_auth_uid($data){
        //$credential    =   array(  'email' => $email , 'password' => $password );        
        $this->db->insert('user', $data);
        $user_id                = $this->db->insert_id();
        $this->api_subscription_model->create_trial_subscription($user_id);
        return TRUE;     
    }

    // get user info  function
    function create_user_by_phone_no($data=array()){
        //$credential    =   array(  'email' => $email , 'password' => $password );
        $data['name']           = 'No name set';
        $data['username']       = $phone;
        $data['email']          = $phone;
        $data['phone']          = $phone;
        $data['password']       = md5($phone);
        $data['role']           = 'subscriber';
        $data['join_date']      = date('Y-m-d H:i:s');
        $data['last_login']     = date('Y-m-d H:i:s');
        $this->db->insert('user', $data);
        $user_id                = $this->db->insert_id();
        $this->api_subscription_model->create_trial_subscription($user_id);
        return TRUE;     
    }


    function update_profile($user_id   =   '' , $data   =  array()){
        $this->db->where('user_id',$user_id);
        $this->db->update('user' ,$data);  
        return TRUE;     
    }



    // validate email  function
    function check_signup_ability_by_email($email   =   ''){
        $result = TRUE;
        $credential    =   array(  'email' => $email);
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            $result = FALSE;
        endif;    
        return $result;      
    }

    // validate email  function
    function user_exist_by_email($email   =   ''){
        if($email =="" || $email == NULL):
            return false;
        endif;
        if(filter_var($email, FILTER_VALIDATE_EMAIL)):
            $credential     =   array(  'email' => $email);
            $query          =   $this->db->get_where('user' , $credential);
            if ($query->num_rows() > 0):
                return true;
            else:
                return false;
            endif;    
        else:
            return false;
        endif;    
    }





    /**********************
    extra
    **********************/
    function genre_details_generator($genre=''){
        $response   =   array();
        $genres     =   explode(',', $genre);
        $i          =   0;
        foreach ($genres as $genre_id):
            $response[$i]['genre_id']   = $genre_id;
            $response[$i]['name']       = $this->genre_model->get_genre_name_by_id($genre_id);            
            $response[$i]['url']        = $this->genre_model->get_genre_url_by_id($genre_id);
            $i++;
        endforeach;
        return $response;
    }
    function country_details_generator($country=''){
        $response   =   array();
        $countrys   =   explode(',', $country);
        $i          =   0;
        foreach ($countrys as $country_id):
            $response[$i]['country_id'] = $country_id;
            $response[$i]['name']       = $this->country_model->get_country_name_by_id($country_id);            
            $response[$i]['url']        = $this->country_model->get_country_url_by_id($country_id);
            $i++;
        endforeach;
        return $response;
    }

    function star_details_generator($star=''){
        $response   =   array();
        $stars     =   explode(',', $star);
        $i          =   0;
        foreach ($stars as $star_id):
            $name                       =  $this->common_model->get_star_name_by_id($star_id);
            if(!empty($name) && $name !='' && $name !=NULL):
                $response[$i]['star_id']    = $star_id;
                if($name=='null'):
                    $response[$i]['name']       = 'Unknown';
                else:
                    $response[$i]['name']       = $name;
                endif;         
                $response[$i]['url']        = base_url().'star/'.$this->common_model->get_star_slug_by_id($star_id).'.html';
                $response[$i]['image_url']  = $this->get_star_image_url($star_id);
                $i++;
            endif;
        endforeach;
        return $response;
    }
    function get_star_image_url($star_id = '')
    {
        if(file_exists('uploads/star_image/'.$star_id.'.jpg'))
            $image_url  =   base_url().'uploads/star_image/'.$star_id.'.jpg';
        else
            $image_url  =   base_url().'uploads/default_image/actor.jpg';
            
        return $image_url;
    }


    public function get_movie_search_result($q='',$page='',$genre_id='',$country_id='',$range_to='',$range_from=''){
        $q          = trim($q);
        $page       = trim($page);
        $genre_id   = trim($genre_id);
        $country_id = trim($country_id);
        $range_to   = trim($range_to);
        $range_from = trim($range_from);

        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;

        if(!empty($q) && $q !='' && $q !=NULL):
            $this->db->like('title', $q,'both');
        endif;

        if(!empty($genre_id) && $genre_id !='' && $genre_id !=NULL && is_numeric($genre_id)):
            $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        endif;

        if(!empty($country_id) && $country_id !='' && $country_id !=NULL && is_numeric($country_id)):
            $this->db->where("find_in_set(".$country_id.",country) >",0);
        endif;

        if(!empty($range_from) && $range_from !='' && $range_from !=NULL && is_numeric($range_from) && strlen($range_from) ==4 && !empty($range_to) && $range_to !='' && $range_to !=NULL && is_numeric($range_to) && strlen($range_to) ==4):
            $release_from = date("Y-m-d",strtotime($range_from.'-01-01'));
            $this->db->where("release >=",$release_from);

            $release_to = date("Y-m-d",strtotime($range_to.'-12-31'));
            $this->db->where("release <=",$release_to);
        endif;
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries !=', '1');        
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['release']                    = '2000';
            if($response[$i]['release'] !='' && $response[$i]['release'] !=NULL)
                $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['is_tvseries']                = $video['is_tvseries'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_tvseries_search_result($q='',$page='',$genre_id='',$country_id='',$range_to='',$range_from=''){
        $q          = trim($q);
        $page       = trim($page);
        $genre_id   = trim($genre_id);
        $country_id = trim($country_id);
        $range_to   = trim($range_to);
        $range_from = trim($range_from);

        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;

        if(!empty($q) && $q !='' && $q !=NULL):
            $this->db->like('title', $q,'both');
        endif;

        if(!empty($genre_id) && $genre_id !='' && $genre_id !=NULL && is_numeric($genre_id)):
            $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        endif;

        if(!empty($country_id) && $country_id !='' && $country_id !=NULL && is_numeric($country_id)):
            $this->db->where("find_in_set(".$country_id.",country) >",0);
        endif;

        if(!empty($range_from) && $range_from !='' && $range_from !=NULL && is_numeric($range_from) && strlen($range_from) ==4 && !empty($range_to) && $range_to !='' && $range_to !=NULL && is_numeric($range_to) && strlen($range_to) ==4):
            $release_from = date("Y-m-d",strtotime($range_from.'-01-01'));
            $this->db->where("release >=",$release_from);

            $release_to = date("Y-m-d",strtotime($range_to.'-12-31'));
            $this->db->where("release <=",$release_to);
        endif;
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '1');
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['release']                    = $video['release'];
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['is_tvseries']                = $video['is_tvseries'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_tv_channel_search_result($q='',$page='',$tv_category_id=''){
        $tv_category_id = trim($tv_category_id);
        $q              = trim($q);
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;

        if(!empty($q) && $q !='' && $q !=NULL):
            $this->db->like('tv_name', $q,'both');
        endif;

        if(!empty($tv_category_id) && $tv_category_id !='' && $tv_category_id !=NULL && is_numeric($tv_category_id)):
            $this->db->where("live_tv_category_id",$tv_category_id);
        endif;

        $this->db->where('publish', '1');
        $tvs  =   $this->db->get('live_tv')->result_array();
        $i              =   0;
        foreach ($tvs as $tv):
            $response[$i]['live_tv_id']                     = $tv['live_tv_id'];
            $response[$i]['tv_name']                        = $tv['tv_name'];
            $response[$i]['description']                    = strip_tags($tv['description']);
            $response[$i]['slug']                           = $tv['slug'];
            $response[$i]['stream_from']                    = $tv['stream_from'];
            $response[$i]['stream_label']                   = $tv['stream_label'];
            $response[$i]['stream_url']                     = $tv['stream_url'];
            $response[$i]['thumbnail_url']                  = $this->live_tv_model->get_tv_thumbnail($tv['thumbnail']);
            $response[$i]['poster_url']                     = $this->live_tv_model->get_tv_poster($tv['poster']);
            $i++;
        endforeach;
        return $response;
    }



    public function get_favorite($user_id='',$page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where('user_id', $user_id);
        $this->db->order_by('wish_list_id', 'DESC');
        $wish_lists     =   $this->db->get('wish_list')->result_array();
        //var_dump($wish_lists);
        $i                =   0;
        foreach ($wish_lists as $wish_list):
            $validity = $this->varify_videos_id($wish_list['videos_id']);
            if($validity):
                $response[$i]     = $this->get_movie_details_by_id($wish_list['videos_id']);
                $i++;
            endif;            
        endforeach;
        return $response;
    }
    function add_favorite($user_id   =   '' , $videos_id   =  ''){
        $credential    =   array(  'user_id' => $user_id , 'videos_id' => $videos_id , 'wish_list_type' => 'fav','wish_list_type' => 'fav','create_at'=> date('Y-m-d H:i:s'));
        $this->db->insert('wish_list',$credential);
        return TRUE;     
    }

    function remove_favorite($user_id   =   '' , $videos_id   =  ''){
        $credential    =   array(  'user_id' => $user_id , 'videos_id' => $videos_id);
        $this->db->where($credential);
        $this->db->delete('wish_list');
        return TRUE;     
    }

    public function verify_favorite_list($user_id   =   '' , $videos_id   =  '')
    {
        //var_dump($id);
        $result =   FALSE;
        $rows   =   $this->db->get_where('wish_list', array('user_id' => $user_id,'videos_id' => $videos_id))->num_rows();
        if($rows >    0):
            $result =   TRUE;
        endif;
        return $result;
    }



    // validate email  function
    function varify_videos_id($videos_id   =   ''){
        $result = FALSE;
        $credential    =   array(  'videos_id' => $videos_id);
        $query = $this->db->get_where('videos' , $credential);
        if ($query->num_rows() > 0):
            $result = TRUE;
        endif;    
        return $result;      
    }

    public function get_movie_details_by_id($id=''){
        $response                   = array();
        $this->db->where('videos_id', $id);
        $movie                      =   $this->db->get('videos')->row();        
        $response['videos_id']                  = $movie->videos_id;
        $response['title']                      = $movie->title;
        $response['description']                = strip_tags($movie->description);
        $response['slug']                       = $movie->slug;
        $response['release']                    = $movie->release;
        $response['runtime']                    = $movie->runtime;
        $response['video_quality']              = $movie->video_quality;
        $response['is_tvseries']                = $movie->is_tvseries;
        $response['thumbnail_url']              = $this->common_model->get_video_thumb_url($movie->videos_id);
        $response['poster_url']                 = $this->common_model->get_video_poster_url($movie->videos_id);        
        $response['videos']                     = $this->get_all_video_by_movie_id($movie->videos_id);      
        $response['genre']                      = $this->genre_details_generator($movie->genre);      
        $response['country']                    = $this->country_details_generator($movie->country);      
        $response['director']                   = $this->star_details_generator($movie->director);      
        $response['writer']                     = $this->star_details_generator($movie->writer);      
        $response['cast']                       = $this->star_details_generator($movie->stars);      
        return $response;
    }

    public function reset_password($email='',$password=''){
        $response                   = TRUE;
        $data['password']           = md5($password);
        $this->db->where('email', $email);
        $this->db->update('user', $data);     
        return $response;
    }

    public function get_all_comments($id=''){
        $response                   = array();
        $this->db->where('video_id', $id);
        $this->db->where('comment_type', '1');
        $this->db->order_by('comment_at', "DESC");
        $comments                               =   $this->db->get('comments')->result_array();
        $i          = 0;
        foreach ($comments as $comment):        
            $response[$i]['comments_id']                = $comment['comments_id'];
            $response[$i]['videos_id']                  = $comment['video_id'];
            $response[$i]['user_id']                    = $comment['user_id'];
            $response[$i]['user_name']                  = $this->common_model->get_name_by_id($comment['user_id']);
            $response[$i]['user_img_url']               = $this->common_model->get_img('user', $comment['user_id']);
            $response[$i]['comments']                   = $comment['comment'];
            $i++;
        endforeach;      
        return $response;
    }

    public function get_replay_by_comments_id($id=''){
        $response                   = array();
        $this->db->where('replay_for', $id);
        $this->db->where('comment_type', '2');
        $this->db->order_by('comment_at', "ASC");
        $comments                   =   $this->db->get('comments')->result_array();
        $i = 0;
        foreach ($comments as $comment):        
            $response[$i]['replay_id']                  = $comment['comments_id'];
            $response[$i]['videos_id']                  = $comment['video_id'];
            $response[$i]['user_id']                    = $comment['user_id'];
            $response[$i]['user_name']                  = $this->common_model->get_name_by_id($comment['user_id']);
            $response[$i]['user_img_url']               = $this->common_model->get_img('user', $comment['user_id']);
            $response[$i]['comments']                   = $comment['comment'];
            $i++;
        endforeach;      
        return $response;
    }

    function add_comments($user_id   =   '' , $videos_id   =  '',$comment   =  ''){
        $publication        =   '0';
        $comments_approval  =   $this->db->get_where('config' , array('title'=>'comments_approval'))->row()->value;
        if($comments_approval == '1'):
            $publication        =   '1';
        endif;
        $data         =   array(  'user_id' => $user_id , 'video_id' => $videos_id , 'comment_type' => '1','replay_for' => '0','comment'=>$comment,'comment_at'=> date('Y-m-d H:i:s'),'publication' => $publication);
        if($this->db->insert('comments',$data)):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;    
    }

    function add_replay($user_id   =   '' , $comments_id   =  '',$comment   =  ''){
        $videos_id = $this->get_videos_id_by_comment_id($comments_id);
        $publication        =   '0';
        $comments_approval  =   $this->db->get_where('config' , array('title'=>'comments_approval'))->row()->value;
        if($comments_approval == '1'):
            $publication        =   '1';
        endif;
        $data         =   array(  'user_id' => $user_id , 'video_id' => $videos_id , 'comment_type' => '2','replay_for' => $comments_id,'comment'=>$comment,'comment_at'=> date('Y-m-d H:i:s'),'publication' => $publication);
        if($this->db->insert('comments',$data)):
            return $this->db->insert_id();
        else:
            return FALSE;
        endif;    
    }

    public function get_videos_id_by_comment_id($id=''){
        $response                   = 0;
        $this->db->where('comments_id', $id);
        $response                  =   $this->db->get('comments')->row()->video_id;     
        return $response;
    }

    public function verify_comments_id($id='')
    {
        //var_dump($id);
        $result =   FALSE;
        $rows   =   $this->db->get_where('comments', array('comments_id' => $id))->num_rows();
        if($rows >    0):
            $result =   TRUE;
        endif;
        return $result;
    }

    public function get_features_genre_and_movie(){
        $response = array();
        $this->db->where('publication', '1');
        $this->db->where('featured', '1');
        $this->db->order_by("genre_id","ASC");
        $genres         =   $this->db->get('genre')->result_array();
        $i              =   0;
        foreach ($genres as $genre):
            if($this->movie_found_by_genre_id($genre['genre_id'])):
                $response[$i]['genre_id']               = $genre['genre_id'];
                $response[$i]['name']                   = $genre['name'];
                $response[$i]['description']            = strip_tags($genre['description']);
                $response[$i]['slug']                   = $genre['slug'];
                $response[$i]['url']                    = base_url('genre/'.$genre['slug'].'.html');
                $response[$i]['videos']                 = $this->get_movie_tvseries_by_genre_id($genre['genre_id']);
                $i++;
            endif;
        endforeach;
        return $response;
    }

    public function movie_found_by_genre_id($genre_id=''){
        $result = false;
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        $this->db->where('publication', '1');
        $query = $this->db->get('videos');
        if($query->num_rows() > 0):
            $result = true;
        endif;
        return $result;
    }

    public function get_movie_tvseries_by_genre_id($genre_id='',$page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        //$this->db->where('genere_id', $genere_id);
        $this->db->where('publication', '1');
        //$this->db->where('is_tvseries !=', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['release']                    = date("Y",strtotime($video['release']));
            $response[$i]['is_tvseries']                = $video['is_tvseries'];
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
            $i++;
        endforeach;
        return $response;
    }

    public function get_preroll_ads_details(){
        $response = array();
        $response['status']       =   $this->db->get_where('config' , array('title'=>'preroll_ads_enable'))->row()->value;
        $response['video_url']    =   $this->db->get_where('config' , array('title'=>'preroll_ads_video'))->row()->value;
        return $response;
    }

    public function get_admob_ads_details(){
        $response = array();
        $response['status']                     =   $this->db->get_where('config' , array('title'=>'admob_ads_enable'))->row()->value;
        $response['admob_publisher_id']         =   $this->db->get_where('config' , array('title'=>'admob_publisher_id'))->row()->value;
        $response['admob_app_id']               =   $this->db->get_where('config' , array('title'=>'admob_app_id'))->row()->value;
        $response['admob_banner_ads_id']        =   $this->db->get_where('config' , array('title'=>'admob_banner_ads_id'))->row()->value; 
        $response['admob_interstitial_ads_id']  =   $this->db->get_where('config' , array('title'=>'admob_interstitial_ads_id'))->row()->value;
        return $response;
    }
    
    function get_tv_connection_code($user_id=0) {
        $str                  = "";
        $characters         = array_merge(range('1','9'));
        $max                = count($characters) - 1;
        for ($i = 0; $i < 6; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        $data['code']           = $str;
        $data['user_id']        = $user_id;
        $data['create_time']    = time();
        $data['expire_time']    = strtotime("1 hour", time());
        $this->db->insert('tv_connection',$data);
        return $str;
    }

    // validate login  function
    function validate_tv_connection_code($code = '', $user_id=''){
        $result             = FALSE;
        //$credential         =   array('user_id'=>$user_id,'code' => $code,'create_time <'=>time(),'expire_time >'=> time());
        //$this->db->where('user_id',$user_id);
        $this->db->where('code',$code);
        $this->db->where('create_time <',time());
        $this->db->where('expire_time >',time());
        $query              = $this->db->get('tv_connection');
        if ($query->num_rows() > 0):
           // $this->db->where($credential);
            $result = TRUE;
        endif;   
        return $result;      
    }

    // validate login  function
    function get_user_id_by_tv_connection_code($code   =   ''){
        $result = "Invalid Code";
        $this->db->where('code',$code);
        $this->db->where('create_time <',time());
        $this->db->where('expire_time >',time());
        $query              = $this->db->get('tv_connection');
        if ($query->num_rows() > 0):
            $result = $query->row()->user_id;
        endif;    
        return $result;      
    }



    // Subscription started

    function create_trial_subscription($user_id=''){
        $data['user_id']        = $user_id;
        $data['plan_id']        = '0';
        $data['timestamp_from'] = time();
        $day                    = $this->db->get_where('config' , array('title'=>'trial_period'))->row()->value;
        $day_str                = $day." days";
        $data['timestamp_to']   = strtotime($day_str, $data['timestamp_from']);
        $data['status']         = '1';
        $this->db->insert('subscription', $data);
        return TRUE;
    }

    function create_subscription($user_id='',$plan_id=''){
        $data['user_id']        = $user_id;
        $data['plan_id']        = $plan_id;
        $data['timestamp_from'] = time();
        $day                    = $this->get_plan_day_by_id($plan_id);
        $day_str                = $day." days";
        $data['timestamp_to']   = strtotime($day_str, $data['timestamp_from']);
        $data['status']         = '1';
        $this->db->insert('subscription', $data);
        return TRUE;
    }

    function get_active_plan_title($user_id=''){
        $title =    'Free';
        $query =    $this->db->get_where('subscription',array('user_id' => $user_id,'status'=>'1'),1);
        if($query->num_rows() > 0):
            $plan_id = $query->row()->plan_id;
            if($plan_id == 0):
                $title = 'Trial';
            else:
                $title = $this->get_plan_name_by_id($plan_id);
            endif;
        endif;
      return $title;
    }

    function get_plan_name_by_id($plan_id){
        $name = "Not Found";
        if($plan_id == 0):
            $name = "Trial";
        endif;
        $query = $this->db->get_where('plan',array('plan_id'=>$plan_id));
        if($query->num_rows() >0):
            $name = $this->db->get_where('plan',array('plan_id'=>$plan_id))->row()->name;
        endif;
        return $name;
    }

    function get_plan_day_by_id($plan_id){
        return $this->db->get_where('plan',array('plan_id'=>$plan_id))->row()->day;
    }


    function get_active_plan_validity($user_id=''){
        $validity =    'Lifetime';
        $query =    $this->db->get_where('subscription',array('user_id' => $user_id,'status'=>'1'),1);
        if($query->num_rows() > 0):
            $date = time();
            if($date > $query->row()->timestamp_to):
                $validity = "Expired";
            else:
                $validity = date("d-m-Y",$query->row()->timestamp_to);
            endif;
        endif;
      return $validity;
    }

    function check_video_availability($slug=''){
        $error = FALSE;
        if ($slug == '' || $slug==NULL)
            $error = TRUE;

        $videos_exist = $this->common_model->videos_exist_by_slug($slug);
        if (!$videos_exist )
            $error = TRUE;
        return $error;
    }

    function check_live_tv_availability($slug=''){
        $error = FALSE;
        if ($slug == '' || $slug==NULL)
            $error = TRUE;

        $videos_exist = $this->common_model->live_tv_exist_by_slug($slug);
        if (!$videos_exist )
            $error = TRUE;
        return $error;
    }

    function videos_exist_by_slug($slug='') {
        $rows = $this->db->get_where('videos', array('slug' => $slug,'publication'=>'1'))->num_rows();
        if($rows >0){
          return TRUE;
        }
        else{
          return FALSE;
        }    
    }

    function live_tv_exist_by_slug($slug='') {
        $rows = $this->db->get_where('live_tv', array('slug' => $slug,'publish'=>'1'))->num_rows();
        if($rows >0){
          return TRUE;
        }
        else{
          return FALSE;
        }    
    }


    function check_video_accessibility($videos_id=''){
        $accessibility = "denied";        
        // free content can access by all
        $is_paid = $this->db->get_where('videos',array('videos_id'=>$videos_id))->row()->is_paid;
        if($is_paid =='0')
            $accessibility = "allowed";        
        if($is_paid =='1'):
            $subscription = $this->check_validated_subscription_plan();
            //var_dump($subscription);
            if($subscription == "login_required"):
                $accessibility = "login_required";
            elseif($subscription === "TRUE"):
                $accessibility = "allowed";
            endif;
        endif;
        // admin can access all movie
        if ($this->session->userdata('admin_is_login') == 1)
            $accessibility = "allowed";
        return $accessibility;
    }

    function check_live_tv_accessibility($live_tv_id=''){
        $accessibility = "denied";
        
        // free content can access by all
        $is_paid = $this->db->get_where('live_tv',array('live_tv_id'=>$live_tv_id))->row()->is_paid;
        if($is_paid =='0')
            $accessibility = "allowed";        
        if($is_paid =='1'):
            $subscription = $this->check_validated_subscription_plan();
            //var_dump($subscription);
            if($subscription == "login_required"):
                $accessibility = "login_required";
            elseif($subscription === "TRUE"):
                $accessibility = "allowed";
            endif;
        endif;
        // admin can access all movie
        if ($this->session->userdata('admin_is_login') == 1)
            $accessibility = "allowed";
        return $accessibility;
    }

    function check_validated_subscription_plan($user_id=''){
        $validity = "FALSE";
        if(!empty($user_id)):
            $this->db->where('status','1');
            $this->db->where('timestamp_to >',time());
            $this->db->where('user_id',$user_id);
            $query = $this->db->get('subscription');
            if($query->num_rows() >0):
                $validity = $query->row()->timestamp_to;
                if($validity > time())
                    $validity = "TRUE";
            endif;
        endif;
        if(empty($user_id)):
            $validity = "login_required";
        endif;
        return $validity;
    }

    function check_user_subscription_status($user_id=''){
        //var_dump($user_id);
        $validity = "inactive";
        if(!empty($user_id)):
            //var_dump($this->is_admin($user_id));
            if($this->is_admin($user_id)):
                $validity = "active";
            else:
                $this->db->where('status','1');
                $this->db->where('timestamp_to >',time());
                $this->db->where('user_id',$user_id);
                $query = $this->db->get('subscription');
                if($query->num_rows() >0):
                    $validity = $query->row()->timestamp_to;
                    if($validity > time())
                        $validity = "active";
                endif;
            endif;
        endif;
        return $validity;
    }

    function is_admin($user_id){
        //var_dump($user_id);
        $result     = false;
        $query = $this->db->get_where('user',array('user_id'=>$user_id));
        if($query->num_rows() > 0):
            if($query->row()->role =='admin')
                $result     = true;
        endif;
        return $result;
    }

    function get_active_subscription($user_id=''){
        $response = array();
        $this->db->where('status','1');
        $this->db->where('timestamp_to >',time());
        $this->db->where('user_id',$user_id);
        $subscriptions =  $this->db->get('subscription')->result_array();
        $i              =   0;
        foreach ($subscriptions as $row):
            $response[$i]['subscription_id']     = $row['subscription_id'];
            $response[$i]['plan_id']             = $row['plan_id'];
            $response[$i]['plan_title']          = $this->get_plan_name_by_id($row['plan_id']);
            $response[$i]['user_id']             = $row['user_id'];
            $response[$i]['price_amount']        = $row['price_amount'];
            $response[$i]['paid_amount']         = $row['paid_amount'];
            $response[$i]['start_date']          = date("d-m-Y",$row['timestamp_from']);
            $response[$i]['expire_date']         = date("d-m-Y",$row['timestamp_to']);
            $response[$i]['payment_method']      = $row['payment_method'];
            $response[$i]['payment_info']        = $row['payment_info'];
            $response[$i]['payment_timestamp']   = date("d-m-Y",$row['payment_timestamp']);
            $response[$i]['status']              = $row['status'];
            $i++;
        endforeach;
        return $response;
    }

    function get_user_active_event_list($user_id=''){
        $response = array();
        $this->db->where('status','1');
        $this->db->where('timestamp_to >',time());
        $this->db->where('user_id',$user_id);
        $subscriptions =  $this->db->get('event_subscription')->result_array();
        $i              =   0;
        foreach ($subscriptions as $row):
            $response[$i]     = $row['event_id'];
            $i++;
        endforeach;
        return $response;
    }

    function get_user_subscription_package_title_and_expired_date($user_id=''){
        $response['title']              = "Free";
        $response['expire_date']       = date('d-m-Y', strtotime("+100 years"));
        $this->db->where('status','1');
        $this->db->where('timestamp_to >',time());
        $this->db->where('user_id',$user_id);
        $query    = $this->db->get('subscription');
        if($query->num_rows() > 0):
            $response['title']          = $this->get_plan_name_by_id($query->first_row()->plan_id);
            $response['expire_date']    = date("d-m-Y",$query->first_row()->timestamp_to);
        endif;
        return $response;
    }

    function get_inactive_subscription($user_id=''){
        $response = array();
        $this->db->group_start();
        $this->db->where('status','0');
        $this->db->or_where('timestamp_to <',time());
        $this->db->group_end();
        $this->db->where('user_id',$user_id);
        $subscriptions =  $this->db->get('subscription')->result_array();
        $i              =   0;
        foreach ($subscriptions as $row):
            $response[$i]['subscription_id']     = $row['subscription_id'];
            $response[$i]['plan_id']             = $row['plan_id'];
            $response[$i]['plan_title']          = $this->get_plan_name_by_id($row['plan_id']);
            $response[$i]['user_id']             = $row['user_id'];
            $response[$i]['price_amount']        = $row['price_amount'];
            $response[$i]['paid_amount']         = $row['paid_amount'];
            $response[$i]['start_date']          = date("d-m-Y",$row['timestamp_from']);
            $response[$i]['expire_date']         = date("d-m-Y",$row['timestamp_to']);
            $response[$i]['payment_method']      = $row['payment_method'];
            $response[$i]['payment_info']        = $row['payment_info'];
            $response[$i]['payment_timestamp']   = date("d-m-Y",$row['payment_timestamp']);
            $response[$i]['status']              = $row['status'];
            $i++;
        endforeach;
        return $response;
    }

    function get_payment_config(){
        $response                               = array();
        $response['currency_symbol']            = $this->db->get_where('config' , array('title'=>'currency_symbol'))->row()->value;
        $response['currency']                   = $this->db->get_where('config' , array('title'=>'currency'))->row()->value;
        $response['exchnage_rate']              = $this->common_model->get_usd_exchange_rate($response['currency']);
        // paypal
        $response['paypal_enable']              = true;
        $query                                  = $this->db->get_where('config' , array('title'=>'paypal_enable'));
        if($query->num_rows() >0):
            if($query->first_row()->value == "false"):
                $response['paypal_enable']= false;
            endif;
        endif;
        $response['paypal_email']               = $this->db->get_where('config' , array('title'=>'paypal_email'))->row()->value;
        $response['paypal_client_id']           = $this->db->get_where('config' , array('title'=>'paypal_client_id'))->row()->value;
        // stripe
        $response['stripe_enable']              = true;
        $query                                  = $this->db->get_where('config' , array('title'=>'stripe_enable'));
        if($query->num_rows() >0):
            if($query->first_row()->value == "false"):
                $response['stripe_enable']= false;
            endif;
        endif;
        $response['stripe_publishable_key']     = $this->db->get_where('config' , array('title'=>'stripe_publishable_key'))->row()->value;
        $response['stripe_secret_key']          = $this->db->get_where('config' , array('title'=>'stripe_secret_key'))->row()->value;
        // razorpay
        $response['razorpay_enable']            = true;
        $query                                  = $this->db->get_where('config' , array('title'=>'razorpay_enable'));
        if($query->num_rows() >0):
            if($query->first_row()->value == "false"):
                $response['razorpay_enable']= false;
            endif;
        endif;
        $response['razorpay_key_id']            = $this->db->get_where('config' , array('title'=>'razorpay_key_id'))->row()->value;
        $response['razorpay_key_secret']        = $this->db->get_where('config' , array('title'=>'razorpay_key_secret'))->row()->value;
        $response['razorpay_inr_exchange_rate'] = 1;
        $query                                  = $this->db->get_where('config' , array('title'=>'razorpay_inr_exchange_rate'));
        if($query->num_rows() >0):
            $response['razorpay_inr_exchange_rate'] = $query->first_row()->value;
        endif;
        // offline payment
        $response['offline_payment_enable']     = false;
        $offline_payment_enable                                  = ovoo_config("offline_payment_enable");
        if($offline_payment_enable  === "true"):
            $response['offline_payment_enable']= true;
        endif;
        $response['offline_payment_title']               = ovoo_config("offline_payment_title");
        $response['offline_payment_instruction']         = ovoo_config("offline_payment_instruction");


        return $response;
    }

    function get_app_config(){
        $menu                   = $this->db->get_where('config' , array('title'=>'app_menu'))->row()->value;
        $program_guide_enable   = $this->db->get_where('config' , array('title'=>'app_program_guide_enable'))->row()->value;
        $mandatory_login        = $this->db->get_where('config' , array('title'=>'app_mandatory_login'))->row()->value;
        $genre_visible          = $this->db->get_where('config' , array('title' =>'genre_visible'))->row()->value;
        $country_visible        = $this->db->get_where('config' , array('title' =>'country_visible'))->row()->value;

        $response['menu']                   = 'grid';
        if($menu =="vertical"):
            $response['menu']               = 'vertical';
        endif;
        $response['program_guide_enable']   = false;

        $response['mandatory_login']        = false;
        if($mandatory_login == "true"):
            $response['mandatory_login']    = true;
        endif;

        $response['genre_visible']        = true;
        if($genre_visible == "false"):
            $response['genre_visible']    = false;
        endif;

        $response['country_visible']        = true;
        if($country_visible == "false"):
            $response['country_visible']    = false;
        endif;
        return $response;
    }

    function get_ads_config(){
        // mobile ads config
        $response['ads_enable']                         =   $this->db->get_where('config' , array('title'=>'mobile_ads_enable'))->row()->value;
        $response['mobile_ads_network']                 =   $this->db->get_where('config' , array('title'=>'mobile_ads_network'))->row()->value;
        $response['admob_app_id']                       =   $this->db->get_where('config' , array('title'=>'admob_app_id'))->row()->value;
        $response['admob_banner_ads_id']                =   $this->db->get_where('config' , array('title'=>'admob_banner_ads_id'))->row()->value; 
        $response['admob_interstitial_ads_id']          =   $this->db->get_where('config' , array('title'=>'admob_interstitial_ads_id'))->row()->value; 
        $response['admob_native_ads_id']                =   $this->db->get_where('config' , array('title'=>'admob_native_ads_id'))->row()->value; 
        $response['fan_native_ads_placement_id']        =   $this->db->get_where('config' , array('title'=>'fan_native_ads_placement_id'))->row()->value; 
        $response['fan_banner_ads_placement_id']        =   $this->db->get_where('config' , array('title'=>'fan_banner_ads_placement_id'))->row()->value; 
        $response['fan_interstitial_ads_placement_id']  =   $this->db->get_where('config' , array('title'=>'fan_interstitial_ads_placement_id'))->row()->value; 
        $response['fan_native_ads_placement_id']        =   $this->db->get_where('config' , array('title'=>'fan_native_ads_placement_id'))->row()->value; 
        $response['startapp_app_id']                    =   $this->db->get_where('config' , array('title'=>'startapp_app_id'))->row()->value;
        return $response;
    }

    function get_ads_config_new(){
        // mobile ads config
        $response['reward_ad']                          =   ovoo_config('reward_ad');
        $response['reward_ad_id']                       =   ovoo_config('reward_ad_id');

        $response['banner_ad']                          =   ovoo_config('banner_ad');
        $response['banner_ad_id']                       =   ovoo_config('banner_ad_id');

        $response['interstitial_ad']                    =   ovoo_config('interstitial_ad');
        $response['interstitial_ad_id']                 =   ovoo_config('interstitial_ad_id');
        $response['interstitial_ad_interval']           =   ovoo_config('interstitial_ad_interval');

        $response['native_ad']                          =   ovoo_config('native_ad');
        $response['native_ad_id']                       =   ovoo_config('native_ad_id');
        $response['native_ad_interval']                 =   ovoo_config('native_ad_interval');

        $response['admob_publisher_id']                 =   ovoo_config('admob_publisher_id');
        $response['unity_android_game_id']              =   ovoo_config('unity_android_game_id');
        $response['unity_ios_game_id']                  =   ovoo_config('unity_ios_game_id');
        $response['unity_test_mode']                    =   ovoo_config('unity_test_mode') =='1'? true:false;
        return $response;
    }


    function process_cancel_subscription($user_id="",$subscription_id=""){
        $result = false;
        $query                          = $this->db->get_where('subscription' , array('subscription_id' => $subscription_id, 'user_id'=>$user_id));
        if ($query->num_rows() > 0) {
            $data['status'] = '0';
            //$data['recurring'] = '0';
            $this->db->where('subscription_id',$subscription_id);
            $this->db->update('subscription',$data);
            $result = true;            
        }
        return $result;
    }

    // get APK version info
    public function get_apk_version_info() {
        $response['version_code']           =   $this->db->get_where('config' , array('title'=>'apk_version_code'))->row()->value;      
        $response['version_name']           =   $this->db->get_where('config' , array('title'=>'apk_version_name'))->row()->value;      
        $response['whats_new']              =   $this->db->get_where('config' , array('title'=>'apk_whats_new'))->row()->value;      
        $response['apk_url']                =   $this->db->get_where('config' , array('title'=>'latest_apk_url'))->row()->value;
        $response['is_skipable']            =   false;     
        $is_skipable                        =   $this->db->get_where('config' , array('title'=>'apk_update_is_skipable'))->row()->value;
        if($is_skipable == "1"):
            $response['is_skipable']            =   true;
        endif;     
        return $response;
    }

     // movie file
    public function video_file_order(){
        // season order
        $season_order   =   ovoo_config('video_file_order');
        if($season_order == 'DESC'):
            $season_order = 'DESC';
        else:
            $season_order = 'ASC';
        endif;
        return $season_order;
    }

    // tv-series order

    public function season_order(){
        // season order
        $season_order   =   ovoo_config('season_order');
        if($season_order == 'DESC'):
            $season_order = 'DESC';
        else:
            $season_order = 'ASC';
        endif;
        return $season_order;
    }

    public function episode_order(){
        // episode order
        $episode_order   =   ovoo_config('episode_order');
        if($episode_order == 'DESC'):
            $episode_order = 'DESC';
        else:
            $episode_order = 'ASC';
        endif;
        return $episode_order;
    }

    // validate email  function
    function user_exist_by_uid($uid   =   ''){
        if($uid =="" || $uid == NULL):
            return false;
        endif;
        $credential     =   array(  'firebase_auth_uid' => $uid);
        $query          =   $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            return true;
        else:
            return false;
        endif;    
    }

    // validate phone  function
    function user_exist_by_phone($phone   =   ''){
        if($phone =="" || $phone == NULL):
            return false;
        endif;
        $credential     =   array(  'phone' => $phone);
        $query          =   $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0):
            return true;
        else:
            return false;
        endif;   
    }

    // update last login time
    function update_last_login_info_by_user_id($user_id=''){
        $this->db->where('user_id',$user_id);
        $this->db->update('user', array('last_login' => date('Y-m-d H:i:s')));
        return true;
    }

    // get user info  function
    function get_user_info_by_phone($phone   =   ''){
        $credential     =   array(  'phone' => $phone );
        $result         = $this->db->get_where('user' , $credential)->row();   
        return $result;     
    }

    function get_now_playing_card_video_preview_url($videos_id,$is_tvseries =false){
        $blank_video_file = base_url("uploads/videos/blank.mp4");
        if($is_tvseries):            
            $this->db->order_by("seasons_id","DESC");
            $this->db->order_by("order","DESC");
            $this->db->where("videos_id",$videos_id);
            $this->db->where("file_source !=","emdeb");
            $this->db->where("file_source !=","youtube");
            $this->db->limit(1);
            $query = $this->db->get("episodes");
            if($query->num_rows()>0):
                return $query->first_row()->file_url;
            else:
                return $blank_video_file;
            endif;
        else:
            $this->db->order_by("order","ASC");
            $this->db->where("videos_id",$videos_id);
            $this->db->where("file_source !=","emdeb");
            $this->db->where("file_source !=","youtube");
            $this->db->limit(1);
            $query = $this->db->get("video_file");
            if($query->num_rows()>0):
                return $query->first_row()->file_url;
            else:
                return $blank_video_file;
            endif;
        endif;
    }

}


