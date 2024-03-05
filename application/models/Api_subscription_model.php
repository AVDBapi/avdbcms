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

class Api_subscription_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	function create_trial_subscription($user_id=''){
        $data['user_id']        = $user_id;
        $data['plan_id']        = '0';
        $data['timestamp_from'] = time();
        $day                    = $this->db->get_where('config' , array('title'=>'trial_period'))->row()->value;
        $day_str                = $day." days";
        $data['timestamp_to']   = strtotime($day_str, $data['timestamp_from']);
        $data['status']         = '1';
        $this->db->insert('subscription', $data);
        return TRUE;
    }

    function create_subscription($user_id='',$plan_id=''){
        $data['user_id']        = $user_id;
        $data['plan_id']        = $plan_id;
        $data['timestamp_from'] = time();
        $day                    = $this->get_plan_day_by_id($plan_id);
        $day_str                = $day." days";
        $data['timestamp_to']   = strtotime($day_str, $data['timestamp_from']);
        $data['status']         = '1';
        $this->db->insert('subscription', $data);
        return TRUE;
    }

    function get_active_plan_title($user_id=''){
        $title =    'Free';
        $query =    $this->db->get_where('subscription',array('user_id' => $user_id,'status'=>'1'),1);
        if($query->num_rows() > 0):
            $plan_id = $query->row()->plan_id;
            if($plan_id == 0):
                $title = 'Trial';
            else:
                $title = $this->get_plan_name_by_id($plan_id);
            endif;
        endif;
      return $title;
    }

    function get_plan_name_by_id($plan_id){
        $name = "Not Found";
        if($plan_id == 0):
            $name = "Trial";
        endif;
        $query = $this->db->get_where('plan',array('plan_id'=>$plan_id));
        if($query->num_rows() >0):
            $name = $this->db->get_where('plan',array('plan_id'=>$plan_id))->row()->name;
        endif;
        return $name;
    }

    function get_plan_day_by_id($plan_id){
        return $this->db->get_where('plan',array('plan_id'=>$plan_id))->row()->day;
    }


    function get_active_plan_validity($user_id=''){
        $validity =    'Lifetime';
        $query =    $this->db->get_where('subscription',array('user_id' => $user_id,'status'=>'1'),1);
        if($query->num_rows() > 0):
            $date = time();
            if($date > $query->row()->timestamp_to):
                $validity = "Expired";
            else:
                $validity = date("d-m-Y",$query->row()->timestamp_to);
            endif;
        endif;
      return $validity;
    }

    function check_video_availability($slug=''){
        $error = FALSE;
        if ($slug == '' || $slug==NULL)
            $error = TRUE;

        $videos_exist = $this->common_model->videos_exist_by_slug($slug);
        if (!$videos_exist )
            $error = TRUE;
        return $error;
    }

    function check_live_tv_availability($slug=''){
        $error = FALSE;
        if ($slug == '' || $slug==NULL)
            $error = TRUE;

        $videos_exist = $this->common_model->live_tv_exist_by_slug($slug);
        if (!$videos_exist )
            $error = TRUE;
        return $error;
    }

    function videos_exist_by_slug($slug='') {
        $rows = $this->db->get_where('videos', array('slug' => $slug,'publication'=>'1'))->num_rows();
        if($rows >0){
          return TRUE;
        }
        else{
          return FALSE;
        }    
    }

    function live_tv_exist_by_slug($slug='') {
        $rows = $this->db->get_where('live_tv', array('slug' => $slug,'publish'=>'1'))->num_rows();
        if($rows >0){
          return TRUE;
        }
        else{
          return FALSE;
        }    
    }


    function check_video_accessibility($videos_id=''){
        $accessibility = "denied";        
        // free content can access by all
        $is_paid = $this->db->get_where('videos',array('videos_id'=>$videos_id))->row()->is_paid;
        if($is_paid =='0')
            $accessibility = "allowed";        
        if($is_paid =='1'):
            $subscription = $this->check_validated_subscription_plan();
            //var_dump($subscription);
            if($subscription == "login_required"):
                $accessibility = "login_required";
            elseif($subscription === "TRUE"):
                $accessibility = "allowed";
            endif;
        endif;
        // admin can access all movie
        if ($this->session->userdata('admin_is_login') == 1)
            $accessibility = "allowed";
        return $accessibility;
    }

    function check_live_tv_accessibility($live_tv_id=''){
        $accessibility = "denied";
        
        // free content can access by all
        $is_paid = $this->db->get_where('live_tv',array('live_tv_id'=>$live_tv_id))->row()->is_paid;
        if($is_paid =='0')
            $accessibility = "allowed";        
        if($is_paid =='1'):
            $subscription = $this->check_validated_subscription_plan();
            //var_dump($subscription);
            if($subscription == "login_required"):
                $accessibility = "login_required";
            elseif($subscription === "TRUE"):
                $accessibility = "allowed";
            endif;
        endif;
        // admin can access all movie
        if ($this->session->userdata('admin_is_login') == 1)
            $accessibility = "allowed";
        return $accessibility;
    }

    function check_validated_subscription_plan($user_id=''){
        $validity = "FALSE";
        if(!empty($user_id)):
            $this->db->where('status','1');
            $this->db->where('timestamp_to >',time());
            $this->db->where('user_id',$user_id);
            $query = $this->db->get('subscription');
            if($query->num_rows() >0):
                $validity = $query->row()->timestamp_to;
                if($validity > time())
                    $validity = "TRUE";
            endif;
        endif;
        if(empty($user_id)):
            $validity = "login_required";
        endif;
        return $validity;
    }

    function check_user_subscription_status($user_id=''){
        //var_dump($user_id);
        $validity = "inactive";
        if(!empty($user_id)):
            //var_dump($this->is_admin($user_id));
            if($this->is_admin($user_id)):
                $validity = "active";
            else:
                $this->db->where('status','1');
                $this->db->where('timestamp_to >',time());
                $this->db->where('user_id',$user_id);
                $query = $this->db->get('subscription');
                if($query->num_rows() >0):
                    $validity = $query->row()->timestamp_to;
                    if($validity > time())
                        $validity = "active";
                endif;
            endif;
        endif;
        return $validity;
    }

    function is_admin($user_id){
        //var_dump($user_id);
        $result     = false;
        $query = $this->db->get_where('user',array('user_id'=>$user_id));
        if($query->num_rows() > 0):
            if($query->row()->role =='admin')
                $result     = true;
        endif;
        return $result;
    }

    function get_active_subscription($user_id=''){
        $response = array();
        $this->db->where('status','1');
        $this->db->where('timestamp_to >',time());
        $this->db->where('user_id',$user_id);
        $subscriptions =  $this->db->get('subscription')->result_array();
        $i              =   0;
        foreach ($subscriptions as $row):
            $response[$i]['subscription_id']     = $row['subscription_id'];
            $response[$i]['plan_id']             = $row['plan_id'];
            $response[$i]['plan_title']          = $this->get_plan_name_by_id($row['plan_id']);
            $response[$i]['user_id']             = $row['user_id'];
            $response[$i]['price_amount']        = $row['price_amount'];
            $response[$i]['paid_amount']         = $row['paid_amount'];
            $response[$i]['start_date']          = date("d-m-Y",$row['timestamp_from']);
            $response[$i]['expire_date']         = date("d-m-Y",$row['timestamp_to']);
            $response[$i]['payment_method']      = $row['payment_method'];
            $response[$i]['payment_info']        = $row['payment_info'];
            $response[$i]['payment_timestamp']   = date("d-m-Y",$row['payment_timestamp']);
            $response[$i]['status']              = $row['status'];
            $i++;
        endforeach;
        return $response;
    }

    function get_user_active_event_list($user_id=''){
        $response = array();
        $this->db->where('status','1');
        $this->db->where('timestamp_to >',time());
        $this->db->where('user_id',$user_id);
        $subscriptions =  $this->db->get('event_subscription')->result_array();
        $i              =   0;
        foreach ($subscriptions as $row):
            $response[$i]     = $row['event_id'];
            $i++;
        endforeach;
        return $response;
    }

    function get_user_subscription_package_title_and_expired_date($user_id=''){
        $response['title']              = "Free";
        $response['expire_date']       = date('d-m-Y', strtotime("+100 years"));
        $this->db->where('status','1');
        $this->db->where('timestamp_to >',time());
        $this->db->where('user_id',$user_id);
        $query    = $this->db->get('subscription');
        if($query->num_rows() > 0):
            $response['title']          = $this->get_plan_name_by_id($query->first_row()->plan_id);
            $response['expire_date']    = date("d-m-Y",$query->first_row()->timestamp_to);
        endif;
        return $response;
    }

    function get_inactive_subscription($user_id=''){
        $response = array();
        $this->db->group_start();
        $this->db->where('status','0');
        $this->db->or_where('timestamp_to <',time());
        $this->db->group_end();
        $this->db->where('user_id',$user_id);
        $subscriptions =  $this->db->get('subscription')->result_array();
        $i              =   0;
        foreach ($subscriptions as $row):
            $response[$i]['subscription_id']     = $row['subscription_id'];
            $response[$i]['plan_id']             = $row['plan_id'];
            $response[$i]['plan_title']          = $this->get_plan_name_by_id($row['plan_id']);
            $response[$i]['user_id']             = $row['user_id'];
            $response[$i]['price_amount']        = $row['price_amount'];
            $response[$i]['paid_amount']         = $row['paid_amount'];
            $response[$i]['start_date']          = date("d-m-Y",$row['timestamp_from']);
            $response[$i]['expire_date']         = date("d-m-Y",$row['timestamp_to']);
            $response[$i]['payment_method']      = $row['payment_method'];
            $response[$i]['payment_info']        = $row['payment_info'];
            $response[$i]['payment_timestamp']   = date("d-m-Y",$row['payment_timestamp']);
            $response[$i]['status']              = $row['status'];
            $i++;
        endforeach;
        return $response;
    }

    function get_payment_config(){
        $response                               = array();
        $response['currency_symbol']            = $this->db->get_where('config' , array('title'=>'currency_symbol'))->row()->value;
        $response['currency']                   = $this->db->get_where('config' , array('title'=>'currency'))->row()->value;
        $response['paypal_email']               = $this->db->get_where('config' , array('title'=>'paypal_email'))->row()->value;
        $response['paypal_client_id']           = $this->db->get_where('config' , array('title'=>'paypal_client_id'))->row()->value;
        $response['stripe_publishable_key']     = $this->db->get_where('config' , array('title'=>'stripe_publishable_key'))->row()->value;
        $response['stripe_secret_key']          = $this->db->get_where('config' , array('title'=>'stripe_secret_key'))->row()->value;
        $response['reve_public_key']            = 'dfgdfdgdfgdfg';//$this->db->get_where('config' , array('title'=>'reve_public_key'))->row()->value;
        $response['reve_secret_key']            = 'dfgdfdgdfgdfg';//$this->db->get_where('config' , array('title'=>'reve_secret_key'))->row()->value;
        $response['reve_encryption_key']        = 'dfgdfdgdfgdfg';//$this->db->get_where('config' , array('title'=>'reve_encryption_key'))->row()->value;
        $response['play_stack_public_key']      = 'dfgdfdgdfgdfg';//$this->db->get_where('config' , array('title'=>'play_stack_public_key'))->row()->value;
        return $response;
    }

    function process_cancel_subscription($user_id="",$subscription_id=""){
        $result = false;
        $query                          = $this->db->get_where('subscription' , array('subscription_id' => $subscription_id, 'user_id'=>$user_id));
        if ($query->num_rows() > 0) {
            $data['status'] = '0';
            //$data['recurring'] = '0';
            $this->db->where('subscription_id',$subscription_id);
            $this->db->update('subscription',$data);
            $result = true;            
        }
        return $result;
    }
}


