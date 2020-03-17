<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Designer extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->check_action_auth($this->prevId, 'view', true); // Check Auth
        $this->check_action_auth($this->menuId, 'view', true); // Check Auth

        $this->load->model('designer/tb_designer_model', 'designer_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $designerId = uniqid();
        if($post = $this->input->post(null,true)){
            $this->designer_model->insert_designer($post);
            $designerId = $post['designerId'];
            if($this->input->get('back',true)){
                // exit;
                redirect("backend/designer/designer");
            }
            // exit;
            redirect('backend/designer/designer/edit/' . $designerId . $this->query);
        }
        $this->get_view('add',array('designerId' => $designerId));
    }

    public function edit($designerId = false)
    {
        if (!$row = $this->designer_model->get_designer_by_id($designerId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/designer/designer');
        endif;
        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->designer_model->update_designer($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/designer/designer' . $this->query);
                endif;
            endif;

            redirect('backend/designer/designer/edit/' . $designerId . $this->query);
        endif;

        $data = array(
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($designerId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->designer_model->get_designer_by_id($designerId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->designer_model->delete_designer($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/designer/designer' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('designerOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_designer_designer', $order, 'designerId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/designer/designer' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/designer/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}