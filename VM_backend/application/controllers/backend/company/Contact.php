<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('company/tb_contact_model', 'contact_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index');
    }

    public function view($contactId = false)
    {
        if (!$row = $this->contact_model->get_contact_by_id($contactId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/company/contact/index');
        endif;

        $data = array(
            'row' => $row,
        );

        $this->get_view('view', $data);
    }

    public function delete($contactId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->contact_model->get_contact_by_id($contactId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->contact_model->delete_contact($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/company/contact' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('contactOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_contact', $order, 'contactId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/company/contact' . $this->query);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/company/contact/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}