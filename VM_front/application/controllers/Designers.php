<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Designers extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('designer/tb_designer_model','tb_designer_model');        
    }

    public function index()
    {
        $top_designerList = $this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1)),array(array('field'=>'designer.order','dir' => 'desc')),array('start' => 0,'limit' => 4),$this->langId);      
        $designerList = $this->tb_designer_model->get_designer_select(array(array('field'=>'designer.is_visible','value' => 1)),array(array('field'=>'designer.order','dir' => 'desc')),array('start' => 5,'limit' =>'20'),$this->langId);
        $designer_story = random_element($this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1),array('field' => 'designer.is_designer_story','value' => 1))),false,false,$this->langId);
        $data = array(
            'top_designerList' => $top_designerList,
            'designerList' => $designerList,
            'designer_story' => $designer_story
        );

        $this->get_view('content/designers/index', $data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
