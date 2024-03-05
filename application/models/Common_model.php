<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * OVOO
 *
 * OVOO-Movie & Video Streaming CMS with Unlimited TV-Series
 *
 * @package     OVOO
 * @author      Abdul Mannan
 * @copyright   Copyright (c) 2014 - 2020 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/
 

class Common_model extends CI_Model {
    
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


    function check_email_username($username='',$email='') {
      $this->db->where('email',$email);
      $this->db->or_where('username',$username);
        $rows = count($this->db->get('user')->result_array());
        if($rows >0){
            return TRUE;
        }
        else{
            return FALSE;
        }  
              
    }

    public function get_user_num_rows($name='')
    {
        if($name !="" && $name !=NULL):
            $this->db->like("name",$name,"both");
        endif;
        return $this->db->get('user')->num_rows();
    }

    public function get_users($name='',$limit=NULL, $start=NULL)
    {
        if($name !="" && $name !=NULL):
            $this->db->like("name",$name,"both");
        endif;
        $this->db->limit($limit,$start);
        return $this->db->get('user')->result_array();
    }

    function check_email($email='') {
        $result = FALSE;
        if($email !='' && $email != NULL):
            $this->db->where('email',$email);
            $rows = $this->db->get('user')->num_rows();
            if($rows > 0):
                $result = TRUE;
            endif;
        endif;
        return $result;              
    }

    function check_token($token='') {
        $this->db->where('token',$token);
        $rows = count($this->db->get('user')->result_array());
        if($rows >0){
            return TRUE;
        }
        else{
            return FALSE;
        }    
    }


    function slug_exist($table='',$slug='') {
        $rows = count($this->db->get_where($table, array('slug' => $slug))->result_array());
        if($rows >0){
          return TRUE;
        }
        else{
          return FALSE;
        }      
    }

    function slug_num($table='',$slug='') {
        return count($this->db->get_where($table, array('slug' => $slug))->result_array());
    }

    function get_video_type($video_type_id=''){
        $query = $this->db->get_where('video_type', array('video_type_id' => $video_type_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['video_type'];
    }

    function get_category_name($category_id=''){
        $query = $this->db->get_where('post_category', array('post_category_id' => $category_id));
        $res = $query->result_array();
        foreach ($res as $row)
            return $row['category'];
    }
        /* get image url */
    function get_img($type = '' , $id = '')
    {
        if(file_exists('uploads/'.$type.'_image/'.$id.'.jpg')):
            $image_url  =   base_url().'uploads/'.$type.'_image/'.$id.'.jpg';
        elseif(ovoo_config('active_theme') == 'flix'):
            $image_url  =   base_url().'uploads/default_image_flix/image_152X152.png';
        else:
            $image_url  =   base_url().'uploads/user.jpg';
        endif;
        return $image_url;
    }

    function get_star_image($id){
        if(file_exists('uploads/star_image/'.$id.'.jpg')):
            return base_url().'uploads/star_image/'.$id.'.jpg';
        else:
            if(version_compare(ovoo_config('version'), '2.3.1', '>')):
                return base_url().'uploads/default_image/star138x175.jpg';
            else:
                return base_url().'uploads/user.jpg';
            endif;
        endif;
    }

    function get_episode_image_url($videos_id="",$episode_id = "")
    {
        if(file_exists('uploads/episodes/'.$episode_id.'.jpg')):
            return base_url().'uploads/episodes/'.$episode_id.'.jpg';
//        elseif(file_exists('uploads/video_thumb/'.$videos_id.'.jpg')):
//            return base_url().'uploads/video_thumb/'.$videos_id.'.jpg';
        else:
            return base_url().'uploads/default_image/episode.jpg';
        endif;
    }

    function get_genre_image_url($id = '')
    {
        if(file_exists('uploads/genre/'.$id.'.png'))
            $image_url  =   base_url().'uploads/genre/'.$id.'.png';
        else
            $image_url  =   base_url().'uploads/default_image/genre.png';            
        return $image_url;
    }
    function get_country_image_url($id = '')
    {
        if(file_exists('uploads/country/'.$id.'.png'))
            $image_url  =   base_url().'uploads/country/'.$id.'.png';
        else
            $image_url  =   base_url().'uploads/default_image/country.png';            
        return $image_url;
    }
    
        /* create and download database backup*/
    function create_backup()
    {
        $this->load->dbutil();  
        $options = array(
                'format'      => 'txt',             
                'add_drop'    => TRUE,              
                'add_insert'  => TRUE,              
                'newline'     => "\n"               
              );
        $tables   = array();
        $file_name  =   'db_backup_'.date('Y-m-d-H-i-s');
        $backup = $this->dbutil->backup(array_merge($options , $tables));
        $this->load->helper('file');
        write_file('db_backup/'.$file_name.'.sql', $backup); 
        //$this->load->helper('download');
        //force_download($file_name.'.sql', $backup);
        return 'done';
    }
    
    
        /* restore database backup*/    
    function restore_backup()
    {
        
        move_uploaded_file($_FILES['backup_file']['tmp_name'], 'uploads/backup.sql');

        $prefs = array(
            'filepath'                      => 'uploads/backup.sql',
            'delete_after_upload'           => TRUE,
            'delimiter'                     => ';'
        );
        
        $schema = htmlspecialchars(file_get_contents($prefs['filepath']));

        $query = rtrim( trim($schema), "\n;");

        $query_list = explode(";", $query);
        $this->truncate();  
        

        foreach($query_list as $query){
            $this->db->query($query);
        }
        //$restore =& $this->dbutil->restore($prefs);
        unlink($prefs['filepath']);
    }
    
        /* empty data from table */
    function truncate() {
            $this->db->truncate('access');
            $this->db->truncate('accessories');
            $this->db->truncate('apps');
            $this->db->truncate('brand');
            $this->db->truncate('category');
            $this->db->truncate('computer');
            $this->db->truncate('ip');
            $this->db->truncate('device');
            $this->db->truncate('os');
            $this->db->truncate('supplier');  
    }

    function set_custom_value(){
         $data['value'] = "SpaGreen Creative";
         $this->db->where('title' , 'company_name');
         $this->db->update('config' , $data);
         
         $data['value'] = "Gulshan, Dhaka-1200";
         $this->db->where('title' , 'address');
         $this->db->update('config' , $data);
         
         $data['value'] = "880100000000";
         $this->db->where('title' , 'phone');
         $this->db->update('config' , $data);
         
         $data['value'] = "support@spagreen.net";
         $this->db->where('title' , 'system_email');
         $this->db->update('config' , $data);
    }

     function reset_database(){
        $this->set_custom_value();
        $this->truncate();
    $prefs = array(
            'filepath'                      => 'uploads/data.sql',
            'delete_after_upload'           => FALSE,
            'delimiter'                     => ';'
        );
        
        $schema = htmlspecialchars(file_get_contents($prefs['filepath']));

        $query = rtrim( trim($schema), "\n;");

        $query_list = explode(";", $query);
        $this->truncate();
        foreach($query_list as $query){
            $this->db->query($query);
        }
        unlink($prefs['filepath']);

    }


    public function all_published_slider()
    {
        $this->db->order_by("order","ASC");
        return $this->db->get_where('slider', array('publication'=> '1'), 8)->result();
    }

    public function all_published_videos($limit='',$page='')
    {        
        $offset = ($page*$limit)-$limit;
        if($offset<0){
            $offset = 0;
        }
        $this->db->where('is_tvseries','0');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit($limit,$offset);
        return $this->db->get('videos')->result_array();
    }

    public function all_published_channels($limit='',$page='')
    {        
        $offset = ($page*$limit)-$limit;
        if($offset<0){
            $offset = 0;
        }
        $this->db->where('publish', '1');
        $this->db->order_by("live_tv_id","desc");
        $this->db->limit($limit,$offset);
        return $this->db->get('live_tv')->result_array();
    }

    public function most_watched_videos($limit='',$page='')
    {        
        $offset = ($page*$limit)-$limit;
        if($offset<0){
            $offset = 0;
        }
        $this->db->where('publication', '1');
        $this->db->order_by("total_view","DESC");
        $this->db->limit($limit,$offset);
        return $this->db->get('videos')->result_array();
    }


    public function get_hot_videos($limit=12)
    {        
        $this->db->where('is_tvseries','0');
        $this->db->where('publication', '1');
        $this->db->order_by("total_view","desc");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }

    public function get_today_hot_videos($limit=12)
    {        
        $this->db->where('is_tvseries','0');
        $this->db->where('publication', '1');
        $this->db->order_by("today_view","desc");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }


    public function get_weekly_hot_videos($limit=12)
    {        
        $this->db->where('is_tvseries','0');
        $this->db->where('publication', '1');
        $this->db->order_by("weekly_view","desc");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }

    public function get_monthly_hot_videos($limit=12)
    {        
        $this->db->where('is_tvseries','0');
        $this->db->where('publication', '1');
        $this->db->order_by("monthly_view","desc");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }


    public function get_top_rated_videos($limit=12)
    {        
        $this->db->where('is_tvseries','0');
        $this->db->where('publication', '1');
        $this->db->order_by("total_rating","desc");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }

    public function get_hot_tvseries($limit=12)
    {        
        $this->db->where('is_tvseries','1');
        $this->db->where('publication', '1');
        $this->db->order_by("total_view","desc");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }

    public function get_today_hot_tvseries($limit=12)
    {        
        $this->db->where('is_tvseries','1');
        $this->db->where('publication', '1');
        $this->db->order_by("today_view","desc");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }


    public function get_weekly_hot_tvseries($limit=12)
    {        
        $this->db->where('is_tvseries','1');
        $this->db->where('publication', '1');
        $this->db->order_by("weekly_view","desc");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }


    public function get_top_rated_tvseries($limit=12)
    {        
        $this->db->where('is_tvseries','1');
        $this->db->where('publication', '1');
        $this->db->order_by("total_rating","desc");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }


    public function get_features_genres($limit=5)
    {  
        $this->db->where('featured', '1');
        $this->db->where('publication', '1');
        $this->db->order_by("genre_id","desc");
        $this->db->limit($limit);
        return $this->db->get('genre')->result_array();
    }

    public function get_features_genres_homepage($limit=5)
    {  
        $this->db->where('featured', '1');
        $this->db->where('publication', '1');
        $this->db->limit($limit);
        return $this->db->get('genre')->result_array();
    }


    public function new_published_videos($limit='',$page='')
    {
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '0');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(12);
        return $this->db->get('videos')->result_array();
    }

    public function latest_published_videos($limit=12,$page='')
    {
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '0');
        $this->db->order_by("videos_id","desc");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }

    public function new_published_tv_series($limit='',$page='')
    {
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(12);
        return $this->db->get('videos')->result_array();
    }

    public function latest_published_tv_series($limit=16,$page='')
    {
        $this->db->where('publication', '1');
        $this->db->where('is_tvseries', '1');
        $this->db->order_by("last_ep_added","DESC");
        $this->db->limit($limit);
        return $this->db->get('videos')->result_array();
    }

    public function get_num_episodes_by_id($videos_id='')
    {
        return $this->db->get_where('episodes', array('videos_id'=>$videos_id))->num_rows();
    }

    public function get_num_episodes_by_seasons_id($seasons_id='')
    {
        return $this->db->get_where('episodes', array('seasons_id'=>$seasons_id))->num_rows();
    }

    public function all_published_tv_series()
    {
        $this->db->where('is_tvseries', '1');
        $this->db->where('publication', '1');
        $this->db->order_by("last_ep_added","DESC");
        $this->db->limit(12);
        $query_result = $this->db->get('videos');
        $result = $query_result->result();
        return $result;
    }

    public function all_published_request_movies()
    {
        $this->db->where("FIND_IN_SET(left(3,10),video_type)>0");
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(12);
        $query_result = $this->db->get('videos');
        $result = $query_result->result();
        return $result;
    }

    public function all_page_on_primary_menu()
    {
        $this->db->where('primary_menu', '1');
        $this->db->order_by("page_id","ASC");
        $query_result = $this->db->get('page');
        $result = $query_result->result();
        return $result;
    }

    public function all_video_type_on_primary_menu()
    {
        $this->db->where('primary_menu', '1');
        $this->db->order_by("video_type_id","ASC");
        $query_result = $this->db->get('video_type');
        $result = $query_result->result();
        return $result;
    }
    public function all_video_type_on_footer_menu()
    {
        $this->db->where('footer_menu', '1');
        $this->db->order_by("video_type_id","ASC");
        $query_result = $this->db->get('video_type');
        $result = $query_result->result();
        return $result;
    }

    public function all_page_on_footer_menu()
    {
      $this->db->select('*');
        $this->db->from('page');
        $this->db->where('footer_menu', '1');
        $this->db->order_by("page_id","ASC");
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }    
    
    public function all_published_trailers()
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('is_tvseries', '0');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(6);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
   

    public function get_videos_by_slug($slug)
    {
        return $this->db->get_where('videos', array('slug' => $slug))->row();
    }
    public function get_videos_id_by_slug($slug)
    {
        return $this->db->get_where('videos', array('slug' => $slug))->row()->videos_id;
    }
    public function watch_count_by_slug($videos_id='')
    {
        //$videos_id          =   $this->db->get_where('videos', array('videos_id' => $videos_id))->row()->videos_id;
        $today_view         =   $this->db->get_where('videos', array('videos_id' => $videos_id))->row()->today_view;
        $weekly_view        =   $this->db->get_where('videos', array('videos_id' => $videos_id))->row()->weekly_view;
        $monthly_view       =   $this->db->get_where('videos', array('videos_id' => $videos_id))->row()->monthly_view;
        $total_view         =   $this->db->get_where('videos', array('videos_id' => $videos_id))->row()->total_view;
        
        $data['today_view'] =    $today_view +   1;
        $this->db->where('videos_id', $videos_id);
        $this->db->update('videos', $data);


        $data['weekly_view'] =    $weekly_view +   1;
        $this->db->where('videos_id', $videos_id);
        $this->db->update('videos', $data);

        $data['monthly_view']=    $monthly_view +   1;
        $this->db->where('videos_id', $videos_id);
        $this->db->update('videos', $data);


        $data['total_view'] =    $total_view +   1;
        $this->db->where('videos_id', $videos_id);
        $this->db->update('videos', $data);
    }    

    public function type_is_exist($slug)
    {
        $num_rows = $this->db->get_where('video_type', array('slug' => $slug))->num_rows();
        if($num_rows > 0):
            return true;
        else:
            return false;
        endif;
    }

    public function get_star_id_by_slug($slug)
    {
        if(count($this->db->get_where('star', array('slug' => $slug))->result_array())> 0):
            $star_id = $this->db->get_where('star', array('slug' => $slug))->row()->star_id;
        else:
            $star_id =0;
        endif;
        return $star_id;
    }

    public function get_video_by_star($limit, $start,$star_id)
    {
        $data =array();
        $this->db->group_start();
        $this->db->where("FIND_IN_SET($star_id,stars)>0");
        $this->db->or_where("FIND_IN_SET($star_id,director)>0");
        $this->db->or_where("FIND_IN_SET($star_id,writer)>0");
        $this->db->group_end();
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit($limit,$start);
        $query = $this->db->get('videos');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return $data;
    }

    public function convert_star_ids_to_names($ids='')
    {
        $names = '';
        if($ids !='' && $ids !=NULL):
            $i = 0;
            $stars =explode(',', $ids);                                               
            foreach ($stars as $star_id):
                if($i>0){ $names .=',';} $i++;
                $names .= $this->common_model->get_star_name_by_id($star_id);
            endforeach;
        endif;
        return $names;
    }

    public function get_video_by_star_record_count($star_id)
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->group_start();
        $this->db->where("FIND_IN_SET($star_id,stars)>0");
        $this->db->or_where("FIND_IN_SET($star_id,director)>0");
        $this->db->or_where("FIND_IN_SET($star_id,writer)>0");
        $this->db->group_end();
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $query = $this->db->get();        
        return $query->num_rows();
    }

    public function get_video_by_director($limit, $start,$director)
    {
        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->like('director', $director);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';
    }

    public function get_videos_num_rows($array=array())
    {
        if($array !='' && $array !=NULL && !empty($array))
            $this->db->like($array);
        $query = $this->db->get('videos');
        return $query->num_rows();
    }

     public function get_videos($array=array(),$limit=NULL, $start=NULL)
    {
        if($array !='' && $array !=NULL && !empty($array))
            $this->db->like($array);
        $this->db->order_by("videos_id","desc");
        $this->db->limit($limit,$start);
        $query = $this->db->get('videos');
        if ($query->num_rows() > 0){
            return $query->result_array();        
        }else{
            return array();
        }
    }

    public function get_stars($limit=10, $start=0)
    {
        $this->db->order_by("view","DESC");
        $this->db->limit($limit,$start);
        $query = $this->db->get_where('star', array('status'=>'1'));
        $data = $query->result_array(); 
        if ($query->num_rows() > 0){
            return $data;        
        }
    }

    public function get_popular_stars($limit=10, $start=0)
    {
        $this->db->order_by("view","DESC");
        $this->db->limit($limit,$start);
        $query = $this->db->get_where('star', array('status'=>'1'));
        $data = $query->result_array(); 
        if ($query->num_rows() > 0){
            return $data;        
        }
        return array();
    }

    public function get_latest_episodes($limit=10, $start=0)
    {
        $this->db->order_by("episodes_id","DESC");
        $this->db->limit($limit,$start);
        $query = $this->db->get_where('episodes');
        $data = $query->result_array(); 
        if ($query->num_rows() > 0){
            return $data;        
        }
    }



    public function get_tvseries($limit=NULL, $start=NULL)
    {        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where('is_tvseries', '1');
        $this->db->order_by("last_ep_added","DESC");
        $this->db->limit($limit,$start);
        $query = $this->db->get();
        if ($query->num_rows() > 0){
            return $query->result_array();        
        }
    }

    public function get_video_by_director_record_count($director)
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->like('director', $director);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();        
        return $query->num_rows();
    }

    public function get_video_by_tags($limit, $start,$tags)
    {
        $this->db->like('tags', $tags);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit($limit,$start);
        $query = $this->db->get("videos");        
        return $query->result_array();

    }

    public function get_video_by_year($limit, $start,$year)
    {
        //$start = ($limit * $start) - $limit;
        $this->db->like('release', $year);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit($limit,$start);
        $query = $this->db->get("videos");
        return $query->result_array();
    }
    public function get_video_by_year_record_count($year)
    {
        $this->db->like('release', $year);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $query = $this->db->get("videos");    
        return $query->num_rows();
    }

    public function get_video_by_tags_record_count($tag)
    {
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->like('tags', $tag);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();        
        return $query->num_rows();
    }    
    
    // star movie import
    public function get_star_ids_for_movie_import($type='',$stars='')
    {
        $stars          = explode(',', $stars);
        $data           = array();
        $i=0;
        foreach ($stars as $star) { 
            $data[$i]['id']      =   $this->get_star_id_by_name($type,trim($star));
            $data[$i]['text']     =   trim($star);
            $i++;
        }
        return $data;
    }

    // star
    public function get_star_ids($type='',$stars='')
    {
        $stars          = explode(',', $stars);
        $ids            = '';
        $i=0;
        foreach ($stars as $star) {
            $i++;
            if($i>1){
               $ids .=',';
            }
            $ids .=$this->get_star_id_by_name($type,$star);
        }
        return $ids;
    }

    function get_star_name_by_id($star_id)
    {
        if(is_numeric($star_id) && $star_id !=''):
            $query  =   $this->db->get_where('star' , array('star_id' => $star_id));
            $res    =   $query->result_array();
            foreach($res as $row)           
                return $row['star_name'];
        else:
            return $star_id;
        endif;
    }

    function count_start_view($star_id)
    {
        if(is_numeric($star_id) && $star_id !=''):
            $query  =   $this->db->get_where('star' , array('star_id' => $star_id));
            if($query->num_rows() > 0):
                $current_view = $query->row()->view;
                $data['view'] = $current_view +1;
                $this->db->where("star_id",$star_id);
                $this->db->update("star",$data);
                return true;
            else:
                return false;
            endif;
        else:
            return false;
        endif;
    }


    function get_star_slug_by_id($star_id)
    {
        $query  =   $this->db->get_where('star' , array('star_id' => $star_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['slug'];
    }

    public function get_star_id_by_name($type,$name)
    {
        $name =$this->get_filtered_string($name);
        $result =   count($this->db->get_where('star', array('star_name' => $name))->result_array());
        if($result >    0){
            $star_id = $this->db->get_where('star', array('star_name' => $name))->row();
                return $star_id->star_id;
        }else{            
            $data['slug']                   = $this->get_seo_url($name);
            $data['star_name']              = $name;
            $data['star_type']              = $type;
            $data['star_desc']              = ' ';
            $data['status']                 = '1';
            $this->db->insert('star', $data);
            return $this->db->insert_id();
        }
    }

    
    public function movies_record_count()
    {
        $this->db->where("is_tvseries !=","1");
        $this->db->where("publication","1");
        $query = $this->db->get('videos');
        return $query->num_rows();
    }

    public function channel_record_count()
    {
        $this->db->where("publish","1");
        $query = $this->db->get('live_tv');
        return $query->num_rows();
    }



    public function search_movies_record_count($search='')
    {
        $query = $this->db->like('title', $search)->get('videos');
        
        return $query->num_rows();
    }
    
    public function tv_series_record_count()
    {
        return $this->db->get_where('videos', array('is_tvseries'=>'1'))->num_rows();
    }

    public function is_video_published($videos_id)
    {
        $publication                    =   $this->db->get_where('videos' , array('videos_id'=>$videos_id))->row()->publication;
        
        if($publication =='1')
            return true;
        else
            return false;        
    }
    
    public function requested_movie_record_count()
    {
        $query = $this->db->where("FIND_IN_SET(left(3,10),video_type)>0")->get('videos');
        //$query = $this->db->where('video_type', '3')->get('videos');
        
        return $query->num_rows();
    }
    
    public function trailers_record_count()
    {
        $query = $this->db->where("FIND_IN_SET(left(4,10),video_type)>0")->get('videos');
        //$query = $this->db->where('video_type', '4')->get('videos');
        
        return $query->num_rows();
    }
    
   public function fetch_videos($limit, $start) {
        $this->db->limit($limit, $start);
        
        $this->db->select('*');
        $this->db->from('videos');
        //$this->db->where('video_type', '1');
        $this->db->where("FIND_IN_SET(left(1,10),video_type)>0");
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }

   public function fetch_search_videos($limit, $start,$search) {
        $this->db->limit($limit, $start);
        $this->db->like('title',$search);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        return $this->db->get('videos')->result_array();        
   }

   
   public function fetch_tv_series($limit, $start) {
        $this->db->where('is_tvseries','1');
        $this->db->where('publication', '1');
        $this->db->order_by("last_ep_added","DESC");
        $this->db->limit($limit,$start);
        $query = $this->db->get("videos");
        return $query->result_array();
   }
   
   public function fetch_request_movies($limit, $start) {
        $this->db->limit($limit, $start);
        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where("FIND_IN_SET(left(3,10),video_type)>0");
        //$this->db->where('video_type', '3');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(32);
        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
   
   public function fetch_trailers($limit, $start) {
        $this->db->limit($limit, $start);
        $this->db->where("FIND_IN_SET(left(4,10),video_type)>0");
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(32);
        $query = $this->db->get('videos');
        

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }   

   public function fetch_video_type_video_by_slug($limit, $start, $slug)
   {
        $video_type = $this->db->get_where('video_type', array('slug' => $slug))->row()->video_type_id;
        $this->db->limit($limit, $start);
        $this->db->where("find_in_set(".$video_type.",video_type) >",0);
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");;
        $query = $this->db->get("videos");
        return $query->result_array();
    }

  public function fetch_video_type_video_by_slug_record_count($slug)
    {
        $video_type = $this->db->get_where('video_type', array('slug' => $slug))->row();
        $query = $this->db->where(array('video_type'=>$video_type->video_type_id))->get('videos');        
        return $query->num_rows();
    }

    public function fetch_country_video_by_slug($limit, $start, $slug) {
        $country_id = $this->db->get_where('country', array('slug' => $slug))->row();
        $this->db->limit($limit, $start);        
        $this->db->select('*');
        $this->db->from('videos');
        $this->db->where("FIND_IN_SET(left($country_id->country_id,10),country)>0");
        //$this->db->where('country', $country_id->country_id);
        //$this->db->where('video_type', '3');
        $this->db->where('publication', '1');
        $this->db->order_by("videos_id","desc");
        $this->db->limit(24);
        $query = $this->db->get();
        

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';
   }

   public function fetch_country_video_by_slug_record_count($slug)
    {
        $country_id = $this->db->get_where('country', array('slug' => $slug))->row();
        $query = $this->db->where(array('country'=>$country_id->country_id))->get('videos');
        
        return $query->num_rows();
    }


    public function fetch_blog_post($limit=10, $page=1) {
        $result = array();
        $offset = ($page*$limit)-$limit;
        if($offset<0){
            $offset = 0;
        }
        $this->db->limit($limit, $offset);        
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('publication', '1');
        $this->db->order_by("posts_id","DESC");
        $query = $this->db->get();      

        if ($query->num_rows() > 0) {
            $result = $query->result();
        }
        return $result;
    }

    public function get_latest_post($limit) {
        $result = array();
        $this->db->limit($limit);
        $this->db->where('publication', '1');
        $this->db->order_by("posts_id","DESC");
        $query = $this->db->get('posts');      

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }
        return $result;
    }

    public function fetch_blog_post_record_count()
    {
        
        $query = $this->db->where(array('publication'=>'1'))->get('posts');
        
        return $query->num_rows();
    }
    public function post_comments_record_count_by_id($id='')
    {
        
        $query = $this->db->where(array('post_id'=>$id, 'comment_type'=>'1','publication'=>'1'))->get('post_comments');
        
        return $query->num_rows();
    }

    public function fetch_blog_post_by_category_record_count($slug)
    {        
        $category_id = $this->db->get_where('post_category', array('slug' => $slug))->row();
        $this->db->where("FIND_IN_SET(left($category_id->post_category_id,10),category_id)>0");
        $this->db->where('publication', '1');
        $query = $this->db->get('posts');        
        return $query->num_rows();
    }
    public function fetch_blog_post_by_category($limit, $start, $slug)
    {
        $category_id = $this->db->get_where('post_category', array('slug' => $slug))->row();
        $this->db->limit($limit, $start);        
        $this->db->select('*');
        $this->db->where("FIND_IN_SET(left($category_id->post_category_id,10),category_id)>0");
        $this->db->where('publication', '1');
        $this->db->order_by("posts_id","desc");
        $this->db->limit(10);
        $query = $this->db->get('posts');        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';
    }

    public function fetch_blog_post_by_author_record_count($slug)
    {        
        $author_id = $this->db->get_where('user', array('slug' => $slug))->row();
        $this->db->where('user_id',$author_id->user_id);
        $this->db->where('publication', '1');
        $query = $this->db->get('posts');        
        return $query->num_rows();
    }
    public function fetch_blog_post_by_author($limit, $start, $slug)
    {
        $author_id = $this->db->get_where('user', array('slug' => $slug))->row();
        $this->db->limit($limit, $start);        
        $this->db->select('*');
        $this->db->where('user_id',$author_id->user_id);
        $this->db->where('publication', '1');
        $this->db->order_by("posts_id","desc");
        $this->db->limit(10);
        $query = $this->db->get('posts');        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return '';
    }
   
   public function search_result($search)
   {
     $this->db->like('title',$search);
     $query  =   $this->db->get('videos');
         return $query->result();
   }


   function get_image_url($type = '' , $id = '')
    {
        if(file_exists('uploads/'.$type.'_image/'.$id.'.jpg'))
            $image_url  =   base_url().'uploads/'.$type.'_image/'.$id.'.jpg';
        else
            $image_url  =   base_url().'uploads/user.jpg';
            
        return $image_url;
    }

    function get_video_thumb_url($videos_id = '')
    {
        if(file_exists('uploads/video_thumb/'.$videos_id.'.jpg'))
            $image_url  =   base_url().'uploads/video_thumb/'.$videos_id.'.jpg';
        else
            $image_url  =   base_url().'uploads/default_image/thumbnail.jpg';
            
        return $image_url;
    }

    function get_video_poster_url($videos_id = '')
    {
        if(file_exists('uploads/poster_image/'.$videos_id.'.jpg'))
            $image_url  =   base_url().'uploads/poster_image/'.$videos_id.'.jpg';
        else if(file_exists('uploads/video_thumb/'.$videos_id.'.jpg'))
            $image_url  =   base_url().'uploads/video_thumb/'.$videos_id.'.jpg';
        else
            $image_url  =   base_url().'uploads/default_image/poster.jpg';            
        return $image_url;
    }

    function get_video_original_poster_url($videos_id = '')
    {
        if(file_exists('uploads/poster_image/'.$videos_id.'.jpg'))
            $image_url  =   base_url().'uploads/poster_image/'.$videos_id.'.jpg';
        else
            $image_url  =   base_url().'uploads/default_image/poster.jpg';            
        return $image_url;
    }


    function get_video_poster_admin_url($videos_id = '')
    {
        if(file_exists('uploads/poster_image/'.$videos_id.'.jpg'))
            $image_url  =   base_url().'uploads/poster_image/'.$videos_id.'.jpg';
        
        else
            $image_url  =   base_url().'uploads/default_image/poster.jpg';
            
        return $image_url;
    }    


   function get_name_by_id($user_id)
    {
        $query  =   $this->db->get_where('user' , array('user_id' => $user_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['name'];
    }

    

    function get_slug_by_user_id($user_id)
    {
        $query  =   $this->db->get_where('user' , array('user_id' => $user_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['slug'];
    }

    function get_category_name_by_id($category_id)
    {
        $query  =   $this->db->get_where('post_category' , array('post_category_id' => $category_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['category'];
    }

    function get_slug_by_category_id($category_id)
    {
        $query  =   $this->db->get_where('post_category' , array('post_category_id' => $category_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['slug'];
    }

    public function post_is_exist($slug='')
    {
        $num_rows = $this->db->get_where('posts', array('slug' => $slug))->num_rows();
        if($num_rows > 0):
            return true;
        else:
            return false;
        endif;

    }

    public function get_posts_by_slug($slug)
    {
        return $this->db->get_where('posts', array('slug' => $slug))->row();
    }

    public function related_posts($id='')
    {
        $this->db->select('*');
        $this->db->from('posts');
        if($id != '' && $id != NULL && is_numeric($id)):
            $this->db->where("FIND_IN_SET(left($id,10),category_id)>0");
        endif;
        $this->db->where('publication', '1');
        $this->db->order_by("posts_id","desc");
        $this->db->limit(2);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function create_small_thumbnail($source='', $destination='', $width='',$height=''){
        $this->load->library('image_lib');
        $config['image_library'] = 'gd2';
        $config['source_image'] = $source;
        $config['create_thumb'] = TRUE;
        $config['maintain_ratio'] = TRUE;
        $config['height']   = $height;
        $config['width'] = $width;
        $config['new_image'] = $destination;//you should have write permission here..
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

    public function resize_image($source='', $destination='', $width=110,$height=110)
    {
        //$filename = $this->input->post('new_val');
        //$source_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/avatar/tmp/' . $filename;
        //$target_path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/avatar/';
        $config_manip = array(
            'image_library' => 'gd2',
            'source_image' => $source,
            'new_image' => $destination,
            'maintain_ratio' => FALSE,
            'width' => $width,
            'height' => $height
        );
        $this->load->library('image_lib', $config_manip);
        if (!$this->image_lib->crop()) {
            echo $this->image_lib->display_errors();
        }
        // clear //
        $this->image_lib->clear();
    }

    public function get_page_details_by_slug($slug='')
    {
        return $this->db->get_where('page', array('slug' => $slug))->row();
    }

    public function page_is_exist($slug='')
    {
        $num_rows = $this->db->get_where('page', array('slug' => $slug))->num_rows();
        if($num_rows > 0):
            return true;
        else:
            return false;
        endif;

    }

    function get_video_title_by_id($videos_id)
    {
        $query  =   $this->db->get_where('videos' , array('videos_id' => $videos_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['title'];
    }


    function escapeString($val) {
    $db = get_instance()->db->conn_id;
    $val = mysqli_real_escape_string($db, $val);
    return $val;
    }

    function time_ago($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public function grab_image($file_url,$save_to){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $file_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 140);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        $output = curl_exec($ch);
        $file = fopen($save_to, "w+");
        fputs($file, $output);
        fclose($file);
    }
    function get_extension($file) {
     $extension = explode(".", $file);
     $ext = end($extension);
     return $ext ? $ext : 'link';
    }
    function get_filtered_string($string) {
        $string = trim($string);
        $string = preg_replace("/[^ \w]+/", "", $string);
        return $string;
    }
    function get_seo_url($string) {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }

    function get_total_episods_by_seasons_id($seasons_id){
        return count($this->db->get_where('episodes', array('seasons_id'=>$seasons_id))->result_array());
    }
    function get__seasons_name_by_id($seasons_id=''){
        $seasons =$this->db->get_where('seasons' , array('seasons_id'=>$seasons_id));
        if($seasons->num_rows() >0){
            return $seasons->row()->seasons_name;
        }else{
            return 'Seasons Not Found';
        }
    }

    function get_title_by_videos_id($videos_id=''){
        $video =$this->db->get_where('videos' , array('videos_id'=>$videos_id));
        if($video->num_rows() >0){
            return $video->row()->title;
        }else{
            return 'Title Not Found';
        }
    }

    function get_srclang($language=''){
        $languages =$this->db->get_where('languages_iso' , array('name'=>$language));
        if($languages->num_rows() >0){
            return $languages->row()->iso;
        }else{
            return 'en';
        }
    }

    function get_slug_by_videos_id($videos_id=''){
        $video =$this->db->get_where('videos' , array('videos_id'=>$videos_id));
        if($video->num_rows() >0){
            return $video->row()->slug;
        }else{
            return '';
        }
    }

    function get_title_by_posts_id($posts_id){
         $total = count($this->db->get_where('posts' , array('posts_id'=>$posts_id))->result_array());
         if($total > 0){
            return $this->db->get_where('posts' , array('posts_id'=>$posts_id))->row()->post_title;        
         }else{
            return "Not Found";
        }
    }

    function get_ads_status($unique_name = ''){
         return $this->db->get_where('ads' , array('unique_name'=>$unique_name),1)->row()->enable;
    }

    function get_ads($unique_name = ''){
        $ads_content    =   '';
         $ads      =   $this->db->get_where('ads' , array('unique_name'=>$unique_name),1)->row();
         if($ads->ads_type == 'image' && $ads->enable !='0'){
            $ads_content .= "<a href='".$ads->ads_url."'><img src='".$ads->ads_image_url."'class='img-fluid'></a>";
        }else if($ads->ads_type == 'code' && $ads->enable !='0'){
            $ads_content .= $ads->ads_code;       
         }
         return $ads_content;
    }

    function get_all_ads($unique_name = ''){
        return $this->db->get('ads')->result_array();
    }

    function get_single_ads($ads_id = ''){
        return $this->db->get_where('ads', array('ads_id'=>$ads_id),1)->row();
    }

    function generate_slug($table='',$slug='')
    {
       $slug = url_title($slug, 'dash', TRUE);
       $rows = $this->db->get_where($table, array('slug'=>$slug))->num_rows();
       if($rows > 0){
        $slug = $slug.'-'.$this->generate_random_string();
       }
       return $slug;
    }

    function regenerate_slug($table='',$id='',$slug='')
    {
        $column_name = $table.'_id !=';
        $slug = url_title($slug, 'dash', TRUE);
        $rows = $this->db->get_where($table, array('slug'=>$slug,$column_name=>$id))->num_rows();
        if($rows > 0){
            $slug = $slug.'-'.$this->generate_random_string();
        }
        return $slug;
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

    function get_base64_code($str=""){
        return base64_encode($str);
    }

    function pagination(){
        $config['full_tag_open']    = '<ul class ="pagination">';
        $config['full_tag_close']   = '</ul><!--pagination-->';
        $config['first_link']       = '«';
        $config['first_tag_open']   = '<li class="page-item page-link">';
        $config['first_tag_close']  = '</li>';
        $config['last_link']        = '»';
        $config['last_tag_open']    = '<li class="page-item page-link">';
        $config['last_tag_close']   = '</li>';
        $config['next_link']        = '&rarr;';
        $config['next_tag_open']    = '<li class="page-item page-link">';
        $config['next_tag_close']   = '</li>';
        $config['prev_link']        = '&larr;';
        $config['prev_tag_open']    = '<li class="page-item page-link">';
        $config['prev_tag_close']   = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close']    = '</a></li>';
        $config['num_tag_open']     = '<li class="page-item page-number">';
        $config['num_tag_close']    = '</li>';
        return $config;
    }

    function check_movie_accessability($slug=''){
        $error = FALSE;
        if ($slug != '' && $slug != NULL):
            if($this->movie_exist($slug)):
                $videos_id          = $this->get_videos_id_by_slug($slug);
                if($this->check_movie_visiability($videos_id) == FALSE):
                    $error = TRUE;
                endif;
            else:
                $error = TRUE;
            endif;
            
        else:
            $error = TRUE;
        endif;
        return $error;
    }


    function movie_exist($slug='') {
        $result = FALSE;
        $rows = $this->db->get_where('videos', array('slug' => $slug))->num_rows();
        if($rows >0):
          $result = TRUE;
        endif;
        return $result;     
    }

    function tmdb_exist($id=NULL) {
        $result = FALSE;
        if($id !=NULL && $id!=""):
            $rows = $this->db->get_where('videos', array('tmdbid' => $id))->num_rows();
            if($rows >0):
                $result = TRUE;
            endif;
        endif;
        return $result;
    }

    function check_movie_visiability($videos_id) {
        $result = TRUE;
        $publication = $this->db->get_where('videos', array('videos_id' => $videos_id))->row()->publication;
        if($publication =='0'):
            if ($this->session->userdata('admin_is_login') != '1')
                $result = FALSE;
        endif;
        return $result;     
    }

    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

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
    function get_related_movie($videos_id='',$genre_ids=''){
        //var_dump($genre_ids);
        $response   =   array();
        $this->db->where('videos_id !=',$videos_id);
        $this->db->where('is_tvseries !=','1');
        $this->db->where('publication','1');
        $this->db->limit(12);
        if($genre_ids !=NULL && $genre_ids !=''):
            $genres     =   explode(',', $genre_ids);
            $i          =   0;
            $this->db->group_start();
            foreach ($genres as $genre_id):
                if($i > 0):
                    $this->db->or_where("FIND_IN_SET($genre_id,genre)>0");
                else:
                    $this->db->where("FIND_IN_SET($genre_id,genre)>0");
                endif;
                $i++;
            endforeach;
            $this->db->group_end();
        endif;
        $response     = $this->db->get('videos')->result_array();
        //var_dump($this->db->last_query());
        return $response;

    }

    function get_related_tvseries($videos_id='',$genre_ids=''){
        $response   =   array();
        $this->db->where('videos_id !=',$videos_id);
        $this->db->where('is_tvseries','1');
        $this->db->where('publication','1');
        $this->db->order_by("last_ep_added","DESC");
        $this->db->limit(12);

        if($genre_ids !=NULL && $genre_ids !=''):
            $genres     =   explode(',', $genre_ids);
            $i          =   0;
            $this->db->group_start();
            foreach ($genres as $genre_id):
                if($i > 0):
                    $this->db->or_where("FIND_IN_SET($genre_id,genre)>0");
                else:
                    $this->db->where("FIND_IN_SET($genre_id,genre)>0");
                endif;
                $i++;
            endforeach;
            $this->db->group_end();
        endif;
        $response     = $this->db->get('videos')->result_array();
        return $response;
    }

    public function check_cron_key($user_cron_key=''){
        $result         =   FALSE;
        $cron_key       =   ovoo_config('cron_key');
        if($cron_key == $user_cron_key):
            $result     =  TRUE;
        endif;
        return $result;
    }

    public function html2text($html){
        require_once(__DIR__ . "/html2text/Html2Text.php");
        require_once(__DIR__ . "/html2text/Html2TextException.php");
        return Html2Text\Html2Text::convert($html);
    }

    public function generate_stars_anchor($ids){
        $result = '';
        if($ids !='' && $ids !=NULL):
            $i = 0;
            $stars =explode(',', $ids);                                                
            foreach ($stars as $star_id):
                if($i>0):
                    $result .= ',';
                endif;
                $i++;
                $result .= $this->common_model->get_star_name_by_id($star_id);
            endforeach;
        endif;
        return $result;
    }

    public function get_az_videos_num_rows($title='')
    {
        $result = array();
       if($title =='09'):
            for($i=0;$i<10;$i++):
                if($i > 0):
                    $this->db->or_like('title',$i,'after');
                else:
                    $this->db->like('title',$i,'after');
                endif;
            endfor;
        else:
            $this->db->like('title',$title,'after');
        endif;        
        $query = $this->db->get('videos');
        return $query->num_rows();
    }

    public function get_az_videos($title='',$limit=16, $start=0)
    {

        $result = array();
        if($title =='09'):
            for($i=0;$i<10;$i++):
                if($i > 0):
                    $this->db->or_like('title',$i,'after');
                else:
                    $this->db->like('title',$i,'after');
                endif;
            endfor;
        else:
            $this->db->like('title',$title,'after');
        endif;
        $this->db->limit($limit,$start);
        $query = $this->db->get('videos');
        
        if ($query->num_rows() > 0){
            $result = $query->result_array();       
        }
        return $result;
    }

    public function get_config($title=''){
        $result   = $title;
        $query  = $this->db->get_where('config' , array('title'=>$title));
        if($query->num_rows() > 0):
            $result = $query->row()->value;
        else:
            $data['title'] = $title;
            $data['value'] = $title;
            $this->db->insert('config',$data);
        endif;
        return $result;
    }
    public function get_active_theme(){
        $theme = 'default';
        $query  = $this->db->get_where('config' , array('title'=>"active_theme"));
        if($query->num_rows() > 0):
            $db_theme_name = $query->row()->value;
            if(is_dir(APPPATH.'views/theme/'.$db_theme_name)):
                $theme = $query->row()->value;
            endif;
        endif;
        return $theme;
    }

    public function generator_sitemap(){
        $movies 			= $this->db->get_where('videos', array('publication'=>'1'))->result_array();
        $movie_types 		= $this->db->get('video_type')->result_array();
        $live_tvs 			= $this->db->get_where('live_tv', array('publish'=>'1'))->result_array();
        $pages 				= $this->db->get_where('page', array('publication'=>'1'))->result_array();
        $posts 				= $this->db->get_where('posts', array('publication'=>'1'))->result_array();
        $countries 			= $this->db->get_where('country', array('publication'=>'1'))->result_array();
        $genres 			= $this->db->get_where('genre', array('publication'=>'1'))->result_array();
        $tv_series_publish  = ovoo_config('tv_series_publish');
        $live_tv_publish    = ovoo_config('live_tv_publish');
        $blog_enable        = ovoo_config('blog_enable');
		$landing_page_enable= ovoo_config('landing_page_enable');
		
		$xml = new SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' ?>\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" />');
		// home page page
		$url = $xml->addChild('url');
		$url->addChild('loc',base_url());
		$url->addChild('priority','1.0'); 
		// landing page page
		if($landing_page_enable == '1'):
			$url = $xml->addChild('url');
			$url->addChild('loc',base_url('all-movies.html'));
			$url->addChild('priority','1.0');
		endif;
		
		// movie page
		$url = $xml->addChild('url');
		$url->addChild('loc',base_url('movies.html'));
		$url->addChild('priority','0.9'); 

		// privacy page
		$url = $xml->addChild('url');
		$url->addChild('loc',base_url('privacy-policy.html'));
		$url->addChild('priority','0.8');

		// dmca page
		$url = $xml->addChild('url');
		$url->addChild('loc',base_url('dmca.html'));
		$url->addChild('priority','0.8');

		// contact page
		$url = $xml->addChild('url');
		$url->addChild('loc',base_url('contact-us.html'));
		$url->addChild('priority','0.9');

		if($live_tv_publish =='1'):
			// contact page
			$url = $xml->addChild('url');
			$url->addChild('loc',base_url('live-tv.html'));
			$url->addChild('priority','0.9');
		endif;


		// country page
		foreach($countries as $country):
			$url = $xml->addChild('url');
			$url->addChild('loc',base_url("country/".$country['slug'].".html"));
			$url->addChild('priority','0.5');
		endforeach;


		// genre page
		foreach($genres as $genre):
			$url = $xml->addChild('url');
			$url->addChild('loc',base_url("genre/".$genre['slug'].".html"));
			$url->addChild('priority','0.5');
		endforeach;
		//  year page
		$current_year = date("Y");
		$end_year = $current_year - 108;
		for($i=$current_year;$i>$end_year;$i--):
			$url = $xml->addChild('url');
			$url->addChild('loc',base_url("year/".$i.".html"));
			$url->addChild('priority','0.5');
		endfor;

		// movie page
		foreach($movies as $movie):
			$url = $xml->addChild('url');
			$url->addChild('loc',base_url("watch/".$movie['slug'].".html"));
			$url->addChild('priority','0.9');
		endforeach;


		foreach($movie_types as $movie_type):
			$url = $xml->addChild('url');
			$url->addChild('loc',base_url("type/".$movie_type['slug'].".html"));
			$url->addChild('priority','0.9');
		endforeach;

		foreach($pages as $page):
			$url = $xml->addChild('url');
			$url->addChild('loc',base_url("page/".$page['slug'].".html"));
			$url->addChild('priority','0.9');
		endforeach;

		foreach($pages as $page):
			$url = $xml->addChild('url');
			$url->addChild('loc',base_url("page/".$page['slug'].".html"));
			$url->addChild('priority','0.9');
		endforeach;

		if($blog_enable =='1'):
			$url = $xml->addChild('url');
			$url->addChild('loc',base_url('blog.html'));
			$url->addChild('priority','0.9');
			foreach($posts as $post):
				$url = $xml->addChild('url');
				$url->addChild('loc',base_url("blog/".$post['slug'].".html"));
				$url->addChild('priority','0.9');
			endforeach;
		endif;
		$this->load->helper('file');
		if (! write_file('sitemap.xml', $xml->asXML())):
			return true;
		else:
			return true;
		endif;
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
    public function get_video_file_by_videos_id($videos_id=''){
        $this->db->order_by('order', $this->video_file_order());
        return $this->db->get_where('video_file',array('videos_id'=>$videos_id))->result_array();
    }
    public function get_first_video_details_videos_id($videos_id=''){
        $this->db->order_by('order', $this->video_file_order());
        $this->db->limit(1);
        return $this->db->get_where('video_file', array('videos_id'=>$videos_id))->row();
    }
    public function get_single_video_file_details_by_id($id=''){
        $this->db->order_by('order', $this->video_file_order());
        $this->db->limit(1);
        $query = $this->db->get_where('video_file', array('video_file_id'=>$id));
        if($query->num_rows() > 0):
            return $this->db->get_where('video_file', array('video_file_id'=>$id))->row();
        endif;
    }

    public function get_single_video_file_details_by_key($key=''){
        $this->db->order_by('order', $this->video_file_order());
        $this->db->limit(1);
        $query = $this->db->get_where('video_file', array('stream_key'=>$key));
        if($query->num_rows() > 0):
            return $this->db->get_where('video_file', array('stream_key'=>$key))->row();
        endif;
    }


    // tv-series

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

    

    public function get_seasons_by_videos_id($videos_id=''){
        $this->db->order_by('order', $this->season_order());
        return $this->db->get_where('seasons',array('videos_id'=>$videos_id))->result_array();
    }

    public function get_episodes_by_videos_id_and_season_id($videos_id='',$seasons_id=''){
        $this->db->order_by('order', $this->episode_order());
        return $this->db->get_where('episodes',array('videos_id'=>$videos_id,'seasons_id'=> $seasons_id))->result_array();
    }

    public function get_first_episode_details_videos_id($videos_id=''){
        $this->db->order_by('order', $this->episode_order());
        $this->db->limit(1);
        return $this->db->get_where('episodes', array('videos_id'=>$videos_id))->row();
    }

    public function validate_stream_key($key=''){
        $result = false;
        $query = $this->db->get_where('episodes', array('stream_key'=>$key));
        if($query->num_rows() > 0):
            $result = true;
        endif;
        return $result;
    }

    public function get_single_episode_details_by_id($id=''){
        $this->db->order_by('order', $this->episode_order());
        $this->db->limit(1);
        $query = $this->db->get_where('episodes', array('episodes_id'=>$id));
        if($query->num_rows() > 0):
            return $this->db->get_where('episodes', array('episodes_id'=>$id))->row();
        endif;
    }

    public function get_single_episode_details_by_key($key=''){
        $this->db->order_by('order', $this->episode_order());
        $this->db->limit(1);
        $query = $this->db->get_where('episodes', array('stream_key'=>$key));
        if($query->num_rows() > 0):
            return $this->db->get_where('episodes', array('stream_key'=>$key))->row();
        endif;
    }

    public function get_episode_subtitles_by_episode_id($episodes_id=''){
        return $this->db->get_where('tvseries_subtitle',array('episodes_id'=>$episodes_id))->result_array();
    }

    public function get_user_name_by_id($user_id='')
    {
        $name = 'Unknown';
        $query = $this->db->get_where('user', array('user_id'=>$user_id));
        if($query->num_rows() > 0):
            $name = $query->row()->name;
        endif;
        return $name;
    }

    public function exchange_rate_update(){
        // Fetching JSON
        $req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
        $response_json = file_get_contents($req_url);

        // Continuing if we got a result
        if(false !== $response_json) {

            // Try/catch for json_decode operation
            try{
                // Decoding
                $response_object = json_decode($response_json);
                $i = 0;
                foreach ((array)$response_object->rates as $key => $value):
                    $this->db->where('iso_code',$key);
                    $data['exchange_rate'] = $value;
                    //$data['symbol'] = $key;
                    //$data['iso_code'] = $key;
                    $this->db->update('currency',$data);
                    //$this->db->insert('currency',$data);
                endforeach;
                echo 'process done.';

                // YOUR APPLICATION CODE HERE, e.g.
                // $base_price = 12; // Your price in USD
                // $EUR_price = round(($base_price * $response_object->rates->EUR), 2);
            }
            catch(Exception $e) {
                echo 'process fail!!';
                // Handle JSON parse error...
            }
        }
    }

    public function get_usd_exchange_rate($iso_code='USD'){
        $rate = 1;
        $this->db->where('iso_code',$iso_code);
        $query = $this->db->get('currency');
        if($query->num_rows()> 0):
            $rate = $query->first_row()->exchange_rate;
        endif;
        return $rate;
    }

    public function exchange_rate_update_by_iso_code($iso_code,$exchange_rate){
        $this->db->where('iso_code',$iso_code);
        $data['exchange_rate'] = $exchange_rate;
        $this->db->update('currency',$data);
        return true;
    }

    public function jsonToTable ($data){
        $table = '
        <table class="table table-responsive table-bordered">
        ';
        foreach ($data as $key => $value):
            $table .= '
            <tr valign="top">
            ';
            if ( ! is_numeric($key)):
                $table .= '
                <td>
                    <strong>'. $key .':</strong>
                </td>
                <td>
                ';
            else:
                $table .= '
                <td colspan="2">
                ';
            endif;
            if (is_object($value) || is_array($value)):
                $table .= $this->jsonToTable($value);
            else:
                $table .= $value;
            endif;
            $table .= '
                </td>
            </tr>
            ';
        endforeach;
        $table .= '
        </table>
        ';
        return $table;
    }

    function is_json($string,$return_data = false) {
        $data = json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE) ? ($return_data ? $data : TRUE) : FALSE;
    }

    public function verify_live_tv_id($id='')
    {
        //var_dump($id);
        $result =   FALSE;
        $rows   =   $this->db->get_where('live_tv', array('live_tv_id' => $id))->num_rows();
        if($rows >    0):
            $result =   TRUE;
        endif;
        return $result;
    }

    //    request

    public function get_request($limit=16, $start=0)
    {
        $this->db->order_by('request_id',"DESC");
        $this->db->limit($limit,$start);
        return $this->db->get('request')->result_array();
    }

    public function get_report($limit=16, $start=0)
    {
        $this->db->order_by('report_id',"DESC");
        $this->db->limit($limit,$start);
        return $this->db->get('report')->result_array();
    }
    public function getYouTubeId($url) {
        $youtube_id = '3gK_2XdjOdY';
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        $youtube_id = isset($match[1]) ? $match[1] : '3gK_2XdjOdY';
        return $youtube_id;
    }

    public function render_movies($array=array()){
        $movies = '';
        foreach ($array as $videos) :
            $movies .= '<div class="col-md-3 col-sm-4 col-xs-6">';
            $movies .=  require(APPPATH.'views/theme/default/thumbnail.php');
            $movies .=  '</div>';
        endforeach;
        return $movies;
    }
}


