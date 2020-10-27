<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('help/tb_customer_model','customer_model');
    }

    public function index()
    {
        if($this->langFile == 'tw'){
            $this->pageMeta['title'][] = '客戶服務';
        }else{
            $this->pageMeta['title'][] = 'Customer Service';
        }
        $customer = $this->customer_model->get_customer_information($this->langId);
        $data = array(
            'customer' => $customer
        );
        $this->get_view('help/customer',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
