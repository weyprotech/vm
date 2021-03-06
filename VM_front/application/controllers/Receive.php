<?php

class Receive extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tb_member_model','member_model');
        $this->load->model('product/tb_product_model','product_model');
        $this->load->model('order/tb_order_model','order_model');
        $this->load->library('my_pay_ecpay');        
    }

    public function index()
    {
        $post = $this->input->post(null,true);
        $this->db->insert('tb_return_status',array('text' => json_encode($post)));
        $response_data = $this->my_pay_ecpay->receive();
        if($response_data != 'CheckMacValue verify fail.'){
            $this->db->insert('tb_return_status',array('text' => json_encode($response_data)));
            $order = $this->order_model->get_order_by_id($post['MerchantTradeNo']);

            if($response_data['RtnCode'] == 1){
                $update_data = array(
                    'status' => 1,
                    'rtn_code' => $response_data['RtnCode'],
                    'rtn_msg' => $response_data['RtnMsg'],
                    'trade_no' => $response_data['TradeNo'],
                    'payment_type' => $response_data['PaymentType'],
                    'trade_amount' => $response_data['TradeAmt'],
                    'payment_type_charge_fee' => $response_data['PaymentTypeChargeFee'],
                    'payment_date' => $response_data['PaymentDate']
                );
                $this->order_model->update_order($order,$update_data);
               
                //寫入log
                $data = array(
                    'model' => '綠界回傳-單號'.$post['MerchantTradeNo'],
                    'log' => json_encode($response_data),
                    'create_by' => "系統",
                    'create_at' => date('Y-m-d H:i:s')
                );                            
                $this->db->insert('tb_website_log', $data);
                $this->db->insert('tb_return_status',array('text' => 'OK'));
            }
            echo "1|OK";
        }            
    }
}