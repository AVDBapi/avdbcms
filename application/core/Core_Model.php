<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Core_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // timezone
        date_default_timezone_set(ovoo_config('timezone'));
    }
}

class Admin_Core_Model extends Core_Model
{
    public function __construct()
    {
        parent::__construct();
    }
}