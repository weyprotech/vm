<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Exchange extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('help/tb_exchange_model','exchange_model');
    }

    public function index()
    {
        if($this->langFile == 'tw'){
            $this->pageMeta['title'][] = '退款與換貨';
        }else{
            $this->pageMeta['title'][] = 'Refunds & Exchanges';
        }
        
        $exchange = $this->exchange_model->get_exchange_information($this->langId);
        $data = array(
            'exchange' => $exchange
        );
        $this->get_view('help/exchange',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
