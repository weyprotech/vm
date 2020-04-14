<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('tb_member_model', 'member_model');
    }

    /******************** member ********************/
    public function check_member()
    {
        header('Content-Type: application/json; charset=utf-8');
        $email = $this->input->post('email',null);
        $password = $this->input->post('password',null);
        $remember = $this->input->post('remember',null);
        if($member = $this->member_model->get_member_select(array(array('field' => 'member.email','value' => $email),array('field' => 'member.password','value' => md5($password))))){
            $this->session->set_userdata('memberinfo',array(
                'memberId' => $member[0]->memberId,
                'memberEmail' => $member[0]->email,
                'memberPassword' => $member[0]->password,
                'memberImg' => $member[0]->memberImg,
                'memberFirst_name' => $member[0]->first_name,
                'memberLast_name' => $member[0]->last_name                
            ));
            if($remember == 1){
                $this->encryption->initialize(array('driver' => 'mcrypt'));
                $encrypted_string = $this->encryption->encrypt($email.'###'.md5($password));
                
                $array = array(
                    'name' => 'login',
                    'value' => $encrypted_string,
                    'expire' => '604800'
                );
                $this->input->set_cookie($array);
            }

            
            echo json_encode(array(
                'status' => 'success'
            ));
        }else{
            echo json_encode(array(
                'status' => 'error'
            ));
        }
    }


    
    /******************** End member ********************/
}