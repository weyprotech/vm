<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tb_member_model', 'member_model');
    }

    public function index()
    {
        if($this->langFile == 'tw'){
            $this->pageMeta['title'][] = '登入';
        }else{
            $this->pageMeta['title'][] = 'Login';
        }
        $login = $this->input->cookie('login', true);
        $type = $this->input->get('type',true);
        $this->encryption->initialize(array('driver' => 'mcrypt'));
        if($this->session->userdata('memberinfo')['memberId']){
            redirect(website_url('member/member'));
        }
        if($login != null){
            $temp = $this->encryption->decrypt($login);
            $temp_login = explode('###', $temp);
            $email = @$temp_login[0];
            $password = @$temp_login[1];
            if($member = $this->member_model->get_member_select(array(array('field' => 'member.email', 'value' => $email), array('field' => 'member.password', 'value' => $password)))){
                $this->session->set_userdata('memberinfo', array(
                    'memberId' => $member[0]->memberId,
                    'memberEmail' => $member[0]->email,
                    'memberPassword' => $member[0]->password,
                    'memberImg' => $member[0]->memberImg,
                    'memberFirst_name' => $member[0]->first_name,
                    'memberLast_name' => $member[0]->last_name                
                ));
                if($type == 'order'){
                    redirect(website_url('order/index'));
                }else{
                    redirect(website_url('member/member'));
                }
            }
        }
        $this->get_view('member/login', array('type' => $type), $this->load->view('shared/script/member/_login_script', array(), true));
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
