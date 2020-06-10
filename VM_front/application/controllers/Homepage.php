<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Homepage extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('designer/tb_designer_model','tb_designer_model');
        $this->load->model('designer/tb_runway_model','tb_runway_model');
        $this->load->model('homepage/tb_homepage_banner_model','tb_homepage_banner_model');
        $this->load->model('homepage/tb_inspiration_model','inspiration_model');
    }

    public function index()
    {
        $designerList = $this->tb_designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1)),array(array('field'=>'designer.order','dir' => 'desc')),array('start' => 0,'limit' => 14),$this->langId);
        $homepageBanner = $this->tb_homepage_banner_model->get_homepage_banner_select(array(array('field' => 'banner.is_visible','value' =>1)),array(array('field' => 'banner.order','dir' => 'desc')),false,$this->langId);
        $inspirationList = $this->inspiration_model->get_inspiration_select(array(array('field' => 'inspiration.is_visible','value' => 1)),array(array('field' => 'inspiration.order','dir' => 'desc')),array('start' => 0,'limit' =>15),$this->langId);
        
        $runwayList = false;
        foreach ($designerList as $designerKey => $designerValue){
            $temp = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.designerId', 'value' => $designerValue->designerId)), array(array('field' => 'runway.runwayId', 'dir' => 'RANDOM')), false, $this->langId);
            if(!empty($temp)){
                $runwayList[$designerKey] = $temp[0];
                $runwayList[$designerKey]->imgList = $this->tb_runway_model->get_runway_img_select(array(array('field' => 'runway_img.runwayId', 'value' => $temp[0]->runwayId)), array(array('field' => 'runway_img.runwayId', 'dir' => 'asc')));
            }
        }

        $data = array(
            'designerList' => $designerList,
            'homepageBanner' => $homepageBanner,
            'inspirationList' => $inspirationList,
            'runwayList' => $runwayList
        );

        $this->get_view('index', $data,$this->load->view('shared/script/_index_script','',true));
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
