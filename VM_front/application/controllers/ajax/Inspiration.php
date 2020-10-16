<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inspiration extends Ajax_Controller
{
    public function __construct()
    {        
        parent::__construct();
        $this->load->model('member/tb_member_inspiration_model','tb_member_inspiration_model');
    }

    public function set_like(){
        $inspirationId = $this->input->post('inspirationId',true);
        if($this->session->userdata('memberinfo')['memberId']){
            $like = $this->tb_member_inspiration_model->get_member_inspiration_select(array(array('field' => 'member_inspiration.inspirationId','value' => $inspirationId),array('field' => 'member_inspiration.memberId','value' => $this->session->userdata('memberinfo')['memberId'])));
            if(!$like){
                $this->tb_member_inspiration_model->insert_member_inspiration(array('memberId' => $this->session->userdata('memberinfo')['memberId'],'inspirationId' => $inspirationId));
            }else{
                $this->tb_member_inspiration_model->delete_member_inspiration($like[0]);
            }
            echo json_encode(array('status' => 'success'));
        }else{
            echo json_encode(array('status' => 'error'));
        }
    }
}