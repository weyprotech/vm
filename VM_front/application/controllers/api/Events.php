<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Events extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('events/tb_events_model','tb_events_model');
        $this->load->model('brand/tb_brand_model','tb_brand_model');
        $this->load->model('brand/tb_brand_banner_model','tb_brand_banner_model'); 
        $this->load->model('designer/tb_runway_model','tb_runway_model');
    }

    public function list()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得Events列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{
            $eventsList = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.is_visible','value' => 1)), array(array('field' => 'runway.update_at','dir' => 'desc')) ,array('start' => 0,'limit' => 5), $this->langId);            
            $eventsImgList = $this->tb_runway_model->get_runway_img_select(false,array(array('field' => 'runway_img.order','dir' => 'asc')),false);
            foreach($eventsList as $eventsValue){
                foreach($eventsImgList as $eventImgValue){
                    if($eventsValue->runwayId == $eventImgValue->runwayId){
                        $eventsValue->eventsImg = $eventImgValue->runwayImg;
                        break;
                    }
                }
            }
            // print_r($eventsList);exit;
            $response = array(
                'Status' => 'Success',
                'Messages' => $eventsList
            );
            $data = array(
                'model' => 'api串接-取得Events列表',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }

        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    // 取得客戶端IP
    private function get_public_ip(){
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   
        {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        }
        //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
        {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        //whether ip is from remote address
        else
        {
            $ip_address = $_SERVER['REMOTE_ADDR'];
        }

        return $ip_address;
    }
}