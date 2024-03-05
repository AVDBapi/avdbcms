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

class Live_tv_model extends CI_Model {
	
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

    function get_tv_poster($poster = '')
    {
        if($poster =='' || $poster ==NULL){
            $image_url  =   base_url().'uploads/default_image/tv_poster.jpg';
        }else{
            if(file_exists('uploads/tv_image/'.$poster))
                $image_url  =   base_url().'uploads/tv_image/'.$poster;
            else
                $image_url  =   base_url().'uploads/default_image/tv_poster.jpg';
        }
        return $image_url;        
    }

    function get_tv_thumbnail($thumbnail = '')
    {
         if($thumbnail =='' || $thumbnail ==NULL){
            $image_url  =   base_url().'uploads/default_image/tv_thumbnail.jpg';
        }else{
            if(file_exists('uploads/tv_image/sm/'.$thumbnail))
                $image_url  =   base_url().'uploads/tv_image/sm/'.$thumbnail;
            else
                $image_url  =   base_url().'uploads/default_image/tv_thumbnail.jpg';
        }
        return $image_url;
    }

     public function get_live_tv_url($live_tv_id='',$quality='')
    {
        $query = $this->db->get_where('live_tv_url', array('live_tv_id' => $live_tv_id,'quality'=>$quality));
        if($query->num_rows() > 0):
            return '<br>'.$query->row()->url;
        else:
            return '';
        endif;
    }
	

    public function num_live_tv($name=NULL)
    {
        if($name !=NULL && $name !=''):
            $this->db->like('tv_name',$name,'both');
        endif;
        return  $this->db->get('live_tv')->num_rows();
    }

    public function live_tv_is_published($slug='')
    {
        $status = FALSE;
        $row =  $this->db->get_where('live_tv', array('publish' => '1','slug'=>$slug))->num_rows();
        if($row >0)
            $status = TRUE;
        return $status;
    }

    public function live_tv_category_is_published($slug='')
    {
        $status = FALSE;
        $row =  $this->db->get_where('live_tv_category', array('status' => '1','slug'=>$slug))->num_rows();
        if($row >0)
            $status = TRUE;
        return $status;
    }

    public function get_live_tvs($limit=NULL, $start=NULL,$name=NULL)
    {
        if($name !=NULL && $name !=''):
            $this->db->like('tv_name',$name,'both');
        endif;
        $this->db->order_by("live_tv_id","desc");
        $this->db->limit($limit,$start);
        $query = $this->db->get('live_tv');
        if ($query->num_rows() > 0){
            return $query->result_array();        
        }else{
            return array();
        }
    }

    public function get_stream_from($live_tv_id='',$url_for=''){
        $query =$this->db->get_where('live_tv_url', array('live_tv_id' => $live_tv_id,'url_for'=>$url_for),1);
        if($query->num_rows() >0){
            return $query->row()->source;
        }else{
            return "";
        }
    }

    public function get_stream_label($live_tv_id='',$url_for=''){
        $query =$this->db->get_where('live_tv_url', array('live_tv_id' => $live_tv_id,'url_for'=>$url_for),1);
        if($query->num_rows() >0){
            return $query->row()->label;
        }else{
            return "";
        }
    }

    public function get_stream_key($live_tv_id='',$url_for=''){
        $query =$this->db->get_where('live_tv_url', array('live_tv_id' => $live_tv_id,'url_for'=>$url_for),1);
        if($query->num_rows() >0){
            return $query->row()->stream_key;
        }else{
            return "";
        }
    }


    public function get_stream_url($live_tv_id='',$url_for=''){
        $query = $this->db->get_where('live_tv_url', array('live_tv_id' => $live_tv_id,'url_for'=>$url_for),1);
        //var_dump($this->db->last_query());
        if($query->num_rows() > 0){
            return $query->row()->url;
        }else{
            return "";
        }
    }

    public function get_featured_tv_status() {
        $status             =   FALSE;
        $rows               =   $this->db->get_where('live_tv',array('featured'=>'1','publish'=>'1'))->num_rows();
        $live_tv_publish    =   $this->db->get_where('config' , array('title' =>'live_tv_publish'))->row()->value;
        if($live_tv_publish =='1' && ($rows > 0))
            $status     =   TRUE;
        return $status;
    }

    public function get_featured_live_tv($limit=10,$start=0) {
        $this->db->where('featured','1');
        $this->db->where('publish','1');
        $this->db->limit($limit,$start);
        return $this->db->get('live_tv')->result_array();
    }

    public function get_tv_status() {
        $status             =   FALSE;
        $rows               =   $this->db->get_where('live_tv',array('publish'=>'1'))->num_rows();
        $live_tv_publish    =   $this->db->get_where('config' , array('title' =>'live_tv_publish'))->row()->value;
        if($live_tv_publish =='1' && ($rows > 0))
            $status     =   TRUE;
        return $status;
    }

    public function get_live_tv($start=0, $limit=10) {
        $this->db->where('publish','1');
        $this->db->limit($limit,$start);
        return $this->db->get('live_tv')->result_array();
    }

    public function get_all_live_tv() {
        $this->db->where('publish','1');
        //$this->db->limit($limit,$start);
        return $this->db->get('live_tv')->result_array();
    }

    public function get_live_tv_details_by_slug($slug)
    {
        return $this->db->get_where('live_tv', array('slug' => $slug))->row();
    }

    public function get_slug_by_live_tv_id($live_tv_id='')
    {
        $query  =   $this->db->get_where('live_tv' , array('live_tv_id' => $live_tv_id));
        $res    =   $query->result_array();
        foreach($res as $row)           
            return $row['slug'];
    }
    public function get_live_tv_category($live_tv_category_id='') {
        $result = "not found";
        $this->db->where('live_tv_category_id',$live_tv_category_id);
        $query = $this->db->get('live_tv_category');
        if($query->num_rows() > 0)
            $result = $query->row()->live_tv_category;
        return $result;
    }

    public function get_live_tv_category_by_slug($slug='') {
        $result = array();
        $this->db->where('slug',$slug);
        $result = $this->db->get('live_tv_category')->result_array();
        return $result;
    }

    public function get_live_tv_title_by_id($live_tv_id='') {
        $result = "not found";
        $this->db->where('live_tv_id',$live_tv_id);
        $query = $this->db->get('live_tv');
        if($query->num_rows() > 0)
            $result = $query->row()->tv_name;
        return $result;
    }

    public function get_live_tv_by_category_id($live_tv_category_id='') {
        $this->db->where('publish','1');
        $this->db->where('live_tv_category_id',$live_tv_category_id);
        return $this->db->get('live_tv')->result_array();
    }

    public function get_all_live_tv_category() {
        $this->db->where('status','1');
        return $this->db->get('live_tv_category')->result_array();
    }
}


