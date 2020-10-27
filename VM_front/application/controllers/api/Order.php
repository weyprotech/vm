<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('order/tb_order_model', 'tb_order_model');
        $this->load->model('member/tb_member_model', 'tb_member_model');
    }
    
    public function list()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        $page = $this->input->get('page', true);
        $memberId = $this->input->get('memberId', true);

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得Order列表',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else{            
            $member = $this->tb_member_model->get_member_by_id($memberId, $langId);
            if($member)
            {
                if(empty($page))
                {
                    $page = 1;
                }
                $orderList = $this->tb_order_model->get_order_select(array(array('field' => 'order.memberId', 'value' => $memberId)),array(array('field' => 'order.create_at','dir' => 'desc')), false, $langId);
                // $orderList = $this->tb_order_model->get_order_select(array(array('field' => 'order.memberId', 'value' => $memberId)),array(array('field' => 'order.create_at','dir' => 'desc')), array('start' => ($page -1) * 10,'limit' =>10), $langId);                
                $response = array(
                    'Status' => 'Success',
                    'Messages' => $orderList
                );
                $data = array(
                    'model' => 'api串接-取得Order列表',
                    'log' => '取得成功',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }   
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This MemberId is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-取得Order列表',
                    'log' => '取得失敗，無此Member',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }                     
        }
        
        print_r(json_encode($response));
        $this->db->insert('tb_website_log', $data);  // 寫LOG
        return true;
    }

    public function detail()
    {
        $apiKey = $this->input->get("apiKey", true);
        $langId = $this->input->get("langId", true);
        $memberId = $this->input->get('memberId', true);
        $orderId = $this->input->get('orderId', true);

        if($apiKey != "vmapi"){
            $response = array(
                'Status' => 'Failed',
                'Messages' => 'Error ApiKey'
            );
            $data = array(
                'model' => 'api串接-取得Order Detail',
                'log' => '取得失敗，錯誤的ApiKey',
                'create_by' => $this->get_public_ip(),
                'create_at' => date('Y-m-d H:i:s')
            );
        }
        else
        {
            $member = $this->tb_member_model->get_member_by_id($memberId, $langId);
            if($member)
            {
                $order = $this->tb_order_model->get_order_by_id($orderId);
                if($order)
                {
                    $response = array(
                        'Status' => 'Success',
                        'Messages' => $order
                    );
                    $data = array(
                        'model' => 'api串接-取得Order Detail',
                        'log' => '取得成功',
                        'create_by' => $this->get_public_ip(),
                        'create_at' => date('Y-m-d H:i:s')
                    );
                }
                else
                {
                    $response = array(
                        'Status' => 'Failed',
                        'Messages' => 'This OrderId is not Exist.'
                    );
                    $data = array(
                        'model' => 'api串接-取得Order Detail',
                        'log' => '取得失敗，無此Order',
                        'create_by' => $this->get_public_ip(),
                        'create_at' => date('Y-m-d H:i:s')
                    );
                }               
            }
            else
            {
                $response = array(
                    'Status' => 'Failed',
                    'Messages' => 'This MemberId is not Exist.'
                );
                $data = array(
                    'model' => 'api串接-取得Order Detail',
                    'log' => '取得失敗，無此Member',
                    'create_by' => $this->get_public_ip(),
                    'create_at' => date('Y-m-d H:i:s')
                );
            }
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