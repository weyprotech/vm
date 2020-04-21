<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Company extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('company/tb_company_model', 'company_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function edit()
    {
        $row = $this->company_model->get_company_information();
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->company_model->update_company_information($post);
                $this->set_active_status('success', 'Success');                
            endif;

            redirect('backend/company/company/edit' . $this->query);
        endif;
        $data = array(            
            'row' => $row
        );

        $this->get_view('edit', $data);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/company/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}