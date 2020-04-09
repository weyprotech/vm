<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events extends Ajax_Controller
{
    public function __construct()
    {        
        $this->load->model('events/tb_events_model', 'events_model');
    }

    /******************** event ********************/
    public function get_more()
    {
        header('Content-Type: application/json; charset=utf-8');
        $page = $this->input->get('page',true);
        $notin = $this->input->get('notin',true);
        $events = $this->tb_events_model->get_events_select(array(array('field' => 'events.is_visible','value' => 1),array('field' => 'events.category','value' => 0),'other' => array('value' => 'events.eventId NOT IN('.$notin.')')),array(array('field' => 'events.order','dir' => 'desc')),array('start' => 0,'limit' => 10),$this->langId);
        $data = array(
            'events' => $events
        );
        echo json_encode($data);
    }


    
    /******************** End event ********************/
}