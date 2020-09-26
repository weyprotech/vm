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
        $this->load->model('product/tb_product_review_model','tb_product_review_model');
        $this->load->model('coupon/tb_coupon_model','tb_coupon_model');
        $this->load->model('member/tb_member_point_record_model','tb_member_point_record_model');
        $this->load->model('member/tb_member_reward_record_model','tb_member_reward_record_model');
        $this->load->model('member/tb_gift_designer_model','tb_gift_designer_model');
        $this->load->model('member/tb_member_inspiration_model','tb_member_inspiration_model');
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
    
    //My favorite
    public function favorite(){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $memberId = $this->session->userdata('memberinfo')['memberId'];
        $member = $this->member_model->get_member_by_id($memberId);
        //設計師
        $designerList = $this->tb_designer_like_model->get_designer_like_select(array(array('field' => 'designer.is_enable','value' => 1),array('field' => 'designer_like.memberId','value' => $memberId)),false,false,$this->langId);
        if(!empty($designerList)){
            foreach($designerList as $designerKey => $designerValue){
                $designerList[$designerKey]->runway = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.designerId','value' => $designerValue->designerId),array('field' => 'runway.live','value' => 0)),false,false,$this->langId);                
            }
        }
        
        //產品
        $productList = $this->tb_product_like_model->get_product_like_select(array(array('field' => 'product.is_visible','value' => 1),array('field' => 'product_like.memberId','value' => $memberId)),false,false,$this->langId,1);

        $data = array(
            'designerList' => $designerList,
            'productList' => $productList
        );
        $this->get_view('member/favorite',$data);
    }
    
    //歷史訂單
    public function order_history(){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $memberId = $this->session->userdata('memberinfo')['memberId'];
        $orderList = $this->tb_order_model->get_order_select(array(array('field' => 'order.memberId','value' => $memberId)),false,false);
        $data = array(
            'orderList' => $orderList
        );
        $this->get_view('member/order_history',$data);
    }

    //歷史訂單詳細資料
    public function order_history_detail($orderId){    
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
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

    //點數紀錄
    public function mypoint(){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $memberId = $this->session->userdata('memberinfo')['memberId'];
        $member = $this->member_model->get_member_by_id($memberId);
        $recordList = $this->tb_member_point_record_model->get_member_point_record_select(array(array('field' => 'memberId','value' => $memberId)));
        $rewardList = $this->tb_member_reward_record_model->get_member_reward_record_select(array(array('field' => 'memberId','value' => $memberId)),false,false,$this->langId);
        $data = array(
            'member' => $member,
            'recordList' => $recordList,
            'rewardList' => $rewardList
        );
        $this->get_view('member/my_point',$data);
    }

    //設計師禮品
    public function gift(){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $memberId = $this->session->userdata('memberinfo')['memberId'];
        $member = $this->member_model->get_member_by_id($memberId);
        $giftList = $this->tb_gift_designer_model->get_gift_designer_select(array(array('field' => 'gift_designer.memberId','value' => $memberId)),false,false,$this->langId);
        $data = array(
            'member' => $member,
            'giftList' => $giftList
        );
        $this->get_view('member/member_gift',$data);
    }

    //be vm model
    public function be_vm_model(){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $this->get_view('member/be_vm_model');
    }    

    //贈送禮物
    public function popup_gift($designerId){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        if($post = $this->input->post(null, true)){
            $designer = $this->tb_gift_designer_model->insert_gift_designer(array(
                'designerId' => $designerId,
                'memberId' => $this->session->userdata('memberinfo')['memberId'],
                'date' => date('Y-m-d'),
                'comment' => $post['comment'],
                'money' => $post['money'],
                'payway' => $post['payway']
            ));
            redirect(website_url('member/member/favorite'));
        }
        $data = array(
            'designerId' => $designerId
        );
        $this->load->view('content/member/popup_gift',$data);
    }

    //Style Inspiration
    public function style_inpsiration(){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $inspirationList = $this->tb_member_inspiration_model->get_member_inspiration_select(array(array('field' => 'member_inspiration.memberId','value' => $this->session->userdata('memberId')['memberId'])),false,false,$this->langId);
        $data = array(
            'inspirationList' => $inspirationList
        );
        $this->get_view('member/inspiration',$data);
    }

    //my reviews
    public function member_reviews($page = 1){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $reviewList = $this->tb_product_review_model->get_product_review_select(array(array('field' => 'review.memberId','value' => $this->session->userdata('memberinfo')['memberId'])),false,array('start' => $page*6,'limit' => 6),$this->langId);
        $reviewCount = $this->tb_product_review_model->count_product_review(array(array('field' => 'review.memberId','value' => $this->session->userdata('memberinfo')['memberId'])),$this->langId);
        if(!empty($reviewList)){
            foreach($reviewList as $reviewKey => $reviewValue){
                $reviewList->brand = $this->tb_brand_model->get_brand_by_id($reviewValue->brandId,$this->langId);
                $reviewList->designer = $this->tb_designer_model->get_designer_by_id($reviewList->brand->designerId,$this->langId);
            }
        }

        $data = array(
            'reviewList' => $reviewList,
            'reviewCount' => $reviewCount,
            'page' => $page
        );
        $this->get_view('member/my_review',$data);
    }

    //member_upcoming
    public function member_upcoming($page = 1){
        if(!$this->session->userdata('memberinfo')['memberId']){
            js_warn('請重新登入，謝謝!');
            redirect(website_url());
        }
        $eventList = $this->tb_runway_model->get_runway_select(array(array('field' => 'runway.is_visible','value' => 1)),array(array('field' => 'runway.date','dir' => 'asc')),array('start' => $page*10,'limit' => 10));
        $eventCount = $this->tb_runway_model->count_runway(array(array('field' => 'runway.is_visible','value' =>1)));
        $totalPage = ceil($eventCount/10);
        $data = array(
            'eventList' => $eventList,
            'page' => $page,
            'totalPage' => $totalPage
        );
        $this->get_view('member/upcoming_events',$data);
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
