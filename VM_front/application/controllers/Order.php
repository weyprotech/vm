<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Frontend_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tb_member_model','member_model');
        $this->load->model('product/tb_product_model','product_model');
        $this->load->model('shipping/tb_shipping_model','shipping_model');
        $this->load->model('order/tb_order_model','order_model');
        $this->load->model('member/tb_dividend_model','dividend_model');
        $this->load->model('coupon/tb_coupon_model','coupon_model');
        $this->load->model('money/tb_money_model','money_model');
        $this->load->library('My_pay_ecpay');
    }

    public function index(){

        //購物車內容
        $this->my_cart->_calc_cart();
        $cart_productList = $this->my_cart->get_product_list();
        foreach($cart_productList as $cartKey => $cartValue){
            $cart_productList[$cartKey]['sizeList'] = $this->product_model->get_product_size_select(array(array('field' => 'product_size.pId','value' => $cartValue['productId'])),false,false,$this->langId);
            $cart_productList[$cartKey]['colorList'] = $this->product_model->get_product_color_select(array(array('field' => 'product_color.pId','value' => $cartValue['productId'])),false,false,$this->langId);
        }
        $shippingList = $this->shipping_model->get_shipping_select(false,array(array('field' => 'shipping.order','dir' => 'asc')),false,$this->langId);
        $this->my_cart->update_shipping();
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
        
        if(isset($this->session->userdata('memberinfo')['memberId'])){
            $member = $this->member_model->get_member_by_id($this->session->userdata('memberinfo')['memberId']);
        }else{
            js_warn("請登入會員，謝謝!");
            redirect(website_url('login'));
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
                'currency' => $this->my_cart->currency(),
                'total' => $this->my_cart->all_total(),
                'dividend' => $this->my_cart->dividend(),
                'couponId' => $this->my_cart->coupon()['couponId'],
                'shipping' => $this->my_cart->shipping()['money'],
                'status' => 0,
                'notes' => $post['notes'],
                'first_name' => $post['first_name'],
                'last_name' => $post['last_name'],
                'country' => $post['country'],
                'state' => $post['state'],
                'address' => $post['address'],
                'phone' => $post['phone_code'].'-'.$post['phone']
            );
            foreach($cart_productList as $cartKey => $cartValue){
                $insert['productList'][] = array(
                    'productId' => $cartValue['productId'],
                    'price' => round($cartValue['productPrice']),
                    'size' => $cartValue['productSize'],
                    'color' => $cartValue['productColor'],
                    'qty' => $cartValue['productQty']
                );
            }
            $orderId = $this->order_model->insert_order($insert);
            $coupon = $this->coupon_model->get_coupon_by_id($this->my_cart->coupon()['couponId']);
            $this->coupon_model->update_coupon($coupon,array('usable' => 0));
            
            redirect(website_url("order/order_payment/".$orderId));
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
            'all_country' => $all_country,
            'member' => $member
        );
        $this->get_view('order/information',$data);
    }

    public function order_payment($orderId){
        $data = array();
        if(!isset($this->session->userdata('memberinfo')['memberId'])){
            js_warn("請登入會員，謝謝!");
            redirect(website_url('login')); 
        }

        $member = $this->member_model->get_member_by_id($this->session->userdata('memberinfo')['memberId']);
        $order = $this->order_model->get_order_by_id($orderId);
        if($post = $this->input->post(null,true)){
            $this->order_model->update_order($order,array('payway' => $post['payway']));
            //購物車美金金額
            $cart_total = $this->my_cart->original_total();
            $all_total = $this->my_cart->original_all_total();

            //匯率
            $moneyList = $this->money_model->get_money_select(false,false,false);

            $cart_productList = $this->my_cart->get_product_list();
            $productList = array();
            foreach($cart_productList as $cartKey => $cartValue){
                $productList[] = array('Name' => $cartValue['productName'], 'Price' => round($cartValue['productPrice'] * $moneyList[0]->twd_value),
                'Currency' => "元", 'Quantity' => $cartValue['productQty'], 'URL' => "dedwed");
            }

            //串綠界
            $this->my_pay_ecpay->set_paramer(array(
                'redirect' => website_url("order/order_view/$orderId"),
                'return' => website_url('receive'),
                'orderId' => $orderId,
                'money' => round($all_total * $moneyList[0]->twd_value),
                'productList' => $productList
            ));

            switch($post['payway']){
                case '0':
                    $mac_code = $this->my_pay_ecpay->credit();
                    $this->order_model->update_order($order,array('check_mac_value' => $mac_code)); 
                    $this->my_pay_ecpay->excute();  
                    break;
                case '1':
                    $this->my_pay_ecpay->atm();
                    break;
                case '2': //扣除會員點數
                    if($member->point < $all_total){
                        js_warn('error');
                        redirect(website_url());
                    }
                    $point = $member->point-$all_total;
                    $this->member_model->update_member($member,array('point' => $point));
                    redirect(website_url("order/order_view/".$orderId));
                    break;                                
            }
            //重置購物車
            $this->my_cart->reset_cart();
        }


        $data = array(
            'member' => $member,
            'order' => $order
        );
        $this->get_view('order/payment',$data);
    }

    public function order_view($orderId){
        $order = $this->order_model->get_order_by_id($orderId);
        if($order->rtn_msg == 'Succeeded' || $order->rtn_msg == 'SUCCESS'){
            redirect(website_url());
        }
        $post = $this->input->post(null,true);
        $mac_value = $this->my_pay_ecpay->ecpayCheckMacValue($post);
        print_r($post);
        echo '<br>';
        print_r($mac_value);exit;
        $member = $this->member_model->get_member_by_id($order->memberId);
        $this->order_model->update_order($order,array('status' => 1));
        $dividend = intval(($order->total-$order->shipping)/10);
        $this->member_model->update_member($member,array('dividend' => $dividend));
        $this->dividend_model->insert_dividend(array('orderId' => $orderId,'dividend' => $dividend,'memberId' => $order->memberId));
        $data = array(
            'order' => $order
        );
        $this->get_view('order/view',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}