<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Coupon extends Ajax_Controller
{
    public function __construct()
    {        
        parent::__construct();
        $this->load->model('coupon/tb_coupon_model','tb_coupon_model');
        $this->load->library('my_cart');
    }

    public function check_coupon(){
        $coupon = $this->input->post('coupon',true);
        if($couponList = $this->tb_coupon_model->get_coupon_select(array(array('field' => 'coupon.code','value' => $coupon)))){
            $this->my_cart->update_coupon(array('couponId' => $couponList[0]->couponId,'money' => $couponList[0]->coupon_money));
		    $all_total = $this->my_cart->all_total();
            echo json_encode(array('status' => "success",'all_total' => $all_total,'coupon' => round(($couponList[0]->coupon_money)* $this->session->userdata('currency'))));
        }else{
            echo json_encode(array('status' => "error"));
        }
    }
}