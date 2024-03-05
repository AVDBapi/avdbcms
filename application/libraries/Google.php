<?php defined('BASEPATH') OR exit('No direct script access allowed');
#[AllowDynamicProperties]
class Google{	
	public function __construct(){		
		$this->CI =& get_instance();
		$this->CI->load->database();	
		require APPPATH .'third_party/google-api-client/vendor/autoload.php';
    	$application_name       =   $this->CI->db->get_where('config' , array('title'=>'google_application_name'))->row()->value;
    	$client_id       		=   $this->CI->db->get_where('config' , array('title'=>'google_client_id'))->row()->value;
    	$client_secret       	=   $this->CI->db->get_where('config' , array('title'=>'google_client_secret'))->row()->value;
    	$redirect_uri       	=   $this->CI->db->get_where('config' , array('title'=>'google_redirect_uri'))->row()->value;
    	$api_key       			=   $this->CI->db->get_where('config' , array('title'=>'google_api_key'))->row()->value;
		$this->client = new Google_Client();
		$this->client->setApplicationName($application_name);
		$this->client->setClientId($client_id);
		$this->client->setClientSecret($client_secret);
		$this->client->setRedirectUri($redirect_uri);
		$this->client->setDeveloperKey($api_key);
		$this->client->addScope('email');
		$this->client->addScope('profile');
		$this->client->setAccessType('online');
		$this->client->setApprovalPrompt('auto');
		//$this->oauth2 = new Google_Oauth2Service($this->client);
	}
	
	public function login_url() {
        return $this->client->createAuthUrl();
    }
	
	public function authenticate() {
        return $this->client->authenticate();
    }
	
	public function getAccessToken() {
        return $this->client->getAccessToken();
    }
	
	public function setAccessToken() {
        return $this->client->setAccessToken();
    }
	
	public function revokeToken() {
        return $this->client->revokeToken();
    }
	
	public function get_user_info($code) {
		//It will Attempt to exchange a code for an valid authentication token.
 		$token = $this->client->fetchAccessTokenWithAuthCode($_GET["code"]);
 		//This condition will check there is any error occur during geting authentication token. If there is no any error occur then it will execute if block of code/
		 if(!isset($token['error']))
		 {
		  //Set the access token used for requests
		  $this->client->setAccessToken($token['access_token']);

		  //Store "access_token" value in $_SESSION variable for future use.
		  //$_SESSION['access_token'] = $token['access_token'];

		  //Create Object of Google Service OAuth 2 class
		  $google_service = new Google_Service_Oauth2($this->client);

		  //Get user profile data from google
		  return $google_service->userinfo->get();
        //return $this->oauth2->userinfo->get();
		}
    }
	
}