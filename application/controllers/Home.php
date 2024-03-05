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

class Home extends Home_Core_Controller {
	
	public $active_theme;
	public function __construct(){
		parent::__construct();
		/* cache control */
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
	}


  public function index() {
  	    $landing_page_enable        	= $this->db->get_where('config' , array('title'=>'landing_page_enable'))->row()->value;
		$data['all_published_slider']	= $this->common_model->all_published_slider();
		$data['new_videos']				= $this->common_model->new_published_videos();
		$data['latest_videos']			= $this->common_model->latest_published_videos();
		$data['new_tv_series']			= $this->common_model->new_published_tv_series();
		$data['latest_tv_series']		= $this->common_model->latest_published_tv_series();		
		$data['title'] 					= $this->db->get_where('config' , array('title' =>'home_page_seo_title'))->row()->value;
		// seo
		$data['title']					= $this->db->get_where('config' , array('title' =>'home_page_seo_title'))->row()->value;
		$data['meta_description']		= $this->db->get_where('config' , array('title' =>'meta_description'))->row()->value;
		$data['focus_keyword']			= $this->db->get_where('config' , array('title' =>'focus_keyword'))->row()->value;


		$this->db->order_by("order", "asc");
		$data['homepage_sections'] = $this->db->get('homepage_sections')->result_array(); 

		$data['canonical']				= base_url();
		// end seo
		$data['page_name']				= 'home';

		// Homepage section

		$data['all_live_tvs']	        = $this->live_tv_model->get_all_live_tv();
		$data['popular_actors']	        = $this->common_model->get_popular_stars();
		$data['latest_episodes']	    = $this->common_model->get_latest_episodes();

		if(ovoo_config('active_theme') == 'flix'):
			$data['latest_videos']	        = $this->common_model->latest_published_videos(10, 1);
			$data['latest_tvseries']	    = $this->common_model->latest_published_tv_series(10, 1);
		endif;
		
		$data['features_genres']	    = $this->common_model->get_features_genres_homepage(6);
		$this->db->order_by('order', 'asc');
		$data['homepage_sections']      = $this->db->get('homepage_sections')->result_array();

		// end homepage section

		if($landing_page_enable == "1" && $this->active_theme == 'default'):
			$this->load->view('theme/'.$this->active_theme.'/landing',$data);
		else:
			$this->load->view('theme/'.$this->active_theme.'/index',$data);
		endif;
	}
	public function home2() {

		$data['all_published_slider']	= $this->common_model->all_published_slider();
		$data['new_videos']				= $this->common_model->new_published_videos();
		$data['latest_videos']			= $this->common_model->latest_published_videos();
		$data['new_tv_series']			= $this->common_model->new_published_tv_series();
		$data['latest_tv_series']		= $this->common_model->latest_published_tv_series();		
		// seo
		$data['title']					= $this->db->get_where('config' , array('title' =>'home_page_seo_title'))->row()->value;
		$data['meta_description']		= $this->db->get_where('config' , array('title' =>'meta_description'))->row()->value;
		$data['focus_keyword']			= $this->db->get_where('config' , array('title' =>'focus_keyword'))->row()->value;
		$data['canonical']				= base_url('all-movies.html');
		$this->db->order_by("order", "asc");
		$data['homepage_sections'] = $this->db->get('homepage_sections')->result_array(); 

		$data['canonical']				= base_url();
		// end seo
		$data['page_name']				= 'home';

		// Homepage section

		$data['all_live_tvs']	        = $this->live_tv_model->get_all_live_tv();
		$data['popular_actors']	        = $this->common_model->get_popular_stars();
		$data['latest_episodes']	    = $this->common_model->get_latest_episodes();

		if(ovoo_config('active_theme') == 'flix'):
			$data['latest_videos']	        = $this->common_model->latest_published_videos(10, 1);
			$data['latest_tvseries']	    = $this->common_model->latest_published_tv_series(10, 1);
		endif;
		
		$data['features_genres']	    = $this->common_model->get_features_genres_homepage(6);
		$this->db->order_by('order', 'asc');
		$data['homepage_sections']      = $this->db->get('homepage_sections')->result_array();

		// end homepage section
		$data['page_name']				= 'home';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}
  
	public function search(){
		$filter 			= array();
		$search_string		= '';
		$filter['title'] 	= '';
		if(isset($_GET['q'])){
			$title 				= trim($this->input->get('q',true));
			$filter['title'] 	= $title;
			$search_string	   .= 'q='.$title;
		}
		$total_rows = $this->common_model->get_videos_num_rows($filter);
		$this->load->library("pagination");
		$config 					= array();
		$config["base_url"] 		= base_url() . "search?".$search_string;
		$config["total_rows"] 		= $total_rows;
		$config["per_page"] 		= 24;
		$config["uri_segment"] 		= 3;
		$config['full_tag_open'] 	= '<div class="pagination-container text-center"><ul class ="pagination">';
		$config['full_tag_close'] 	= '</ul></div><!--pagination-->';

		$config['first_link'] 		= '«';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';

		$config['last_link'] 		= '»';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';

		$config['next_link'] 		= '&rarr;';
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';

		$config['prev_link'] 		= '&larr;';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';

		$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
		$config['cur_tag_close'] 	= '</a><div class="pagination-hvr"></div></li>';

		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '<div class="pagination-hvr"></div></li>';
		$config['page_query_string'] = TRUE;
		$this->pagination->initialize($config);
		$page 						= $this->input->get('per_page');   
        $data["all_published_videos"] = $this->common_model->get_videos($filter,$config["per_page"], $page);
		$data["links"] 				= $this->pagination->create_links();
		$data['total_rows']			= $config["total_rows"];
		$data['search_keyword']		= $filter['title'];
		$data['title'] 				= $filter['title'].'-search results';
		$data['page_name']			= 'search_results.php';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}
	public function autoCompleteAjax()
    {
    	$tearm = $this->input->get('term');
    	$this->db->order_by('title',"ASC");
        $this->db->limit(5);
        $this->db->like('title',$tearm);
        $videos =  $this->db->get('videos')->result_array();
            foreach($videos as $video)
            {                
                $new_row['title']= $video['title'];
                $new_row['type']= "Movie";
                if($video['is_tvseries']=="1"){
                	$new_row['type']= "TV-Series";
                }
	            $new_row['image'] 	= $this->common_model->get_video_thumb_url($video['videos_id']);
                $new_row['url']		= base_url().'watch/'.$video['slug'].'.html';              
             	$row_set[] 			= $new_row;
            }        
        echo json_encode($row_set); 
    }
  
    public function movies(){
    	$movie_per_page              =   $this->db->get_where('config' , array('title'=>'movie_per_page'))->row()->value;
		$this->load->library("pagination");
		$total_movie 				= $this->common_model->movies_record_count();  
		$config 					= array();
		$config["base_url"] 		= base_url() . "home/movies";
		$config["total_rows"] 		= $total_movie;
		$config["per_page"] 		= $movie_per_page;
		$config["uri_segment"] 		= 3;
	    $config['full_tag_open'] 	= '<div class="pagination-container text-center"><ul class ="pagination">';
		$config['full_tag_close'] 	= '</ul></div><!--pagination-->';
		$config['first_link'] 		= '«';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_link'] 		= '»';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$config['next_link'] 		= '&rarr;';
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_link'] 		= '&larr;';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
		$config['cur_tag_close'] 	= '</a><div class="pagination-hvr"></div></li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '<div class="pagination-hvr"></div></li>';
		$config['suffix']			= '.html'; 
		$config['use_page_numbers'] = TRUE;	

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["all_published_videos"] = $this->common_model->all_published_videos($movie_per_page, $page);
		$data["links"] = $this->pagination->create_links();
	    $data['total_rows']=$total_movie;
		// seo
		$data['title']				= $this->db->get_where('config' , array('title' =>'movie_page_seo_title'))->row()->value;
		$data['meta_description']	= $this->db->get_where('config' , array('title' =>'movie_page_meta_description'))->row()->value;
		$data['focus_keyword']		= $this->db->get_where('config' , array('title' =>'movie_page_focus_keyword'))->row()->value;
		$data['canonical']			= base_url('movies.html');
		// end seo

		$data['page_name']='movies';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}


	public function actor_movies($id){

		echo $id;
		exit();
    	$movie_per_page              =   $this->db->get_where('config' , array('title'=>'movie_per_page'))->row()->value;
		$this->load->library("pagination");
		$total_movie 				= $this->common_model->movies_record_count();  
		$config 					= array();
		$config["base_url"] 		= base_url() . "home/movies";
		$config["total_rows"] 		= $total_movie;
		$config["per_page"] 		= $movie_per_page;
		$config["uri_segment"] 		= 3;
	    $config['full_tag_open'] 	= '<div class="pagination-container text-center"><ul class ="pagination">';
		$config['full_tag_close'] 	= '</ul></div><!--pagination-->';
		$config['first_link'] 		= '«';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_link'] 		= '»';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$config['next_link'] 		= '&rarr;';
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_link'] 		= '&larr;';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
		$config['cur_tag_close'] 	= '</a><div class="pagination-hvr"></div></li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '<div class="pagination-hvr"></div></li>';
		$config['suffix']			= '.html'; 
		$config['use_page_numbers'] = TRUE;	

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["all_published_videos"] = $this->common_model->all_published_videos($movie_per_page, $page);
		$data["links"] = $this->pagination->create_links();
	    $data['total_rows']=$total_movie;
		// seo
		$data['title']				= $this->db->get_where('config' , array('title' =>'movie_page_seo_title'))->row()->value;
		$data['meta_description']	= $this->db->get_where('config' , array('title' =>'movie_page_meta_description'))->row()->value;
		$data['focus_keyword']		= $this->db->get_where('config' , array('title' =>'movie_page_focus_keyword'))->row()->value;
		$data['canonical']			= base_url('movies.html');
		// end seo

		$data['page_name']  ='movies';
		$data['title']      ='movies of ';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}



	public function trailers(){
		$this->load->library("pagination");
    
		$config = array();
		$config["base_url"] = base_url() . "home/trailers";
		$config["total_rows"] = $this->common_model->trailers_record_count();
		$config["per_page"] = 24;
		$config["uri_segment"] = 3;
		$config['full_tag_open'] = '<div class="pagination-container text-center"><ul class ="pagination">';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';

		$config['first_link'] = '«';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = '»';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a><div class="pagination-hvr"></div></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '<div class="pagination-hvr"></div></li>';
		$config['suffix']=  '.html'; 
  

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["all_published_videos"] = $this->common_model->fetch_trailers($config["per_page"], $page);
		$data["links"] = $this->pagination->create_links();
		$data['total_rows']=$config["total_rows"];
		$data['title'] = 'Free Movies Online';
		$data['page_name']='movies';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}  

	public function request_movies(){

		$this->load->library("pagination");    
		$config = array();
		$config["base_url"] = base_url() . "home/request_movies";
		$config["total_rows"] = $this->common_model->requested_movie_record_count();
		$config["per_page"] = 24;
		$config["uri_segment"] = 3;
		$config['full_tag_open'] = '<div class="pagination-container text-center"><ul class ="pagination">';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';

		$config['first_link'] = '«';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = '»';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '&rarr;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&larr;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a><div class="pagination-hvr"></div></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '<div class="pagination-hvr"></div></li>';
		$config['suffix']=  '.html'; 
  

		$this->pagination->initialize($config);
		$page 							= ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data["all_published_videos"] 	= $this->common_model->fetch_request_movies($config["per_page"], $page);
		$data["links"] 					= $this->pagination->create_links();
		$data['total_rows']				= $config["total_rows"];
		$data['title'] 					= 'Free Movies  Request Online';
		$data['page_name']				= 'request_movies';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
    }

    public function request_for_movies(){
		$data['title'] = 'Send Us Movie Request';
		$data['page_name']='requiest_for_movie';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}

	public function dmca(){
		$data['title'] = 'DMCA';
		$data['page_name']='dmca';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}


  
	public function faq(){
		$data['title'] = 'FAQ';
		$data['page_name']='faq';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}
  
  
    public function policy(){
		$data['title'] = 'Privacy Policy';
		$data['page_name']='policy';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}
  
  
    public function terms(){
		$data['title'] = 'Terms & Condition';
		$data['page_name']='terms';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}
  
  
    public function contact(){
		$data['title'] = 'Contact Us';
		$data['page_name']='contact';
		$this->load->view('theme/'.$this->active_theme.'/index',$data);
	}

	function send_message(){
        $response = array();        
        //Ajax database name,username and password request
        $name                   	= $_POST["name"];
        $email                   	= $_POST["email"]; 
        $message                   	= $_POST["message"];
        //$this->email_model->contact_email($name , $email, $message);
        $response['status'] = 'success';        
        //Replying ajax request with validation response
        echo json_encode($response);
    }

    function contact_process(){
    	$name 			= $this->input->post('name');
    	$email 			= $this->input->post('email');
    	$message		= $this->input->post('message');
        $this->form_validation->set_rules('name', 'Name', 'required|min_length[3]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[8]');
		$this->form_validation->set_rules('message', 'Message', 'required|min_length[8]');
		if ($this->form_validation->run() == FALSE)
        {
        	$this->session->set_flashdata('error', validation_errors());
            redirect(base_url() . 'contact-us.html', 'refresh');
        }
        else
        {
        	$this->load->model('email_model');
        	if($this->email_model->contact_email($name , $email, $message)){
        		//$insert_id = '1043';
        		//$this->email_model->new_movie_notification($insert_id);
        		$this->session->set_flashdata('success', 'Message send successfully.');
    		}else{
    			$this->session->set_flashdata('error', 'Oops! Something went wrong.');	
    	    	rediret(base_url() . 'contact-us.html', 'refresh');
    		}
    	}
    	redirect(base_url() . 'contact-us.html', 'refresh');
    }

    function send_movie_request(){
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('movie_name', 'Movie Name', 'trim|required|min_length[2]');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email|min_length[4]');
        $this->form_validation->set_rules('message', 'Message', 'trim');
        if ($this->form_validation->run() == FALSE):
            $this->session->set_flashdata('error', json_encode(validation_errors()));
            redirect($this->agent->referrer());
        else:
            $data['name']           =   trim($this->input->post('name'));
            $data['email']          =   trim($this->input->post('email'));
            $data['movie_name']     =   trim($this->input->post('movie_name'));
            $data['message']        =   trim($this->input->post('message'));
            $this->db->insert('request',$data);
            $this->session->set_flashdata('success', 'Request sent successfully.');
        	redirect($this->agent->referrer());
        endif;
    }

    public function validate_recaptcha(){
        $is_valid = $this->recaptcha->is_valid();
        if($is_valid['success']):
            return true;
        else:
            if(array_key_exists("error_message",$is_valid)):
                $this->form_validation->set_message('validate_recaptcha', $is_valid['error_message']);
            else:
                $this->form_validation->set_message('validate_recaptcha', trans("captcha_code_is_wrong"));
            endif;
            return false;
        endif;
   }

    function view_modal($page_name = '' , $param2 = '' , $param3 = ''){
            $account_type       =   $this->session->userdata('login_type');
            $data['param2']     =   $param2;
            $data['param3']     =   $param3;
            //$this->load->view('front_end/'.$page_name.'.php' ,$data);
            $this->load->view('theme/'.$this->active_theme.'/'.$page_name.'.php',$data);       
        
	}


	function continue_watching(){
		$data['watch'] = $this->input->post('watch');

		echo json_encode( array(
		    'view_html' => $this->load->view('theme/'.$this->active_theme.'/'.'continue_watching_view'.'.php',$data,TRUE),
		    'data'      => $data['watch']
		));
	}
	public function filter_movies(){ 
		$sort                   = $this->input->post('sort');
		$category               = $this->input->post('category');
		$language               = $this->input->post('language');
		$country                = $this->input->post('country');
		$minimum_rating         = $this->input->post('minimum_rating');
		$maximum_rating         = $this->input->post('maximum_rating');

		$movie_per_page             =   20;

		// short		
		if(!empty($sort) && ($sort =='asc' || $sort =='desc')):
			$this->db->order_by("videos_id",$sort);
		elseif(!empty($sort) && $sort =='total_view'):
			$this->db->order_by("total_view","DESC");
		elseif(!empty($sort) && $sort =='rating'):
			$this->db->order_by("imdb_rating","DESC");
		elseif(!empty($sort) && $sort =='release'):
			$this->db->order_by("release","DESC");
		elseif(!empty($sort) && $sort =='az'):
			$this->db->order_by("title","ASC");
		elseif(!empty($sort) && $sort =='za'):
			$this->db->order_by("title","DESC");
		endif;

		// category		
		if(!empty($category) && is_numeric($category)):
			$this->db->where("FIND_IN_SET($category,genre)>0");
		endif;

		// language		
		if(!empty($language) && is_numeric($language)):
			if($language ==99999999):
				$this->db->group_start();
				$this->db->where("language",NULL);
				$this->db->or_where("language","");
				$this->db->or_where("language"," ");
				$this->db->group_end();
			else:
				$this->db->where("FIND_IN_SET($language,language)>0");
			endif;
		endif;

		// country		
		if(!empty($country) && is_numeric($country)):
			$this->db->where("FIND_IN_SET($country,country)>0");
		endif;

		// rating		
		if(!empty($minimum_rating) && isset($maximum_rating)):
			$this->db->where("imdb_rating BETWEEN $minimum_rating AND $maximum_rating");
		endif;

		
		$page 						= ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$offset 					= ($page*$movie_per_page)-$movie_per_page;
        if($offset<0){
            $offset = 0;
        }

        $this->db->where('is_tvseries','0');
        $this->db->where('publication', '1');     
        $this->db->limit($movie_per_page,$offset);
        $data['all_videos'] 		=  $this->db->get('videos')->result_array();
        $response['movie_list']    	= $this->load->view('theme/default/filter_movies',$data,TRUE);


		// category		
		if(!empty($category) && is_numeric($category)):
			$this->db->where("FIND_IN_SET($category,genre)>0");
		endif;

		// language		
		if(!empty($language) && is_numeric($language)):
			if($language ==99999999):
				$this->db->group_start();
				$this->db->where("language",NULL);
				$this->db->or_where("language","");
				$this->db->or_where("language"," ");
				$this->db->group_end();
			else:
				$this->db->where("FIND_IN_SET($language,language)>0");
			endif;
		endif;

		// country		
		if(!empty($country) && is_numeric($country)):
			$this->db->where("FIND_IN_SET($country,country)>0");
		endif;

		// rating		
		if(!empty($minimum_rating) && isset($maximum_rating)):
			$this->db->where("imdb_rating BETWEEN $minimum_rating AND $maximum_rating");
		endif;

        $this->db->where('is_tvseries','0');
        $this->db->where('publication', '1');
        $total_movie 		=  $this->db->get('videos')->num_rows();


        $this->load->library("pagination"); 
		$config 					= array();
		$config["base_url"] 		= base_url() . "movie_filter";
		$config["total_rows"] 		= $total_movie;
		$config["per_page"] 		= $movie_per_page;
		$config["uri_segment"] 		= 2;
	    $config['full_tag_open'] 	= '<div class="pagination-container text-center"><ul class ="pagination">';
		$config['full_tag_close'] 	= '</ul></div><!--pagination-->';
		$config['first_link'] 		= '«';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_link'] 		= '»';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$config['next_link'] 		= '&rarr;';
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_link'] 		= '&larr;';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
		$config['cur_tag_close'] 	= '</a><div class="pagination-hvr"></div></li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '<div class="pagination-hvr"></div></li>';
		$config['suffix']			= '.html'; 
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$response["pagination_link"]= $this->pagination->create_links();
		$response["inputs"]= $this->input->post();
		$response["last_query"]= $this->db->last_query();

		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function filter_tvseries(){ 
		$sort                   = $this->input->post('sort');
		$category               = $this->input->post('category');
		$language               = $this->input->post('language');
		$country                = $this->input->post('country');
		$minimum_rating         = $this->input->post('minimum_rating');
		$maximum_rating         = $this->input->post('maximum_rating');

		$movie_per_page             =   20;

		// short		
		if(!empty($sort) && ($sort =='asc' || $sort =='desc')):
			$this->db->order_by("videos_id",$sort);
		elseif(!empty($sort) && $sort =='total_view'):
			$this->db->order_by("total_view","DESC");
		elseif(!empty($sort) && $sort =='rating'):
			$this->db->order_by("imdb_rating","DESC");
		elseif(!empty($sort) && $sort =='release'):
			$this->db->order_by("release","DESC");
		elseif(!empty($sort) && $sort =='az'):
			$this->db->order_by("title","ASC");
		elseif(!empty($sort) && $sort =='za'):
			$this->db->order_by("title","DESC");
		endif;

		// category		
		if(!empty($category) && is_numeric($category)):
			$this->db->where("FIND_IN_SET($category,genre)>0");
		endif;

		// language		
		if(!empty($language) && is_numeric($language)):
			if($language ==99999999):
				$this->db->group_start();
				$this->db->where("language",NULL);
				$this->db->or_where("language","");
				$this->db->or_where("language"," ");
				$this->db->group_end();
			else:
				$this->db->where("FIND_IN_SET($language,language)>0");
			endif;
		endif;

		// country		
		if(!empty($country) && is_numeric($country)):
			$this->db->where("FIND_IN_SET($country,country)>0");
		endif;

		// rating		
		if(!empty($minimum_rating) && isset($maximum_rating)):
			$this->db->where("imdb_rating BETWEEN $minimum_rating AND $maximum_rating");
		endif;

		
		$page 						= ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$offset 					= ($page*$movie_per_page)-$movie_per_page;
        if($offset<0){
            $offset = 0;
        }

        $this->db->where('is_tvseries','1');
        $this->db->where('publication', '1');     
        $this->db->limit($movie_per_page,$offset);
        $data['all_videos'] 		=  $this->db->get('videos')->result_array();
        $response['movie_list']    	= $this->load->view('theme/default/filter_movies',$data,TRUE);


		// category		
		if(!empty($category) && is_numeric($category)):
			$this->db->where("FIND_IN_SET($category,genre)>0");
		endif;

		// language		
		if(!empty($language) && is_numeric($language)):
			if($language ==99999999):
				$this->db->group_start();
				$this->db->where("language",NULL);
				$this->db->or_where("language","");
				$this->db->or_where("language"," ");
				$this->db->group_end();
			else:
				$this->db->where("FIND_IN_SET($language,language)>0");
			endif;
		endif;

		// country		
		if(!empty($country) && is_numeric($country)):
			$this->db->where("FIND_IN_SET($country,country)>0");
		endif;

		// rating		
		if(!empty($minimum_rating) && isset($maximum_rating)):
			$this->db->where("imdb_rating BETWEEN $minimum_rating AND $maximum_rating");
		endif;

        $this->db->where('is_tvseries','1');
        $this->db->where('publication', '1');
        $total_movie 		=  $this->db->get('videos')->num_rows();


        $this->load->library("pagination"); 
		$config 					= array();
		$config["base_url"] 		= base_url() . "movie_filter";
		$config["total_rows"] 		= $total_movie;
		$config["per_page"] 		= $movie_per_page;
		$config["uri_segment"] 		= 2;
	    $config['full_tag_open'] 	= '<div class="pagination-container text-center"><ul class ="pagination">';
		$config['full_tag_close'] 	= '</ul></div><!--pagination-->';
		$config['first_link'] 		= '«';
		$config['first_tag_open'] 	= '<li>';
		$config['first_tag_close'] 	= '</li>';
		$config['last_link'] 		= '»';
		$config['last_tag_open'] 	= '<li>';
		$config['last_tag_close'] 	= '</li>';
		$config['next_link'] 		= '&rarr;';
		$config['next_tag_open'] 	= '<li>';
		$config['next_tag_close'] 	= '</li>';
		$config['prev_link'] 		= '&larr;';
		$config['prev_tag_open'] 	= '<li>';
		$config['prev_tag_close'] 	= '</li>';
		$config['cur_tag_open'] 	= '<li class="active"><a href="#">';
		$config['cur_tag_close'] 	= '</a><div class="pagination-hvr"></div></li>';
		$config['num_tag_open'] 	= '<li>';
		$config['num_tag_close'] 	= '<div class="pagination-hvr"></div></li>';
		$config['suffix']			= '.html'; 
		$config['use_page_numbers'] = TRUE;
		$this->pagination->initialize($config);
		$response["pagination_link"]= $this->pagination->create_links();
		$response["inputs"]= $this->input->post();
		$response["last_query"]= $this->db->last_query();

		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
	
}