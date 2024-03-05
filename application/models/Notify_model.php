<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * OXOO - Android Live TV & Movie Portal App
 * ---------------------- OXOO --------------------
 * ------- Android Live TV & Movie Portal App --------
 * - Live tv channel & movie management system -
 *
 * @package     OXOO - Android Live TV & Movie Portal App
 * @author      Abdul Mannan/Spa Green Creative
 * @copyright   Copyright (c) 2014 - 2019 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/

class Notify_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

    function send_push_notification($video_id = NULL)
    {   
        $site_name          =   $this->db->get_where('config' , array('title' => 'site_name'))->row()->value;
        $video              =   $this->db->get_where('videos', array('videos_id' => $video_id))->row();
        $logo               =   base_url('uploads/system_logo/logo.png');
        $thumb_image        =   $this->common_model->get_video_poster_url($video->videos_id);;
        $watch_url          =   base_url().'watch/'.$video->slug.'.html';       
        $headings           =   "New Movie Available-".$video->title;
        $message            =   "Watch ".$video->title." on ".$site_name;
        $data['message']    =   $message;
        $data['url']        =   $watch_url;
        $data['headings']   =   $headings;
        $data['icon']       =   $logo;        
        $data['img']        =   $thumb_image;

        $data['id']         =   $video->videos_id;
        $data['vtype']      =   'movie';
        if($video->is_tvseries =='1')
            $data['vtype']  =   'tvseries';
        $data['open_with']  =   'app';
        $this->send_notification($data);

        return TRUE;
    }

	function send_web_notification($data = array())
	{
        $data['message']            =   $data['message'];
        $data['url']                =   $data['url'];
        $data['headings']           =   $data['headings'];
        $data['icon']               =   $data['icon'];         
        $data['img']                =   $data['img'];
        $data['id']                 =   '';
        $data['vtype']              =   '';
        $data['open_with']          =   'web';
        $this->load->model('notify_model');
        $this->notify_model->send_notification($data);
        return TRUE;
	}
    function send_movie_tvseries_notification($udata = array())
    {   
        $video              =   $this->db->get_where('videos', array('videos_id' => $udata['id']))->row();
        $watch_url          =   base_url().'watch/'.$video->slug.'.html';

        $data['message']    =   $udata['message'];
        $data['url']        =   $watch_url;
        $data['headings']   =   $udata['headings'];
        $data['icon']       =   $udata['icon'];        
        $data['img']        =   $udata['img'];
        $data['id']         =   $udata['id'];
        $data['vtype']      =   'movie';
        if($video->is_tvseries =='1')
            $data['vtype']  =   'tvseries';
        $data['open_with']  =   'app';
        $this->send_notification($data);        
        return TRUE;
    }


    function send_live_tv_notification($udata = array())
    {   
        $live_tv            =   $this->db->get_where('live_tv', array('live_tv_id' => $udata['id']))->row();
        $watch_url          =   base_url().'live-tv/'.$live_tv->slug.'.html';

        $data['message']    =   $udata['message'];
        $data['url']        =   $watch_url;
        $data['headings']   =   $udata['headings'];
        $data['icon']       =   $udata['icon'];        
        $data['img']        =   $udata['img'];
        $data['id']         =   $udata['id'];
        $data['vtype']      =   'tv';
        $data['open_with']  =   'app';
        $this->send_notification($data);        
        return TRUE;
    }

    function send_movie_notification($video_id = NULL)
    {   
        $site_name          =   $this->db->get_where('config' , array('title' => 'site_name'))->row()->value;
        $video              =   $this->db->get_where('videos', array('videos_id' => $video_id))->row();
        $logo               =   base_url('uploads/system_logo/logo.png');
        $thumb_image        =   $this->common_model->get_video_thumb_url($video->videos_id);;
        $watch_url          =   base_url().'watch/'.$video->slug.'.html';       
        $headings           =   "New Movie Release-".$video->title;
        $message            =   "Watch ".$video->title." on ".$site_name;
        $data['message']    =   $message;
        $data['url']        =   $watch_url;
        $data['headings']   =   $headings;
        $data['icon']       =   $logo;        
        $data['img']        =   $thumb_image;
        $data['id']         =   $video->videos_id;
        $data['vtype']      =   'movie';
        if($video->is_tvseries =='1')
            $data['vtype']  =   'tvseries';
        $data['open_with']  =   'app';
        $this->send_notification($data);        
        return TRUE;
    }

    function send_custom_movie_notification($user_data = array())
    {
        $site_name          =   $this->db->get_where('config' , array('title' => 'site_name'))->row()->value;
        $video              =   $this->db->get_where('videos', array('videos_id' => $user_data['videos_id']))->row();
        $logo               =   base_url('uploads/system_logo/logo.png');
        $thumb_image        =   $this->common_model->get_video_thumb_url($video->videos_id);;
        $watch_url          =   base_url().'watch/'.$video->slug.'.html';       
        $headings           =   "New Movie Release-".$video->title;
        $message            =   "Watch ".$video->title." on ".$site_name;
        $data['message']    =   $message;
        if($user_data['message'] !='' && $user_data['message'] !=null):
            $data['message']    =   $user_data['message'];
        endif;
        $data['url']        =   $watch_url;
        $data['headings']   =   $headings;
        if($user_data['headings'] !='' && $user_data['headings'] !=null):
            $data['headings']    =   $user_data['headings'];
        endif;
        $data['icon']       =   $logo;        
        $data['img']        =   $thumb_image;
        $data['id']         =   $video->videos_id;
        $data['vtype']      =   'movie';
        if($video->is_tvseries =='1')
            $data['vtype']  =   'tvseries';
        $data['open_with']  =   'app';
        $this->send_notification($data);        
        return TRUE;
    }

	function send_notification($data = array()){
		$onesignal_appid    = $this->db->get_where('config' , array('title' =>'onesignal_appid'))->row()->value;
        $onesignal_api_keys = $this->db->get_where('config' , array('title' =>'onesignal_api_keys'))->row()->value; 
        $content = array(
            "en" => $data['message']
        );
        $headings = array(
            "en" => $data['headings']
        );
        $fields = array(
            'app_id'                => $onesignal_appid,
            'included_segments'     => array('All'),
            'url'                   => $data['url'],
            'contents'              => $content,
            'chrome_web_icon'       => $data['icon'],
            'chrome_web_image'      => $data['img'],
            'big_picture'           => $data['img'], // for android
            'small_icon'            => $data['icon'], // for android
            'large_icon'            => $data['icon'], // for android
            'headings'              => $headings,
            // vtype: for movie=movie, for tvseries= tvseries, for live tv=tv
            // open_with: for webview=web, for app=app
            'data'     => array('id'=>$data['id'],'vtype'=>$data['vtype'],'open'=>$data['open_with'],'url'=>$data['url'])
        );

        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$onesignal_api_keys));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
	}
}

