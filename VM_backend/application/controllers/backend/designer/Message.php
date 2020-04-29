<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('designer/tb_message_model', 'message_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index($designerId)
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index',array('designerId' => $designerId));
    }    

    public function view($messageId = false)
    {

        if (!$row = $this->message_model->get_message_by_id($messageId, 3, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/message');
        endif;

        if ($message = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $message['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                unset($message['dt_basic_length']);
                $this->message_model->update_message($row, $message);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/designer/message/index/'.$row->designerId . $this->query);
                endif;
            endif;
            redirect('backend/designer/message/view/' . $messageId . $this->query);
        endif;

        $data = array(
            'row' => $row,
            'messageId' => $messageId,
            'designerId' => $row->designerId
        );

        $this->get_view('view', $data);
    }

    public function delete($messageId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->message_model->get_message_by_id($messageId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $designerId = $row->designerId;
            $this->message_model->delete_message($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/designer/message/index/'.$designerId . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/designer/message/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}