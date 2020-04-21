<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Physical_store extends Backend_Controller
{
    public $query;

    public function __construct()
    {
        parent::__construct();
        if (!is_logged_in()):
            redirect("admin");
        endif;

        $this->load->model('company/tb_physical_store_model', 'physical_store_model');
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
        $physical_storeId = uniqid();
        
        if($post = $this->input->post(null,true)){
            $this->set_active_status('success', 'Success');
            unset($post['image_list_length']);
            $physical_storeId = $post['physical_storeId'];
            $this->physical_store_model->insert_physical_store($post);
            if ($this->input->get('back', true)):
                redirect('backend/company/physical_store/index' . $this->query);
            endif;
            redirect("backend/company/physical_store/edit/" . $physical_storeId);            
        }
        $data = array(
            'physical_storeId' => $physical_storeId
        );
        $this->get_view('add',$data);
    }

    public function edit($physical_storeId = false)
    {
        if (!$row = $this->physical_store_model->get_physical_store_by_id($physical_storeId, false, array('enable' => false, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
            redirect('backend/company/physical_store/index');
        endif;

        if ($post = $this->input->post(null, true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth
            if ($row->uuid != $post['uuid']):
                $this->set_active_status('danger', 'Date has been changed');
            else:
                $this->physical_store_model->update_physical_store($row, $post);
                $this->set_active_status('success', 'Success');
                if ($this->input->get('back', true)):
                    redirect('backend/company/physical_store' . $this->query);
                endif;
            endif;

            redirect('backend/company/physical_store/edit/' . $physical_storeId . $this->query);
        endif;
        $data = array(
            'row' => $row,
        );

        $this->get_view('edit', $data);
    }

    public function delete($physical_storeId = false)
    {
        $this->check_action_auth($this->menuId, 'delete', true); // Check Auth

        if (!$row = $this->physical_store_model->get_physical_store_by_id($physical_storeId, $this->langId, array('enable' => true, 'visible' => false))):
            $this->set_active_status('danger', 'The data does not exist!');
        else:
            $this->physical_store_model->delete_physical_store($row);
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/company/physical_store' . $this->query);
    }

    public function save()
    {
        if ($order = $this->input->post('physical_storeOrder', true)):
            $this->check_action_auth($this->menuId, 'edit', true); // Check Auth

            foreach ($order as $i => $row):
                $order[$i] = array_merge($row, array('uuid' => uniqid(), 'update_at' => date('Y-m-d H:i:s')));
            endforeach;

            $this->db->update_batch('tb_physical_store', $order, 'physical_storeId');
            $this->set_active_status('success', 'Success');
        endif;

        redirect('backend/company/physical_store' . $this->query);
    }


    /******************** Private Function ********************/
    private function get_view($page, $data = '')
    {
        $content = $this->load->view('backend/company/physical_store/' . $page, $data, true);
        $this->load->view('backend/index', $this->get_page_nav($content), false);
    }
}