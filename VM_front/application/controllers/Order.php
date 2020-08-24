<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Frontend_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tb_member_model','member_model');
        $this->load->model('product/tb_product_model','product_model');
        $this->load->model('shipping/tb_shipping_model','shipping_model');
        $this->load->model('order/tb_order_model','order_model');
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
        $all_total = $this->my_cart->all_total();
        $shipping = $this->my_cart->shipping();
        if(empty($shipping)){
            $shipping = array('shippingId' => "","money" => "");
        }
        $data = array(
            'cart_productList' => $cart_productList,
            'cart_amount' => $cart_amount,
            'cart_total' => $cart_total,
            'all_total' => $all_total,
            'shippingList' => $shippingList,
            'shippingId' => $shipping['shippingId'],
            'money' => $shipping['money']
        );
        $this->get_view('order/index',$data);        
    }

    public function order_information(){
        //購物車內容
        $cart_productList = $this->my_cart->get_product_list();
        foreach($cart_productList as $cartKey => $cartValue){
            $cart_productList[$cartKey]['sizeList'] = $this->product_model->get_product_size_select(array(array('field' => 'product_size.pId','value' => $cartValue['productId'])),false,false,$this->langId);
            $cart_productList[$cartKey]['colorList'] = $this->product_model->get_product_color_select(array(array('field' => 'product_color.pId','value' => $cartValue['productId'])),false,false,$this->langId);
        }
        if($post = $this->input->post(null,true)){
            if(!isset($this->session->userdata('memberinfo')['memberId'])){
                $memberId = uniqid();
                $this->member_model->insert_member(
                    array(
                        'is_enable' => 1,
                        'memberId' => $memberId,
                        'email' => $post['email'],
                        'password' => $post['password'],
                        'first_name' => $post['first_name'],
                        'last_name' => $post['last_name'],
                        'country' => $post['country'],
                        'address' => $post['address'],
                        'phone' => $post['phone_code'].'-'.$post['phone']
                    )
                );
                $member = $this->member_model->get_member_by_id($memberId);
                $this->session->set_userdata('memberinfo', array(
                    'memberId' => $memberId,
                    'memberEmail' => $member->email,
                    'memberPassword' => $member->password,
                    'memberImg' => $member->memberImg,
                    'memberFirst_name' => $member->first_name,
                    'memberLast_name' => $member->last_name                
                ));
            }
            $insert = array(
                'is_enable' => 1,
                'memberId' => $this->session->userdata('memberinfo')['memberId'],
                'date' => date('Y-m-d'),
                'total' => $this->my_cart->all_total(),
                'shipping' => $this->my_cart->shipping()['money'],
                'status' => 0,
                'notes' => $post['notes'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'country' => $post['country'],
                'state' => $post['state'],
                'address' => $post['address'],
                'phone' => $post['phone_code'].'-'.$post['phone'],
            );
            foreach($cart_productList as $cartKey => $cartValue){
                $insert['productList'][] = array(
                    'productId' => $cartValue['productId'],
                    'price' => $cartValue['productPrice'],
                    'size' => $cartValue['productSize'],
                    'color' => $cartValue['productColor'],
                    'qty' => $cartValue['productQty']
                );
            }
            $this->order_model->insert_order($insert);
            //重置購物車
            $this->my_cart->reset_cart();
            // redirect();
        }
        $cart_amount = $this->my_cart->amount();
        $cart_total = $this->my_cart->total();
        $all_total = $this->my_cart->all_total();
        $all_country = get_code_country();
        $data = array(
            'cart_productList' => $cart_productList,
            'cart_amount' => $cart_amount,
            'cart_total' => $cart_total,
            'all_total' => $all_total,
            'all_country' => $all_country
        );
        $this->get_view('order/information',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}