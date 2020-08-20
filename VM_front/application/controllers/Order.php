<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Frontend_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tb_member_model','member_model');
        $this->load->model('product/tb_product_model','product_model');
        $this->load->model('shipping/tb_shipping_model','shipping_model');
    }

    public function index(){
        //購物車內容
        $cart_productList = $this->my_cart->get_product_list();
        foreach($cart_productList as $cartKey => $cartValue){
            $cart_productList[$cartKey]['sizeList'] = $this->product_model->get_product_size_select(array(array('field' => 'product_size.pId','value' => $cartValue['productId'])),false,false,$this->langId);
            $cart_productList[$cartKey]['colorList'] = $this->product_model->get_product_color_select(array(array('field' => 'product_color.pId','value' => $cartValue['productId'])),false,false,$this->langId);
        }
        $shippingList = $this->shipping_model->get_shipping_select(false,array(array('field' => 'shipping.order','dir' => 'asc')),false,$this->langId);
        $cart_amount = $this->my_cart->amount();
        $cart_total = $this->my_cart->total();
        $data = array(
            'cart_productList' => $cart_productList,
            'cart_amount' => $cart_amount,
            'cart_total' => $cart_total,
            'shippingList' => $shippingList
        );
        $this->get_view('order/index',$data);        
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}