<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * Ovoo-Movie & Video Stremaing CMS Pro
 * ---------------------- OVOO --------------------
 * ------- Movie & Video Stremaing CMS Pro --------
 * - Professional video content management system -
 *
 * @package     OVOO-Movie & Video Stremaing CMS Pro
 * @author      Abdul Mannan/Spa Green Creative
 * @copyright   Copyright (c) 2014 - 2018 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/

require(APPPATH ."third_party/razorpay/Razorpay.php");
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
class Subscription extends Home_Core_Controller {   
    
    function __construct() {
        parent::__construct();
        $this->load->model('subscription_model');
        $this->admin_is_login       = $this->session->userdata('admin_is_login');
        $this->moderator_is_login   = $this->session->userdata('moderator_is_login');        
    }
    
    //default index function, redirects to login/dashboard 
    public function index(){
        if ($this->admin_is_login != 1 && $this->moderator_is_login != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->admin_is_login != 1 && $this->moderator_is_login != 1)
            redirect(base_url() . 'admin/dashboard', 'refresh');
    }

    function package($param1 = '', $param2 = ''){
        if ($this->admin_is_login != 1 && $this->moderator_is_login != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '301');
            /* end menu active/inactive section*/ 

            /* add new access */ 
        if ($param1 == 'add') {
            demo_check();
            $data['name']           = $this->input->post('name');
            $data['day']            = $this->input->post('day');
            $data['price']          = $this->input->post('price');
            $data['status']         = $this->input->post('status');
            $this->db->insert('plan', $data);
            $this->session->set_flashdata('success', 'Package added successed.');
            redirect(base_url() . 'subscription/package/', 'refresh');
        }
        if ($param1 == 'update') {
            demo_check();
            $data['name']           = $this->input->post('name');
            $data['day']            = $this->input->post('day');
            $data['price']          = $this->input->post('price');
            $data['status']         = $this->input->post('status');
            $this->db->where('plan_id', $param2);
            $this->db->update('plan', $data);
            $this->session->set_flashdata('success', 'Package update successed.');
            redirect(base_url() . 'subscription/package/', 'refresh');
        }      
        $data['page_name']      = 'package';
        $data['page_title']     = 'Manage Package';
        $data['plans']    = $this->db->get('plan')->result_array(); 
        $this->load->view('admin/index', $data);
    }

    function transaction_history($param1 = '', $param2 = ''){
        if ($this->admin_is_login != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '3001');
            /* end menu active/inactive section*/       
        $data['page_name']      = 'transaction_history';
        $data['page_title']     = 'Transaction History';
        $this->db->order_by('subscription_id',"desc");
        $data['subscriptions']          = $this->db->get('subscription')->result_array(); 
        $this->load->view('admin/index', $data);
    }

    function upgrade($param1 = '', $param2 = ''){      
        $data['page_name']      = 'price_plan';
        $data['page_title']     = 'Upgrade Membership';
        $data['plans']    = $this->db->get('plan')->result_array(); 
        //$this->load->view('front_end/index', $data);
        $this->load->view('theme/'.$this->active_theme.'/index',$data);
    }


    function manage_subscription($param1 = '', $param2 = ''){
        if ($this->admin_is_login != 1 && $this->moderator_is_login != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '15');
            /* end menu active/inactive section*/ 

            /* add new access */ 
        if ($param1 == 'add') {
            demo_check();
            $user_id                = $this->input->post('user_id');
            $status                 = $this->input->post('status');
            //deactive previus plan
            if($status =='1'):
                $sub_data['status']     = 0;
                $this->db->where('user_id',$user_id);
                $this->db->update('subscription',$sub_data);
            endif;

            // add subscription plan
            $data['user_id']                = $user_id;
            $data['plan_id']                = $this->input->post('plan_id');
            $data['payment_method']         = $this->input->post('payment_method');
            $data['paid_amount']            = $this->input->post('paid_amount');
            $data['transaction_id']         = $this->input->post('transaction_id');
            
            $data['timestamp_from']         = strtotime($this->input->post('start_date'));
            $data['payment_timestamp']      =   time();
            $day                            = $this->subscription_model->get_plan_day_by_id($data['plan_id']);
            $day_str                        = $day." days";
            $data['timestamp_to']           = strtotime($day_str, $data['timestamp_from']);
            $data['status']                 = $status;
            $data['payment_info']           = json_encode($data);
            $this->db->insert('subscription', $data);
            $this->session->set_flashdata('success', 'Plan added successed.');
            redirect(base_url() . 'subscription/manage_subscription/'.$user_id, 'refresh');
        }
        if ($param1 == 'update') {
            demo_check();
            $user_id                        = $this->input->post('user_id');
            $status                         = $this->input->post('status');
            //deactive previus plan
            if($status =='1'):
                $sub_data['status']     = 0;
                $this->db->where('user_id',$user_id);
                $this->db->update('subscription',$sub_data);
            endif;

            // edit subscription plan
            $data['user_id']                = $user_id;
            $data['plan_id']                = $this->input->post('plan_id');
            $data['payment_method']         = $this->input->post('payment_method');
            $data['paid_amount']            = $this->input->post('paid_amount');
            $data['transaction_id']         = $this->input->post('transaction_id');
            //$data['payment_info']           = json_encode(array("Transaction ID"=>$this->input->post('transaction_id')));
            $data['timestamp_from']         = strtotime($this->input->post('start_date'));
            $day                            = $this->subscription_model->get_plan_day_by_id($data['plan_id']);
            $day_str                        = $day." days";
            $data['timestamp_to']           = strtotime($day_str, $data['timestamp_from']);
            $data['status']                 = $status;
            $data['payment_info']           = json_encode($data);
            $this->db->where('subscription_id',$param2);
            $this->db->update('subscription', $data);
            $this->session->set_flashdata('success', 'Plan added successed.');
            redirect(base_url() . 'subscription/manage_subscription/'.$user_id, 'refresh');
        }   
        
        $query                  = $this->db->get_where('user',array('user_id'=>$param1),1);
        if($query->num_rows() > 0):
            $data['page_name']      = 'subscription_manage';
            $data['page_title']     = 'Manage Subscription';
            $data['user_data']      = $query->row();
            $this->db->order_by('subscription_id',"DESC");
            $data['subscriptions']  = $this->db->get_where('subscription',array('user_id'=>$param1))->result_array();
            $this->load->view('admin/index', $data);
        else:
            $this->session->set_flashdata('error', 'User not found.');
            redirect(base_url() . 'subscription/manage_user/', 'refresh');
        endif;
    }

    function sub_setting($param1 = '', $param2 = ''){
        if ($this->admin_is_login != 1 && $this->moderator_is_login != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '302');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();
            $data['value'] = $this->input->post('currency_symbol');
            $this->db->where('title' , 'currency_symbol');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('currency');
            $this->db->where('title' , 'currency');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('exchange_rate_update_by_cron');
            $this->db->where('title' , 'exchange_rate_update_by_cron');
            $this->db->update('config' , $data); 


            $data['value'] = $this->input->post('trial_enable');
            $this->db->where('title' , 'trial_enable');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('trial_period');
            $this->db->where('title' , 'trial_period');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('enable_ribbon');
            $this->db->where('title' , 'enable_ribbon');
            $this->db->update('config' , $data);

            $this->common_model->exchange_rate_update_by_iso_code($this->input->post('currency'),$this->input->post('exchnage_rate'));
            
            $this->session->set_flashdata('success', 'Subscription setting update successed');
            redirect(base_url() . 'subscription/sub_setting/', 'refresh');
        }
        $data['page_name']      = 'sub_setting';
        $data['page_title']     = 'Subscription Setting';
        $data['currencies']     = $this->db->get('currency')->result_array();
        $this->load->view('admin/index', $data);
    }

    function payment_setting($param1 = '', $param2 = ''){
        if ($this->admin_is_login != 1 && $this->moderator_is_login != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '3002');
            /* end menu active/inactive section*/

        if ($param1 == 'update') {
            demo_check();
            // offline_payment
            $offline_payment_enable = $this->input->post('offline_payment_enable');
            if($offline_payment_enable =='on'):
                $data['value'] = "true";
                $this->db->where('title' , 'offline_payment_enable');
                $this->db->update('config' , $data);
            else:
                $data['value'] = "false";
                $this->db->where('title' , 'offline_payment_enable');
                $this->db->update('config' , $data);
            endif;
            $data['value'] = $this->input->post('offline_payment_title');
            $this->db->where('title' , 'offline_payment_title');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('offline_payment_instruction');
            $this->db->where('title' , 'offline_payment_instruction');
            $this->db->update('config' , $data);
            
            // paypal
            $paypal_enable = $this->input->post('paypal_enable');
            if($paypal_enable =='on'):
                $data['value'] = "true";
                $this->db->where('title' , 'paypal_enable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = "false";
                 $this->db->where('title' , 'paypal_enable');
                 $this->db->update('config' , $data);
            endif;
            $data['value'] = $this->input->post('paypal_email');
            $this->db->where('title' , 'paypal_email');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('paypal_client_id');
            $this->db->where('title' , 'paypal_client_id');
            $this->db->update('config' , $data);

            // stripe

            $stripe_enable = $this->input->post('stripe_enable');
            if($stripe_enable =='on'):
                $data['value'] = "true";
                $this->db->where('title' , 'stripe_enable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = "false";
                 $this->db->where('title' , 'stripe_enable');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('stripe_publishable_key');
            $this->db->where('title' , 'stripe_publishable_key');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('stripe_secret_key');
            $this->db->where('title' , 'stripe_secret_key');
            $this->db->update('config' , $data);

            // razorpay

            $razorpay_enable = $this->input->post('razorpay_enable');
            if($razorpay_enable =='on'):
                $data['value'] = "true";
                $this->db->where('title' , 'razorpay_enable');
                 $this->db->update('config' , $data);
            else:
                $data['value'] = "false";
                 $this->db->where('title' , 'razorpay_enable');
                 $this->db->update('config' , $data);
            endif;

            $data['value'] = $this->input->post('razorpay_key_id');
            $this->db->where('title' , 'razorpay_key_id');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('razorpay_key_secret');
            $this->db->where('title' , 'razorpay_key_secret');
            $this->db->update('config' , $data);

            $data['value'] = $this->input->post('razorpay_inr_exchange_rate');
            $this->db->where('title' , 'razorpay_inr_exchange_rate');
            $this->db->update('config' , $data);
            
            $this->session->set_flashdata('success', 'Subscription setting update successed');
            redirect(base_url() . 'subscription/payment_setting/', 'refresh');
        }
        $data['page_name']      = 'payment_setting';
        $data['page_title']     = 'Payment Setting';
        $this->load->view('admin/index', $data);
    }

    function cancel_subscription(){
        $response                       = array();
        $subscription_id                = trim($_POST["subscription_id"]);       
        $response['submitted_data']     = $_POST;
        $status                         = $this->process_cancel_subscription($subscription_id);
        $response['status']             = $status;
        echo json_encode($response);
    }

    // function process_cancel_subscription($subscription_id=""){
    //     $user_id                        = $this->session->userdata('user_id');
    //     $query                          = $this->db->get_where('subscription' , array('subscription_id' => $subscription_id, 'user_id'=>$user_id));
    //     if($user_id =='' || $user_id==NULL){
    //        return 'login_error'; 
    //     }else if ($query->num_rows() > 0) {
    //         $data['recurring'] = '0';
    //         //$data['status'] = '0';
    //         $this->db->where('subscription_id',$subscription_id);
    //         $this->db->update('subscription',$data);
    //         return 'success';            
    //     }else{
    //        return 'error'; 
    //     }
    // }

    function process_cancel_subscription($subscription_id=""){
        $user_id                        = $this->session->userdata('user_id');
        $query                          = $this->db->get_where('subscription' , array('subscription_id' => $subscription_id, 'user_id'=>$user_id));
        if($user_id =='' || $user_id==NULL){
           return 'login_error'; 
        }else if ($query->num_rows() > 0) {
            $data['status'] = '0';
            $this->db->where('subscription_id',$subscription_id);
            $this->db->update('subscription',$data);
            return 'success';            
        }else{
           return 'error'; 
        }
    }

    function stripe_payment(){
        $data['plan_id']           =   $this->input->post('plan_id');
        $data['page_title']        =   'Purchase Package/Subscription';
        //$this->load->view('front_end/stripe_payment', $data);
        $this->load->view('theme/'.$this->active_theme.'/stripe_payment',$data);
    } 

    function stripe($plan_id = '') {
        if (isset($_POST['stripeToken'])) {
            $currency_code                      =   $this->db->get_where('config',array('title'=>'currency'))->row()->value;         
            $plan_name                          =   $this->db->get_where('plan', array('plan_id'=>$plan_id))->row()->name;
            $price                              =   $this->db->get_where('plan', array('plan_id'=>$plan_id))->row()->price;
            $charging_amount                    =   $price * 100;
            $stripe_token                       =   $_POST['stripeToken'];
            $stripe_secret_key                  =   $this->db->get_where('config',array('title'=>'stripe_secret_key'))->row()->value;           
            
            
            $stripe_data['stripe_token']        =   $stripe_token;
            $stripe_data['amount']              =   $charging_amount;
            $stripe_data['currency']            =   strtolower($currency_code);  
            $stripe_data['description']         =   $plan_name;
            $stripe_data['stripe_secret_key']   =   $stripe_secret_key;

            $stripe_response  = $this->stripegateway->checkout($stripe_data);

            if(isset($stripe_response->paid) && $stripe_response->paid):
                $data['transaction_id']             = $stripe_response->balance_transaction;
                $data['payment_info']               = json_encode($stripe_response);
                $data['plan_id']                    =   $plan_id;
                $data['user_id']                    =   $this->session->userdata('user_id');
                $data['price_amount']               =   $price;
                $data['paid_amount']                =   $price;
                $data['currency']                   =   $currency_code;
                $data['payment_timestamp']          =   time();
                $data['timestamp_from']             =   time();
                $day                                =   $this->db->get_where('plan', array('plan_id'=>$plan_id))->row()->day;
                $day                                =   '+'.$day.' days';
                $data['timestamp_to']               =   strtotime($day, $data['timestamp_from']);
                $data['payment_method']             =   'stripe';
                $data['status']                     =   1;
                $this->db->insert('subscription' , $data);
                $this->session->set_flashdata('success', 'Subscription purchase successfully!');
            else:
                $this->session->set_flashdata('error', 'Transaction fail to process.</br>Reason:'.$this->stripegateway->checkout($stripe_data));
            endif;
            redirect(base_url('my-account/subscription') , 'refresh');
        }      
    }

    function razorpay_payment(){
        $plan_id                    =   $this->input->post('plan_id');
        $query                      =   $this->db->get_where('plan', array('plan_id'=>$plan_id));
        if($query->num_rows() > 0):
            $plan_title                 = $query->first_row()->name;
            $plan_price                 = $query->first_row()->price;
            $data['plan_id']            = $query->first_row()->plan_id;
            $this->session->unset_userdata('plan_id');
            $this->session->set_userdata('plan_id',$data['plan_id']);
            $data['page_title']         =   'Purchase Package/Subscription';
            $data['site_name']          =   $this->db->get_where('config' , array('title'=>'site_name'))->row()->value;
            $razorpay_inr_exchange_rate =   $this->db->get_where('config' , array('title'=>'razorpay_inr_exchange_rate'))->row()->value;
            $transaction_amount         =   ($plan_price*(int)$razorpay_inr_exchange_rate)*100;
            $api = new Api(ovoo_config('razorpay_key_id'), ovoo_config('razorpay_key_secret'));
            $orderData = [
                'receipt'         => uniqid(),
                'amount'          => $transaction_amount, // 2000 rupees in paise
                'currency'        => 'INR',
                'payment_capture' => 1 // auto capture
            ];

            try
            {
                $razorpayOrder = $api->order->create($orderData);
                $this->session->unset_userdata('razorpay_order_id');
                $this->session->set_userdata('razorpay_order_id',$razorpayOrder['id']);
                }
            catch (\Exception $e)
            {
                $this->session->set_flashdata('error', $e->getMessage());
                redirect(base_url('subscription/upgrade') , 'refresh');
            }

            

            $data['razorpay_options']   = [
                "key"               => ovoo_config('razorpay_key_id'),
                "amount"            => $transaction_amount,
                "name"              => $data['site_name'],
                "description"       => "Package: ".$plan_title,
                "image"             => base_url("uploads/system_logo/").ovoo_config('logo'),
                "prefill"           => [
                    "name"              => $this->session->userdata('name'),
                    "email"             => $this->session->userdata('email'),
                    "contact"           => $this->session->userdata('phone'),
                ],
                "notes"             => [
                    "address"           => "Hello World",
                    "merchant_order_id" => $plan_id,
                ],
                "theme"             => [
                    "color"             => "#286cd5"
                ],
                "order_id"          => $razorpayOrder['id'],
            ];
            $this->session->unset_userdata('razorpay_options');
            $this->session->set_userdata('razorpay_options',$data['razorpay_options']);
            $this->load->view('theme/'.$this->active_theme.'/razorpay_payment',$data);
        else:
            $this->session->set_flashdata('error', 'Please select a valid plan.');
            redirect(base_url('my-account/subscription') , 'refresh');
        endif;  
    } 

    function save_razorpay() {        

        $success = true;
        $error = "Payment Failed";
        if (empty($_POST['razorpay_payment_id']) === false):
            $api = new Api(ovoo_config('razorpay_key_id'), ovoo_config('razorpay_key_secret'));
            try
            {
                $attributes = array(
                    'razorpay_order_id'     => $this->session->userdata('razorpay_order_id'),
                    'razorpay_payment_id'   => $_POST['razorpay_payment_id'],
                    'razorpay_signature'    => $_POST['razorpay_signature']
                );
                $api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $this->session->set_flashdata('error', $e->getMessage());
            }
        endif;

        if ($success === true):
            $plan_id                            =   $this->session->userdata('plan_id');
            $plan_info                          =   $this->db->get_where('plan', array('plan_id'=>$plan_id))->first_row();
            $plan_price                         =   $plan_info->price;          
            $razorpay_inr_exchange_rate         =   $this->db->get_where('config' , array('title'=>'razorpay_inr_exchange_rate'))->row()->value;
            $transaction_amount                 =   ($plan_price*(int)$razorpay_inr_exchange_rate);

            $data['transaction_id']             =   $_POST['razorpay_payment_id'];
            $data['payment_info']               =   json_encode($this->session->userdata('razorpay_options'));
            $data['plan_id']                    =   $plan_id;
            $data['user_id']                    =   $this->session->userdata('user_id');
            $data['price_amount']               =   $transaction_amount;
            $data['paid_amount']                =   $transaction_amount;
            $data['currency']                   =   "INR";
            $data['payment_timestamp']          =   time();
            $data['timestamp_from']             =   time();
            $day                                =   $plan_info->day;
            $day                                =   '+'.$day.' days';
            $data['timestamp_to']               =   strtotime($day, $data['timestamp_from']);
            $data['payment_method']             =   'Razorpay';
            $data['status']                     =   1;
            $this->db->insert('subscription' , $data);
            $this->session->set_flashdata('success', 'Subscription purchase successfully!');
        else:
        endif;
        redirect(base_url('my-account/subscription') , 'refresh');      
    }
    
    function paypal($action = '')
    {
        if ($action == 'process')
        {
            $plan_id                            =   $this->input->post('plan_id');
            $supported_currencies               =   array("USD","AUD","BRL","GBP","CAD","CZK","DKK","EUR","HKD","HUF","ILS","JPY","MXN","TWD","NZD","NOK","PHP","PLN","RUB","SGD","SEK","CHF","THB");
            $currency_code                      =   $this->db->get_where('config',array('title'=>'currency'))->row()->value;
            $amount                             =   $this->db->get_where('plan', array('plan_id'=>$plan_id))->row()->price;
            $exchnage_rate                      =   $this->common_model->get_usd_exchange_rate($currency_code);

            if(!in_array($currency_code, $supported_currencies)):
               $currency_code                   = "USD";
               $amount                          = $amount / $exchnage_rate;
            endif;


            
            $user_id                            =   $this->session->userdata('user_id');
            $plan_name                          =   $this->db->get_where('plan', array('plan_id'=>$plan_id))->row()->name;            
            $custom                             =   'user_id='.$user_id.'&plan_id='.$plan_id;
            $paypal_email                       =   $this->db->get_where('config',array('title'=>'paypal_email'))->row()->value;


            //custom url
            $notify_url                         =   base_url('subscription/paypal/ipn');
            $cancel_url                         =   base_url('subscription/paypal/cancel');
            $success_url                        =   base_url('subscription/paypal/success');

            $this->paypal->add_field('business',        $paypal_email);
            $this->paypal->add_field('notify_url',      $notify_url);
            $this->paypal->add_field('cancel_return',   $cancel_url);
            $this->paypal->add_field('return',          $success_url);

            $this->paypal->add_field('rm',              2);
            $this->paypal->add_field('no_note',         0);
            $this->paypal->add_field('item_name',       $plan_name);
            $this->paypal->add_field('amount',          $amount);
            $this->paypal->add_field('currency_code',   $currency_code);
            $this->paypal->add_field('custom',          $custom);

            // process data 
            $this->paypal->submit_paypal_post();
            //var_dump($this->paypal);
        }
        
        else if ($action == 'ipn')
        {
            $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
            $txt = "John Doe\n";
            fwrite($myfile, $txt);
            $txt = "Jane Doe\n";
            fwrite($myfile, $txt);
            fclose($myfile);

            if ($this->paypal->validate_ipn() == true) 
            {
                $currency_code              =   $this->db->get_where('config',array('title'=>'currency'))->row()->value;
                $response                   = '';
                $transaction_id             = '';
                $payment_info               = array();
                $i                          = 0;
                foreach ($_POST as $key => $value) {
                    $value = urlencode(stripslashes($value));
                    $response .= "\n$key=$value";
                    if($key =="txn_id"):
                        $transaction_id = $value;
                    endif;
                    $payment_info[$i][$key] = $value;
                }
                $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
                $txt = "John Doe\n";
                fwrite($myfile, $txt);
                $txt = "Jane Doe\n";
                fwrite($myfile, $txt);
                fclose($myfile);

                $custom =   $_POST['custom'];
                parse_str($custom,$_MYVAR);
                $data['plan_id']            =   $_MYVAR['plan_id'];
                $data['user_id']            =   $_MYVAR['user_id'];

                $price                      = $this->db->get_where('plan', array('plan_id'=>$_MYVAR['plan_id']))->row()->price;
                
                $data['paid_amount']        =   $price;
                $data['price_amount']       =   $price;
                $data['currency']           =   $currency_code;
                $day                        =   $this->db->get_where('plan', array('plan_id'=>$_MYVAR['plan_id']))->row()->day;
                $day                        =   '+'.$day.' days';

                $data['payment_timestamp']  =   time();
                $data['timestamp_from']     =   time();
                $data['timestamp_to']       =   strtotime($day, $data['timestamp_from']);
                $data['payment_method']     =   'paypal';
                $data['payment_info']       =   json_encode($payment_info,JSON_FORCE_OBJECT);
                $data['transaction_id']     =   $transaction_id;
                $data['status']             =   1;                
                $this->db->insert('subscription' , $data);
            }
        }
        
        else if ($action == 'success')
        {
            $this->session->set_flashdata('success', 'Subscription purchase successfully!');
        }
        else if ($action == 'cancel')
        {
            $this->session->set_flashdata('error', 'Transaction cancelled!');
        }
        redirect(base_url('my-account/subscription') , 'refresh');      
    }

    public function save_payment(){
        $response = array();
        $response['status']         = "error";
        $response['message']        = "Something went wrong.Please contact with system admin";

        $plan_id                    = $_POST['plan_id'];      
        $payment_method             = $_POST['payment_method'];      
        $payment_info               = $_POST['payment_info'];

        if($this->session->userdata('user_id') !='' && $this->session->userdata('user_id') !=NULL):
            $response['status']         = "error";
            $response['message']        = "Plan ID not found.";
            if($this->db->get_where('plan', array('plan_id'=>$plan_id))->num_rows() > 0):
                $data['plan_id']                    =   $plan_id;
                $data['user_id']                    =   $this->session->userdata('user_id');
                $data['paid_amount']        =   $this->db->get_where('plan', array('plan_id'=>$plan_id))->row()->price;
                $data['payment_timestamp']          =   time();
                $data['timestamp_from']             =   time();
                $day                                =   $this->db->get_where('plan', array('plan_id'=>$plan_id))->row()->day;
                $day                                =   '+'.$day.' days';
                $data['timestamp_to']               =   strtotime($day, $data['timestamp_from']);
                $data['payment_method']             =   $payment_method;
                $data['payment_info']               =   $payment_info;
                $data['status']                     =   1;
                $this->db->insert('subscription' , $data);

                $response['status']         = "success";
                $response['message']        = "Payment Completed.";
                $this->session->set_flashdata('success', 'Payment Completed.');
            endif;             
        endif;
        echo json_encode($response);
    }

    // users
    function manage_coupon($param1 = '', $param2 = ''){
        if ($this->admin_is_login != 1 && $this->moderator_is_login != 1)
            redirect(base_url(), 'refresh');
            /* start menu active/inactive section*/
            $this->session->unset_userdata('active_menu');
            $this->session->set_userdata('active_menu', '303');
            /* end menu active/inactive section*/ 

            /* add new access */   
        
        if ($param1 == 'add') {
            demo_check();
            $data['title']           = $this->input->post('title');
            $data['description']     = $this->input->post('description');
            $data['coupon_code']     = strtoupper($this->input->post('coupon_code'));
            $data['date_from']       = date("Y-m-d",strtotime($this->input->post('date_from')));           
            $data['date_to']         = date("Y-m-d",strtotime($this->input->post('date_to')));           
            $data['type']            = $this->input->post('type');           
            $data['amount']          = $this->input->post('amount');           
            $data['status']          = $this->input->post('status');           
            
            $this->db->insert('coupon', $data);
            $this->session->set_flashdata('success', 'Coupon added successed');
            redirect(base_url() . 'subscription/manage_coupon/', 'refresh');
        }
        if ($param1 == 'update') {
            demo_check();
            $data['title']           = $this->input->post('title');
            $data['description']     = $this->input->post('description');
            $data['coupon_code']     = strtoupper($this->input->post('coupon_code'));
            $data['date_from']       = date("Y-m-d",strtotime($this->input->post('date_from')));           
            $data['date_to']         = date("Y-m-d",strtotime($this->input->post('date_to')));
            $data['type']            = $this->input->post('type');           
            $data['amount']          = $this->input->post('amount');           
            $data['status']          = $this->input->post('status');

            $this->db->where('coupon_id', $param2);
            $this->db->update('coupon', $data);
            $this->session->set_flashdata('success', 'Coupon update successed.');
            redirect(base_url() . 'subscription/manage_coupon/', 'refresh');
        }
        $data['page_name']      = 'coupon_manage';
        $data['page_title']     = 'Coupon Management';
        $data['coupons']    = $this->db->get('coupon')->result_array(); 
        $this->load->view('admin/index', $data);
    }


    public function coupon_details(){
        $response               = array();
        $response['status']     = "error";
        $response['message']    = "Coupon is not valid.";
        $coupon_code            = strtoupper($this->input->post("coupon_code"));
        $this->db->where('date_from <=',date("Y-m-d"));
        $this->db->where('date_to >=',date("Y-m-d"));
        $this->db->where('coupon_code',$coupon_code);
        $query                  = $this->db->get('coupon');
        if($query->num_rows() > 0):
            $response['status']     = "success";
            $response['message']    = "Coupon is valid";
            $response['data']       = $query->row();
        endif;
        echo json_encode($response);
    }
    
}
