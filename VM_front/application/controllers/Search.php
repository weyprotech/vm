<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Search extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('product/tb_category_model','tb_category_model');
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('events/tb_events_model','tb_events_model');
    }

    public function index()
    {
        $search = $this->input->get('search',true);    
        $type = $this->input->get('type',true);
        if($type == 'product'){
            $result = $this->tb_product_model->get_product_select(array(array('field' => 'product.is_visible','value' => 1),'like' => array('field' => 'lang.name','value' => $search)),array(array('field'=>'product.order','dir' => 'desc')),false,$this->langId);
            $count = $this->tb_product_model->count_product(array(array('field' => 'product.is_visible','value' => 1),'like' => array('field' => 'lang.name','value' => $search)),$this->langId);
            $data = array(
                'search' => $search,
                'result' => $result,
                'count' => $count
            );
    
            $this->get_view('search_products', $data);
        }elseif($type == 'events'){
            $result = $this->tb_events_model->get_events_select(array(array('field' => 'events.is_visible','value' => 1),array('field' => 'events.category','value' => 0),'like' => array('field' => 'lang.title','value' => $search)),array(array('field'=>'events.order','dir' => 'desc')),false,$this->langId);
            $count = $this->tb_events_model->count_events(array(array('field' => 'events.is_visible','value' => 1),array('field' => 'events.category','value' => 0),'like' => array('field' => 'lang.title','value' => $search)),$this->langId);
            $data = array(
                'search' => $search,
                'result' => $result,
                'count' => $count
            );
    
            $this->get_view('search_events', $data);
        }    
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
