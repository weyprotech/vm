<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feedback extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('help/tb_feedback_model', 'feedback_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index');
    }

    public function view($feedbackId = false)
    {
        if (!$row = $this->feedback_model->get_feedback_by_id($feedbackId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/help/feedback/index');
        endif;

        $data = array(
            'row' => $row,
        );

        $this->get_view('view', $data);
    }

    public function delete($feedbackId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->feedback_model->get_feedback_by_id($feedbackId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->feedback_model->delete_feedback($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/help/feedback' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('feedbackOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_feedback', $order, 'feedbackId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/help/feedback' . $this->query);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/help/feedback/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}