<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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


class Comments extends Home_Core_Controller {   
    
	function __construct(){
		parent::__construct();		
   		/*cache controlling*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		
    }
    
    /*default index function, redirects to login/dashboard */
    public function index() {
        if ($this->session->userdata('login_status') != 1)
            redirect(base_url() , 'refresh');        
    }
    function comment($param1='' , $param2=''){
        $url =$this->input->post('url');
		if ($this->session->userdata('login_status') != 1){
			$this->session->set_flashdata('error', 'You must login to comments.');
			redirect($url , 'refresh');
		}
        $data['user_id'] =$this->session->userdata('user_id');
        $data['video_id'] = $this->input->post('video_id');
        $data['comment'] = $this->input->post('comment');
        $data['comment_at'] = date("Y-m-d H:i:s");
        //var_dump($data);

        $this->db->insert('comments', $data);
        $this->session->set_flashdata('success', 'Comment successed');
        redirect($url, 'refresh');

    }
   function replay($param1='' , $param2=''){
        $url =$this->input->post('url');
		if ($this->session->userdata('login_status') != 1){
			$this->session->set_flashdata('error', 'You must login to replay.');
			redirect($url , 'refresh');
		}
            

        $data['user_id'] =$this->session->userdata('user_id');
        $data['video_id'] = $this->input->post('video_id');
        $data['comment'] = $this->input->post('comment');
        $data['replay_for'] = $this->input->post('replay_for');
        $data['comment_at'] = date("Y-m-d H:i:s");
        $data['comment_type'] = '2';
        //var_dump($data);

        $this->db->insert('comments', $data);
        $this->session->set_flashdata('success', 'Replay successed');
        redirect($url, 'refresh');

    }

    function post_replay($param1='' , $param2=''){
        $url =$this->input->post('url');
		if ($this->session->userdata('login_status') != 1){
			$this->session->set_flashdata('error', 'You must login to replay.');
			redirect($url , 'refresh');
		}
        $data['user_id'] =$this->session->userdata('user_id');
        $data['post_id'] = $this->input->post('post_id');
        $data['comment'] = $this->input->post('comment');
        $data['replay_for'] = $this->input->post('replay_for');
        $data['comment_at'] = date("Y-m-d H:i:s");
        $data['comment_type'] = '2';
        //var_dump($data);

        $this->db->insert('post_comments', $data);
        $this->session->set_flashdata('success', 'Replay successed');
        redirect($url, 'refresh');

    }

    function post_comment($param1='' , $param2=''){
        $url =$this->input->post('url');
		if ($this->session->userdata('login_status') != 1){
			$this->session->set_flashdata('error', 'You must login to comments.');
			redirect($url , 'refresh');
		}            

        $data['user_id'] =$this->session->userdata('user_id');
        $data['post_id'] = $this->input->post('post_id');
        $data['comment'] = $this->input->post('comment');
        $data['comment_at'] = date("Y-m-d H:i:s");
        //var_dump($data);

        $this->db->insert('post_comments', $data);
        $this->session->set_flashdata('success', 'Comment successed');
        redirect($url, 'refresh');

    }
}