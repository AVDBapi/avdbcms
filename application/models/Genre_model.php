<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * OVOO
 *
 * OVOO-Movie & Video Streaming CMS with Unlimited TV-Series
 *
 * @package     OVOO
 * @author      Abdul Mannan
 * @copyright   Copyright (c) 2014 - 2016 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/
 

class Genre_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
        date_default_timezone_set(ovoo_config('timezone'));
    }
		/* clear cache*/	
	function clear_cache()
	{
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
	}


	

    public function all_published_genre()
    {

        return  $this->db->get_where('genre', array('publication' => '1'))->result();
    }
    public function genres()
    {

        return  $this->db->get_where('genre', array('publication' => '1'))->result_array();
    }

    public function genre_exist($slug)
    {
        $status = FALSE;
        $num_rows = $this->db->get_where('genre', array('slug' => $slug))->num_rows();
        if($num_rows > 0){
           $status = TRUE; 
        }
        return $status;
    }


    public function total_genre_found($slug)
    {
        $genre_id = $this->db->get_where('genre', array('slug' => $slug))->row()->genre_id;
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        $query = $this->db->get('videos');
        return $query->num_rows();
    }    

    public function get_genre_ids($name='')
    {
        $names          = explode(',', $name);
        $ids            = '';
        $i=0;
        foreach ($names as $name) {
            $i++;
            if($i>1){
               $ids .=',';
            }
            $ids .=$this->get_genre_id_by_name($name);
        }
        return $ids;
    }


    public function get_genre_id_by_name($name)
    {
        $result =   count($this->db->get_where('genre', array('name' => $name))->result_array());
        if($result >    0){
        $genre_id = $this->db->get_where('genre', array('name' => $name))->row();
        return $genre_id->genre_id;
        }else{
            $data['name']           = $name;
            $data['description']    = $name;
            $data['slug']           = url_title($name, 'dash', TRUE);
            $data['publication']    = '1';
            $this->db->insert('genre', $data);
            return $this->db->insert_id();
        }

    }

    public function get_genre_name_by_id($genre_id)
    {
        $result =count($this->db->get_where('genre', array('genre_id' => $genre_id))->result_array());
        if($result >0){
            return $this->db->get_where('genre', array('genre_id' => $genre_id))->row()->name;
        }else{
            return "Unknown";
        }
    }

    public function get_genre_slug_by_id($genre_id)
    {
        $result =count($this->db->get_where('genre', array('genre_id' => $genre_id))->result_array());
        if($result >0){
            return $this->db->get_where('genre', array('genre_id' => $genre_id))->row()->slug;
        }else{
            return "Unknown";
        }
    }
    public function get_genre_url_by_id($genre_id)
    {
        $result =$this->db->get_where('genre', array('genre_id' => $genre_id))->num_rows();
        if($result >0){
            return site_url().'genre/'.$this->db->get_where('genre', array('genre_id' => $genre_id))->row()->slug.'.html';
        }else{
            return "#";
        }
    }
    

   public function fetch_genre_video_by_slug($limit=16, $start=0, $slug="") {
        $genre_id   = $this->db->get_where('genre', array('slug' => $slug))->row()->genre_id;
        $this->db->order_by('videos_id','DESC');
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        $this->db->limit($limit,$start);
        return $this->db->get('videos')->result_array();
   }

   
   public function fetch_genre_video_by_slug_record_count($slug)
    {
        $genre_id = $this->db->get_where('genre', array('slug' => $slug))->row()->genre_id;
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        $query = $this->db->get('videos');        
        return $query->num_rows();
    }

    public function get_video_by_genre_id($genre_id='',$limit=12)
    {
        //$genre_id = $this->db->get_where('genre', array('slug' => $slug))->row()->genre_id;
        $this->db->where("is_tvseries !=",'1');
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        $this->db->limit($limit);
        $this->db->order_by('videos_id',"desc");
        $query = $this->db->get('videos');        
        return $query->result_array();
    }


    public function get_popular_video_by_genre_id($genre_id='',$limit=12)
    {
        //$genre_id = $this->db->get_where('genre', array('slug' => $slug))->row()->genre_id;
        $this->db->where("is_tvseries !=",'1');
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        $this->db->limit($limit);
        $this->db->order_by('total_view',"desc");
        $query = $this->db->get('videos');        
        return $query->result_array();
    }

    public function get_tvseries_by_genre_id($genre_id='',$limit=12)
    {
        //$genre_id = $this->db->get_where('genre', array('slug' => $slug))->row()->genre_id;
        $this->db->where("is_tvseries",'1');
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        $this->db->limit($limit);
        $this->db->order_by('videos_id',"desc");
        $query = $this->db->get('videos');        
        return $query->result_array();
    }

    public function get_popular_tvseries_by_genre_id($genre_id='',$limit=12)
    {
        //$genre_id = $this->db->get_where('genre', array('slug' => $slug))->row()->genre_id;
        $this->db->where("is_tvseries",'1');
        $this->db->where("find_in_set(".$genre_id.",genre) >",0);
        $this->db->limit($limit);
        $this->db->order_by('total_view',"desc");
        $query = $this->db->get('videos');        
        return $query->result_array();
    }

    public function generate_genres_anchor($ids){
        $result = '';
        if($ids !='' && $ids !=NULL):
            $i = 0;
            $genres =explode(',', $ids);                                                
            foreach ($genres as $genre_id):
                if($i>0):
                    $result .= ',';
                endif;
                $i++;
                $result .= '<a href="'.$this->genre_model->get_genre_url_by_id($genre_id).'">'.$this->genre_model->get_genre_name_by_id($genre_id).'</a>';
            endforeach;
        endif;
        return $result;
    }  
}


