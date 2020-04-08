<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (is_logged_in()) {
            redirect("backend/admin");
        }
    }

    public function index()
    {
        $this->login();
    }

    /******************** Private Function ********************/
    private function login()
    {
        $this->load->view('backend/login');
    }
}