<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fabric extends Backend_Controller
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

        $this->load->model('fabric/tb_fabric_model', 'fabric_model');
        $this->query = $this->set_http_query(array('search' => $this->input->get('search', true)));
    }

    public function index()
    {
        $this->get_view('index');
    }

    public function add()
    {
        $this->check_action_auth($this->menuId, 'add', true); // Check Auth
        $fabricId = uniqid();
    
        if($post = $this->input->post(null,true)){
            $this->fabric_model->insert_fabric($post);
            $fabricId = $post['fabricId'];
            if($this->input->get('back',true)){
                redirect("backend/fabric/fabric/");
            }
            redirect('backend/fabric/fabric/edit/' . $fabricId . $this->query);
        }
        $this->get_view('add',array('fabricId' => $fabricId));
    }

    public function edit($fabricId = false)
    {
        if (!$row = $this->fabric_model->get_fabric_by_id($fabricId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/fabric/fabric');
        endif;        

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->fabric_model->update_fabric($row, $post);
                $this->set_active_status('success', 'Success');

                if ($this->input->get('back', true)):
                    redirect('backend/fabric/fabric' . $this->query);
                endif;
            endif;

            redirect('backend/fabric/fabric/edit/' . $fabricId . $this->query);
        endif;
        
        $data = array(
            'fabricId' => $fabricId,
            'row' => $row
        );

        $this->get_view('edit', $data);
    }

    public function delete($fabricId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->fabric_model->get_fabric_by_id($fabricId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->fabric_model->delete_fabric($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/fabric/fabric' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('eventOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_fabric', $order, 'fabricId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/fabric/fabric' . $this->query);
    }

    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/fabric/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}