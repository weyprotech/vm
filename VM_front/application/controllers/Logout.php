<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tb_member_model','member_model');
    }

    public function index()
    {
        $this->session->unset_userdata('memberinfo');
        redirect(website_url(''));        
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
