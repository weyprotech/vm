<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('member/tb_member_model', 'member');
        $this->load->model('brand/tb_brand_message_model', 'message');
    }

    /******************** brand ********************/
    public function get_message_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $search = check_input_value($this->input->get('search[value]', true));
        $country = check_input_value($this->input->get('country',true));
        $query = $this->set_http_query(array('search' => $search));
        /***** Filter *****/
        $filter = array('like' => array('field' => 'message.message', 'value' => $search));
        /***** Order *****/
        $order = array(array('field' => 'message.create_at', 'dir' => 'desc'));
        $messageList = $this->message->get_brand_message_select($filter, $order, array('limit' => $limit, 'start' => $start));
        $recordsTotal = $this->message->count_brand_message($filter);
        if ($messageList):
            foreach ($messageList as $row):
                $member = $this->member->get_member_by_id($row->memberId);
                $data[] = array(
                    'member' => $member->first_name . " " . $member->last_name,
                    'message' => $row->message,
                    'action' => $this->get_button('edit', 'backend/brand/message/edit/' . $row->Id . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }
    
    /******************** End brand ********************/
}