<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Popular_designers extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('designer/tb_designer_model','tb_designer_model');
        $this->load->model('designer/tb_designer_banner_model','tb_designer_banner_model');
        $this->load->model('designer/tb_runway_model','tb_runway_model');        
        $this->load->model('designer/tb_post_model','tb_post_model');
        $this->load->model('brand/tb_brand_model','tb_brand_model');
    }

    public function index()
    {        
        $designerList = $this->tb_designer_model->get_designer_select(array(array('field'=>'designer.is_visible','value' => 1)),array(array('field'=>'designer.click','dir' => 'desc')),array('start' => 0,'limit' =>'7'),$this->langId);       
        if($designerList){
            foreach($designerList as $designerKey => $designerValue){
                if($designerList[$designerKey]->runway = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.designerId','value' => $designerValue->designerId),array('field' => 'runway.live','value' => 0)),false,false,$this->langId)){
                    $designerList[$designerKey]->runway[0]->imgList = $this->tb_runway_model->get_runway_img_select(array(array('field' => 'runway_img.runwayId','value' => $designerList[$designerKey]->runway[0]->runwayId)),array(array('field' => 'runway_img.order','dir' => 'desc')),false);
                }else{
                    @$designerList[$designerKey]->runway[0]->imgList = array();                    
                }
            }    
        }
        $data = array(            
            'designerList' => $designerList
        );

        $this->get_view('popular_designers', $data,$this->load->view('shared/script/_popular_designers_script','',true));
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
