<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Popular_designers extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('designer/tb_designer_model', 'designer_model');
        $this->load->model('designer/tb_runway_model','tb_runway_model');
    }

    /******************** popular ********************/
    public function get_popular_data()
    {
        header('Content-Type: application/json; charset=utf-8');
        $start = $this->input->get('start',true);
        $designerList = $this->designer_model->get_designer_select(array(array('field' => 'designer.is_visible','value' => 1)),array(array('field' => 'designer.click','dir' => 'desc')),array('start' => $start,'limit' =>10),$this->langId);
        foreach ($designerList as $designerKey => $designerValue){
            $designerList[$designerKey]->description = mb_substr(strip_tags(str_replace("<br>","", html_entity_decode($designerList[$designerKey]->description, ENT_QUOTES, "UTF-8"))),"0","200","UTF-8");
            if($designerList[$designerKey]->runway = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.designerId','value' => $designerValue->designerId),array('field' => 'runway.live','value' => 0)),false,false,$this->langId)){
                
                if($designerList[$designerKey]->runway[0]->imgList = $this->tb_runway_model->get_runway_img_select(array(array('field' => 'runway_img.runwayId','value' => $designerList[$designerKey]->runway[0]->runwayId)),array(array('field' => 'runway_img.order','dir' => 'desc')),false)){ 
                    $designerList[$designerKey]->first_img ='<a class="thumb '.(!empty($designerList[$designerKey]->runway[0]->imgList[0]->youtube) ? 'is_video' : '').' popup" href="'.website_url('designers/popup/event/'.$designerList[$designerKey]->runway[0]->runwayId).'">'.
                        '<div class="pic" style="background-image: url('.backend_url($designerList[$designerKey]->runway[0]->imgList[0]->runwayImg).');">'.
                            '<img class="size" src="'.base_url('assets/images/size_16x9.png').'">'.
                        '</div>'.
                    '</a>';
                }else{
                    $designerList[$designerKey]->first_img = '';
                }
            }else{
                $designerList[$designerKey]->first_img = '';
            }
        }
        $data = array(
            'designerList' => $designerList
        );
        echo json_encode($data);
    }


    
    /******************** End popular ********************/
}