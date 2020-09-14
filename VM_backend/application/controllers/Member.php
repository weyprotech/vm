<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Frontend_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('member/tb_member_model','member_model');
    }

    public function update_member()
    {
        $member_img = $this->input->post('member_img',true);
        $member_id = $this->input->post('member_id',true);
        if(!empty($member_id)){
            $member = $this->member_model->get_member_by_id($member_id);

            $this->member_model->update_member($member,array('memberImg' => $member_img));
            echo json_encode(array('type' => 'success'));

        }else{
            echo json_encode(array('type' => 'error'));
        }
        
    }

    private function get_view($page, $data = array(), $script = "")
    {
        $this->load->view("webPage", $this->get_frontend_view($page, $data, $script));
    }
}
