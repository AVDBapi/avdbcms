<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * OVOO-Live TV & Movie Portal CMS with Unlimited TV-Series
 * ---------------------- OVOO --------------------
 * ------- Live TV & Movie Portal CMS with Unlimited TV-Series --------
 * - Professional live tv and movie management system -
 *
 * @package     OVOO-Movie & Video Stremaing CMS Pro
 * @author      Abdul Mannan/SpaGreen Creative
 * @copyright   Copyright (c) 2014 - 2019 SpaGreen,
 * @license     http://codecanyon.net/wiki/support/legal-terms/licensing-terms/ 
 * @link        http://www.spagreen.net
 * @link        support@spagreen.net
 *
 **/
class Updater extends CI_Controller{

    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
    }

    //default index function, redirects to login/dashboard 
    public function index(){
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('admin_is_login') == 1)
            redirect(base_url() . 'admin/dashboard', 'refresh');
    }
    // updater function

    function process($action = '')
    {
        ini_set('max_execution_time', 300); //300 seconds 
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');

        // create directory if not exist.
        $update_dir = 'update';
        if (!is_dir($update_dir))
            mkdir($update_dir, 0777, true);

        $zip_file_name = $_FILES["zip_file"]["name"];
        $path = 'update/' . $zip_file_name;
        move_uploaded_file($_FILES["zip_file"]["tmp_name"], $path);

        // unzip file and remove uploded zip file.
        $zip = new ZipArchive;
        $contents = $zip->open($path);
        if ($contents === TRUE) {
            $zip->extractTo($update_dir);
            $zip->close();
            unlink($path);
        }

        $unzip_file_name = substr($zip_file_name, 0, -4);



        // update database
        //check for valid database connection
        $host           =     $this->db->hostname;
        $dbuser         =     $this->db->username;
        $dbpassword     =     $this->db->password;
        $dbname         =     $this->db->database;

        $mysqli = @new mysqli($host, $dbuser, $dbpassword, $dbname);

        if (mysqli_connect_errno()) {
            // echo json_encode(array("success" => false, "message" => $mysqli->connect_error));
            // exit();
        }else{
            $sql = file_get_contents('./update/' . $unzip_file_name . '/database.sql');

            $mysqli->multi_query($sql);
            do {
                
            } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));
            $mysqli->close();

            $configs =$this->db->get('temp_config')->result_array();
            //var_dump($configs);
            foreach($configs as $config):
                $data['title'] = trim($config['title']);
                $data['value'] = trim($config['value']);

                $this->db->where('title',trim($config['title']));
                $query = $this->db->get('config');
                if($query->num_rows() == 0):                                   
                    $this->db->insert('config',$data);
                    //var_dump($this->db->last_query());                    
                endif;
                if($query->num_rows() > 1):
                    $this->db->reset_query();
                    $this->db->where('title',$config['title']);
                    $this->db->delete('config');
                    $this->db->reset_query();
                    $this->db->insert('config',$data);
                    //var_dump($this->db->last_query());
                endif;
            endforeach;
            // delete temp table
            $this->load->dbforge();
            $this->dbforge->drop_table('temp_config',TRUE);
        }

        // get json_content        
        $str = file_get_contents('./update/' . $unzip_file_name . '/config.json');
        $converted_json = json_decode($str, true);

        // process php file
        require './update/' . $unzip_file_name . '/php_update.php';

        // Create directorie if not exist
        if (!empty($converted_json['directories'])) {
            foreach ($converted_json['directories'] as $dir) {
                if (!is_dir($dir['title']))
                    mkdir($dir['title'], 0777, true);
            }
        }
        // copy file if not exist or replace existing file
        if (!empty($converted_json['files'])) {
            foreach ($converted_json['files'] as $files):
                // copy/replace file
                copy($files['from_dir'], $files['to_dir']);
                unlink($files['from_dir']);
            endforeach;
        } 
        $this->deleteDir();      
        // redirect after ompleted
        $this->session->set_flashdata('success', "Update successfully completed.");
        redirect(base_url() . 'admin/update/', 'refresh');
    }

    public function deleteDir($dirPath =FCPATH.'update') {
        if ($this->session->userdata('admin_is_login') != 1)
            redirect(base_url(), 'refresh');

        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

}
