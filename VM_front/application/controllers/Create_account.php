<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Create_account extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tb_member_model','member_model');
    }

    public function index()
    {
        $this->load->view('content/member/create_account');
    }

    public function check_member($uuid){
        if($member = $this->member_model->get_member_select(array(array('field' => 'member.uuid','value' => $uuid)))){
            if($member[0]->is_open == 0){
                $this->member_model->update_member($member,array('is_open' => 1));
                $this->session->set_userdata('memberinfo',array(
                    'memberId' => $member[0]->memberId,
                    'memberEmail' => $member[0]->email,
                    'memberPassword' => $member[0]->password,
                    'memberImg' => $member[0]->memberImg,
                    'memberFirst_name' => $member[0]->first_name,
                    'memberLast_name' => $member[0]->last_name                
                ));
                redirect('member');
            }else{
                redirect('login');
            }
        }else{
            redirect('login');
        }
    }
}
