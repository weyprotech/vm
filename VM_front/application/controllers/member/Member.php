<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tb_member_model','member_model');
        $this->load->model('designer/tb_designer_like_model','tb_designer_like_model');
        $this->load->model('product/tb_product_like_model','tb_product_like_model');
        $this->load->model('designer/tb_runway_model','tb_runway_model');
        $this->load->model('order/tb_order_model','tb_order_model');
        $this->load->model('product/tb_product_model','tb_product_model');
        $this->load->model('coupon/tb_coupon_model','tb_coupon_model');
        $this->load->library('my_api');
    }

    public function index()
    {
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $memberId = $this->session->userdata('memberinfo')['memberId'];        
        $member = $this->member_model->get_member_by_id($memberId);
        $data = array(
            'member' => $member
        );
        
        $this->get_view('member/index',$data);
    }

    //修改個人資料
    public function edit_profile(){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn("請重新登入，謝謝!");
            redirect(website_url());
        }
        $type = $this->input->get('type',true);
        $memberId = $this->session->userdata('memberinfo')['memberId'];
        $member = $this->member_model->get_member_by_id($memberId);
        if($post = $this->input->post(null)){
            if(!empty($post['memberImg'])){
                $this->my_api->set_api_parameter($post,$memberId,backend_url('index.php/tw/member/update_member'));
                $this->my_api->excute();
                unset($post['memberImg']);
            }

            $this->member_model->update_member($member,$post);
            redirect(website_url('member/member/edit_profile?type=success'));
        }
        $data = array(
            'member' => $member            
        );
        $this->get_view('member/edit_profile',$data,$this->load->view('shared/script/member/_edit_profile_script',array('type' => $type),true));
    }

    //修改帳號
    public function edit_account(){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $type = $this->input->get('type');
        $memberId = $this->session->userdata('memberinfo')['memberId'];
        $member = $this->member_model->get_member_by_id($memberId);
        if($post = $this->input->post(null,true)){
            $this->member_model->update_member($member,$post);
            redirect(website_url('member/member/edit_account?type=success'));
        }
        $data = array(
            'member' => $member
        );
        $this->get_view('member/edit_account',$data,$this->load->view('shared/script/member/_edit_account_script',array('type' => $type),true));
    }

    public function be_vm_model(){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $this->get_view('member/be_vm_model');
    }
    
    //My favorite
    public function favorite(){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $memberId = $this->session->userdata('memberinfo')['memberId'];
        $member = $this->member_model->get_member_by_id($memberId);
        //設計師
        $designerList = $this->tb_designer_like_model->get_designer_like_select(array(array('field' => 'designer_like.memberId','value' => $memberId)),false,false,$this->langId);
        foreach($designerList as $designerKey => $designerValue){
            $designerList[$designerKey]->runway = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.designerId','value' => $designerValue->designerId),array('field' => 'runway.live','value' => 0)),false,false,$this->langId);                
        }
        
        //產品
        $productList = $this->tb_product_like_model->get_product_like_select(array(array('field' => 'product_like.memberId','value' => $memberId)),false,false,$this->langId,1);

        $data = array(
            'designerList' => $designerList,
            'productList' => $productList
        );
        $this->get_view('member/favorite',$data);
    }
    
    //歷史訂單
    public function order_history(){
        $memberId = $this->session->userdata('memberinfo')['memberId'];
        $orderList = $this->tb_order_model->get_order_select(array(array('field' => 'order.memberId','value' => $memberId)),false,false);
        $data = array(
            'orderList' => $orderList
        );
        $this->get_view('member/order_history',$data);
    }

    //歷史訂單詳細資料
    public function order_history_detail($orderId){    
        if($order = $this->tb_order_model->get_order_by_id($orderId)){
            if(!empty($order->couponId)){
                $coupon = $this->tb_coupon_model->get_coupon_by_id($order->couponId);
            }else{
                $coupon = array();
            }
            $data = array(
                'order' => $order,
                'coupon' => $coupon
            );
            $this->get_view('member/order_history_detail',$data);
        }else{
            redirect(website_url("member/member/order_history"));
        }
    }
    
    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}