<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tb_designer_model','designer_model');
    }

    public function index()
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        // $designerId = $this->input->get('designerId',true);
        if($designerList = $this->designer_model->get_designer_select(array(array('field' => 'designer.url','value' => $url)),false,false,3)){  
            // print_r($designerList);exit;          
            $title = $designerList[0]->personal_title;
            $content = $designerList[0]->personal_content;
            $img = $designerList[0]->personalImg;
            $country = $designerList[0]->country;
            $name = $designerList[0]->name;
            $data = array(
                'title' => $title,
                'content' => $content,
                'img' => $img,
                'designer' => $designerList[0],
                'country' => $country,
                'name' => $name
            );
            $this->get_view('index', $data,'',$title.' - '.$name);
        }else{
            $this->load->view('errors/index.php',array());
        }    
    }

    private function get_view($page, $data = array(), $script = "",$title)
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script,$title));
    }
}
