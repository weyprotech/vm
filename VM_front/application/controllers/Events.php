<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('events/tb_events_model','tb_events_model');
        $this->load->model('brand/tb_brand_model','tb_brand_model');
        $this->load->model('brand/tb_brand_banner_model','tb_brand_banner_model');   
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('designer/tb_designer_model','tb_designer_model');
        $this->load->model('designer/tb_post_model','tb_post_model');
        $this->load->model('product/tb_sale_model','tb_sale_model');
    }

    public function index()
    {    
        $top = $this->tb_events_model->get_events_select(array(array('field' => 'events.is_visible','value' => 1),array('field' => 'events.category','value' => 0)),array(array('field'=>'events.order','dir' => 'desc')),array('start' => 0,'limit' => 4),$this->langId);
        foreach ($top as $topKey => $topValue){
            if($topKey == 0){
                $notin = "'".$topValue->eventId."'";
            }else{
                $notin .= ",'".$topValue->eventId."'";
            }
        }
        $collections = $this->tb_events_model->get_events_select(array(array('field' => 'events.is_visible','value' => 1),array('field' => 'events.category','value' => 1),'other' => array('value' => 'events.eventId NOT IN('.$notin.')')),array(array('field' => 'events.order','dir' => 'desc')),false,$this->langId);
        $explore = $this->tb_events_model->get_events_select(array(array('field' => 'events.is_visible','value' => 1),array('field' => 'events.category','value' => 0),'other' => array('value' => 'events.eventId NOT IN('.$notin.')')),array(array('field' => 'events.order','dir' => 'desc')),array('start' => 0,'limit' => 10),$this->langId);
        
        $data = array(
            'top' => $top,
            'collections' => $collections,
            'explore' => $explore,
            'notin' => $notin
        );

        $this->get_view('events/index', $data);
    }

    public function detail(){
        $eventId = $this->input->get('eventId',true);
        $row = $this->tb_events_model->get_events_by_id($eventId,$this->langId);
        $eventList = $this->tb_events_model->get_events_select(array(array('field' => 'events.is_visible','value' => 1),array('field' => 'events.category','value' => 0),'other' => array('value' => "events.eventId != '".$eventId."'")),array(array('field' => 'events.order','dir' => 'RANDOM')),array('start' => 0,'limit' => 3),$this->langId);
        $data = array(
            'row' => $row,
            'eventList' => $eventList
        );
        $this->get_view('events/detail',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
