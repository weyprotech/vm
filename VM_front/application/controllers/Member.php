<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tb_member_model','member_model');
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
            redirect('member/edit_profile?type=success');
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
            redirect('member/edit_account?type=success');
        }
        $data = array(
            'member' => $member
        );
        $this->get_view('member/edit_account',$data,$this->load->view('shared/script/member/_edit_account_script',array('type' => $type),true));
    }
    
    
    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
