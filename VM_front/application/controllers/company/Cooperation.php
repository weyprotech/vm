<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cooperation extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('company/tb_company_model','company_model');
    }

    public function index()
    {
        $company = $this->company_model->get_company_information($this->langId);
        $data = array(
            'company' => $company
        );
        $this->get_view('company/cooperation',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
