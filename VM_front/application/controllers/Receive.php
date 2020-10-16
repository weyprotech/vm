<?php

class Receive extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tb_member_model','member_model');
        $this->load->model('tb_deposit_model','deposit_model');
        $this->load->model('product/tb_product_model','product_model');
        $this->load->model('order/tb_order_model','order_model');
        $this->load->model('order/tb_business_model','business_model');
        $this->load->library('my_pay_ezpay');
        $this->load->library('my_pay_newebpay');        
        $this->load->library('my_api');
    }

    public function index()
    {
        $post = $this->input->post(null,true);
        $this->db->insert('tb_return_status',array('text' => json_encode($post)));
        $response_data = json_decode(@$this->my_pay_newebpay->receive($post),true);
        $receive_result   = $response_data["Result"];
        $this->db->insert('tb_return_status',array('text' => json_encode($response_data)));
        $deposit = $this->deposit_model->get_deposit_select(array(array('field' => 'deposit.depositNumber','value' => $receive_result['MerchantOrderNo'])));            
        $member = $this->member_model->get_member_by_id($deposit[0]->memberId);
        $deposit_money = $receive_result['Amt'];
        $deposit_option = $this->deposit_model->get_deposit_option_select(array(array('field' => 'deposit_option.deposit_money','value' => $deposit_money)));
        $rate = (($deposit_money)*$deposit_option[0]->rebate)/100;
        $money = $member->money+$deposit_money+$rate;
        if($post['Status'] == 'SUCCESS'){
            $this->db->insert('tb_return_status',array('text' => 'ezpay更新:會員-'.$member->account.'  原本金額:'.$member->money.'  金額:'.$money.'  藍新回傳金額:'.$receive_result['Amt'].' 回饋金額:'.$rate.' 儲值類別:'.$receive_result['PaymentType']));            
            $this->deposit_model->update_deposit($deposit[0],array('status' => 2));  //更新狀態為已付款
            $this->member_model->update_member($member,array('money' => $money));    
            //固定時間點
            $deposit_time = $this->deposit_model->get_set_deposit_time(1);
            $time = $deposit_time->days.' days';
            //寫入log
            $data = array(
                'model' => '時間',
                'log' => json_encode(strtotime("+$time",date('Y-m-d'))),
                'create_by' => "系統",
                'create_at' => date('Y-m-d H:i:s')
            );                            
            $this->db->insert('tb_website_log', $data);
            //如果這個會員不是廠商或經銷商自動升級
            if(($member->levelId != 1) && ($member->levelId != 17)){
                if($member->level_money < $deposit_option[0]->level_money){
                    $member->levelId = $deposit_option[0]->levelId;
                    $last_date = date_create($member->next_date);
                    $next_date = date_add($last_date,date_interval_create_from_date_string($time));
                    $this->member_model->update_member($member,array('levelId' => $member->levelId,'next_date' => $next_date->format('Y-m-d')));
                }
            }
            
            $member = $this->member_model->get_member_by_id($deposit[0]->memberId);

            //如果直接儲值的話
            if(!empty($deposit[0]->order_number)){
                //讀取訂單編號
                $orderArray=array();
                $all_order = explode('###',$deposit[0]->order_number);

                //寫入log
                $data = array(
                    'model' => '儲值後讀取訂單',
                    'log' => json_encode($all_order),
                    'create_by' => "系統",
                    'create_at' => date('Y-m-d H:i:s')
                );                            
                $this->db->insert('tb_website_log', $data);

                $order_count = count($all_order);
                foreach($all_order as $all_order_key => $all_order_value){
                    $orderList = $this->order_model->get_order_select(array(array('field' => 'order.orderNumber','value' => $all_order_value),array('field' => 'order.memberId','value' => $member->memberId),array('field' => 'order.status','value' => 3)));
                    // $orderArray[] = $orderList[0];
                }
            }

            if(!empty($orderArray)){
                $member = $this->member_model->get_member_by_id($deposit[0]->memberId);
                if($member->money >= ($orderArray[0]->total)*$order_count){
                    $money = $member->money-($orderArray[0]->total)*$order_count;
                    $this->member_model->update_member($member,array('money' => $money));
                    foreach($orderArray as $orderKey => $orderValue){                                   
                        $this->order_model->update_order($orderValue,array('status' => 0));
                        $product = $this->product_model->get_product_by_id($orderValue->productId);
                        $product_api = json_decode(json_encode($product),true);
                        
                        //執行api
                        $api_parameter_List = $this->product_model->get_product_api_select(array(array('field' => 'product_api.productId','value' => $product->productId)));
                        
                        //寫入log
                        $data = array(
                            'model' => '儲值後執行',
                            'log' => '會員'.$member->account.'   執行'.$orderValue->orderNumber.'訂單  剩餘:'.$money,
                            'create_by' => "系統",
                            'create_at' => date('Y-m-d H:i:s')
                        );                            
                        $this->db->insert('tb_website_log', $data);

                        //寫入交易記錄
                        $businessId = $this->business_model->insert_business(
                            array(
                                'is_enable' => 1,
                                'orderId' => $orderValue->Id,
                                'orderNumber' => $orderValue->orderNumber,
                                'memberId' => $orderValue->memberId,
                                'date' => date('Y-m-d'),
                                'money' => $orderValue->total
                            )
                        );

                        $apiList = array();
                        $apiList['api_url'] = $product_api['api_url'];
                        $apiList['api_key'] = $product_api['api_key'];
                        if($api_parameter_List){
                            foreach($api_parameter_List as $key => $value){
                                $apiList['api_paramer'][$key] = json_decode(json_encode($value),true);
                            }
                        }

                        $order = json_decode(json_encode($orderValue),true);
                        // $api_order=$this->my_api->order(array('service' => 1, 'link' => 'http://example.com/test', 'quantity' => 100));
                        
                        $this->my_api->set_api_parameter($apiList);
                        $this->my_api->set_order($order);
                        $services = $this->my_api->services();
                        $result = $this->my_api->excute();
                        
                        if(isset($result->order)){
                            //更新帳單api的id
                            $this->order_model->update_order($orderList[0],array('api_id' => $result->order));
                        }
                    }
                }
            }    
        }            
    }

    private function process_verify_response_data($response_data){
        $receive_data   = $response_data["result"];
        $receive_result = $receive_data['rp_result'];
        $receive_result['Amt'] = (int)$receive_result['Amt'];

        $order_id   = $receive_result['MerchantOrderNo'];
        $deposit = $this->deposit_model->get_deposit_select(array(array('field' => 'deposit.depositNumber','value' => $order_id)));
        
        $Amt                = (int)$deposit[0]->money;
        $MerchantOrderNo    = $deposit[0]->depositNumber;
        
        $merchant_data = Array(
            'Amt'               => $Amt,
            'MerchantOrderNo'   => $MerchantOrderNo
        );
        
        $return_array = $this->my_pay_newebpay->verify_response_data($receive_result, $merchant_data);
        
        if($return_array["status"] !== "SUCCESS"){
            //寫入log
            $data = array(
                'model' => '驗證雙方回傳交易資料失敗',
                'log' => json_encode($return_array),
                'create_by' => "系統",
                'create_at' => date('Y-m-d H:i:s')
            );                            
            $this->db->insert('tb_website_log', $data);
            return true;
        }else{
            //寫入log
            $data = array(
                'model' => '驗證雙方回傳交易資料成功',
                'log' => json_encode($return_array),
                'create_by' => "系統",
                'create_at' => date('Y-m-d H:i:s')
            );                            
            $this->db->insert('tb_website_log', $data);
            return false;
        }
    }
}