<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Delivery extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('help/tb_delivery_model','delivery_model');
    }

    public function index()
    {
        $delivery = $this->delivery_model->get_delivery_information($this->langId);
        $data = array(
            'delivery' => $delivery
        );
        $this->get_view('help/delivery',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
