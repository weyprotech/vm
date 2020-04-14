<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;
    }

    /******************** member ********************/
    public function get_member_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->post('start', true);
        $limit = $this->input->post('length', true);
        $search = check_input_value($this->input->post('search[value]', true));
        $this->load->model('tb_member_model', 'member_model');
        $filter['like'] = array('field' => 'lang.name', 'value' => $search);        
        $order = array(array('field' => 'member.create_at', 'dir' => 'asc'));
        $query = $this->set_http_query(array('search' => $search));

        
        $memberList = $this->member_model->get_member_select($filter, $order, array('limit' => $limit, 'start' => $start), $this->langId);
        $recordsTotal = $this->member_model->count_member($filter, $this->langId);

        if ($memberList):
            foreach ($memberList as $row):
                $data[] = array(                    
                    'preview' => '<div id="preview">' . (!empty($row->memberImg) ? '<img src="' . base_url($row->memberImg) . '">' : '') . '</div>',
                    'email' => $row->email,
                    'first_name' => $row->first_name,
                    'last_name' => $row->last_name,
                    'gender' => $row->gender == 0 ? '男' : '女',
                    'age' => $row->age,
                    'point' => $row->point,
                    'action' => $this->get_button('edit', 'backend/member/edit/' . $row->memberId . $query) . $this->get_button('delete', 'backend/member/delete/' . $row->memberId . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->post('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    public function check_email(){
        $email = $this->input->post('email',true);
        $this->load->model('tb_member_model', 'member_model');

        if($email == null){
            echo json_encode(array(
                'valid' => false
            ));
        }else{
            if($this->member_model->get_member_select(array(array('field' => 'member.is_enable','value' => 1),array('field' => 'member.email','value' => $email)))){
                echo json_encode(array(
                    'valid' => false
                ));
            }else{
                echo json_encode(array(
                    'valid' => true
                ));
            }
        }
    }
}