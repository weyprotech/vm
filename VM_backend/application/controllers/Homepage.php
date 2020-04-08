<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = array(
        );

        $this->get_view('index', $data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
