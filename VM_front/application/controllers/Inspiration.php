<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inspiration extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('homepage/tb_inspiration_model','tb_inspiration_model');
    }

    public function index()
    {
        $inspirationList = $this->tb_inspiration_model->get_inspiration_select(array(array('field' => 'inspiration.is_visible','value' => 1)),array(array('field'=>'inspiration.order','dir' => 'desc')),array('start' => 0,'limit' => 15),$this->langId);
        
        $data = array(
            'inspirationList' => $inspirationList
        );

        $this->get_view('inspiration/index', $data);
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
