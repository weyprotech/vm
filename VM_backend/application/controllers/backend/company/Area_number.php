<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Area_number extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('company/tb_area_number_model', 'area_number_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $Id = uniqid();
        if($post = $this->input->post(null,true)){
            $this->area_number_model->insert_area_number($post);
            $Id = $post['Id'];
            if($this->input->get('back',true)){
                redirect("backend/company/area_number/index/".$Id);
            }
            redirect('backend/company/area_number/edit/' . $Id . $this->query);
        }
        $this->get_view('add',array('Id' => $Id));
    }

    public function edit($numberId = false)
    {
        if (!$row = $this->area_number_model->get_area_number_by_id($numberId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/area_number');
        endif;
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->area_number_model->update_area_number($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/company/area_number' . $this->query);
                endif;
            endif;

            redirect('backend/company/area_number/edit/' . $numberId . $this->query);
        endif;

        $data = array(
            'row' => $row,
            'Id' => $numberId
        );

        $this->get_view('edit', $data);
    }

    public function delete($numberId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->area_number_model->get_area_number_by_id($numberId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->area_number_model->delete_area_number($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/company/area_number' . $this->query);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/company/contact/area_number/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}