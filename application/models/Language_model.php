<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set(ovoo_config('timezone'));
    }

    public function input_values()
    {
        $data = array(
            'name' => $this->input->post('name', true),
            'short_form' => $this->input->post('short_form', true),
            'language_code' => $this->input->post('language_code', true),
            'language_order' => $this->input->post('language_order', true),
            'text_direction' => $this->input->post('text_direction', true),
            'status' => $this->input->post('status', true),
        );
        return $data;
    }

    //add language
    public function add_language()
    {
        ini_set("upload_max_filesize","512M");
        ini_set("post_max_size","256M");
        ini_set("max_execution_time","300");
        ini_set("max_input_time","300");
        ini_set("memory_limit","1024M");
        $data = $this->input_values();

        $folder_name = str_slug($data["name"]);

        if (empty($folder_name)) {
            $folder_name = "lang_" . uniqid();
        }

        $data["folder_name"] = $folder_name;

        if ($this->create_language_folder($folder_name)) {
            return $this->db->insert('language_list', $data);
        } else {
            return false;
        }
    }

    //get language
    public function get_language($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('language_list');
        return $query->row();
    }

    //get language by short
    public function get_language_by_short($short)
    {
        $this->db->where('short_form', $short);
        $query = $this->db->get('languages');
        return $query->row();
    }

    //get languages
    public function get_languages()
    {
        $this->db->order_by('language_list.language_order');
        $query = $this->db->get('language_list');
        return $query->result();
    }

    //get active languages
    public function get_active_languages()
    {
        $this->db->where('status', 1);
        $this->db->order_by('languages.language_order');
        $query = $this->db->get('languages');
        return $query->result();
    }

    //update language
    public function update_language($id)
    {
        $data = $this->input_values();

        $this->db->where('id', $id);
        return $this->db->update('language_list', $data);
    }

    //delete language
    public function delete_language($id)
    {
        $language = $this->get_language($id);

        if (!empty($language)):
            $this->remove_language_folder($language->folder_name);
            $this->db->where('id', $id);
            return $this->db->delete('language_list');
        else:
            return false;
        endif;
    }

    //create language folder
    public function create_language_folder($lang_name)
    {
        ini_set("upload_max_filesize","512M");
        ini_set("post_max_size","256M");
        ini_set("max_execution_time","300");
        ini_set("max_input_time","300");
        ini_set("memory_limit","1024M");
        $root = FCPATH . "application/language/" . $lang_name;
        $default = FCPATH . "application/language/english";

        if (!file_exists($root) && is_writable("application/language")) {
            mkdir($root, 0777, true);
            copy($default . '/db_lang.php', $root . '/db_lang.php');
            copy($default . '/pagination_lang.php', $root . '/pagination_lang.php');
            copy($default . '/site_lang.php', $root . '/site_lang.php');
            copy($default . '/rest_controller_lang.php', $root . '/rest_controller_lang.php');
            copy($default . '/form_validation_lang.php', $root . '/form_validation_lang.php');
            copy($default . '/email_lang.php', $root . '/email_lang.php');
            copy($default . '/upload_lang.php', $root . '/upload_lang.php');
            copy($default . '/index.html', $root . '/index.html');
            return true;
        } else {
            return false;
        }
    }

    //remove language folder
    public function remove_language_folder($lang_name)
    {
        $root = FCPATH . "application/language/" . $lang_name;

        //delete files
        $files = glob($root . '/*');
        if (!empty($files)) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file); //delete file
                }
            }
        }

        //delete folder
        if (is_dir($root)) {
            rmdir($root);
        }
    }

    //get phrases
    public function get_phrases($lang_name)
    {
        $lang = array();
        $phrases = array();
        include 'application/language/' . $lang_name . '/site_lang.php';

        foreach ($lang as $key => $value) {
            $phrases[] = array(
                'phrase' => $key,
                'label' => $value
            );
        }

        return $phrases;
    }

    //create language file
    public function create_language_file($lang_name, $phrases, $labels)
    {
        $start = '<?php defined("BASEPATH") OR exit("No direct script access allowed");' . PHP_EOL . PHP_EOL;
        $keys = '';
        $end = '?>';

        $i = 0;
        foreach ($phrases["phrase"] as $item) {
            if (!empty($item) && !empty($labels["label"][$i])) {
                //escape
                if (strpos($labels["label"][$i], '"') !== false) {
                    $labels["label"][$i] = str_replace('"', '&quot;', $labels["label"][$i]);
                }
                $keys .= '$lang["' . $item . '"] = "' . $labels["label"][$i] . '";' . PHP_EOL;
            }

            $i++;
        }

        $content = $start . $keys . $end;

        file_put_contents(FCPATH . "application/language/" . $lang_name . "/site_lang.php", $content);
    }

    //create phrases file
    public function create_phrase($lang_name, $phrases)
    {
        $file = FCPATH . "application/language/" . $lang_name . "/site_lang.php";
        file_put_contents($file,str_replace('?>','',file_get_contents($file)));
        if($phrases !="404"):
            $phrases_to_word = ucfirst(str_replace("_", " ", $phrases));
            $content = '';
            $content .= '$lang["' . $phrases . '"] = "' . $phrases_to_word . '";' . PHP_EOL;

            file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
        endif;
    }

    //update language file
    public function update_language_file($lang_name, $phrases, $labels)
    {
        //var_dump($lang_name,$phrases,$labels);
        $start = '<?php defined("BASEPATH") OR exit("No direct script access allowed");' . PHP_EOL . PHP_EOL;
        $keys = '';
        $end = '';

        $old_phrases = $this->get_phrases($lang_name);

        foreach ($old_phrases as $old_item) {

            $i = 0;

            foreach ($phrases["phrase"] as $item) {

                if (!empty($item) && !empty($labels["label"][$i])) {

                    if ($old_item["phrase"] == $item) {
                        //echo $labels["label"][$i];
                        $old_item["label"] = $labels["label"][$i];
                    }

                    //escape
                    if (strpos($labels["label"][$i], '"') !== false) {
                        $labels["label"][$i] = str_replace('"', '&quot;', $labels["label"][$i]);
                    }

                }

                $i++;
            }

            $keys .= '$lang["' . $old_item["phrase"] . '"] = "' . $old_item["label"] . '";' . PHP_EOL;
            // if (($i % 50) == 0):
            //     sleep(1);
            // endif;

        }

        $content = $start . $keys . $end;

        if(is_writable(FCPATH . "application/language/" . $lang_name . "/site_lang.php")):
            file_put_contents(FCPATH . "application/language/" . $lang_name . "/site_lang.php", $content);
            return true;
        else:
            return false;
        endif;
    }

    public function get_active_language(){
        $active_language_id         = $this->session->userdata('active_language_id');
        if($active_language_id =='' || !$this->language_id_exist($active_language_id))
            $active_language_id     = $this->common_model->get_config('active_language_id');
        $active_language            = $this->language_by_id($active_language_id);
        return $active_language;
    }

    public function get_active_language_id(){
        $active_language_id         = $this->session->userdata('active_language_id');
        if($active_language_id =='' || !$this->language_id_exist($active_language_id))
            $active_language_id     = $this->common_model->get_config('active_language_id');
        return $active_language_id;
    }


    public function language_id_by_short_form($short_form=''){
        $language           = "en";
        $this->db->limit(1);
        $query              = $this->db->get_where('language_list' , array('short_form'=>$short_form));
        if($query->num_rows()  > 0):
            $language       = $query->row()->id;
        endif;
        return $language;
    }

    public function language_short_form_exist($short_form=''){
        $result             = false;
        $query              = $this->db->get_where('language_list',array('short_form'=>$short_form));
        if($query->num_rows() > 0)
            $result         = true;
        return $result;
    }

    public function language_id_exist($id=''){
        $result             = false;
        $query              = $this->db->get_where('language_list',array('id'=>$id));
        if($query->num_rows() > 0)
            $result         = true;
        return $result;
    }

    public function language_by_id($id=''){
        $language           = "English";
        $this->db->limit(1);
        $query              = $this->db->get_where('language_list' , array('id'=>$id));
        if($query->num_rows()  > 0):
            $language       = $query->row()->folder_name;
        endif;
        return $language;
    }

    public function get_short_form_by_id($id=''){
        $language           = "En";
        $this->db->limit(1);
        $query              = $this->db->get_where('language_list' , array('id'=>$id));
        if($query->num_rows()  > 0):
            $language       = $query->row()->short_form;
        endif;
        return $language;
    }


    public function get_rtl_status(){
        $result             = false;
        $query              = $this->db->get_where('language_list',array('id'=>$this->get_active_language_id()));
        if($query->num_rows() > 0):
            if($query->row()->text_direction == 'rtl'):
                $result = true;
            endif;
        endif;
        return $result;
    }
}