<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('help/tb_faq_model','faq_model');

    }

    public function index()
    {
        $faqList = $this->faq_model->get_faq_select(array(array('field' => 'faq.is_visible','value' => 1)),array(array('field'=>'faq.order','dir' => 'desc')),false,$this->langId);
        $data = array(
            'faqList' => $faqList
        );
        $this->get_view('help/faq',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}