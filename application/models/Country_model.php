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
 

class Country_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
		/* clear cache*/	
	function clear_cache()
	{
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        date_default_timezone_set(ovoo_config('timezone'));
	}


	

    public function countries(){
        return  $this->db->get_where('country', array('publication' => '1'))->result_array();
    }
    public function all_published_country()
    {

        return  $this->db->get_where('country', array('publication' => '1'))->result();
    }

    public function total_country_found($slug)
    {
        $country_id = $this->db->get_where('country', array('slug' => $slug))->row()->country_id;
        $this->db->where("find_in_set(".$country_id.",country) >",0);
        $query = $this->db->get('videos');
        return $query->num_rows();
    }
    public function country_exist($slug)
    {
        $status = FALSE;
        $num_rows = $this->db->get_where('country', array('slug' => $slug))->num_rows();
        if($num_rows > 0){
           $status = TRUE; 
        }
        return $status;
    }


    public function get_country_ids($name='')
    {
        $names          = explode(',', $name);
        $ids            = '';
        $i=0;
        foreach ($names as $name) {
            $i++;
            if($i>1){
               $ids .=',';
            }
            $ids .=$this->get_country_id_by_name($name);
        }
        return $ids;
    }


    public function get_country_id_by_name($name)
    {
        $result =   count($this->db->get_where('country', array('name' => $name))->result_array());
        if($result >    0){
        $country_id = $this->db->get_where('country', array('name' => $name))->row();
        return $country_id->country_id;
        }else{
            $data['name']           = $name;
            $data['description']    = $name;
            $data['slug']           = url_title($name, 'dash', TRUE);
            $data['publication']    = '1';
            $this->db->insert('country', $data);
            return $this->db->insert_id();
        }

    }

    public function get_country_name_by_id($country_id){
        $result =count($this->db->get_where('country', array('country_id' => $country_id))->result_array());
        if($result >0){
            return $this->db->get_where('country', array('country_id' => $country_id))->row()->name;
        }else{
            return "Unknown";
        }
    }
    public function get_country_url_by_id($country_id){
        $result =$this->db->get_where('country', array('country_id' => $country_id))->num_rows();
        if($result >0){
            return site_url().'country/'.$this->db->get_where('country', array('country_id' => $country_id))->row()->slug.'.html';
        }else{
            return "#";
        }
    }
    

   public function fetch_country_video_by_slug($limit=16, $start=0, $slug="") {
        $country_id   = $this->db->get_where('country', array('slug' => $slug))->row()->country_id;
        $this->db->where("find_in_set(".$country_id.",country) >",0);
        $this->db->limit($limit,$start);
        return $this->db->get('videos')->result_array();
   }

   
   public function fetch_country_video_by_slug_record_count($slug)
    {
        $country_id = $this->db->get_where('country', array('slug' => $slug))->row()->country_id;
        $this->db->where("find_in_set(".$country_id.",country) >",0);
        $query = $this->db->get('videos');        
        return $query->num_rows();
    }

    public function generate_countries_anchor($ids){
        $result = '';
        if($ids !='' && $ids !=NULL):
            $i = 0;
            $countries =explode(',', $ids);                                                
            foreach ($countries as $country_id):
                if($i>0):
                    $result .= ',';
                endif;
                $i++;
                $result .= '<a href="'.$this->country_model->get_country_url_by_id($country_id).'">'.$this->country_model->get_country_name_by_id($country_id).'</a>';
            endforeach;
        endif;
        return $result;
    } 
}


