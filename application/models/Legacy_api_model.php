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
 

class Legacy_api_model extends CI_Model {
    public  $default_limit  =   18;
    
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
                //$response[$i]['content']                = $this->get_movie_tvseries_by_genre_id($genre['genre_id']);
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
            $response[$i]['stream_url']                 = '';
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
            $response[$i]['stream_url']                 = '';
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
            $response[$i]['stream_url']                 = '';
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
            $response[$i]['stream_url']                 = '';
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
        $this->db->where('is_tvseries !=', '1');
        $this->db->order_by("videos_id","DESC");
        $latest_movies  =   $this->db->get('videos')->result_array();
        $i              =   0;
        foreach ($latest_movies as $video):
            $response[$i]['videos_id']                  = $video['videos_id'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['is_paid']                    = $video['is_paid'];
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['release']                    = $video['release'];
            $response[$i]['runtime']                    = $video['runtime'];
            $response[$i]['video_quality']              = $video['video_quality'];
            $response[$i]['thumbnail_url']              = $this->common_model->get_video_thumb_url($video['videos_id']);
            $response[$i]['poster_url']                 = $this->common_model->get_video_poster_url($video['videos_id']);
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
        $latest_tvs  =   $this->db->get('live_tv')->result_array();
        $i              =   0;
        foreach ($latest_tvs as $video):
            $response[$i]['slider_id']                  = $video['live_tv_id'];
            $response[$i]['title']                      = $video['tv_name'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['video_link']                 = $video['is_paid'];
            $response[$i]['slug']                       = $video['slug'];
            $response[$i]['publication']                = 1;
            $response[$i]['image_link']                 = $this->live_tv_model->get_tv_poster($video['poster']);
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

    public function get_movie_by_genre_id($genre_id='',$page=''){
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


    public function get_movie_by_country_id($country_id='',$page=''){
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
        $response['related_movie']              = $this->get_related_movie($movie->videos_id,trim($movie->genre),trim($movie->country));
        return $response;
    }

    function get_all_download_links($videos_id){
        $response   =   array();
        $this->db->where('videos_id',$videos_id);
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
                $i++;
            endforeach;
        endif;
        return $response;
    }

     function get_all_video_by_movie_id($videos_id){
        $response   =   array();
        $this->db->where('videos_id',$videos_id);
        $query = $this->db->get('video_file');
        if($query->num_rows() > 0):
            $videos = $query->result_array();
            $i      =   0;
            foreach ($videos as $video):
                $response[$i]['video_file_id']                  = $video['video_file_id'];
                $response[$i]['label']                          = strtoupper($video['file_source']);
                $response[$i]['stream_key']                     = $video['stream_key'];
                $response[$i]['file_type']                      = $video['file_source'];
                $response[$i]['file_url']                       = $video['file_url'];
                $response[$i]['subtitle']                       = $this->get_all_movie_subtitle($video['video_file_id']);
                if($video['file_source'] =='gdrive'):
                    $response[$i]['file_type']          = 'embed';
                    $response[$i]['label']              = 'GOOGLE';
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

    // function get_all_video_by_movie_id($videos_id){
    //     $response   =   array();
    //     $this->db->where('videos_id',$videos_id);
    //     $query = $this->db->get('video_file');
    //     if($query->num_rows() > 0):
    //         $videos = $query->result_array();
    //         $i      =   0;
    //         foreach ($videos as $video):
    //             $response[$i]['video_file_id']                  = $video['video_file_id'];
    //             $response[$i]['label']                          = $video['label'];
    //             $response[$i]['stream_key']                     = $video['stream_key'];
    //             $response[$i]['file_type']                      = $video['file_source'];
    //             $response[$i]['file_url']                       = $video['file_url'];
    //             $response[$i]['subtitle']                       = $this->get_all_movie_subtitle($video['video_file_id']);
    //             if($video['file_source'] =='gdrive'):
    //                 $response[$i]['file_type']          = 'embed';
    //                 $response[$i]['label']              = 'GOOGLE';
    //             elseif($video['file_source'] =='amazone'):
    //                 $response[$i]['file_type']          = 'mp4';
    //             elseif($video['file_source'] =='m3u8'):
    //                 $response[$i]['file_type']          = 'hls';
    //             elseif($video['file_source'] =='vimeo'):
    //                 $response[$i]['file_type']          = 'embed';
    //                 $response[$i]['file_url']           = str_replace('vimeo','player.vimeo',$video['file_url']);
    //                 $response[$i]['file_url']           = str_replace('.com/','.com/video/',$response[$i]['file_url']);
    //             endif;
    //             $i++;
    //         endforeach;
    //     endif;
    //     return $response;
    // }

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
            $response[$i]['genre']                  = $video['genre'];
            $response[$i]['country']                  = $video['country'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
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

    public function get_tvseries_by_genre_id($genre_id='',$page=''){
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
        $response['enable_download']            = '0';
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
        $response['season']                     = $this->get_season_episode($movie->videos_id);      
        $response['related_tvseries']           = $this->get_related_tvseries($movie->videos_id,trim($movie->genre),trim($movie->country));     
        return $response;
    }

    function get_season_episode($videos_id=''){
        $response   =   array();
        $this->db->order_by('seasons_id','DESC');
        $this->db->where('videos_id',$videos_id);
        $query      =   $this->db->get('seasons');
        if($query->num_rows() > 0):
            $seasons = $query->result_array();
            $i              =   0;
            foreach ($seasons as $season):
                $response[$i]['seasons_id']     = $season['seasons_id'];
                $response[$i]['seasons_name']   = $season['seasons_name'];
                $response[$i]['episodes']       = $this->get_episodes_with_all_video_by_movie_id($season['seasons_id']);
                $i++;
            endforeach;
        endif;
        return $response;
    }




    function get_episodes_with_all_video_by_movie_id($seasons_id){
        $response   =   array();
        $this->db->where('seasons_id',$seasons_id);
        $query = $this->db->get('episodes');
        if($query->num_rows() > 0):
            $episodes   =   $query->result_array();
            $i          =   0;
            foreach ($episodes as $episode):
                $response[$i]['episodes_id']     = $episode['episodes_id'];
                $response[$i]['episodes_name']   = $episode['episodes_name'];
                $response[$i]['stream_key']      = $episode['stream_key'];
                $response[$i]['file_type']       = $episode['file_source'];
                $response[$i]['image_url']       = $this->common_model->get_episode_image_url($episode['episodes_id'],$episode['videos_id']);
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
                $response[$i]['subtitle_id']            = $subtitle['subtitle_id'];
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
            $response[$i]['genre']                  = $video['genre'];
            $response[$i]['country']                  = $video['country'];
            $response[$i]['title']                      = $video['title'];
            $response[$i]['description']                = strip_tags($video['description']);
            $response[$i]['slug']                       = $video['slug'];
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
        if($tv->stream_from =='youtube'):
            $response['stream_url']     = str_replace('watch?v=','embed/',$tv->stream_url);
        elseif($tv->stream_from =='m3u8' || $tv->stream_from =='hls'):
                $response['stream_from'] = 'hls';
        elseif($tv->stream_from =='rtmp' || $tv->stream_from =='RTMP'):
                $response['stream_from'] = 'rtmp';
        endif;        
        $response['thumbnail_url']                  = $this->live_tv_model->get_tv_thumbnail($tv->thumbnail);
        $response['poster_url']                     = $this->live_tv_model->get_tv_poster($tv->poster);      
        $response['additional_media_source']        = $this->get_aditional_media_source($tv->live_tv_id);      
        $response['all_tv_channel']                 = $this->get_all_tv_channel();    
        $response['current_program_title']          = $this->get_cunnent_program_info('title');
        $response['current_program_time']           = $this->get_cunnent_program_info('time');
        $response['program_guide']                  = array(); //$this->get_all_program_guide_by_tv_td($tv->live_tv_id);    
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
        // $this->db->limit(1);
        // $this->db->order_by('time','DESC');
        // $this->db->where('date',date('Y-m-d'));
        // $this->db->where('time <=',date('H:i:s'));
        // $this->db->where('time >=',date("H:i:s", time() - 3600));
        // $query = $this->db->get('live_tv_program_guide');
        // if($query->num_rows() > 0)
        //     $response = $query->result_array();
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

    // validate login  function
    function validate_user_by_id_password($user_id   =   '' , $password   =  ''){
        $result = FALSE;
        $credential    =   array(  'user_id' => $user_id , 'password' => $password );
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
        return TRUE;     
    }


    // get user info  function
    function create_user_by_firebase_auth_uid($data){
        //$credential    =   array(  'email' => $email , 'password' => $password );        
        $this->db->insert('user', $data);
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


    public function get_movie_search_result($q='',$page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;

        $this->db->where('publication', '1');
        $this->db->where('is_tvseries !=', '1');
        $this->db->like('title', $q,'both');
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

    public function get_tvseries_search_result($q='',$page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;

        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '1');
        $this->db->like('title', $q,'both');
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

    public function get_tv_channel_search_result($q='',$page=''){
        $response = array();
        if(!empty($page) && $page !='' && $page !=NULL && is_numeric($page)):
            $offset = ((int)$page *   $this->default_limit)   -   $this->default_limit;
            $this->db->limit($this->default_limit,$offset);
        else:
            $this->db->limit($this->default_limit);
        endif;

        $this->db->where('publish', '1');
        $this->db->like('tv_name', $q,'both');
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

}


