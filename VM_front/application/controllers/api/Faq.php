<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('help/tb_faq_model','faq_model');

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
                'model' => 'api串接-取得faq列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{
            $faqList = $this->faq_model->get_faq_select(array(array('field' => 'faq.is_visible','value' => 1)),array(array('field'=>'faq.order','dir' => 'desc')),false,$langId);
            $response = array(
                'Stauts' => 'Success',
                'Messages' => $faqList
            );
            $data = array(
                'model' => 'api串接-取得faq列表',
                'log' => '取得成功',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        print_r(json_encode($response));
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