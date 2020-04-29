<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message extends Ajax_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('designer/tb_message_model', 'message');
        $this->load->model('brand/tb_brand_model','brand');
    }

    /******************** message ********************/
    public function get_message_data($data = array())
    {
        header('Content-Type: application/json; charset=utf-8');

        $start = $this->input->get('start', true);
        $limit = $this->input->get('length', true);
        $designerId = $this->input->get('designerId', true);
        $query = $this->set_http_query(array('designerId' => $designerId));

        /***** Order *****/
        $order = array(array('field' => 'message.create_at', 'dir' => 'desc'));

        $messageList = $this->message->get_message_select(array(array('field' => 'message.designerId','value' => $designerId)), $order, array('limit' => $limit, 'start' => $start), 3);
        $recordsTotal = $this->message->count_message(array(array('field' => 'message.designerId','value' => $designerId)), 3);
        if ($messageList):
            foreach ($messageList as $row):
                $data[] = array(     
                    'name' => $row->name,
                    'email' => $row->email,
                    'message' => $row->message,
                    'action' => '<a class="btn btn-success" href="'.site_url('backend/designer/message/view/'.$row->Id).'"><i class="fa fa-eye"></i><span class="hidden-mobile"> View</span></a>' . '&nbsp;&nbsp;' . $this->get_button('delete', 'backend/designer/message/delete/' . $row->Id . $query)
                );
            endforeach;
        endif;

        echo json_encode(array('draw' => $this->input->get('draw', true), 'data' => $data, 'recordsFiltered' => $recordsTotal, 'recordsTotal' => $recordsTotal));
        return true;
    }

    /******************** End message ********************/
}