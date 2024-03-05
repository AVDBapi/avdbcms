<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Core_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // timezone
        date_default_timezone_set(ovoo_config('timezone'));
    }
}

class Admin_Core_Controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
}

class Home_Core_Controller extends Core_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->active_theme  =   active_theme();
    }
}