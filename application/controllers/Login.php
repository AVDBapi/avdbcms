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
 
class Login extends Home_Core_Controller{
    
    
    function __construct(){
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2010 05:00:00 GMT");
    }
	
    //Default function, redirects to logged in user area
    public function index(){
        redirect(base_url() . 'user/login', 'refresh');
        
    }
    
	
	function ajax_login(){
		$response = array();
		
		//Ajax username and password request
		$username 						= $_POST["username"];
		$password 						= md5($_POST["password"]);
		$response['submitted_data'] 	= $_POST;		
		
		//Validating login
		$login_status 					= $this->validate_login( $username ,  $password);
		$response['login_status'] 		= $login_status;
		if ($login_status == 'success') {
            if($this->session->userdata('login_type') == 'admin'){
                $response['redirect_url']   = base_url().'admin';
            }else{
                $response['redirect_url']   = base_url('user/profile');
            }
			
		}		
		//Replying ajax request with validation response
		echo json_encode($response);
	}

    function do_login($param1='', $param2=''){
        
        //Ajax username and password request
        $username                       = $this->input->post('username');
        $password                       = $this->input->post('password');              
        
        //Validating login
        $login_status                   = $this->validate_login( $username ,  $password);        
        if ($login_status == 'success') {
            if($this->session->userdata('login_type') == 'admin'){
                $response['redirect_url']   = base_url().'admin';
            }else{
                $response['redirect_url']   = base_url();
            }
            
        }
    }

    
    //Validating login from ajax request
    function validate_login($username	=	'' , $password	 =  ''){
		 $credential	=	array(	'username' => $username , 'password' => $password );
		 
		 
		 // Checking login credential for admin
        $query = $this->db->get_where('user' , $credential);
        if ($query->num_rows() > 0) {
            $this->session->set_userdata('login_status', '1');
            $row = $query->row();
            // Replace the company name                     
            $this->db->where('user_id', $row->user_id);
            $this->db->update('user', array(
                'last_login' => date('Y-m-d H:i:s')
            )); 
            if($row->role=='admin'){
			  $this->session->set_userdata('admin_is_login', '1');			  	
			  $this->session->set_userdata('user_id', $row->user_id);
			  $this->session->set_userdata('name', $row->name);
			  $this->session->set_userdata('username', $row->username);
			  $this->session->set_userdata('login_type', 'admin');
			}
			if($row->role=='subscriber'){
			  $this->session->set_userdata('user_is_login', '1');			  	
			  $this->session->set_userdata('user_id', $row->user_id);
			  $this->session->set_userdata('name', $row->name);
			  $this->session->set_userdata('username', $row->username);
			  $this->session->set_userdata('login_type', 'subscriber');
			}
			if($row->role=='gate_man'){
			  $this->session->set_userdata('gate_man_is_login', '1');			  	
			  $this->session->set_userdata('user_id', $row->user_id);
			  $this->session->set_userdata('name', $row->name);
			  $this->session->set_userdata('username', $row->username);
			  $this->session->set_userdata('login_type', 'gate_man');
			}
			  return 'success';
		}
		
		return 'invalid';		
    }


    // logout function
    function logout() {
        $this->session->unset_userdata('');
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url() , 'refresh');
    }

    function signup($param1='', $param2='')  {
        if ($param1 == 'do_signup') {
            $username               = $this->input->post('username');
            $email                  = $this->input->post('email');
            $password               = $this->input->post('password');
            $data['name']           = 'User';
            $data['email']          = $email;
            $data['username']       = $username;
            $data['password']       = md5($password );
            $data['role']           = 'subscriber';
            $user_exist             = $this->common_model->check_email_username($username,$email);
            if($user_exist){
                $this->session->set_flashdata('error', 'Signup fail.username or email is already exist on system');
                
            }else{
                $data['join_date']       = date('Y-m-d H:i:s');
                $data['last_login']       = date('Y-m-d H:i:s');
                $this->db->insert('user', $data);
                $this->load->model('email_model');
                $this->email_model->account_opening_email($username, $email, $password);
                $this->session->set_flashdata('success', 'Signup successfully.now you can login to system');
                $response['login_status']       = $login_status;
                redirect(base_url() . 'login', 'refresh');
            }     
            
            
        }      
        
            $data['page_name']      = 'signup';
            $data['page_title']     = 'Join with us ';            
            $this->load->view('signup', $data);

    }

    function ajax_signup()  {
        $response = array();
        
        //Ajax username and password request
        $username                       = $_POST["username"];
        $email                          = $_POST["email"];
        $password                       = $_POST["password"];
        $response['submitted_data']     = $_POST;

        $data['name']                   = 'User';
        $data['email']                  = $email;
        $data['username']               = $username;
        $data['password']               = md5($password);
        $data['role']                   = 'subscriber';
        if($username !='' && $email != '' && $_POST["password"] !='' && $username !=NULL && $email != NULL && $_POST["password"] !=NULL)
        {
            $user_exist                     = $this->common_model->check_email_username($username,$email);
            if($user_exist){
                $response['signup_status']  = 'user_exist';            
            }else{
                $data['join_date']          = date('Y-m-d H:i:s');
                $data['last_login']         = date('Y-m-d H:i:s');
                $this->db->insert('user', $data);
                $this->load->model('email_model');
                //$this->email_model->account_opening_email($username, $email, $password);
                $this->session->set_flashdata('success', 'Signup successfully.now you can login to system');
                $response['redirect_url']   = base_url('login');
                $response['signup_status']  = 'success';
            }
        }
        else{
            $response['signup_status']  = 'empty_input';
        }
        echo json_encode($response);

    }


    function forget_password($param1='', $param2='') {
        if ($param1 == 'do_reset') {           
            $email                  = $this->input->post('email');            
            $user_exist             = $this->common_model->check_email($email);
            //var_dump($user_exist , $email);
            if($user_exist){                
                $data['token'] = bin2hex(openssl_random_pseudo_bytes(16));
                $this->db->where('email',$email);
                $this->db->update('user',$data);
                $this->session->set_flashdata('success', 'Please Check Your Email to Complete Password Reset.');
                redirect(base_url() . 'login', 'refresh');                
            }else{
            $this->session->set_flashdata('error', 'Email not found on our system');            
            redirect(base_url() . 'login', 'refresh');
            }    
            
            
        }
        redirect(base_url() . 'login', 'refresh');

    }

    function complete_reset($param1='', $param2='') {
        if ($param1 == 'save') {
            $token                      = $this->input->post('token');
            $password                   = $this->input->post('password');
            $password2                  = $this->input->post('password2');
            if($token !='' && $password !='' && $password2 !='' && $password==$password2){
                $data['token']      = '';
                $data['password']   = md5($password);
                $this->db->where('token', $token);
                $this->db->update('user', $data);
                $this->session->set_flashdata('success', 'Password Changed');
                redirect(base_url() . 'login', 'refresh');
            }

        }
            $token                  = $this->input->get('token');
            if(isset($token) && $token !=''){
                $token_exist             = $this->common_model->check_token($token);
                if($token_exist){                               
                $data['token'] = $token;
                $data['page_title']     = 'New Password';            
                $this->load->view('new_password', $data);
                }else{
                $this->session->set_flashdata('error', 'Invalid token..');
                redirect(base_url() . 'login/forget_password', 'refresh');
                }
            }else{
                $this->session->set_flashdata('error', 'Invalid token..');
                redirect(base_url() . 'login/forget_password', 'refresh');
            }
            //$this->session->set_flashdata('error', 'Invalid token..');
            //redirect(base_url() . 'login/forget_password', 'refresh');
            
        }



    function subscribe(){
        $response = array();        
        //Ajax database name,username and password request
        $email                   = $_POST["email"];
        $name                   = $_POST["name"];       
        $response['submitted_data'] = $_POST;
        $subscribe_status = $this->add_subscriber($name,$email);
        $response['subscribe_status'] = $subscribe_status; 
        
        //Replying ajax request with validation response
        echo json_encode($response);
    }

    function add_subscriber($name="", $email=""){
    $query = $this->db->get_where('subscriber' , array('email' => $email));
        if ($query->num_rows() < 1) {
            $data['name']    = $name;
            $data['email']    = $email;
            $data['subscribe_at']    = date('Y-m-d H:i:s');            
            $this->db->insert('subscriber', $data);
            $this->load->model('email_model');
            if($this->email_model->send_confirmation_to_subscriber($email)){
            return 'success';
            }else{
               return 'error'; 
            }
        }
        else if ($query->num_rows() > 0) {
            return 'exist';
        }
        else{
            return 'error';
        }
    }

    


}
