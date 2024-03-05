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

class Language extends CI_Controller{
	
	function __construct()	{
		parent::__construct();
		$this->load->database();
		$this->load->library('session');
		/*cash control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	}
	
	function index(){
		redirect(base_url(), 'refresh');
	}
	
	function language_switch($short_form = 'en'){
		if($this->language_model->language_short_form_exist($short_form)):
			$language_id = $this->language_model->language_id_by_short_form($short_form);
			$this->session->unset_userdata('active_language_id');
			$this->session->set_userdata('active_language_id',$language_id);
		endif;
		redirect($this->agent->referrer());
	}	
}
